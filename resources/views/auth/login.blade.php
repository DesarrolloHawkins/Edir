<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sesión - Mi comunidad - Edir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.css" integrity="sha512-CaTMQoJ49k4vw9XO0VpTBpmMz8XpCWP5JhGmBvuBqCOaOHWENWO1CrVl09u4yp8yBVSID6smD4+gpzDJVQOPwQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        input[type="checkbox"] {
            transform: scale(2);
        }

    </style>
</head>

<body class="h-100 w-100" style="background-color: #0E4C6B;">
    <div id="app" class="d-flex align-items-center justify-content-center vh-100">
        <div class="container px-4">
            <div class="row justify-content-center">
                <div class="col-sm-12 text-center">
                    <img src="{{ asset('assets/images/logo_white.png') }}" class="logo-login">
                </div>
                <div class="col-sm-12 text-center text-white">
                    <h4 style="font-size:1rem">Administradores de Fincas</h4>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-sm-12 text-center" style="color: white !important">
                    <h4 style="font-size: 1.5rem !important;">Iniciar sesión</h4>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="card" style="background-color: transparent !important; box-shadow: none !important">
                        <div class="card-body" style="background-color: transparent !important">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-10">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="name@example.com">
                                            <label for="username">Nombre de usuario</label>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                                            <label for="floatingPassword">Contraseña</label>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check text-white align-items-center d-flex justify-content-start mb-4">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label fs-6 ms-4" for="remember">
                                                {{ __('Recordar contraseña') }}
                                            </label>
                                        </div>

                                        <button type="submit" class="btn w-100 rounded-pill"
                                            style="background-color: #00BBFF !important;">
                                            <span style="color: white !important; font-size:20px"><b>{{ ('Acceder') }}</b></span>
                                            {{-- 0E4C6B --}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <a type="buttom" class="btn w-100 rounded-pill mt-4" href="/register"
                                style="background-color: white !important; margin-top:10px;">
                                <span style="color: #0E4C6B !important; font-size:20px"><b>{{ ('Registro') }}</b></span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous">
    </script>
</body>
</html>
