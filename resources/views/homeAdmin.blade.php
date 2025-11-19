@extends('layouts.appUser')

@section('title', 'Dashboard')

@section('head')
<style>
    .dashboard-grid {
        width: 100%;
    }
    .dashboard-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        border-radius: 999px;
        font-size: 1.35rem;
        line-height: 1.2;
        white-space: nowrap;
    }
    .dashboard-btn i {
        font-size: 1.3em;
        margin-right: .5rem;
    }
    .dashboard-btn span {
        flex: 1;
        text-align: left;
    }
    @media (max-width: 1199.98px) {
        .dashboard-btn {
            font-size: 1.2rem;
            padding: 0.9rem 1.25rem;
        }
    }
    @media (max-width: 991.98px) {
        .dashboard-btn {
            font-size: 1.1rem;
        }
    }
</style>
@endsection

@section('content-principal')
<div class="d-flex flex-column hv-100 justify-content-start align-items-center pt-4" style="height: 100%;width: 100%">

    <img src="{{asset('assets/images/logo.png')}}" alt="Edir - Administrador de Fincas"  class="img-fluid mb-3" style="max-width: 80px">
    <h4 style="width: 100%" class="text-center">Bienvenido a EDIR</h2>
    <h6 style="width: 100%" class="text-center mt-0">Tu administrador de fincas</h6>
    <div class="row dashboard-grid pt-4">
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{route('incidenciasAdmin.index')}}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-camera"></i>
                <span>
                    Avisos
                </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{route('documentos.admin.index')}}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-file-invoice"></i>
                <span>
                    Documentos
                </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{route('notificaciones.create')}}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-bell"></i>
                <span>
                    Notificaciones
                </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{route('comunidades.index')}}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-building"></i>
                <span>
                    Comunidades
                </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{route('usuarios.index')}}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-user-group"></i>
                <span>
                    Usuarios
                </span>
            </a>
        </div>
        {{-- Botón Contacto Admin --}}
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('contacto.edit') }}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-phone-volume"></i>
                <span>
                    Contacto
                </span>
            </a>
        </div>
        {{-- Botón Configuraciones --}}
        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <a href="{{ route('config.index') }}" class="btn btn-primero dashboard-btn">
                <i class="fa-solid fa-gear"></i>
                <span>Configuraciones</span>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mt-3">
            <form action="{{ route('logout') }}" method="POST" style="width: 100%">
                @csrf
                <button type="submit" class="btn btn-primero dashboard-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>
                        Cerrar sesión
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
