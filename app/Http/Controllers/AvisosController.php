<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvisosController extends Controller
{
    public function index()
    {
        $response = '';
        // $user = Auth::user();

        return view('avisos.index', compact('response'));
    }
    public function create()
    {
        $response = '';
        // $user = Auth::user();

        return view('avisos.create', compact('response'));
    }
    public function edit($id)
    {
        return view('avisos.edit', compact('id'));

    }
}
