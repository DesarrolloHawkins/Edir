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
            wire:ignore>
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
</div>
