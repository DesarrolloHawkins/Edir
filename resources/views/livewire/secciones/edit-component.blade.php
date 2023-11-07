<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITANDO SECCIÓN {{strtoupper($nombre)}}</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Secciones</a></li>
                    <li class="breadcrumb-item active">Editar sección {{$nombre}}</li>
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
                                <label for="ruta_imagen" class="col-sm-12 col-form-label">Icono de la sección</label>
                                <div class="col-sm-11">
                                    @if ($ruta_imagen)
                                        <div class="col text-center">
                                            @if (is_string($ruta_imagen))
                                            @else
                                                <img src="{{ $ruta_imagen->temporaryUrl() }}"
                                                    style="max-height: 30vh !important; text-align: center">
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
                                <label for="nombre" class="col-sm-12 col-form-label">Nombre de la sección</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="nombre" class="form-control" name="nombre"
                                        id="nombre" placeholder="José Carlos...">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="surname" class="col-sm-12 col-form-label">Sección padre (si es
                                    subsección)</label>
                                <div class="col-sm-10" x-data="" x-init="$('#seccion_padre_id').select2();
                                $('#seccion_padre_id').on('change', function(e) {
                                    var data = $('#seccion_padre_id').select2('val');
                                    @this.set('seccion_padre_id', data);
                                });">
                                    <select id="seccion_padre_id" name="seccion_padre_id" class="form-control" wire:model="seccion_padre_id">
                                        <option value="0">-- SIN SECCIÓN PADRE --</option>
                                        @foreach ($secciones as $seccion)
                                            <option value="{{ $seccion->id }}">{{ $seccion->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('direccion')
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
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Crear
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
                text: 'Pulsa el botón de confirmar para crear el nuevo usuario.',
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
