@extends('layouts.appUser')

@section('title', 'Dashboard')

@section('head')
@endsection

@section('content-principal')
<div class="d-flex flex-column hv-100 justify-content-start align-items-center pt-4" style="height: 100%;width: 100%">
    @php
        use App\Models\Comunidad;
        $user = Auth::user();
        $comunidadId = session('comunidad_id', Comunidad::where('id', Auth::user()->comunidad_id)->value('id'));
        // $comunidad = Comunidad::find($comunidadId);
        $comunidad = null;
    @endphp
    <img src="{{asset('assets/images/logo.png')}}" alt="Edir - Administrador de Fincas"  class="img-fluid mb-3" style="max-width: 80px">
    <h4 style="width: 100%" class="text-center">Bienvenido a EDIR</h2>
    <h6 style="width: 100%" class="text-center mt-0">Tu administrador de fincas</h6>
    <div class="row pt-4" style="width: 100%">
        <div class="col-sm-12 col-md-6">
            <a href="{{route('incidencias.index')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-camera px-4"></i>
                <span>
                    Avisos
                </span>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 mt-3">
            <a href="{{route('documentos.index')}}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-file-invoice px-4"></i>
                <span>
                    Documentos
                </span>
            </a>
        </div>
        {{-- <div class="col-sm-12 col-md-6 mt-3">
            <a href="" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-bell px-4"></i>
                <span>
                    Notificaciones
                </span>
            </a>
        </div> --}}
        <div class="col-sm-12 col-md-6 mt-3">
            <a href="{{ route('contacto.form') }}" class="btn btn-primero fs-3 p-3 d-flex align-items-center rounded-pill" style="width: 100%">
                <i class="fa-solid fa-phone-volume px-4"></i>
                <span>
                    Contacto
                </span>
            </a>
        </div>

        <div class="col-sm-12 col-md-6 mt-3 mb-3">
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
