<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeccionController extends Controller
{
    public function index()
    {
        $response = '';
        // $user = Auth::user();

        return view('secciones.index', compact('response'));
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
