<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">DATOS DE LAS COMUNIDADES</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Comunidad</a></li>
                    <li class="breadcrumb-item active">Todas las comunidades</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row" style="max-height: max-content !important">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Código</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comunidades as $comunidad)
                                    <tr>
                                        <td>
                                            @if (is_string($comunidad->ruta_imagen))
                                            <img src="{{ asset('storage/photos/' . $comunidad->ruta_imagen) }}"
                                                style="@mobile
                                                    width: 100px;
                                                    @elsemobile
                                                    max-height: 30vh !important;
                                                    @endmobile text-align: center">
                                        @else
                                            <img src="{{ $ruta_imagen->temporaryUrl() }}"
                                                style=" @mobile
                                                    width: 100px;
                                                    @elsemobile
                                                    max-height: auto !important;
                                                    @endmobile text-align: center">
                                        @endif
                                        </td>
                                        <td>{{ $comunidad->nombre }}</td>
                                        <td>
                                            <input type="text" wire:model.defer="updatedCodes.{{ $comunidad->id }}" wire:change.lazy="updateComunidad({{ $comunidad->id }})" class="form-control">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
