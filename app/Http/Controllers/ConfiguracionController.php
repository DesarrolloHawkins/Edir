<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpresaConfig;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('admin.configuraciones.index');
    }

    public function email()
    {
        // Leer configuración actual del .env o config
        $mailConfig = [
            'mail_mailer' => config('mail.default'),
            'mail_host' => config('mail.mailers.smtp.host'),
            'mail_port' => config('mail.mailers.smtp.port'),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_password' => config('mail.mailers.smtp.password'),
            'mail_encryption' => config('mail.mailers.smtp.encryption'),
            'mail_from_address' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
        ];

        return view('admin.configuraciones.email', compact('mailConfig'));
    }

    /**
     * Escapa un valor para el archivo .env de forma segura
     */
    private function escapeEnvValue($value)
    {
        // Si el valor es null, retornar cadena vacía sin comillas
        if ($value === null) {
            return '';
        }

        // Convertir a string
        $value = (string)$value;

        // Si el valor está vacío, retornar cadena vacía sin comillas
        if ($value === '') {
            return '';
        }

        // Si el valor contiene espacios, comillas, o caracteres especiales, usar comillas dobles
        $needsQuotes = preg_match('/[\s"\'#=$`\\\]/', $value);

        if ($needsQuotes) {
            // Escapar comillas dobles y backslashes dentro del valor
            $value = str_replace(['\\', '"'], ['\\\\', '\\"'], $value);
            return '"' . $value . '"';
        }

        return $value;
    }

    /**
     * Actualiza una variable en el archivo .env de forma segura
     */
    private function updateEnvFile($envPath, $updates)
    {
        if (!File::exists($envPath)) {
            throw new \Exception('El archivo .env no existe.');
        }

        if (!File::isWritable($envPath)) {
            throw new \Exception('El archivo .env no tiene permisos de escritura.');
        }

        // Leer el archivo completo preservando todas las líneas
        $content = File::get($envPath);
        $lines = explode("\n", $content);
        $updated = [];

        // Procesar cada línea
        foreach ($lines as $line) {
            $originalLine = $line;
            $line = rtrim($line);
            
            // Si es un comentario o línea vacía, mantenerla tal cual
            if (empty($line) || $line[0] === '#') {
                $updated[] = $originalLine;
                continue;
            }

            // Buscar clave=valor (puede tener espacios alrededor del =)
            if (preg_match('/^([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*)$/', $line, $matches)) {
                $key = $matches[1];
                $oldValue = trim($matches[2]);

                // Si esta clave está en los updates, reemplazarla
                if (isset($updates[$key])) {
                    $escapedValue = $this->escapeEnvValue($updates[$key]);
                    $updated[] = "{$key}={$escapedValue}";
                    unset($updates[$key]); // Marcar como procesado
                } else {
                    // Mantener la línea original
                    $updated[] = $originalLine;
                }
            } else {
                // Línea que no coincide con el patrón, mantenerla tal cual
                $updated[] = $originalLine;
            }
        }

        // Agregar las variables que no existían al final del archivo
        if (!empty($updates)) {
            // Asegurar que hay una línea en blanco antes de agregar nuevas variables
            if (!empty($updated) && !empty(trim(end($updated)))) {
                $updated[] = '';
            }
            foreach ($updates as $key => $value) {
                $escapedValue = $this->escapeEnvValue($value);
                $updated[] = "{$key}={$escapedValue}";
            }
        }

        // Escribir el archivo preservando el formato
        $newContent = implode("\n", $updated);
        // Asegurar que termine con un salto de línea si el original lo tenía
        if (substr($content, -1) === "\n") {
            $newContent .= "\n";
        }
        File::put($envPath, $newContent);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        try {
            $envPath = base_path('.env');
            
            // Preparar las variables a actualizar
            $envUpdates = [
                'MAIL_MAILER' => $request->mail_mailer,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => (string)$request->mail_port,
                'MAIL_USERNAME' => $request->mail_username ?? '',
                'MAIL_ENCRYPTION' => $request->mail_encryption ?? 'tls',
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
            ];

            // Solo actualizar la contraseña si se proporcionó una nueva
            if (!empty($request->mail_password)) {
                $envUpdates['MAIL_PASSWORD'] = $request->mail_password;
            }

            // Actualizar el archivo .env
            $this->updateEnvFile($envPath, $envUpdates);
            
            // Limpiar cache de configuración
            Artisan::call('config:clear');
            
            return redirect()->route('config.email')->with('success', 'Configuración de email actualizada correctamente.');
            
        } catch (\Exception $e) {
            \Log::error('Error al actualizar configuración de email: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('config.email')
                ->with('error', 'Error al actualizar la configuración: ' . $e->getMessage());
        }
    }

    public function empresa()
    {
        $empresa = EmpresaConfig::first();
        return view('admin.configuraciones.empresa', compact('empresa'));
    }

    public function updateEmpresa(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'cif' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'web' => 'nullable|url|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $empresa = EmpresaConfig::firstOrNew();
        
        $data = $request->only(['nombre', 'direccion', 'telefono', 'email', 'cif', 'web', 'descripcion']);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'empresa_logo_' . time() . '.' . $logo->extension();
            $logoPath = $logo->storeAs('empresa', $logoName, 'public');
            $data['logo'] = $logoPath;
        }

        $empresa->fill($data);
        $empresa->save();

        return redirect()->route('config.empresa')->with('success', 'Configuración de empresa actualizada correctamente.');
    }

    public function whatsapp()
    {
        return view('configuraciones.whatsapp');
    }

    public function templates()
    {
        return view('configuraciones.templates');
    }

    public function mantenimiento()
    {
        return view('configuraciones.mantenimiento');
    }

    public function avisos()
    {
        return view('configuraciones.avisos');
    }
}
