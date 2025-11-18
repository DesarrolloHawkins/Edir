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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Reintentar hasta 3 veces
    public $timeout = 120; // Timeout de 2 minutos
    public $backoff = [30, 60, 120]; // Esperar 30s, 60s, 120s entre reintentos

    protected $alerta;
    protected $usuarioId;
    protected $archivoPath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Alertas $alerta, $usuarioId, $archivoPath = null)
    {
        $this->alerta = $alerta;
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
        try {
            $usuario = User::find($this->usuarioId);
            
            if (!$usuario || !$usuario->email) {
                Log::warning("Usuario {$this->usuarioId} no encontrado o sin email");
                return;
            }

            // Recargar la alerta con la relación comunidad
            $this->alerta->load('comunidad');

            // Enviar el email
            Mail::to($usuario->email)->send(new NotificacionEmail($this->alerta, $this->archivoPath));
            
            // Registrar log de email enviado
            Logs::create([
                'user_id' => $usuario->id,
                'action' => 'Email Enviado',
                'description' => "Email enviado a {$usuario->email} - Notificación: {$this->alerta->titulo}",
                'date' => now(),
                'reference' => "Alerta ID: {$this->alerta->id}"
            ]);
            
            Log::info("Email enviado correctamente a {$usuario->email} para la alerta {$this->alerta->id}");
        } catch (\Exception $e) {
            Log::error("Error al enviar email a usuario {$this->usuarioId}: " . $e->getMessage());
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
