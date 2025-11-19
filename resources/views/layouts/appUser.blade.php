<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        use App\Models\Comunidad;
        use Illuminate\Support\Facades\Route;
    ?>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <script src="//unpkg.com/alpinejs" defer></script>

    <title>Edir - @yield('title') </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.css"
        integrity="sha512-CaTMQoJ49k4vw9XO0VpTBpmMz8XpCWP5JhGmBvuBqCOaOHWENWO1CrVl09u4yp8yBVSID6smD4+gpzDJVQOPwQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <x-livewire-alert::scripts />


    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="../../../plugins/morris/morris.css">

    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../../assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="../../../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../../../assets/css/style.css" rel="stylesheet" type="text/css">
    {{-- <link rel="stylesheet" href="../css/metismenu.min.css"> --}}
    @yield('head')
    <!-- Scripts -->
    @vite(['resources/sass/appUser.scss', 'resources/js/app.js'])

</head>

<body>
    @php
        $user = Auth::user();
        $comunidadId = session('comunidad_id', Comunidad::where('id', Auth::user()->comunidad_id)->value('id'));
        // $comunidad = Comunidad::find($comunidadId);
        $comunidad = null;
    @endphp
    <div id="app">
            @include('layouts.headerUser')
            {{-- @include('layouts.sidebar') --}}
            <div class="content-app px-4">
                @php
                    $showBackButtonRaw = trim($__env->yieldContent('show-back-button', 'true'));
                    $showBackButton = !in_array(strtolower($showBackButtonRaw), ['0', 'false', 'no']);
                    $customBackRoute = trim($__env->yieldContent('back-url'));
                    $customBackRoute = $customBackRoute === '' ? null : $customBackRoute;
                    $customBackLabel = trim($__env->yieldContent('back-label'));
                    $customBackLabel = $customBackLabel === '' ? null : $customBackLabel;
                    $excludedRoutes = ['home', 'inicio', 'login', 'register'];
                    $currentRoute = Route::currentRouteName();
                @endphp
                @if ($showBackButton && (!in_array($currentRoute, $excludedRoutes)))
                    <div class="pt-3">
                        <x-back-button :route="$customBackRoute" :label="$customBackLabel ?? 'Atrás'" />
                    </div>
                @endif
                {{-- @livewire('container-component') --}}
                @yield('content-principal')

            </div>



    </div>
    <script src="../../../assets/js/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Bootstrap 5 JS - Debe estar antes del bootstrap.bundle.min.js local para que funcione correctamente -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap local comentado para evitar conflictos - usar el de CDN arriba -->
    {{-- <script src="../../../assets/js/bootstrap.bundle.min.js"></script> --}}
    <script src="../../../assets/js/metismenu.min.js"></script>
    <script src="../../../assets/js/jquery.slimscroll.js"></script>
    <script src="../../../assets/js/waves.min.js"></script>

    <!--Morris Chart-->
    {{-- <script src="../plugins/morris/morris.min.js"></script> --}}
    <script src="../../../plugins/raphael/raphael.min.js"></script>

    {{-- <script src="../assets/pages/dashboard.init.js"></script> --}}

    @livewireScripts
    @yield('scripts')
    
    <!-- App js - Debe cargarse después de Bootstrap para que las funciones estén disponibles -->
    <script src="../../../assets/js/app.js"></script>
    <script>
        $(document).ready(function () {
            console.log('entrando al script de alertas');
            function cargarAlertas() {
                $.get("{{ route('alertas.noLeidas') }}", function (res) {
                    const contenedor = $('#contenido-alertas');
                    contenedor.empty();

                    if (res.status && res.data.length > 0) {
                        $('#contador-alertas').text(res.data.length).show();
                        res.data.forEach(alerta => {
                            contenedor.append(`
                                <div class="alert alert-warning">
                                    <strong>${alerta.titulo}</strong><br>
                                    <small>${new Date(alerta.datetime).toLocaleString()}</small>
                                    <p>${alerta.descripcion}</p>
                                </div>
                            `);
                        });
                    } else {
                        $('#contador-alertas').hide();
                        contenedor.append('<p>No hay alertas no leídas.</p>');
                    }
                });
            }

            $('#alerta-icono').on('click', function () {
                console.log('Cargando alertas...');
                cargarAlertas();
                // Usar Bootstrap 5 API
                const modal = new bootstrap.Modal(document.getElementById('modalAlertas'));
                modal.show();
                // Esperar 3 segundos antes de marcar como leídas
                setTimeout(function () {
                    $.post("{{ route('alertas.marcarLeidas') }}", {
                        _token: '{{ csrf_token() }}'
                    }, function () {
                        $('#contador-alertas').hide();
                        console.log('Alertas marcadas como leídas');
                    });
                }, 3000); // 3000 milisegundos = 3 segundos
            });

            // Cargar al iniciar
            cargarAlertas();
        });
    </script>

</body>

</html>
