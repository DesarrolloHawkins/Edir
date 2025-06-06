<?php

namespace App\Http\Controllers;

use App\Models\ChatGpt;
use App\Models\Cliente;
use App\Models\Mensaje;
use App\Models\MensajeAuto;
use App\Models\PromptAsistente;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Whatsapp;
use App\Models\WhatsappEstadoMensaje;
use App\Models\WhatsappLog;
use App\Models\WhatsappMensaje;
use App\Services\ClienteService;
use Carbon\Carbon;
use CURLFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{

    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }
    /**
     * Handle the incoming request for WhatsApp webhook verification.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function hookWhatsapp(Request $request)
    {
        $responseJson = env('WHATSAPP_KEY', 'valorPorDefecto');

        $query = $request->all();
        $mode = $query['hub_mode'];
        $token = $query['hub_verify_token'];
        $challenge = $query['hub_challenge'];

        // Formatear la fecha y hora actual
        $dateTime = Carbon::now()->format('Y-m-d_H-i-s'); // Ejemplo de formato: 2023-11-13_15-30-25

        // Crear un nombre de archivo con la fecha y hora actual
        $filename = "hookWhatsapp_{$dateTime}.txt";

        Storage::disk('local')->put($filename, json_encode($request->all()));

        return response($challenge, 200)->header('Content-Type', 'text/plain');

    }

    /**
     * Procesa el webhook de WhatsApp y guarda los mensajes entrantes.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processHookWhatsapp(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        // 1. Guardar el JSON original
        WhatsappLog::create(['contenido' => $data]);

        // 2. Guardar el archivo en disco
        if (!Storage::exists('whatsapp/json')) {
            Storage::makeDirectory('whatsapp/json');
        }

        $timestamp = now()->format('Ymd_His_u');
        Storage::put("whatsapp/json/{$timestamp}.json", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // 3. Extraer los datos
        $entry = $data['entry'][0]['changes'][0]['value'] ?? [];

        // 4. Procesar mensajes entrantes
        if (isset($entry['messages'])) {
            foreach ($entry['messages'] as $mensaje) {
                $this->procesarMensajeYResponder($mensaje, $entry);
            }
        }

        // 5. Procesar estados de mensajes enviados
        if (isset($entry['statuses'])) {
            foreach ($entry['statuses'] as $status) {
                $this->procesarStatus($status);
            }
        }

        return response(200)->header('Content-Type', 'text/plain');

    }

    /**
     * Procesar el estado de los mensajes enviados.
     *
     * @param array $status
     * @return void
     */
    public function procesarMensajeYResponder(array $mensaje, array $entry)
    {
        $waId = $mensaje['from'];
        $tipo = $mensaje['type'];
        $id = $mensaje['id'];
        $timestamp = $mensaje['timestamp'] ?? null;

        $contenido = null;
        if ($tipo === 'text') {
            $contenido = $mensaje['text']['body'];
        } elseif ($tipo === 'image' && isset($mensaje['image']['id'])) {
            $contenido = '[Imagen] ' . $mensaje['image']['id'];
        } elseif ($tipo === 'audio' && isset($mensaje['audio']['id'])) {
            $contenido = '[Audio] ' . $mensaje['audio']['id'];
        } elseif ($tipo === 'document') {
            $contenido = '[Documento] ' . ($mensaje['document']['filename'] ?? 'sin nombre');
        }

        $whatsappMensaje = WhatsappMensaje::create([
            'mensaje_id' => $id,
            'tipo' => $tipo,
            'contenido' => $contenido,
            'remitente' => $waId,
            'fecha_mensaje' => $timestamp ? Carbon::createFromTimestamp($timestamp) : now(),
            'metadata' => $mensaje
        ]);

        // Solo si es texto, responde con ChatGPT
        if ($tipo === 'text') {
            // 1. Siempre crear el registro de entrada
            $chat = ChatGpt::create([
                'id_mensaje' => $id,
                'whatsapp_mensaje_id' => $whatsappMensaje->id,
                'remitente' => $waId,
                'mensaje' => $contenido,
                'respuesta' => null, // respuesta aún no disponible
                'status' => 0, // pendiente de respuesta
                'type' => 'text',
                'date' => now(),
            ]);

            // 2. Intentar obtener respuesta de ChatGPT
            $respuestaTexto = $this->enviarMensajeOpenAiChatCompletions($contenido, $waId);

            if ($respuestaTexto) {
                // 3. Solo si hay respuesta, actualizar la fila y contestar
                $chat->update([
                    'respuesta' => $respuestaTexto,
                    'status' => 1,
                ]);

                $response = $this->contestarWhatsapp($waId, $respuestaTexto, $whatsappMensaje);

                return response()->json(['status' => 'ok', 'respuesta' => $respuestaTexto]);
            } else {
                Log::warning("❌ Error de ChatGPT. No se contestó a {$waId}.");
                return response()->json(['status' => 'faile']);
            }
        }

    }

    /**
     * Enviar un mensaje de respuesta a WhatsApp.
     *
     * @param string $waId
     * @param string $respuestaTexto
     * @param WhatsappMensaje $whatsappMensaje
     * @return \Illuminate\Http\Response
     */
    public function procesarStatus(array $status)
    {
        $mensaje = WhatsappMensaje::where('recipient_id', $status['id'])->first(); // CAMBIO AQUÍ

        if ($mensaje) {
            // Guardar último estado
            $mensaje->estado = $status['status'];
            $mensaje->conversacion_id = $status['conversation']['id'] ?? null;
            $mensaje->origen_conversacion = $status['conversation']['origin']['type'] ?? null;
            $mensaje->expiracion_conversacion = isset($status['conversation']['expiration_timestamp'])
                ? Carbon::createFromTimestamp($status['conversation']['expiration_timestamp'])
                : null;
            $mensaje->billable = $status['pricing']['billable'] ?? null;
            $mensaje->categoria_precio = $status['pricing']['category'] ?? null;
            $mensaje->modelo_precio = $status['pricing']['pricing_model'] ?? null;
            $mensaje->errores = $status['errors'] ?? null;
            $mensaje->save();

            // Guardar en histórico
            WhatsappEstadoMensaje::create([
                'whatsapp_mensaje_id' => $mensaje->id,
                'estado' => $status['status'],
                'recipient_id' => $status['recipient_id'] ?? null,
                'fecha_estado' => isset($status['timestamp']) ? Carbon::createFromTimestamp($status['timestamp']) : now(),
            ]);
            return response()->json(['status' => 'ok', 'mensaje' => $mensaje]);
        } else {
            Log::warning("⚠️ No se encontró mensaje con recipient_id = {$status['id']} para guardar estado.");
        }
        return response()->json(['status' => 'faile']);

    }

    /**
     * Envía un mensaje de respuesta a WhatsApp.
     *
     * @param string $waId
     * @param string $respuestaTexto
     * @param WhatsappMensaje $whatsappMensaje
     * @return \Illuminate\Http\Response
     */
    function enviarMensajeOpenAiChatCompletions($nuevoMensaje, $remitente)
    {
        $apiKey = env('OPENAI_API_KEY');
        $modelo = 'gpt-4o';
        $endpoint = 'https://api.openai.com/v1/chat/completions';
        $promptAsistente = PromptAsistente::first();

        $tools = [
            [
                "type" => "function",
                "function" => [
                    "name" => "avisar_mantenimiento",
                    "description" => "Cuando detectes que un usuario quiere avisar de un mantenimiento, usa esta herramienta para enviar un aviso al administrador.",
                    "parameters" => [
                        "type" => "object",
                        "properties" => [
                            "mantenimiento" => [
                                "type" => "string",
                                "description" => "Envía un aviso de mantenimiento añ administrador"
                            ]
                        ],
                        // "required" => ["codigo_reserva"]
                    ]
                ]
            ]
        ];

        $promptSystem = [
            "role" => "system",
            "content" => $promptAsistente ? $promptAsistente->prompt : "Eres un asistente de Administrador de Fincas y Comunidades. Tu tarea es ayudar a los clientes con sus consultas y proporcionar información relevante. Responde de manera clara y profesional.",
        ];

        $historial = ChatGpt::where('remitente', $remitente)
            ->orderBy('date', 'desc')
            ->limit(20)
            ->get()
            ->reverse()
            ->flatMap(function ($chat) {
                $mensajes = [];
                if (!empty($chat->mensaje)) {
                    $mensajes[] = ["role" => "user", "content" => $chat->mensaje];
                }
                if (!empty($chat->respuesta)) {
                    $mensajes[] = ["role" => "assistant", "content" => $chat->respuesta];
                }
                return $mensajes;
            })
            ->toArray();

        $historial[] = ["role" => "user", "content" => $nuevoMensaje];

        $response = Http::withToken($apiKey)->post($endpoint, [
            'model' => $modelo,
            'messages' => array_merge([$promptSystem], $historial),
            'tools' => $tools,
            'tool_choice' => "auto",
        ]);

        if ($response->failed()) {
            Log::error("❌ Error llamando a ChatGPT: " . $response->body());
            return null;
        }

        $data = $response->json();

        if (isset($data['choices'][0]['message']['tool_calls'])) {
            $toolCall = $data['choices'][0]['message']['tool_calls'][0];
            if ($toolCall['function']['name'] === 'avisar_mantenimiento') {

            }
        }

        return $data['choices'][0]['message']['content'] ?? null;
    }

    /**
     * Envía un mensaje de respuesta a WhatsApp.
     *
     * @param string $phone
     * @param string $texto
     * @param WhatsappMensaje|null $mensajeOriginal
     * @return array
     */
    public function contestarWhatsapp($phone, $texto, $mensajeOriginal = null)
    {
        $token = env('TOKEN_WHATSAPP', 'valorPorDefecto');

        $mensajePersonalizado = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $phone,
            "type" => "text",
            "text" => [
                "body" => $texto
            ]
        ];

        $urlMensajes = 'https://graph.facebook.com/v16.0/102360642838173/messages';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post($urlMensajes, $mensajePersonalizado);

        if ($response->failed()) {
            Log::error("❌ Error al enviar mensaje: " . $response->body());
            return ['error' => 'Error enviando mensaje'];
        }

        $responseJson = $response->json();

        if (isset($responseJson['messages'][0]['id']) && $mensajeOriginal instanceof WhatsappMensaje) {
            $mensajeOriginal->recipient_id = $responseJson['messages'][0]['id'];
            $mensajeOriginal->save();

            Log::info("✅ Guardado recipient_id en mensaje original: " . $mensajeOriginal->id);
        }

        return $responseJson;
    }


    /**
     * Muestra los mensajes de WhatsApp en la vista.
     *
     * @return \Illuminate\View\View
     */
    public function whatsapp()
    {
        // $mensajes = ChatGpt::orderBy('created_at', 'desc')->limit(10)->get();
        $mensajes = ChatGpt::orderBy('created_at', 'desc')->get();
        $resultado = [];
        foreach ($mensajes as $elemento) {
            $mensaje = $elemento;
            $mensaje['whatsapp_mensaje'] = $mensaje->whatsappMensaje;

            // El resto igual:
            $remitenteSinPrefijo = $elemento['remitente'];
            $cliente = User::where('telefono', '+'.$remitenteSinPrefijo)->first();
            if ($cliente) {
                $mensaje['nombre_remitente'] = $cliente->nombre != '' ? $cliente->nombre . ' ' . $cliente->apellido1 : $cliente->alias;
            } else {
                $mensaje['nombre_remitente'] = 'Desconocido';
            }

            $resultado[$elemento['remitente']][] = $mensaje;
        }
        return view('admin.whatsapp.index', compact('resultado'));
    }
}
