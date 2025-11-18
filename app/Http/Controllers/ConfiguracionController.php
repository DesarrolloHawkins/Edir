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

        // Actualizar el archivo .env
        $envPath = base_path('.env');
        
        if (File::exists($envPath)) {
            $envContent = File::get($envPath);
            
            // Actualizar o agregar las variables
            $envVars = [
                'MAIL_MAILER' => $request->mail_mailer,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username ?? '',
                'MAIL_PASSWORD' => $request->mail_password ?? '',
                'MAIL_ENCRYPTION' => $request->mail_encryption ?? 'tls',
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
                'MAIL_FROM_NAME' => $request->mail_from_name,
            ];

            foreach ($envVars as $key => $value) {
                // No actualizar la contraseña si está vacía
                if ($key === 'MAIL_PASSWORD' && empty($value)) {
                    continue;
                }
                
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}={$value}";
                
                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    $envContent .= "\n{$replacement}";
                }
            }

            File::put($envPath, $envContent);
            
            // Limpiar cache de configuración
            Artisan::call('config:clear');
        }

        return redirect()->route('config.email')->with('success', 'Configuración de email actualizada correctamente.');
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
