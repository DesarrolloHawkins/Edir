<?php

namespace App\Http\Livewire;

use App\Models\Alertas;
use App\Models\Anuncio;
use App\Models\Comunidad;
use App\Models\Seccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public $usuario;

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
        $this->comunidad_id = session('comunidad_id', Auth::user()->comunidad_id);
        $this->formularioCheck = 0;
        $this->subseccionCheck = 0;
        $this->secciones = Seccion::all();
        $this->seccion_id = $id;
        $this->seccion = Seccion::find($this->seccion_id);
        $this->subsecciones = Seccion::where('seccion_padre_id', $id)->orderBy('orden', 'asc')->get();
        $this->tipo = 1;
        $this->anuncios = Anuncio::where('seccion_id', $id)->get();
        $this->usuario= User::find(Auth::user()->id);
        $alertas = $this->usuario->alertas()->where('seccion_id',$this->seccion_id)->wherePivot('status', 0)->get();
        foreach($alertas as $alerta){
            $alertaId = $alerta->id;
            $this->usuario->alertas()->updateExistingPivot($alertaId, ['status' => 1]);
        }
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
        $datetime = date('Y-m-d');

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
            $name = $this->titulo . "-" . $datetime . '.' . $this->ruta_archivo->extension();

            $this->ruta_archivo->storePubliclyAs('public', 'archivos/' . $this->secciones->firstWhere('id', $this->seccion_id)->nombre . '/' . $name);

            $validatedData['ruta_archivo'] = $name;
        }
        // Guardar datos validados
        $usuariosSave = Anuncio::create($validatedData);

        $alertaSave = Alertas::create([
            'admin_user_id' =>Auth::user()->id,
            'tipo' =>$this->tipo,
            'datetime' => Carbon::now(),
            'titulo' =>$this->titulo ,
            'seccion_id'=> $this->seccion_id,
            'descripcion'=>$this->descripcion,
         ]);
        $comunidad = Comunidad::with('user')->find($this->comunidad_id);
        $users = $comunidad->user;
        $nombreseccion = Seccion::find($this->seccion_id);

        $data =[
            'seccion'=> $nombreseccion->nombre,
            'tipo'=> $this->tipo,
        ];

        foreach($users as $user){
            $user_ids =$user->id;
            $alertaSave->users()->attach($user_ids, ['status' => 0]);
            $response = enviarMensajeWhatsapp('nuevos_anuncios', $data, $user->telefono, 'es');
        }
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
