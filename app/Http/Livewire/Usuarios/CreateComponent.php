<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Comunidad;
use App\Models\User;
use App\Models\Rol;
use App\Models\Club;
use App\Models\UserClub;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;


class CreateComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $name;
    public $surname;
    public $role;
    public $username;
    public $despartamentos;
    public $password;
    public $email;
    public $user_department_id = 1;
    public $inactive;
    public $comunidad_nombre;
    public $comunidad_direccion;
    public $comunidad_info;
    public $comunidad_imagen;
    public $comunidad_secciones;
    public $isAdminCheckbox = false;

    public function render()
    {
        return view('livewire.usuarios.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {

        $this->role = $this->isAdminCheckbox ? 1 : 2;
        $this->password = Hash::make($this->password);
        // Validación de datos
        $validatedData = $this->validate(
            [
                'name' => 'required',
                'surname' => 'required',
                'role' => 'required',
                'username' => 'required',
                'password' => 'required',
                'user_department_id' => 'nullable',
                'email' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],

            ],
            // Mensajes de error
            [
                'name.required' => 'El nombre es obligatorio.',
                'surname.required' => 'El apellido es obligatorio.',
                'role.required' => 'El rol es obligatorio.',
                'username.required' => 'El nombre de usuario es obligatorio.',
                'password.required' => 'La contraseña es obligatoria.',
                'user_department_id.required' => 'El departamento es obligatorio.',
                'email.required' => 'El email es obligatorio.',
                'email.regex' => 'Introduce un email válido',
            ]
        );

        // Guardar datos validados
        $validatedData['inactive'] = 0;
        $usuariosSave = User::create($validatedData);
        if ($this->role == 2) {
            $this->validate([
                'comunidad_nombre' => 'required|string|max:255',
                'comunidad_direccion' => 'required|string|max:255',
                'comunidad_info' => 'nullable|string',
                'comunidad_imagen' => 'nullable|image|max:1024',
            ]);

            $imagen_subir = 'communitas_icon.png';
            if ($this->comunidad_imagen) {
                $name = md5($this->comunidad_imagen . microtime()) . '.' . $this->comunidad_imagen->extension();
                $this->comunidad_imagen->storePubliclyAs('public', 'photos/' . $name);
                $imagen_subir = $name;
            }

            Comunidad::create([
                'user_id' => $usuariosSave->id,
                'nombre' => $this->comunidad_nombre,
                'direccion' => $this->comunidad_direccion,
                'ruta_imagen' => $imagen_subir,
                'informacion_adicional' => $this->comunidad_info
            ]);
        }


        // Alertas de guardado exitoso
        if ($usuariosSave) {
            $this->alert('success', '¡Usuario registrado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del usuario!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'submit'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('usuarios.index');
    }
}
