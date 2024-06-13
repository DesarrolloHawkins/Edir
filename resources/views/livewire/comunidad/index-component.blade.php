<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">DATOS DE LA COMUNIDAD</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Comunidad</a></li>
                    <li class="breadcrumb-item active">Ver/Editar datos de tu comunidad</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->
    <div class="row" style="max-height: max-content !important">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="ruta_imagen" class="col-sm-12 col-form-label">Foto de la comunidad</label>
                                <div class="col-sm-11">
                                    @if ($ruta_imagen)
                                        <div class="col text-center">
                                            @if (is_string($ruta_imagen))
                                                <img src="{{ asset('storage/photos/' . $ruta_imagen) }}"
                                                    style="@mobile
                                                        max-width: 100%;
                                                        @elsemobile
                                                        max-height: 30vh !important;
                                                        @endmobile text-align: center">
                                            @else
                                                <img src="{{ $ruta_imagen->temporaryUrl() }}"
                                                    style=" @mobile
                                                        max-width: 100%;
                                                        @elsemobile
                                                        max-height: 30vh !important;
                                                        @endmobile text-align: center">
                                            @endif
                                        </div>
                                    @endif
                                    <br>
                                    <input type="file" class="form-control" wire:model="ruta_imagen"
                                        name="ruta_imagen" id="ruta_imagen" placeholder="Imagen del producto...">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="nombre" class="col-sm-12 col-form-label">Nombre de la comunidad</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="nombre" class="form-control" name="nombre"
                                        id="nombre" placeholder="José Carlos...">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="surname" class="col-sm-12 col-form-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="direccion" class="form-control"
                                        name="direccion" id="direccion" placeholder="Pérez...">
                                    @error('direccion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="informacion_adicional" class="col-sm-12 col-form-label">Información
                                    adicional</label>
                                <div class="col-sm-11">
                                    <textarea wire:model.defer="informacion_adicional" class="form-control" name="informacion_adicional"
                                        id="informacion_adicional" placeholder="Pérez..."></textarea>
                                    @error('informacion_adicional')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Guardar cambios</button>
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
                text: 'Pulsa el botón de confirmar para guardar cambios.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('submit');
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
