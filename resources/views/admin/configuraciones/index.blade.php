@extends('layouts.appUser')

@section('title', 'Configuraciones')
@section('back-url', route('home'))

@section('content-principal')
<div class="d-flex flex-column align-items-center pt-1" style="width: 100%">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Edir - Administrador de Fincas" class="img-fluid mb-3" style="max-width: 80px">
    <h4 class="text-center">Configuraciones del sistema</h4>
    <div class="row pt-4 w-100">
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.email') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-envelope px-3"></i>
                <span>Email</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.empresa') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-building px-3"></i>
                <span>Configuración de Empresa</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.whatsapp') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100" target="_blank">
                <i class="fa-brands fa-whatsapp px-3"></i>
                <span>WhatsApp</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.whatsapp.templates') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-file-lines px-3"></i>
                <span>Templates WhatsApp</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.mantenimiento.index') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-screwdriver-wrench px-3"></i>
                <span>Mantenimiento</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.avisos-whatsapp.index') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-bell px-3"></i>
                <span>Avisos WhatsApp</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.prompt') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-robot px-3"></i>
                <span>Prompt del Asistente</span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.logs.index') }}" class="btn btn-primero fs-4 p-3 d-flex align-items-center rounded-pill w-100">
                <i class="fa-solid fa-file-lines px-3"></i>
                <span>Logs del Sistema</span>
            </a>
        </div>
    </div>
</div>
@endsection
