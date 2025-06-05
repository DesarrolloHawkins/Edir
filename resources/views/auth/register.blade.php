<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrarse - Mi comunidad - COMMUNITAS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <style>
        .iti.iti--allow-dropdown {
            width: 100%;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="h-100 w-100" style="background-color: #0E4C6B;">
    <div class="boton-volver">
        <a href="/login"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <div id="app" class="d-flex align-items-center justify-content-center vh-100">
        <div class="container px-4">
            <div class="row justify-content-center">
                <div class="col-sm-12 text-center">
                    <img src="{{ asset('assets/images/logo_white.png') }}" class="logo-login w-25">
                </div>
                <div class="col-sm-12 text-center text-white">
                    <h4 style="font-size:1rem">Administradores de Fincas</h4>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-sm-12 text-center" style="color: white !important">
                    <h4 style="font-size: 1.5rem !important;" class="m-0">Registrarse</h4>
                </div>
            </div>
            <br>

            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <form method="POST" action="{{ route('register') }}">
                        <div class="card">
                            <div class="card-body" style="background-color: transparent;">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-2">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" name="name" placeholder="Nombre" value="{{old('name')}}" autofocus>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>.text-danger {color: red;}</style>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="surname">Apellidos</label>
                                        <input type="text" class="form-control" name="surname" placeholder="Apellidos" value="{{old('surname')}}" autocomplete="false">
                                        @error('surname')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>.text-danger {color: red;}</style>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="username">Nombre de usuario</label>
                                        <input type="text" class="form-control" name="username" placeholder="Usuario" value="{{old('username')}}" autocomplete="false">
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>.text-danger {color: red;}</style>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="email">Correo electronico</label>
                                        <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="{{old('email')}}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>.text-danger {color: red;}</style>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="phone">Numero de movil</label>
                                        <input type="text" id="phone" name="telefono" class="form-control" value="{{old('telefono')}}" placeholder="Telefono">
                                        @error('telefono')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>.text-danger {color: red;}</style>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="codigo">Codigo de comunidad</label>
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" name="codigo" value="{{old('codigo')}}" placeholder="Codigo de comunidad">
                                        @error('codigo')
                                            <span class="text-danger">{{ $message }}</span>
                                            <style>.text-danger {color: red;}</style>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <label for="password">Contraseña</label>
                                        <input type="password" class="form-control" name="password" placeholder="Contraseña">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        <style>.text-danger {color: red;}</style>
                                    @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="password_confirmation">Confirmar contraseña</label>

                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        <style>.text-danger {color: red;}</style>
                                    @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn w-100 rounded-pill" style="background-color: #00BBFF;">
                            <span style="color: white; font-size:20px"><b>{{('Registrar') }}</b></span>
                        </button>
                    </form>
                        {{-- <a type="submit" class="btn w-100" href="/login" style="background-color: rgb(14, 76, 107) !important; margin-top:10px;">
                        <span style="color: #ffffff !important"><b>{{('Inicio de sesión') }}</b></span>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                initialCountry: "es",  // Establece el código de país predeterminado a +34 (España)
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

            var form = input.closest("form");
            form.addEventListener("submit", function(event) {
                var fullNumber = iti.getNumber();
                var phoneNumber = fullNumber.replace(/^\+/, ""); // Remueve el prefijo +34
                input.value = phoneNumber;
            });
        });
    </script>
</body>
</html>
