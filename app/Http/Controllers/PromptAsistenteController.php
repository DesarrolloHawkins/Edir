<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromptAsistente;

class PromptAsistenteController extends Controller
{
    public function index()
    {
        $prompt = PromptAsistente::latest()->first();
        return view('admin.configuraciones.prompt', compact('prompt'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|min:10',
        ]);

        PromptAsistente::create([
            'prompt' => $request->prompt,
        ]);

        return redirect()->route('config.prompt')->with('success', 'Prompt guardado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prompt' => 'required|string|min:10',
        ]);

        $prompt = PromptAsistente::findOrFail($id);
        $prompt->update(['prompt' => $request->prompt]);

        return redirect()->route('config.prompt')->with('success', 'Prompt actualizado correctamente.');
    }
}
