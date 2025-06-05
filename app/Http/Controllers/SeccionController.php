<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeccionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $comunidad = Comunidad::find($user->comunidad_id)->first();
        $secciones = Seccion::where('comunidad_id', $comunidad->id)->get();
        if ($user->role != 1) {
            return view('secciones.indexUser', compact('secciones'));

        }

        return view('secciones.index', compact('secciones'));
    }
    public function create()
    {
        $response = '';
        // $user = Auth::user();

        return view('secciones.create', compact('response'));
    }
    public function edit($id)
    {
        return view('secciones.edit', compact('id'));

    }}
