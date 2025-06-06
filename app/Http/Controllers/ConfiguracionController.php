<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('admin.configuraciones.index');
    }

    public function whatsapp()
    {
        return view('configuraciones.whatsapp');
    }

    public function templates()
    {
        return view('configuraciones.templates');
    }

    public function mantenimiento()
    {
        return view('configuraciones.mantenimiento');
    }

    public function avisos()
    {
        return view('configuraciones.avisos');
    }
}
