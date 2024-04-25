<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Anuncio;
use App\Models\Comunidad;
use App\Models\Incidencia;
use App\Models\Seccion;
use App\Models\User;
use App\Models\UserClub;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;


class EditComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $identificador;

    public $name;
    public $surname;
    public $roles = 0; // 0 por defecto por si no se selecciona ninguna
    public $comunidad;
    public $role;
    public $username;
    public $password = null;
    public $email;
    public $inactive;
    public $comunidad_nombre;
    public $comunidad_direccion;
    public $comunidad_info;
    public $comunidad_imagen;
    public $comunidad_secciones;

    public function mount()
    {
        $usuarios  = User::find($this->identificador);
        $this->fill($usuarios->toArray()); // Rellena las propiedades con datos del usuario
        $this->comunidad = Comunidad::where('user_id', $this->identificador)->first();
        if ($this->comunidad) {
            $this->fill($this->comunidad->toArray()); // Rellena las propiedades con datos de la comunidad
            $this->comunidad_secciones = (new Seccion)->getHierarchy($this->comunidad->id);
        }
    }

    public function render()
    {
        return view('livewire.usuarios.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        $user = User::find($this->identificador);
        $this->password = isset($this->password) ? Hash::make($this->password): $user->password; // Usa la contraseña existente si no se proporciona una nueva
        // Validación de datos
        $validatedData = $this->validate(
            [
                'name' => 'required',
                'role' => 'required',
                'username' => 'required',
                'password' => 'required',
                'email' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            ],
            // Mensajes de error
            [
                'name.required' => 'El nombre es obligatorio.',
                'role.required' => 'El rol es obligatorio.',
                'username.required' => 'El nombre de usuario es obligatorio.',
                'password.required' => 'La contraseña es obligatoria.',
                'email.required' => 'El código postal es obligatorio.',
                'email.regex' => 'Introduce un email válido',

            ]
        );
        // Encuentra el identificador
        $usuariosSave = $user->update($validatedData);
        if ($this->comunidad != null) {
            $this->validate([
                'comunidad_nombre' => 'required|string|max:255',
                'comunidad_direccion' => 'required|string|max:255',
                'comunidad_imagen' => 'nullable|image|max:1024', // Por ejemplo, si es una imagen.
                'comunidad_info'   => 'nullable|string',
            ]);
            $imagen_guardar = 'communitas_icon.png';
            if (Storage::disk('public')->exists('photos/' . $this->ruta_imagen) == false) {

                $name = md5($this->ruta_imagen . microtime()) . '.' . $this->ruta_imagen->extension();

                $this->ruta_imagen->storePubliclyAs('public', 'photos/' . $name);

                $imagen_guardar = $name;
            }
            $comunidadSave = Comunidad::find($this->comunidad->id)->update(['user_id' => $usuariosSave->id, 'nombre' => $this->comunidad_nombre, 'direccion' => $this->comunidad_direccion, 'ruta_imagen' => $imagen_guardar, 'informacion_adicional' => $this->comunidad_info]);
        } else {
            $this->validate([
                'comunidad_nombre' => 'required|string|max:255',
                'comunidad_direccion' => 'required|string|max:255',
                'comunidad_imagen' => 'nullable|image|max:1024', // Por ejemplo, si es una imagen.
                'comunidad_info'   => 'nullable|string',
            ]);

            $comunidadSave = Comunidad::create(['user_id' => $usuariosSave->id, 'nombre' => $this->comunidad_nombre, 'direccion' => $this->comunidad_direccion, 'ruta_imagen' => $this->comunidad_imagen, 'informacion_adicional' => $this->comunidad_info]);
        }

        if ($usuariosSave) {
            $this->alert('success', '¡Usuario actualizado correctamente!', [
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

        session()->flash('message', 'Usuario actualizado correctamente.');

        $this->emit('userUpdated');
    }

    // Eliminación
    public function destroy()
    {

        $this->alert('warning', '¿Seguro que desea borrar el usuario? No hay vuelta atrás', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmDelete',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'confirmDelete',
            'destroy',
            'update',
            'duplicate'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('usuarios.index');
    }

    public function duplicate()
    {
        // Do something
        return redirect()->route('usuarios.duplicar', $this->identificador);
    }
    // Función para cuando se llama a la alerta
    public function confirmDelete()
    {
        $usuarios = User::find($this->identificador);
        $comunidad = Comunidad::where('user_id', $this->identificador)->first();
        if($comunidad){
            $secciones = Seccion::where('comunidad_id', $comunidad->id)->get();
            foreach ($secciones as $seccion) {
                if ($seccion->seccion_incidencias == 0) {
                    $anuncios = Anuncio::where('seccion_id', $seccion->id)->delete();
                } else {
                    $anuncios = Incidencia::where('comunidad_id', $comunidad->id)->delete();
                }
            }
            $comunidad->delete();
        }
        $usuarios->delete();
        return redirect()->route('usuarios.index');
    }
}
