<div class="container-fluid">
    <style>
        div.card-anuncio {
            margin-bottom: 5px !important;
            border: 1px solid black !important;
        }
    </style>
    @notmobile
        <div class="row">
            <div class="col-10">
                @if ($formularioCheck == 1)
                    <div class="row">
                        <form wire:submit.prevent="submit">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h5>Nueva incidencia</h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="nombre" class="col-sm-12 col-form-label">Nombre</label>
                                            <div class="col-sm-12">
                                                <input type="text" wire:model="nombre" class="form-control"
                                                    name="nombre" id="nombre" placeholder="José Carlos...">
                                                @error('titulo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="tipo" class="col-sm-12 col-form-label">Teléfono</label>
                                            <div class="col-sm-12">
                                                <input type="number" wire:model="telefono" class="form-control"
                                                    name="telefono" id="telefono" placeholder="José Carlos...">
                                                @error('titulo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="name" class="col-sm-12 col-form-label">Título</label>
                                            <div class="col-sm-12">
                                                <input type="text" wire:model="titulo" class="form-control"
                                                    name="titulo" id="titulo" placeholder="José Carlos...">
                                                @error('titulo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="descripcion" class="col-sm-12 col-form-label">Descripción</label>
                                            <div class="col-sm-12">
                                                <textarea wire:model.defer="descripcion" class="form-control" name="descripcion" id="descripcion"
                                                    placeholder="Pérez..."></textarea>
                                                @error('descripcion')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="ruta_imagen" class="col-sm-12 col-form-label">Imagen</label>
                                            <div class="col-sm-12">
                                                @if ($ruta_imagen)
                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <div class="col">
                                                            <img src="{{ $ruta_imagen->temporaryUrl() }}"
                                                                style="max-width: 50% !important; text-align: center">
                                                        </div>
                                                    </div>
                                                @endif
                                                <input type="file" wire:model="ruta_imagen" class="form-control"
                                                    name="ruta_imagen" id="ruta_imagen" placeholder="José Carlos...">
                                                @error('ruta_imagen')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" wire:click="submit" class="btn btn-primary">Publicar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
                @if ($subseccionCheck == 1)
                    <div class="row justify-content-center" id="items" wire:ignore>
                        @foreach ($subsecciones as $subseccion)
                            <div class="col-sm-2 col-xl-2 d-flex align-items-stretch" data-id="{{ $subseccion->id }}">
                                <div class="card w-100 text-center d-flex flex-column justify-content-center">
                                    <button type="button"
                                        class="btn d-flex flex-column justify-content-center align-items-center p-2"
                                        style="height: 100%;"
                                        wire:click="$emit('seleccionarSeccion', '{{ $subseccion->id }}')">
                                        <img src="{{ asset('storage/photos/' . $subseccion->ruta_imagen) }}" onerror="this.onerror=null; this.src='{{asset('storage/communitas_icon.png')}}';"
                                            class="card-img-top" style="width: auto; max-height: 100px;">
                                        <h6 class="mt-2">{{ $subseccion->nombre }}</h6>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row row-cols-1 row-cols-md-3 g-4 d-flex align-items-stretch">
                    @foreach ($anuncios as $anuncio)
                        <div class="col d-flex align-items-stretch">
                            <div class="card card-anuncio w-100">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-16 mt-0">{{ $anuncio->titulo }}</h4>
                                    <h6 class="card-subtitle font-12 mt-0" style="color: #8b8b8b !important">{{ $anuncio->nombre }} - {{$anuncio->telefono}}</h6>
                                    <p class="card-text">{{ $anuncio->descripcion }}</p>
                                    <div class="mt-auto">
                                        @if ($anuncio->tipo == 2)
                                            <a href="{{ $anuncio->url }}" class="btn btn-primary">Ver enlace</a>
                                        @elseif ($anuncio->tipo == 3)
                                            <img src="{{ asset('storage/archivos/' . $seccion->nombre . '/' . $anuncio->ruta_imagen) }}"
                                                class="card-img-top" style="width: auto; max-height: 100px;">
                                        @elseif ($anuncio->tipo == 4)
                                            <a href="{{ asset('storage/archivos/' . $seccion->nombre . '/' . $anuncio->ruta_imagen) }}"
                                                class="btn btn-primary">Ver enlace</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-2">
                <div class="card m-b-30">
                    <div class="card-body align-items-center">
                        <button type="button" class="btn btn-primary btn-lg text-center mb-3 w-100"
                            wire:click="seleccionarSeccionVolver()">Volver</button>
                        <button type="button" class="btn btn-primary btn-lg text-center mb-3 w-100"
                            wire:click="formularioCheck()">Añadir
                            incidencia</button>
                    </div>
                </div>
            </div>
        </div>
    @elsenotmobile
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body align-items-center">
                        <h5>Opciones</h5>
                        <button type="button" class="btn btn-primary btn-lg text-center mb-3 w-100"
                            wire:click="seleccionarSeccionVolver()">Volver</button>
                        <button type="button" class="btn btn-primary btn-lg text-center mb-3 w-100"
                            wire:click="formularioCheck()">Añadir
                            anuncio</button>
                        <button type="button" class="btn btn-primary btn-lg text-center mb-3 w-100"
                            wire:click="subseccionCheck()">Ver subsecciones</button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                @if ($formularioCheck == 1)
                    <div class="row">
                        <form wire:submit.prevent="submit">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <h5>Nuevo anuncio</h5>
                                        </div>
                                        <div class="col-sm-9">
                                            <label for="name" class="col-sm-12 col-form-label">Título</label>
                                            <div class="col-sm-10">
                                                <input type="text" wire:model="titulo" class="form-control"
                                                    name="titulo" id="titulo" placeholder="José Carlos...">
                                                @error('titulo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="tipo" class="col-sm-12 col-form-label">Tipo</label>
                                            <div class="col-sm-11" x-data="" x-init="$('#tipo').select2();
                                            $('#tipo').on('change', function(e) {
                                                var data = $('#tipo').select2('val');
                                                @this.set('tipo', data);
                                            });"
                                                wire:key='{{ time() }}'>
                                                <select wire:model="tipo" id="tipo" name="tipo"
                                                    class="form-control">
                                                    <option value="1">Texto</option>
                                                    <option value="2">Enlace</option>
                                                    <option value="3">Imagen</option>
                                                    <option value="4">Archivo</option>
                                                </select>
                                                @error('tipo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="descripcion" class="col-sm-12 col-form-label">Descripción</label>
                                            <div class="col-sm-10">
                                                <textarea wire:model.defer="descripcion" class="form-control" name="descripcion" id="descripcion"
                                                    placeholder="Pérez..."></textarea>
                                                @error('descripcion')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($tipo == 2)
                                            <div class="col-sm-12">
                                                <label for="url" class="col-sm-12 col-form-label">Enlace</label>
                                                <div class="col-sm-10">
                                                    <input type="url" wire:model="url" class="form-control"
                                                        name="url" id="url" placeholder="José Carlos...">
                                                    @error('url')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif ($tipo == 3)
                                            <div class="col-sm-12">
                                                <label for="ruta_imagen" class="col-sm-12 col-form-label">Imagen</label>
                                                <div class="col-sm-10">
                                                    @if ($ruta_imagen)
                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <div class="col">
                                                                <img src="{{ $ruta_imagen->temporaryUrl() }}"
                                                                    style="max-width: 50% !important; text-align: center">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <input type="file" wire:model="ruta_imagen" class="form-control"
                                                        name="ruta_imagen" id="ruta_imagen"
                                                        placeholder="José Carlos...">
                                                    @error('ruta_imagen')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif ($tipo == 4)
                                            <div class="col-sm-12">
                                                <label for="ruta_imagen" class="col-sm-12 col-form-label">Archivo</label>
                                                <div class="col-sm-10">
                                                    <input type="file" wire:model="ruta_imagen" class="form-control"
                                                        name="ruta_imagen" id="ruta_imagen"
                                                        placeholder="José Carlos...">
                                                    @error('ruta_imagen')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" wire:click="submit" class="btn btn-primary">Publicar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
                @if ($subseccionCheck == 1)
                    <div class="row justify-content-center" id="items" wire:ignore>
                        <h5>Subsecciones de {{ $seccion->nombre }}</h5>
                        @foreach ($subsecciones as $subseccion)
                            <div class="col-sm-2 col-xl-2 d-flex align-items-stretch" data-id="{{ $subseccion->id }}">
                                <div class="card w-100 text-center d-flex flex-column justify-content-center">
                                    <button type="button"
                                        class="btn d-flex flex-column justify-content-center align-items-center p-2"
                                        style="height: 100%;"
                                        wire:click="$emit('seleccionarSeccion', '{{ $subseccion->id }}')">
                                        <img src="{{ asset('storage/photos/' . $subseccion->ruta_imagen) }}"
                                            class="card-img-top" style="width: auto; max-height: 100px;">
                                        <h6 class="mt-2">{{ $subseccion->nombre }}</h6>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row row-cols-1 row-cols-md-3 g-4 d-flex align-items-stretch">
                    <h5>Últimos anuncios</h5>
                    @foreach ($anuncios as $anuncio)
                        <div class="col d-flex align-items-stretch">
                            <div class="card card-anuncio w-100">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-16 mt-0">{{ $anuncio->titulo }}</h4>
                                    <p class="card-text">{{ $anuncio->descripcion }}</p>
                                    <div class="mt-auto">
                                        @if ($anuncio->tipo == 2)
                                            <a href="{{ $anuncio->url }}" class="btn btn-primary">Ver enlace</a>
                                        @elseif ($anuncio->tipo == 3)
                                            <img src="{{ asset('storage/archivos/' . $seccion->nombre . '/' . $anuncio->ruta_imagen) }}"
                                                class="card-img-top" style="width: auto; max-height: 100px;">
                                        @elseif ($anuncio->tipo == 4)
                                            <a href="{{ asset('storage/archivos/' . $seccion->nombre . '/' . $anuncio->ruta_imagen) }}"
                                                class="btn btn-primary">Ver enlace</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    @endnotmobile
</div>
