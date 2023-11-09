<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">@if($user->role == 1) VER/EDITAR @else VER @endif AVISO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Avisos</a></li>
                    <li class="breadcrumb-item active">@if($user->role == 1) Ver/Editar @else Ver @endif aviso</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
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
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Guardar cambios</button>
                            <button class="w-100 btn btn-danger mb-2" id="alertaEliminar">Eliminar
                                sección</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

@section('scripts')
    <script>
        $("#alertaGuardar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Pulsa el botón de confirmar para guardar los cambios.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('update');
                }
            });
        });
        $("#alertaEliminar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Se eliminarán todos los anuncios de esta sección, además de las subsecciones enlazadas.',
                icon: 'danger',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('destroy');
                }
            });
        });
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        document.addEventListener('livewire:load', function() {


        })
        $(document).ready(function() {
            console.log('select2')
            $("#datepicker").datepicker();

            $("#datepicker").on('change', function(e) {
                @this.set('fecha_nac', $('#datepicker').val());
            });

        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.className = "fas fa-eye-slash";
            } else {
                passwordInput.type = "password";
                eyeIcon.className = "fas fa-eye";
            }
        }
    </script>
@endsection
