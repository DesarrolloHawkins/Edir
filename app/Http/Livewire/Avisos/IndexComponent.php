<?php

namespace App\Http\Livewire\Avisos;

use App\Models\Alertas;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class IndexComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $formularioCheck;
    public $anuncios;
    public $titulo;
    public $descripcion;
    public $nombre;
    public $admin_user_id;
    public $tipo;
    public $url;
    public $ruta_archivo;
    public $datetime;
    public function mount()
    {
        $this->anuncios = Alertas::all();
        $this->admin_user_id = Auth::user()->id;
        $this->tipo = 1;

    }
    public function render()
    {
        return view('livewire.avisos.index-component');
    }


    public function formularioCheck()
    {

        if ($this->formularioCheck == 0) {
            $this->formularioCheck = 1;
        } else {
            $this->formularioCheck = 0;
        }
    }

    public function submit()
    {
        $this->datetime = date('Y-m-d');
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
        if ($this->ruta_archivo != null) {

            $name = $this->titulo . "-" . $this->datetime . '.' . $this->ruta_archivo->extension();

            $this->ruta_archivo->storePubliclyAs('public', 'archivos/avisos/' . $name);

            $validatedData['ruta_archivo'] = $name;
        }

        // Guardar datos validados
        $alertaSave = Alertas::create($validatedData);

        $user_ids = User::where('role', 2)->pluck('id');

        $alertaSave->users()->attach($user_ids, ['status' => 0]);


        // Alertas de guardado exitoso
        if ($alertaSave) {
            $this->alert('success', '¡Aviso registrado correctamente!', [
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


    public function confirmed()
    {
        return redirect()->route('avisos.index');
    }
}
