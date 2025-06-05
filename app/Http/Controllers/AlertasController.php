<?php

namespace App\Http\Controllers;

use App\Models\Alertas;
use App\Http\Requests\StoreAlertasRequest;
use App\Http\Requests\UpdateAlertasRequest;
use Illuminate\Support\Facades\Auth;

class AlertasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAlertasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlertasRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alertas  $alertas
     * @return \Illuminate\Http\Response
     */
    public function show(Alertas $alertas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alertas  $alertas
     * @return \Illuminate\Http\Response
     */
    public function edit(Alertas $alertas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlertasRequest  $request
     * @param  \App\Models\Alertas  $alertas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlertasRequest $request, Alertas $alertas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alertas  $alertas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alertas $alertas)
    {
        //
    }

    public function alertasNoLeidas()
    {
        $user = Auth::user();

        // $alertas = $user->alertas()
        //     ->where(function ($q) {
        //         $q->wherePivot('status', 0)->orWhereNull('alertas_status.status');
        //     })
        //     ->latest('alertas.datetime')
        //     ->get();
        $alertas = Auth::user()->alertasNoLeidas()->get();

        return response()->json([
            'status' => true,
            'data' => $alertas,
        ]);
    }

    public function marcarAlertasComoLeidas()
    {
        $user = Auth::user();

        $user->alertas()->updateExistingPivot(
            $user->alertas->pluck('id'), // todos los alert_id relacionados
            ['status' => 1] // marcar como leída
        );

        return response()->json([
            'status' => true,
            'message' => 'Alertas marcadas como leídas.',
        ]);
    }


}
