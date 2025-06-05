<div class="mb-3">
    <label for="username" class="form-label">Usuario</label>
    <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $usuario->username ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $usuario->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="surname" class="form-label">Apellidos</label>
    <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', $usuario->surname ?? '') }}">
</div>
<div class="mb-3">
    <label for="email" class="form-label">Correo Electrónico</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $usuario->email ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $usuario->telefono ?? '') }}">
</div>
<div class="mb-3">
    <label for="role" class="form-label">Rol</label>
    <input type="text" name="role" id="role" class="form-control" value="{{ old('role', $usuario->role ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="comunidad_id" class="form-label">Comunidad</label>
    <select name="comunidad_id" id="comunidad_id" class="form-select">
        <option value="">Sin comunidad</option>
        @foreach ($comunidades as $comunidad)
            <option value="{{ $comunidad->id }}" {{ old('comunidad_id', $usuario->comunidad_id ?? '') == $comunidad->id ? 'selected' : '' }}>
                {{ $comunidad->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="password" class="form-label">Contraseña</label>
    <input type="password" name="password" id="password" class="form-control">
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
</div>
