<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappTemplate;
use Illuminate\Support\Facades\Http;

class WhatsappTemplateController extends Controller
{
    public function index()
    {
        $templates = WhatsappTemplate::all();
        return view('admin.configuraciones.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.configuraciones.templates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'language' => 'required|string',
            'category' => 'required|string',
            'components' => 'required|string', // recibimos como JSON string
        ]);

        $components = json_decode($data['components'], true);

        $template = WhatsappTemplate::create([
            'name' => $data['name'],
            'language' => $data['language'],
            'category' => $data['category'],
            'components' => $components,
            'status' => 'PENDING',
        ]);

        $response = Http::withToken(env('TOKEN_WHATSAPP'))
            ->post("https://graph.facebook.com/v19.0/" . env('BUSINESS_ID') . "/message_templates", [
                'name' => $template->name,
                'language' => ['code' => $template->language],
                'category' => $template->category,
                'components' => $components,
            ]);

        if ($response->successful()) {
            return redirect()->route('config.whatsapp.templates')->with('success', 'Plantilla enviada para aprobación.');
        } else {
            $template->delete();
            return back()->withErrors(['error' => 'Error al enviar la plantilla: ' . $response->body()]);
        }
    }

    public function show(WhatsappTemplate $template)
    {
        return view('admin.configuraciones.templates.show', compact('template'));
    }

    public function edit(WhatsappTemplate $template)
    {
        return view('admin.configuraciones.templates.edit', compact('template'));
    }

    public function update(Request $request, WhatsappTemplate $template)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'header_text' => 'nullable|string',
            'body_text' => 'required|string',
            'buttons' => 'nullable|array',
            'buttons.*.text' => 'nullable|string',
            'buttons.*.url' => 'nullable|url',
        ]);

        $components = [];

        if (!empty($data['header_text'])) {
            $components[] = [
                'type' => 'HEADER',
                'format' => 'TEXT',
                'text' => $data['header_text'],
            ];
        }

        $components[] = [
            'type' => 'BODY',
            'text' => $data['body_text'],
        ];

        if (!empty($data['buttons'])) {
            $components[] = [
                'type' => 'BUTTONS',
                'buttons' => collect($data['buttons'])->map(function ($btn) {
                    return [
                        'type' => 'URL',
                        'text' => $btn['text'],
                        'url' => $btn['url'],
                    ];
                })->toArray(),
            ];
        }

        if ($template->status !== 'PENDING') {
            Http::withToken(env('TOKEN_WHATSAPP'))->delete(
                'https://graph.facebook.com/v19.0/' . env('BUSINESS_ID') . '/message_templates',
                [
                    'name' => $template->name,
                    'language' => $template->language,
                ]
            );
        }

        $apiResponse = Http::withToken(env('TOKEN_WHATSAPP'))->post(
            'https://graph.facebook.com/v19.0/' . env('BUSINESS_ID') . '/message_templates',
            [
                'name' => $template->name,
                'language' => ['code' => $template->language],
                'category' => $template->category,
                'components' => $components,
            ]
        );

        if (!$apiResponse->successful()) {
            return back()->withErrors(['error' => 'Error al reenviar a WhatsApp: ' . $apiResponse->body()]);
        }

        $template->update([
            'status' => 'PENDING',
            'components' => $components,
        ]);

        return redirect()->route('config.whatsapp.templates')->with('success', 'Plantilla actualizada y reenviada.');
    }

    public function sync()
    {
        $wabaId = env('BUSINESS_ID');
        $token = env('TOKEN_WHATSAPP');
        $url = "https://graph.facebook.com/v19.0/{$wabaId}/message_templates";

        do {
            $response = Http::withToken($token)->get($url);

            if (!$response->ok()) {
                return back()->withErrors(['error' => 'Error al sincronizar: ' . $response->body()]);
            }

            $templates = $response->json('data');

            foreach ($templates as $tpl) {
                WhatsappTemplate::updateOrCreate(
                    ['name' => $tpl['name'], 'language' => $tpl['language']],
                    [
                        'template_id' => $tpl['id'] ?? null,
                        'status' => $tpl['status'] ?? 'unknown',
                        'category' => $tpl['category'] ?? null,
                        'parameter_format' => $tpl['parameter_format'] ?? null,
                        'components' => $tpl['components'] ?? [],
                    ]
                );
            }

            $url = $response->json('paging.next') ?? null;
        } while ($url);

        return redirect()->route('config.whatsapp.templates')->with('success', 'Plantillas sincronizadas correctamente.');
    }

    public function checkStatus(WhatsappTemplate $template)
    {
        $response = Http::withToken(env('TOKEN_WHATSAPP'))
            ->get("https://graph.facebook.com/v19.0/" . env('BUSINESS_ID') . "/message_templates?name=" . $template->name);

        if ($response->successful()) {
            $data = $response->json()['data'][0] ?? null;

            if ($data) {
                $template->status = $data['status'];
                $template->save();

                return redirect()->route('config.whatsapp.templates')->with('success', 'Estado actualizado: ' . $template->status);
            } else {
                return back()->withErrors(['error' => 'Plantilla no encontrada en la API.']);
            }
        } else {
            return back()->withErrors(['error' => 'Error al verificar el estado: ' . $response->body()]);
        }
    }
}
