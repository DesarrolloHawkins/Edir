    <div class="container-fluid">
        <script src="//unpkg.com/alpinejs" defer></script>
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">CREAR USUARIO</span></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Usuarios</a></li>
                        <li class="breadcrumb-item active">Crear usuario</li>
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
                            <h5> Datos de usuario </h5>
                            <hr />
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="name" class="col-sm-12 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model.defer="name" class="form-control"
                                            name="name" id="name" placeholder="José Carlos...">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="email" class="col-sm-12 col-form-label">Email </label>
                                    <div class="col-sm-11">
                                        <input type="text" wire:model.defer="email" class="form-control"
                                            name="email" id="email" placeholder="jose85@hotmail.com ...">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="email" class="col-sm-12 col-form-label">Telefono </label>
                                    <div class="col-sm-11">
                                        <input type="text" wire:model.defer="telefono" class="form-control"
                                            name="telefono" id="telefono" placeholder="Telefono">
                                        @error('telefono')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="username" class="col-sm-12 col-form-label">Usuario</label>
                                    <div class="col-sm-11">
                                        <input type="text" wire:model.defer="username" class="form-control"
                                            name="username" id="username" placeholder="jose85">
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-11">
                                    <label for="password" class="col-sm-12 col-form-label">Contraseña </label>
                                    <div class="col-sm-12">
                                        <input type="password" wire:model.defer="password" class="form-control"
                                            name="password" id="password" placeholder="123456...">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label for="password" class="col-sm-12 col-form-label">&nbsp;</label>
                                    <button type="button" class="me-auto btn btn-primary"
                                        onclick="togglePasswordVisibility()">
                                        <i class="fas fa-eye" id="eye-icon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-11">
                                    <div class="col-sm-12">
                                        <input type="checkbox" id="isAdminCheckbox"
                                            wire:model="isAdminCheckbox" />
                                        <label for="role" class="col-form-label">¿Es administrador del
                                            sistema?</label>
                                    </div>
                                </div>
                            </div>
                            <h5> Datos de comunidad </h5>
                            <hr />
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="comunidad_imagen" class="col-sm-12 col-form-label">Foto de la
                                        comunidad</label>
                                    @if ($comunidad_imagen)
                                        <div class="col-sm-11">
                                            <img src="{{ $comunidad_imagen->temporaryUrl() }}"
                                                style="max-height: 30vh !important; text-align: center">
                                        </div>
                                    @endif
                                    <br>
                                    <input type="file" class="form-control" wire:model="comunidad_imagen"
                                        name="comunidad_imagen" id="comunidad_imagen"
                                        placeholder="Imagen del producto...">
                                    @error('comunidad_imagen')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="comunidad_nombre" class="col-sm-12 col-form-label">Nombre de la
                                    comunidad</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="comunidad_nombre" class="form-control"
                                        name="comunidad_nombre" id="comunidad_nombre" placeholder="José Carlos...">
                                    @error('comunidad_nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="comunidad_direccion" class="col-sm-12 col-form-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="comunidad_direccion" class="form-control"
                                        name="comunidad_direccion" id="comunidad_direccion" placeholder="Pérez...">
                                    @error('comunidad_direccion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="comunidad_info" class="col-sm-12 col-form-label">Información
                                    adicional</label>
                                <div class="col-sm-11">
                                    <textarea wire:model.defer="comunidad_info" class="form-control" name="comunidad_info" id="comunidad_info"
                                        placeholder="Pérez..."></textarea>
                                    @error('comunidad_info')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5>Acciones</h5>
                        <div class="row">
                            <div class="col-12">
                                <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Crear
                                    Usuario</button>
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
