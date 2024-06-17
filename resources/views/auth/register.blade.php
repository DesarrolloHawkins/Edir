<!DOCTYPE html>
<html lang="en">
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
</head>
<body style="background-color: #fff;">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-sm-12 text-center">
                <img src="{{ asset('assets/images/logo-empresa.png') }}" style="width: 35%;">
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-sm-12 text-center" style="color: #9ec84c;">
                <h1 style="font-size: 3rem;">Registrarse</h1>
            </div>
        </div>
        <br>

        <div class="row justify-content-center" style="position: relative; top: 50%;">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body" style="background-color: #9ec84c;">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" placeholder="Nombre" value="{{old('name')}}" autofocus>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="surname" placeholder="Apellido" value="{{old('surname')}}">
                                    @error('surname')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="username" placeholder="Usuario" value="{{old('username')}}">
                                    @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" name="codigo" value="{{old('codigo')}}" placeholder="Codigo de comunidad">
                                    @error('codigo')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="{{old('email')}}">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="phone" name="telefono" class="form-control" value="{{old('telefono')}}" placeholder="Telefono">
                                    @error('telefono')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña">
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    <style>.text-danger {color: red;}</style>
                                @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn w-100 mt-2" style="background-color: #fff;">
                                <span style="color: #9ec84c;"><b>{{('Registrar') }}</b></span>
                            </button>
                        </form>
                    </div>
                </div>
                <a type="submit" class="btn w-100" href="/login" style="background-color: #9EC84C !important; margin-top:10px;">
                    <span style="color: #ffffff !important"><b>{{('Inicio de sesión') }}</b></span>
                </a>
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
