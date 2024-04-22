<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu" @notmobile style="margin-top: 100px !important;" @endnotmobile>
    <style>
        h5 .enlarged {
            display: none;
        }

        .enlarged .side-menu h6 {
            display: none;
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
                    });"><select id="select2-comunidades" class="w-100">
                            @foreach ($comunidades as $comunidad)
                                <option value="{{ $comunidad->id }}">{{ $comunidad->nombre }}
                            @endforeach
                        </select></li>
                @endif
                @notmobile
                    <li>
                        @if ($comunidad != null)
                            <h5 style="text-align: center; color: #9ec84c !important">
                                <img onerror="this.onerror=null; this.src='{{asset('storage/communitas_icon.png')}}';" src="{{ asset('storage/photos/' . $comunidad->ruta_imagen) }}"
                                    style="max-width: 10vw !important; text-align: center">
                            </h5>
                            <h6 style="text-align: center; color: #9ec84c !important">
                                {{ $comunidad->nombre }} </h5>
                            @else
                                <h6 style="text-align: center; color: #9ec84c !important;">
                                    {{ $user->name }} </h5>
                        @endif
                    </li>
                @elsenotmobile
                    <li>
                        @if ($comunidad != null)
                            <h5 style="text-align: center; color: #9ec84c !important">
                                <img onerror="this.onerror=null; this.src='{{asset('storage/communitas_icon.png')}}';" src="{{ asset('storage/photos/' . $comunidad->ruta_imagen) }}"
                                    style="max-width: 90vw !important; text-align: center">
                            </h5>
                            <h2 style="text-align: center; color: #9ec84c !important">
                                {{ $comunidad->nombre }} </h2>
                        @else
                            <h6 style="text-align: center; color: #9ec84c !important;">
                                {{ $user->name }} </h5>
                        @endif
                    </li>
                @endnotmobile
                <li class="menu-title">General</li>
                <li>
                    <a href="/../home" class="waves-effect">
                        <i class="icon-accelerator"></i> {{-- <span class="badge badge-success badge-pill float-right">9+</span> --}} <span> Dashboard </span>
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













                <style>
                    .enlarged .side-menu h5 {
                        display: none;
                    }
                </style>








                {{-- <li>
                    <a href="/admin/presupuestos" class="waves-effect">
                        <i class="fas fa-hand-holding-usd"></i></i><span> Presupuestos </span>
                    </a>
                </li> --}}


                {{--   <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-user"></i><span> Programas <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="/admin/programas">Ver Todos</a></li>
                        <li><a href="/admin/programas-create">Crear Programa</a></li>
                        {{-- <li><a href="email-compose.html">Email Compose</a></li>
                    </ul>
                </li> --}}


                {{-- <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-paper-sheet"></i><span> Pages <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="pages-pricing.html">Pricing</a></li>
                        <li><a href="pages-invoice.html">Invoice</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-faqs.html">FAQs</a></li>
                        <li><a href="pages-maintenance.html">Maintenance</a></li>
                        <li><a href="pages-comingsoon.html">Coming Soon</a></li>
                        <li><a href="pages-starter.html">Starter Page</a></li>
                        <li><a href="pages-login.html">Login</a></li>
                        <li><a href="pages-register.html">Register</a></li>
                        <li><a href="pages-recoverpw.html">Recover Password</a></li>
                        <li><a href="pages-lock-screen.html">Lock Screen</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li> --}}

                {{-- <li class="menu-title">Components</li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-pencil-ruler"></i> <span> UI Elements <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                    <ul class="submenu">
                        <li><a href="ui-alerts.html">Alerts</a></li>
                        <li><a href="ui-badge.html">Badge</a></li>
                        <li><a href="ui-buttons.html">Buttons</a></li>
                        <li><a href="ui-cards.html">Cards</a></li>
                        <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                        <li><a href="ui-navs.html">Navs</a></li>
                        <li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a></li>
                        <li><a href="ui-modals.html">Modals</a></li>
                        <li><a href="ui-images.html">Images</a></li>
                        <li><a href="ui-progressbars.html">Progress Bars</a></li>
                        <li><a href="ui-pagination.html">Pagination</a></li>
                        <li><a href="ui-popover-tooltips.html">Popover & Tooltips</a></li>
                        <li><a href="ui-spinner.html">Spinner</a></li>
                        <li><a href="ui-carousel.html">Carousel</a></li>
                        <li><a href="ui-video.html">Video</a></li>
                        <li><a href="ui-typography.html">Typography</a></li>
                        <li><a href="ui-grid.html">Grid</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-diamond"></i> <span> Advanced UI <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                    <ul class="submenu">
                        <li><a href="advanced-alertify.html">Alertify</a></li>
                        <li><a href="advanced-rating.html">Rating</a></li>
                        <li><a href="advanced-nestable.html">Nestable</a></li>
                        <li><a href="advanced-rangeslider.html">Range Slider</a></li>
                        <li><a href="advanced-sweet-alert.html">Sweet-Alert</a></li>
                        <li><a href="advanced-lightbox.html">Lightbox</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-todolist-check"></i><span> Forms <span class="badge badge-pill badge-danger float-right">8</span> </span></a>
                    <ul class="submenu">
                        <li><a href="form-elements.html">Form Elements</a></li>
                        <li><a href="form-validation.html">Form Validation</a></li>
                        <li><a href="form-advanced.html">Form Advanced</a></li>
                        <li><a href="form-editors.html">Form Editors</a></li>
                        <li><a href="form-uploads.html">Form File Upload</a></li>
                        <li><a href="form-mask.html">Form Mask</a></li>
                        <li><a href="form-summernote.html">Summernote</a></li>
                        <li><a href="form-xeditable.html">Form Xeditable</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-graph"></i><span> Charts <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="charts-morris.html">Morris Chart</a></li>
                        <li><a href="charts-chartist.html">Chartist Chart</a></li>
                        <li><a href="charts-chartjs.html">Chartjs Chart</a></li>
                        <li><a href="charts-flot.html">Flot Chart</a></li>
                        <li><a href="charts-c3.html">C3 Chart</a></li>
                        <li><a href="charts-other.html">Jquery Knob Chart</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-spread"></i><span> Tables <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="tables-basic.html">Basic Tables</a></li>
                        <li><a href="tables-datatable.html">Data Table</a></li>
                        <li><a href="tables-responsive.html">Responsive Table</a></li>
                        <li><a href="tables-editable.html">Editable Table</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-coffee"></i> <span> Icons  <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span> </a>
                    <ul class="submenu">
                        <li><a href="icons-material.html">Material Design</a></li>
                        <li><a href="icons-fontawesome.html">Font Awesome</a></li>
                        <li><a href="icons-outline.html">Outline Icons</a></li>
                        <li><a href="icons-themify.html">Themify Icons</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-map"></i><span> Maps <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="maps-google.html"> Google Map</a></li>
                        <li><a href="maps-vector.html"> Vector Map</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-share"></i><span> Multi Level <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="javascript:void(0);"> Menu 1</a></li>
                        <li>
                            <a href="javascript:void(0);">Menu 2  <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="submenu">
                                <li><a href="javascript:void(0);">Menu 2.1</a></li>
                                <li><a href="javascript:void(0);">Menu 2.1</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}

            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->

<style>

</style>
