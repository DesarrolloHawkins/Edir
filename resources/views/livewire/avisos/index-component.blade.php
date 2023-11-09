<div class="container-fluid">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">ADMINISTRACIÓN DE AVISOS</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Avisos</a></li>
                    <li class="breadcrumb-item active">Administración de avisos</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <style>
        button.card-anuncio {
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
                                            <h5>Nuevo aviso</h5>
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
                                                wire:key='{{ time() }}'> <select wire:model="tipo" id="tipo"
                                                    class="form-control" name="tipo">
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
                                                <label for="ruta_archivo" class="col-sm-12 col-form-label">Imagen</label>
                                                <div class="col-sm-10">
                                                    @if ($ruta_archivo)
                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <div class="col">
                                                                <img src="{{ $ruta_archivo->temporaryUrl() }}"
                                                                    style="max-width: 50% !important; text-align: center">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <input type="file" wire:model="ruta_archivo" class="form-control"
                                                        name="ruta_archivo" id="ruta_archivo" placeholder="José Carlos...">
                                                    @error('ruta_archivo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif ($tipo == 4)
                                            <div class="col-sm-12">
                                                <label for="ruta_archivo" class="col-sm-12 col-form-label">Archivo</label>
                                                <div class="col-sm-10">
                                                    <input type="file" wire:model="ruta_archivo" class="form-control"
                                                        name="ruta_archivo" id="ruta_archivo" placeholder="José Carlos...">
                                                    @error('ruta_archivo')
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
                <div class="row row-cols-1 row-cols-md-3 g-4 d-flex align-items-stretch">
                    @foreach ($anuncios as $anuncio)
                        <div class="col d-flex align-items-stretch">
                            <button onclick="location.href='{{ route('avisos.edit', $anuncio->id) }}';"
                                class="card card-anuncio w-100">
                                <div class="card-body d-flex flex-column" style="align-items: flex-start !important;">
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
                            </button>
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
                                                        name="ruta_imagen" id="ruta_imagen" placeholder="José Carlos...">
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
                                                        name="ruta_imagen" id="ruta_imagen" placeholder="José Carlos...">
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
                <div class="row row-cols-1 row-cols-md-3 g-4 d-flex align-items-stretch">
                    <h5>Últimos anuncios</h5>
                    @foreach ($anuncios as $anuncio)
                        <div class="col d-flex align-items-stretch">
                            <button onclick="location.href='{{ route('avisos.edit', $anuncio->id) }}';"
                                class="card card-anuncio w-100">
                                <div class="card-body d-flex flex-column" style="align-items: flex-start !important;">
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
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endnotmobile
</div>
