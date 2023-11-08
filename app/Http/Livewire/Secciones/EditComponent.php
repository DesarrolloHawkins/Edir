<?php

namespace App\Http\Livewire\Secciones;

use App\Models\Anuncio;
use App\Models\Comunidad;
use App\Models\Incidencia;
use App\Models\Seccion;
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
    public $comunidad = null;
    public $comunidad_id;
    public $ruta_imagen;
    public $nombre;
    public $seccion_padre_id;
    public $orden;
    public $secciones;
    public $seccion;
    public $seccion_incidencias;

    public function mount()
    {
        $this->seccion = Seccion::find($this->identificador);
        $this->orden = Seccion::all()->count() + 1;
        $this->comunidad = Comunidad::where('user_id', Auth::id())->first();
        $this->comunidad_id = $this->seccion->comunidad_id;
        $this->secciones = Seccion::all();
        $this->seccion_padre_id = $this->seccion->seccion_padre_id;
        $this->orden = $this->seccion->orden;
        $this->nombre = $this->seccion->nombre;
        $this->ruta_imagen = $this->seccion->ruta_imagen;
        $this->seccion_incidencias = $this->seccion->seccion_incidencias;
    }
    public function render()
    {
        return view('livewire.secciones.edit-component');
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
    public function update()
    {


        // Validación de datos
        $validatedData = $this->validate(
            [
                'comunidad_id' => 'required',
                'nombre' => 'required',
                'seccion_padre_id' => 'required',
                'ruta_imagen' => 'required',
                'orden' => 'required',
                'seccion_incidencias' => 'required',

            ],
            // Mensajes de error
            [
                'comunidad_id.required' => 'El nombre es obligatorio.',
                'nombre.required' => 'El nombre es obligatorio.',
                'seccion_padre_id.required' => 'El id de la categoría es obligatorio.',
                'ruta_imagen.required' => 'El mínimo de monitores es obligatorio.',
                'orden.required' => 'El el precio minimo por monitor es obligatorio.',
                'seccion_incidencias.required' => 'El tiempo de montaje es obligatorio.',
            ]
        );
        if (Storage::disk('public')->exists('photos/' . $this->ruta_imagen) == false) {

            $name = md5($this->ruta_imagen . microtime()) . '.' . $this->ruta_imagen->extension();

            $this->ruta_imagen->storePubliclyAs('public', 'photos/' . $name);

            $validatedData['ruta_imagen'] = $name;
        }
        // Encuentra el identificador
        $seccion = Seccion::find($this->identificador);

        // Guardar datos validados
        $seccionSave = $seccion->update($validatedData);

        if ($seccionSave) {
            $this->alert('success', '¡Seccion actualizada correctamente!', [
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del servicio!', [
                'position' => 'center',
                'toast' => false,
            ]);
        }

        session()->flash('message', 'Servicio actualizado correctamente.');

        $this->emit('eventUpdated');
    }
    public function destroy()
    {
        $seccion_padre = Seccion::where('id', $this->identificador)->first();
        $comunidad = Comunidad::where('id', $seccion_padre->comunidad_id)->first();
        $secciones = Seccion::where('seccion_padre_id', $this->identificador)->get();
        foreach ($secciones as $seccion) {
            if ($seccion->seccion_incidencias == 0) {
                $anuncios = Anuncio::where('seccion_id', $seccion->id)->delete();
            } else {
                $anuncios = Incidencia::where('comunidad_id', $comunidad->id)->delete();
            }
        }
        $anuncios = Anuncio::where('seccion_id', $seccion_padre->id)->delete();
        $secciones = Seccion::where('seccion_padre_id', $this->identificador)->delete();
        $seccion_padre->delete();
        return redirect()->route('secciones.index');
    }
    public function confirmed()
    {
        // Do something
        return redirect()->route('secciones.index');
    }
}
