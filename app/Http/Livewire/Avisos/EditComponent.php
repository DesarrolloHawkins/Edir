<?php

namespace App\Http\Livewire\Avisos;

use App\Models\Alertas;
use App\Models\Comunidad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $identificador;
    public $anuncio;
    public $titulo;
    public $descripcion;
    public $nombre;
    public $admin_user_id;
    public $tipo;
    public $url;
    public $ruta_archivo;
    public $users;
    public $datetime;
    public $user;

    public function mount()
    {
        $this->anuncio = Alertas::where('id', $this->identificador)->first();
        $this->titulo = $this->anuncio->titulo;
        $this->descripcion = $this->anuncio->descripcion;
        $this->tipo = $this->anuncio->tipo;
        $this->url = $this->anuncio->url;
        $this->ruta_archivo = $this->anuncio->ruta_archivo;
        $this->datetime = $this->anuncio->datetime;
        $this->admin_user_id = $this->anuncio->admin_user_id;
        $this->user = Auth::user();
        $this->users = User::where('role', 2)->get();
    }
    public function render()
    {
        return view('livewire.avisos.edit-component');
    }
    public function update()
    {


        $this->datetime = date('Y-m-d H:i:s');
        // Validación de datos
        $validatedData = $this->validate(
            [
                'admin_user_id' => 'required',
                'titulo' => 'required',
                'tipo' => 'required',
                'datetime' => 'required',
                'descripcion' => 'nullable',
                'url' => 'nullable',
                'ruta_archivo' => 'nullable',

            ],
            // Mensajes de error
            [
                'titulo.required' => 'required',
                'tipo.required' => 'required',
                'admin_user_id.required' => 'required',
                'datetime.required' => 'required',
            ]
        );
        if($this->ruta_archivo != null){
            if (Storage::disk('public')->exists('archivos/avisos/' . $this->ruta_archivo) == false) {

                $name = $this->titulo . "-" . $this->datetime . '.' . $this->ruta_archivo->extension();

                $this->ruta_archivo->storePubliclyAs('public', 'archivos/avisos/' . $name);

                $validatedData['ruta_archivo'] = $name;
            }
        }

        // Encuentra el identificador
        $seccion = Alertas::find($this->identificador);

        foreach ($this->anuncio->users()->get() as $user) {
            // Actualiza el campo 'status' en la tabla pivote para cada usuario a '0'
            $this->anuncio->users()->updateExistingPivot($user->id, ['status' => 0]);
        }

        $users = User::where('role', 2)->get();
        foreach($users as $user){
            enviarMensajeWhatsapp('actualizacion_aviso', '', $user->telefono, 'es');
        }
        // Guardar datos validados
        $seccionSave = $seccion->update($validatedData);

        if ($seccionSave) {
            $this->alert('success', '¡Aviso actualizada correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del aviso!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Servicio actualizado correctamente.');

        $this->emit('eventUpdated');
    }
    public function cargarUsuarios()
    {
        $usuariosEstatus = [];

        // Asegúrate de que la relación 'users' esté cargada para evitar N+1 queries.
        $this->anuncio->load('users');

        foreach ($this->anuncio->users as $user) {
            // Aquí accedemos al campo 'status' de la tabla pivote.
            $status = $user->pivot->status;
            $comunidad = Comunidad::where('id', $user->comunidad_id)->first() != null ? Comunidad::where('id', $user->comunidad_id)->first()->nombre : "Comunidad no asignada";
            // Basado en el estado, añadimos el string correspondiente al array.
            $usuariosEstatus[] = "<b>" . $user->name . " (" . $comunidad . ")</b>: " . ($status == 0 ? "No leído" : "Leído");
        }

        return $usuariosEstatus;
    }
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
    public function confirmed()
    {
        // Do something
        return redirect()->route('avisos.index');

    }
    public function destroy()
    {
        $this->alert('warning', '¿Seguro que desea borrar el aviso? No hay vuelta atrás', [
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
    public function confirmDelete()
    {
        $alerta = Alertas::find($this->identificador);
        $alerta->delete();
        return redirect()->route('avisos.index');
    }

}
