<?php

namespace App\Http\Controllers\Auth;

use App\Events\LogEvent;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Comunidad;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'codigo' => ['required', 'string', 'exists:comunidad,codigo'],
            'email' => ['required', 'string', 'max:255','email','unique:users,email'],
            'telefono' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'name.required' => 'El nombre es obligatorio',
            'surname.required' => 'El apellido es obligatorio',
            'username.required' => 'El usuario es obligatorio',
            'codigo.required' => 'El codigo es obligatorio ',
            'email.required' => 'El email es obligatorio',
            'telefono.required' => 'El telefono es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'La contraseña no coincide',
            'email.unique' => 'El email no puede estar registrado',
            'codigo.exists' => 'El codigo no coincide ',
        ]

        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $comunidad_id = Comunidad::where('codigo',$data['codigo'])->first();
            $user = User::create([
                'user_department_id'=> '1',
                'name' => $data['name'],
                'surname' =>  $data['surname'],
                'username' =>  $data['username'],
                'comunidad_id' =>  $comunidad_id->id,
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'role' => '2',
                'password' => Hash::make($data['password']),
                'inactive' => false
            ]);
        event(new LogEvent($user, 26, null));
        return $user;
    }
}
