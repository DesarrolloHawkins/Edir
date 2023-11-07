<?php

namespace App\Http\Livewire;

use App\Models\Anuncio;
use App\Models\Comunidad;
use App\Models\Seccion;
use Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class SeccionComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $formularioCheck;
    public $secciones;
    public $seccion;
    public $subsecciones;
    public $anuncios;
    public $seccion_id;
    public $comunidad_id;
    public $titulo;
    public $descripcion;
    public $tipo;
    public $url;
    public $ruta_archivo;
    public $subseccionCheck;

    public function mount($seccion_id)
    {
        $this->inicializarComponente($seccion_id);
    }

    public function seleccionarSeccionVolver()
    {
        $this->emit('seleccionarSeccion', $this->seccion->seccion_padre_id);
    }
    private function inicializarComponente($id)
    {
        $this->formularioCheck = 0;
        $this->subseccionCheck = 0;
        $this->secciones = Seccion::all();
        $this->seccion_id = $id;
        $this->seccion = Seccion::find($this->seccion_id);
        $this->subsecciones = Seccion::where('seccion_padre_id', $id)->orderBy('orden', 'asc')->get();
        $this->tipo = 1;
        $this->anuncios = Anuncio::where('seccion_id', $id)->get();
    }

    public function formularioCheck()
    {
        if ($this->subseccionCheck == 1) {
            $this->subseccionCheck = 0;
        }
        if ($this->formularioCheck == 0) {
            $this->formularioCheck = 1;
        } else {
            $this->formularioCheck = 0;
        }
    }
    public function subseccionCheck()
    {
        if ($this->formularioCheck == 1) {
            $this->formularioCheck = 0;
        }
        if ($this->subseccionCheck == 0) {
            $this->subseccionCheck = 1;
        } else {
            $this->subseccionCheck = 0;
        }
    }
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'titulo' => 'required',
                'seccion_id' => 'required',
                'descripcion' => 'nullable',
                'tipo' => 'required',
                'url' => 'nullable',
                'ruta_archivo' => 'nullable',

            ],
            // Mensajes de error
            [
                'titulo.required' => 'required',
                'seccion_id.required' => 'required',
                'tipo.required' => 'required',
            ]
        );
        if ($this->ruta_archivo != null) {
            $name = md5($this->ruta_archivo . microtime()) . '.' . $this->ruta_archivo->extension();

            $this->ruta_archivo->storePubliclyAs('public', 'archivos/' . $this->secciones->firstWhere('id', $this->seccion_id)->nombre . '/' . $name);

            $validatedData['ruta_archivo'] = $name;
        }

        // Guardar datos validados
        $usuariosSave = Anuncio::create($validatedData);

        // Alertas de guardado exitoso
        if ($usuariosSave) {
            $this->alert('success', '¡Publicación registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del socio!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.seccion-component');
    }

    public function getListeners()
    {
        return [
            'submit',
            'confirmed',
            'alertaGuardar',
            'seleccionarSeccion',
            'refreshComponent' => '$refresh',

        ];
    }
    public function seleccionarSeccion($id)
    {
        $this->inicializarComponente($id);
    }

    public function confirmed()
    {
        $this->inicializarComponente($this->seccion_id);
    }
    public function updateOrder($order)
    {
        foreach ($order as $item) {
            Seccion::find($item['value'])->update(['orden' => $item['order']]);
        }
        $this->subsecciones = Seccion::where('seccion_padre_id', $this->seccion_id)->orderBy('orden', 'asc')->get();

    }
}
