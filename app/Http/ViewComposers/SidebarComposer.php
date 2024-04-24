<?php

namespace App\Http\ViewComposers;

use App\Models\Comunidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $comunidadId = session('comunidad_id', Comunidad::where('user_id', $user->id)->value('id'));
        $comunidad = Comunidad::find($comunidadId);
        $view->with('comunidad', $comunidad);
    }
}
