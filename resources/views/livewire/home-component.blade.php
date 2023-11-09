<div class="container-fluid">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                @if ($seccion_seleccionada == 0)
                    <h4 class="page-title">BIENVENIDO A {{ strtoupper($comunidad->nombre) }}</h4>
                @else
                    <h4 class="page-title">{{ $secciones->firstWhere('id', $seccion_seleccionada)->nombre }}
                    </h4>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item @if ($seccion_seleccionada == 0) active @endif"><a
                            href="javascript:void(0);">Dashboard</a></li>
                    @if ($seccion_seleccionada != 0)
                        {{ $this->obtenerJerarquia($seccion_seleccionada) }}
                    @endif
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    @if ($seccion_seleccionada == 0)
    @mobile
        <div class="row justify-content-center">
            <div class="col">
                <button class="btn btn-lg btn-primary add-button">Pulsa aquí para añadir Communitas a la pantalla de
                    inicio de tu móvil</button>
            </div>
        </div>
        @elsemobile
        <div class="row justify-content-center mb-5">
            <div class="col text-center">
                <button class="btn btn-lg btn-primary add-button">Pulsa aquí para añadir Communitas a la pantalla de
                    inicio de tu dispositivo</button>
            </div>
        </div>
        @endmobile
        <div class="row justify-content-center" id="items" x-data="" x-init="$nextTick(() => {
            var el = document.getElementById('items');
            var sortable = Sortable.create(el, {
                onEnd: function(evt) {
                    let order = sortable.toArray().map((id, index) => ({
                        value: id,
                        order: index + 1
                    }));
                    console.log(order);
                    @this.call('updateOrder', order);
                }
            });
        });"
            wire:ignore wire:key='{{time()}}'>
            @foreach ($secciones_menu as $seccion)
                <div class="col-sm-2 col-xl-2 d-flex align-items-stretch" data-id="{{ $seccion->id }}">
                    <div class="card w-100 text-center d-flex flex-column justify-content-center">
                        <button type="button"
                            class="btn d-flex flex-column justify-content-center align-items-center p-2"
                            style="height: 100%;" wire:click.prevent='seleccionarSeccion("{{ $seccion->id }}")'>
                            <img src="{{ asset('storage/photos/' . $seccion->ruta_imagen) }}" class="card-img-top"
                                style="width: auto; max-height: 100px;">
                            <h6 class="mt-2">{{ $seccion->nombre }}</h6>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @if ($secciones->firstWhere('id', $seccion_seleccionada)->seccion_incidencias == 1)
            @livewire('incidencias-component', ['seccion_id' => $seccion_seleccionada])
        @else
            @livewire('seccion-component', ['seccion_id' => $seccion_seleccionada])
        @endif
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @php
                $previousUrl = session('previous_url') ?? url()->previous();
                $previousPath = parse_url($previousUrl, PHP_URL_PATH);
                $isAdminRoute = Str::startsWith($previousPath, '/admin');
            @endphp

            @if (!$isAdminRoute)
                @mobile
                    $('body').removeClass('enlarged');
                @endmobile
            @endif
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
                    .then(function(registration) {
                        console.log('Service Worker registrado con éxito con el alcance:', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('Registro de Service Worker fallido:', error);
                    });
            }
            let deferredPrompt;
            const addBtn = document.querySelector(
                '.add-button'); // Asegúrate de tener un botón con la clase 'add-button' en tu HTML
            addBtn.style.display = 'none';

            window.addEventListener('beforeinstallprompt', (e) => {
                // Evita que Chrome muestre el prompt por defecto
                e.preventDefault();
                deferredPrompt = e;
                // Muestra el botón
                addBtn.style.display = 'block';

                addBtn.addEventListener('click', (e) => {
                    // Oculta el botón, ya que no será necesario
                    addBtn.style.display = 'none';
                    // Muestra el prompt
                    deferredPrompt.prompt();
                    // Espera a que el usuario responda al prompt
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('El usuario aceptó añadir a pantalla de inicio');
                        } else {
                            console.log('El usuario rechazó añadir a pantalla de inicio');
                        }
                        deferredPrompt = null;
                    });
                });
            });
            // Suponiendo que las alertas sin leer están en una variable de JavaScript `alertas`
            let alertas = @json($alertas);
            let promiseChain = Promise.resolve();

            alertas.forEach((alerta) => {
                promiseChain = promiseChain.then(() => {
                    switch (alerta.tipo) {
                        case 1:
                            return Swal.fire({
                                title: alerta.titulo,
                                text: alerta.descripcion,
                                type: 'info',
                                confirmButtonText: 'Entendido',
                                willClose: () => {
                                    // Marcar la alerta como leída usando Livewire o una solicitud AJAX
                                    @this.call('marcarComoLeida', alerta.id);
                                }
                            });
                            break;
                        case 2:
                            return Swal.fire({
                                title: alerta.titulo,
                                text: alerta.descripcion +
                                    "<br> Esta alerta contiene un enlace.",
                                type: 'info',
                                confirmButtonText: 'Entendido',
                                willClose: () => {
                                    // Marcar la alerta como leída usando Livewire o una solicitud AJAX
                                    @this.call('marcarComoLeida', alerta.id);
                                }
                            });
                            break;
                        case 3:
                            return Swal.fire({
                                title: alerta.titulo,
                                text: alerta.descripcion +
                                    "<br> Esta alerta contiene una imagen.",
                                type: 'info',
                                confirmButtonText: 'Entendido',
                                willClose: () => {
                                    // Marcar la alerta como leída usando Livewire o una solicitud AJAX
                                    @this.call('marcarComoLeida', alerta.id);
                                }
                            });
                            break;
                        case 4:
                            return Swal.fire({
                                title: alerta.titulo,
                                text: alerta.descripcion +
                                    "<br> Esta alerta contiene un archivo enlazado.",
                                type: 'info',
                                confirmButtonText: 'Entendido',
                                willClose: () => {
                                    // Marcar la alerta como leída usando Livewire o una solicitud AJAX
                                    @this.call('marcarComoLeida', alerta.id);
                                }
                            });
                            break;
                        default:
                            break;
                    }

                });
            });
        });
    </script>
</div>
