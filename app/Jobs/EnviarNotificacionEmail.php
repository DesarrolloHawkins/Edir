<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Alertas;
use App\Models\User;
use App\Models\Logs;
use App\Mail\NotificacionEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnviarNotificacionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public $tries = 3; // Reintentar hasta 3 veces
    public $timeout = 120; // Timeout de 2 minutos
    public $backoff = [30, 60, 120]; // Esperar 30s, 60s, 120s entre reintentos

    protected $alertaId;
    protected $usuarioId;
    protected $archivoPath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Alertas $alerta, $usuarioId, $archivoPath = null)
    {
        // Guardar solo el ID para evitar problemas de serialización
        $this->alertaId = $alerta->id;
        $this->usuarioId = $usuarioId;
        $this->archivoPath = $archivoPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log al inicio para rastrear la ejecución
        Log::info("=== INICIANDO JOB EnviarNotificacionEmail ===", [
            'alerta_id' => $this->alertaId,
            'usuario_id' => $this->usuarioId,
            'archivo_path' => $this->archivoPath,
            'timestamp' => now()->toDateTimeString()
        ]);
        
        try {
            // Recargar la alerta desde la base de datos usando el ID
            $alerta = Alertas::with('comunidad')->find($this->alertaId);
            
            if (!$alerta) {
                Log::warning("Alerta {$this->alertaId} no encontrada");
                return;
            }
            
            Log::info("Alerta encontrada: {$alerta->titulo}");
            
            $usuario = User::find($this->usuarioId);
            
            if (!$usuario || !$usuario->email) {
                Log::warning("Usuario {$this->usuarioId} no encontrado o sin email");
                return;
            }
            
            Log::info("Usuario encontrado: {$usuario->email}");

            // Verificar que el archivo existe si se proporcionó
            $archivoPathFinal = null;
            if ($this->archivoPath) {
                // Si el path incluye 'public/', buscar en storage/app/public
                if (strpos($this->archivoPath, 'public/') === 0) {
                    $archivoPathFinal = storage_path('app/' . $this->archivoPath);
                } else {
                    $archivoPathFinal = storage_path('app/public/' . $this->archivoPath);
                }
                
                if (!file_exists($archivoPathFinal)) {
                    Log::warning("Archivo adjunto no encontrado: {$archivoPathFinal}");
                    $archivoPathFinal = null;
                }
            }

            // Enviar el email
            Log::info("Intentando enviar email a {$usuario->email}");
            Mail::to($usuario->email)->send(new NotificacionEmail($alerta, $archivoPathFinal));
            Log::info("Email enviado exitosamente a {$usuario->email}");
            
            // Registrar log de email enviado
            try {
                Logs::create([
                    'user_id' => $usuario->id,
                    'action' => 'Email Enviado',
                    'description' => "Email enviado a {$usuario->email} - Notificación: {$alerta->titulo}",
                    'date' => now(),
                    'reference' => "Alerta ID: {$alerta->id}"
                ]);
            } catch (\Exception $logError) {
                Log::warning("Error al crear log de email enviado: " . $logError->getMessage());
                // No lanzar excepción, el email ya se envió
            }
            
            Log::info("=== JOB COMPLETADO EXITOSAMENTE ===", [
                'alerta_id' => $this->alertaId,
                'usuario_id' => $this->usuarioId,
                'email' => $usuario->email
            ]);
        } catch (\Exception $e) {
            Log::error("=== ERROR EN JOB EnviarNotificacionEmail ===", [
                'alerta_id' => $this->alertaId,
                'usuario_id' => $this->usuarioId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Relanzar para que Laravel reintente
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error("Job falló después de {$this->tries} intentos para usuario {$this->usuarioId}: " . $exception->getMessage());
    }
}
