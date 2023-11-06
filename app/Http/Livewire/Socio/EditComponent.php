<?php

namespace App\Http\Livewire\Socio;

use App\Models\Nota;
use App\Models\Socio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $identificador;
    public $club_id = 1;
    public $situacion_persona = 1;
    public $situacion_barco = 1;
    public $numero_socio;
    public $nombre_socio;
    public $dni;
    public $direccion;
    public $telefono_1;
    public $telefono_2;
    public $telefono_3;
    public $email;
    public $pantalan_t_atraque;
    public $nombre_barco;
    public $matricula;
    public $eslora;
    public $manga;
    public $calado;
    public $numero_llave;
    public $seguro_barco;
    public $poliza;
    public $vencimiento;
    public $itb;
    public $ruta_foto;
    public $notas;
    public $fecha_nota;
    public $texto_nota;
    public $puede_editar = false;
    public $puede_notas = false;

    public function mount()
    {
        $socio = Socio::find($this->identificador);
        $this->notas = Nota::where('socio_id', $this->identificador)->get();
        $this->situacion_persona = $socio->situacion_persona;
        $this->situacion_barco = $socio->situacion_barco;
        $this->numero_socio = $socio->numero_socio;
        $this->nombre_socio = $socio->nombre_socio;
        $this->dni = $socio->dni;
        $this->direccion = $socio->direccion;
        $this->telefono_1 = $socio->telefono_1;
        $this->telefono_2 = $socio->telefono_2;
        $this->telefono_3 = $socio->telefono_3;
        $this->email = $socio->email;
        $this->pantalan_t_atraque = $socio->pantalan_t_atraque;
        $this->nombre_barco = $socio->nombre_barco;
        $this->matricula = $socio->matricula;
        $this->eslora = $socio->eslora;
        $this->manga = $socio->manga;
        $this->calado = $socio->calado;
        $this->numero_llave = $socio->numero_llave;
        $this->seguro_barco = $socio->seguro_barco;
        $this->vencimiento = $socio->vencimiento;
        $this->itb = $socio->itb;
        $this->ruta_foto = $socio->ruta_foto;
        $this->puedeEditar();
    }
    public function render()
    {
        return view('livewire.socio.edit-component');
    }

    public function puedeEditar(){
        if(Auth::user()->role == 1 || Auth::user()->role == 2){
            $this->puede_editar = true;
        }
        if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3){
            $this->puede_notas = true;
        }
    }
    public function update()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'club_id' => 'required',
                'situacion_persona' => 'required',
                'situacion_barco' => 'required',
                'numero_socio' => 'required',
                'nombre_socio' => 'required',
                'dni' => 'required',
                'direccion' => 'required',
                'telefono_1' => 'required',
                'telefono_2' => 'required',
                'telefono_3' => 'required',
                'email' => 'required',
                'pantalan_t_atraque' => 'required',
                'nombre_barco' => 'required',
                'matricula' => 'required',
                'eslora' => 'required',
                'manga' => 'required',
                'calado' => 'required',
                'numero_llave' => 'required',
                'seguro_barco' => 'required',
                'poliza' => 'required',
                'vencimiento' => 'required',
                'itb' => 'required',
                'ruta_foto' => 'required',

            ],
            // Mensajes de error
            [
                'club_id.required' => 'required',
                'situacion_persona.required' => 'required',
                'situacion_barco.required' => 'required',
                'numero_socio.required' => 'required',
                'nombre_socio.required' => 'required',
                'dni.required' => 'required',
                'direccion.required' => 'required',
                'telefono_1.required' => 'required',
                'telefono_2.required' => 'required',
                'telefono_3.required' => 'required',
                'email.required'  => 'required',
                'pantalan_t_atraque.required' => 'required',
                'nombre_barco.required' => 'required',
                'matricula.required' => 'required',
                'eslora.required' => 'required',
                'manga.required' => 'required',
                'calado.required' => 'required',
                'numero_llave.required' => 'required',
                'seguro_barco.required' => 'required',
                'poliza.required' => 'required',
                'vencimiento.required' => 'required',
                'itb.required' => 'required',
                'ruta_foto.required' => 'required',
            ]
        );
        if (File::exists(asset('storage/photos/' . $this->ruta_foto)) == false) {
            $name = md5($this->ruta_foto . microtime()) . '.' . $this->ruta_foto->extension();

            $this->ruta_foto->storePubliclyAs('public', 'photos/' . $name);

            $validatedData['ruta_foto'] = $name;
        }
        $socio = Socio::find($this->identificador);
        $socioSave = $socio->update($validatedData);

        // Alertas de guardado exitoso
        if ($socioSave) {
            $this->alert('success', '¡Socio actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
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
    public function cambiarSituacionBarco($situacion)
    {
        $this->situacion_barco = $situacion;
    }
    public function cambiarSituacionPersona($situacion)
    {
        $this->situacion_persona = $situacion;
    }

    public function alertaGuardar()
    {
        $this->alert('warning', 'Asegúrese de que todos los datos son correctos antes de guardar.', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'update',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }


    public function alertaNota()
    {
        $this->alert('warning', '¿Estás seguro? Revisa la nota antes de guardarla.', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'guardarNota',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    public function guardarNota()
    {
        $notaSave = Nota::create(['socio_id' => $this->identificador, 'user_id' => Auth::id(), 'descripcion' => $this->texto_nota, 'fecha' => $this->fecha_nota]);
        if ($notaSave) {
            $this->notas = Nota::where('socio_id', $this->identificador)->get();
            $this->dispatchBrowserEvent('closeModal');
            $this->texto_nota = "";
            $this->fecha_nota = "";
        } else {
            $this->alert('error', '¡No se pudo guardar la nota!', [
                'position' => 'center',
                'toast' => false,
                'showDenyButton' => true,
                'denyButtonText' => 'Volver',
                'timerProgressBar' => true,
            ]);
        }
    }

    public function getListeners()
    {
        return [
            'update',
            'confirmed',
            'alertaGuardar',
            'alertaNota',
            'guardarNota'
        ];
    }

    public function confirmed()
    {
        // Do something
        return redirect()->route('socios.index');
    }
}
