@extends('layouts.appUser')

@section('title', 'Perfil de Usuario')

@section('content-principal')
<div class="container mt-4">
    <h2>Mi Perfil</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Apellidos</label>
            <input type="text" name="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Imagen de perfil</label>
            <input type="file" name="image" class="form-control">
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" width="100" class="mt-2 rounded">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>

    <hr class="my-5">

    <h4>Cambiar contraseña</h4>

    @if (session('success_password'))
        <div class="alert alert-success">{{ session('success_password') }}</div>
    @endif

    <form method="POST" action="{{ route('perfil.updatePassword') }}" class="mb-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Contraseña actual</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Nueva contraseña</label>
            <input type="password" name="new_password" class="form-control" required>
            @error('new_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Confirmar nueva contraseña</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar contraseña</button>
    </form>
</div>
@endsection
