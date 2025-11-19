@extends('layouts.appUser')

@section('title', 'Configuración de Email')
@section('back-url', route('config.index'))

@section('content-principal')
<div class="container pb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Configuración de Email</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('config.email.update') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        
        <div class="mb-3">
            <label for="mail_mailer" class="form-label">Mailer</label>
            <select name="mail_mailer" id="mail_mailer" class="form-control" required>
                <option value="smtp" {{ $mailConfig['mail_mailer'] == 'smtp' ? 'selected' : '' }}>SMTP</option>
                <option value="sendmail" {{ $mailConfig['mail_mailer'] == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                <option value="mailgun" {{ $mailConfig['mail_mailer'] == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                <option value="ses" {{ $mailConfig['mail_mailer'] == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                <option value="postmark" {{ $mailConfig['mail_mailer'] == 'postmark' ? 'selected' : '' }}>Postmark</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="mail_host" class="form-label">Host SMTP</label>
            <input type="text" name="mail_host" id="mail_host" class="form-control" 
                   value="{{ $mailConfig['mail_host'] }}" required>
        </div>

        <div class="mb-3">
            <label for="mail_port" class="form-label">Puerto</label>
            <input type="number" name="mail_port" id="mail_port" class="form-control" 
                   value="{{ $mailConfig['mail_port'] }}" required>
        </div>

        <div class="mb-3">
            <label for="mail_username" class="form-label">Usuario</label>
            <input type="text" name="mail_username" id="mail_username" class="form-control" 
                   value="{{ $mailConfig['mail_username'] }}">
        </div>

        <div class="mb-3">
            <label for="mail_password" class="form-label">Contraseña</label>
            <input type="password" name="mail_password" id="mail_password" class="form-control" 
                   value="{{ $mailConfig['mail_password'] }}" placeholder="Dejar vacío para no cambiar">
            <small class="form-text text-muted">Dejar vacío si no deseas cambiar la contraseña actual.</small>
        </div>

        <div class="mb-3">
            <label for="mail_encryption" class="form-label">Encriptación</label>
            <select name="mail_encryption" id="mail_encryption" class="form-control">
                <option value="tls" {{ $mailConfig['mail_encryption'] == 'tls' ? 'selected' : '' }}>TLS</option>
                <option value="ssl" {{ $mailConfig['mail_encryption'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                <option value="" {{ empty($mailConfig['mail_encryption']) ? 'selected' : '' }}>Ninguna</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="mail_from_address" class="form-label">Email Remitente</label>
            <input type="email" name="mail_from_address" id="mail_from_address" class="form-control" 
                   value="{{ $mailConfig['mail_from_address'] }}" required>
        </div>

        <div class="mb-3">
            <label for="mail_from_name" class="form-label">Nombre Remitente</label>
            <input type="text" name="mail_from_name" id="mail_from_name" class="form-control" 
                   value="{{ $mailConfig['mail_from_name'] }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primero rounded-pill px-4">Guardar Configuración</button>
            <a href="{{ route('config.index') }}" class="btn btn-secondary rounded-pill px-4">Cancelar</a>
        </div>
    </form>
</div>
@endsection

