<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Comunidad;
use App\Models\Seccion;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class DuplicarComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $identificador;
    public $name;
    public $surname;
    public $roles = 0; // 0 por defecto por si no se selecciona ninguna
    public $comunidad;
    public $role = 2;
    public $username;
    public $password = null;
    public $email;
    public $inactive;
    public $comunidad_nombre;
    public $comunidad_direccion;
    public $comunidad_info;
    public $comunidad_imagen;
    public $comunidad_secciones;
    public $name_old;
    public $user_department_id = 1;
    public $isAdminCheckbox = false;

    public function mount()
    {
        $this->comunidad = Comunidad::where('user_id', $this->identificador)->first();
        $this->name_old = User::where('id', $this->identificador)->first()->name;
        if ($this->comunidad != null) {
            $this->comunidad_secciones = (new Seccion)->getHierarchy($this->comunidad->id);
        }
    }
    public function render()
    {
        return view('livewire.usuarios.duplicar-component');
    }

    public function submit()
    {
        if ($this->isAdminCheckbox == false) {
            $this->role = 2;
        } elseif ($this->isAdminCheckbox == true) {
            $this->role = 1;
        }

        $this->password = Hash::make($this->password);
        // Validación de datos
        $validatedData = $this->validate(
            [
                'name' => 'required',
                'surname' => 'required',
                'role' => 'required',
                'username' => 'required',
                'password' => 'required',
                'user_department_id' => 'required',
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


        $this->validate([
            'comunidad_nombre' => 'required|string|max:255',
            'comunidad_direccion' => 'required|string|max:255',
            'comunidad_imagen' => 'nullable|image|max:1024', // Por ejemplo, si es una imagen.
            'comunidad_info'   => 'nullable|string',
        ]);

        $comunidadSave = Comunidad::create(['user_id' => $usuariosSave->id, 'nombre' => $this->comunidad_nombre, 'direccion' => $this->comunidad_direccion, 'ruta_imagen' => $this->comunidad_imagen, 'informacion_adicional' => $this->comunidad_info]);

        if ($comunidadSave) {
            // Obtener solo las secciones de nivel superior
            $seccionesNivelSuperior = Seccion::where('comunidad_id', $this->comunidad->id)
                ->where('seccion_padre_id', 0)
                ->get();

            // Array para mapear los IDs antiguos de las secciones a los nuevos
            $mapeoIds = [];

            // Primero clonar las secciones de nivel superior
            foreach ($seccionesNivelSuperior as $seccionSuperior) {
                $nuevaSeccionSuperior = $seccionSuperior->replicate();
                $nuevaSeccionSuperior->comunidad_id = $comunidadSave->id;
                $nuevaSeccionSuperior->seccion_padre_id = 0; // Mantenemos en 0 ya que es una sección de nivel superior
                $nuevaSeccionSuperior->save();

                // Almacenar la correspondencia entre el antiguo ID y el nuevo para las secciones de nivel superior
                $mapeoIds[$seccionSuperior->id] = $nuevaSeccionSuperior->id;

                // Clonar las subsecciones
                $subsecciones = Seccion::where('comunidad_id', $this->comunidad->id)
                    ->where('seccion_padre_id', $seccionSuperior->id)
                    ->get();

                foreach ($subsecciones as $subseccion) {
                    $nuevaSubseccion = $subseccion->replicate();
                    $nuevaSubseccion->comunidad_id = $comunidadSave->id;

                    // Establecer la nueva sección padre clonada
                    $nuevaSubseccion->seccion_padre_id = $mapeoIds[$subseccion->seccion_padre_id];
                    $nuevaSubseccion->save();

                    // Almacenar la correspondencia entre el antiguo ID y el nuevo para las subsecciones
                    $mapeoIds[$subseccion->id] = $nuevaSubseccion->id;
                }
            }
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
    public function confirmed()
    {
        // Do something
        return redirect()->route('usuarios.index');
    }
}
