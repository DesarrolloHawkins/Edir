<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Club;
use App\Models\UserClub;

class HomeComponent extends Component
{
    public $clubs;
    public function mount(){
        if(Auth::user()->role == 1){
            $this->clubs = Club::all();
        }else{
            $this->clubs = Club::whereIn('id', UserClub::where('user_id', Auth::id())->pluck('club_id'))->get();
        }
    }
    public function render()
    {
        return view('livewire.home-component');
    }

    public function seleccionarClub($id){
        session()->put('clubSeleccionado', $id);
        return redirect()->route('socios.index');
    }
}
