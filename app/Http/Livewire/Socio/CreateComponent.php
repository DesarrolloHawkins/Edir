<?php

namespace App\Http\Livewire\Socio;

use App\Models\Socio;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;
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
    public function render()
    {
        return view('livewire.socio.create-component');
    }

    public function submit()
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
        $name = md5($this->ruta_foto . microtime()) . '.' . $this->ruta_foto->extension();

        $this->ruta_foto->storePubliclyAs('public', 'photos/' . $name);

        $validatedData['ruta_foto'] = $name;
        // Guardar datos validados
        $usuariosSave = Socio::create($validatedData);

        // Alertas de guardado exitoso
        if ($usuariosSave) {
            $this->alert('success', '¡Socio registrado correctamente!', [
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
            'onConfirmed' => 'submit',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }
    public function getListeners()
    {
        return [
            'submit',
            'confirmed',
            'alertaGuardar'

        ];
    }

    public function confirmed()
    {
        // Do something
        return redirect()->route('socio.index');
    }

}
