<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu" @notmobile style="margin-top: 100px !important;" @endnotmobile>
    <?php use App\Models\Comunidad; ?>
    <style>
        h5 .enlarged {
            display: none;
        }

        .enlarged .side-menu h6 {
            display: none;
        }
        .span.select2.select2-container.select2-container--default{
            width: 90%;
        }
    </style>
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu" style="position: sticky !important">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                @if ($user->role == 1)
                    <li x-data="" x-init="$('#select2-comunidades').select2();
                    $('#select2-comunidades').on('change', function(e) {
                        var data = $('#select2-comunidades').select2('val');
                        Livewire.emit('cambiarComunidad', data);
                    });" style="text-align: center"><select id="select2-comunidades" style="width: 90%">
                        <option value="">Seleccione Comunidad</option>
                            @foreach ($comunidades as $comuni)
                            @if (isset($comunidad))
                            <option value="{{ $comuni->id }}" {{$comunidad->id == $comuni->id ? 'selected' : '' }}>{{ $comuni->nombre }}</option>
                            @else
                            <option value="{{ $comuni->id }}">{{ $comuni->nombre }}</option>
                            @endif
                            @endforeach
                        </select></li>
                @endif
                @notmobile
                    <li>
                        @if ($comunidad != null)
                            <h5 style="text-align: center; color: rgb(14, 76, 107) !important">
                                <img onerror="this.onerror=null; this.src='{{asset('storage/communitas_icon.png')}}';" src="{{ asset('storage/photos/' . $comunidad->ruta_imagen) }}"
                                    style="max-width: 10vw !important; text-align: center">
                            </h5>
                            <h6 style="text-align: center; color: rgb(14, 76, 107) !important">
                                {{ $comunidad->nombre }}
                            </h5>
                        @else
                                <h6 style="text-align: center; color: rgb(14, 76, 107) !important;">
                                    {{ $user->name }} </h5>
                        @endif
                    </li>
                @elsenotmobile
                    <li>
                        @if ($comunidad != null)
                            <h5 style="text-align: center; color: rgb(14, 76, 107) !important">
                                <img onerror="this.onerror=null; this.src='{{asset('storage/communitas_icon.png')}}';" src="{{ asset('storage/photos/' . $comunidad->ruta_imagen) }}"
                                    style="max-width: 90vw !important; text-align: center">
                            </h5>
                            <h2 style="text-align: center; color: rgb(14, 76, 107) !important">
                                {{ $comunidad->nombre }} </h2>
                        @else
                            <h6 style="text-align: center; color: rgb(14, 76, 107) !important;">
                                {{ $user->name }} </h5>
                        @endif
                    </li>
                @endnotmobile
                <li class="menu-title">General</li>
                <li>
                    <a href="/../home" class="waves-effect">
                        <i class="icon-accelerator"></i> <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="/admin/secciones" class="waves-effect"><i class="fas fa-folder"></i><span> Secciones
                        </span></a>
                </li>
                <li>
                    <a href="/admin/comunidad" class="waves-effect"><i class="fas fa-home"></i><span> Comunidad
                        </span></a>
                </li>
                @if ($user->role == 1)
                    <li>
                        <a href="/admin/usuarios" class="waves-effect"><i class="fas fa-user"></i><span> Usuarios
                            </span></a>
                    </li>
                @endif
                <li>
                    <a href="/admin/avisos" class="waves-effect"><i class="fas fa-bell"></i><span> Avisos
                        </span></a>
                </li>
                @if ($user->role == 1)
                <li>
                    <a href="/admin/comunidades" class="waves-effect"><i class="fa-solid fa-gear"></i><span> Comunidades
                        </span></a>
                </li>
                @endif
                <style>
                    .enlarged .side-menu h5 {
                        display: none;
                    }
                </style>

            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('recarga', function () {
            window.location.reload();
        });
    });
</script>

<style>

</style>
