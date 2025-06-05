@extends('layouts.appUser')

@section('title', 'Dashboard')

@section('head')
@endsection

@section('content-principal')
<div class="d-flex flex-column hv-100 justify-content-start align-items-center pt-4" style="height: 100%;width: 100%">

    <img src="{{asset('assets/images/logo.png')}}" alt="Edir - Administrador de Fincas"  class="img-fluid mb-3" style="max-width: 80px">
    <h4 style="width: 100%" class="text-center">Bienvenido a EDIR</h2>
    <h6 style="width: 100%" class="text-center mt-0">Tu administrador de fincas</h6>
    <div class="row pt-4" style="width: 100%">
        <div class="col-sm-12 col-md-4 mt-3">
            <a href="{{route('incidenciasAdmin.index')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-camera px-4"></i>
                <span>
                    Avisos
                </span>
            </a>
        </div>
        <div class="col-sm-12 col-md-4 mt-3">
            <a href="{{route('documentos.admin.index')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-file-invoice px-4"></i>
                <span>
                    Documentos
                </span>
            </a>
        </div>
        <div class="col-sm-12 col-md-4 mt-3">
            <a href="{{route('notificaciones.create')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-bell px-4"></i>
                <span>
                    Notificaciones
                </span>
            </a>
        </div>
        <div class="col-sm-12 col-md-4 mt-3">
            <a href="{{route('comunidades.index')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-building px-4"></i>
                <span>
                    Comunidades
                </span>
            </a>
        </div>
        <div class="col-sm-12 col-md-4 mt-3">
            <a href="{{route('usuarios.index')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-user-group px-4"></i>
                <span>
                    Usuarios
                </span>
            </a>
        </div>
        {{-- Botón Contacto Admin --}}
        <div class="col-sm-12 col-md-4 mt-3">
            <a href="{{ route('contacto.edit') }}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-phone-volume px-4"></i>
                <span>
                    Contacto
                </span>
            </a>
        </div>
        <div class="col-sm-12 col-md-4 mt-3">
            <form action="{{ route('logout') }}" method="POST" style="width: 100%">
                @csrf
                <button type="submit" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                    <i class="fa-solid fa-right-from-bracket px-4"></i>
                    <span>
                        Cerrar sesión
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
