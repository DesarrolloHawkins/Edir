@extends('layouts.appUser')

@section('title', 'Administrar secciones')

@section('head')
    {{-- @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss']) --}}

@section('content-principal')
<div>
    {{-- @livewire('secciones.index-component') --}}
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <h4 class="page-title">AVISOS</h4>
                </div>
            </div> <!-- end row -->
        </div>
        <div class="text-center mb-4">
            <a href="{{route('incidencias.create')}}" class="btn btn-segundo fs-3 m-auto text-center">Crear Aviso</a>
        </div>
        <!-- end page-title -->
        <div class="row">
            <div class="col-12">
                @if (count($incidencias) > 0)
                    <div class="row" style="width: 100%">
                        @foreach ($incidencias as $incidencia)
                            <div class="col-sm-6">
                                <a href="{{route('incidencias.show', $incidencia->id)}}"
                                    class="btn btn-primero mb-3 fs-6 p-3 d-flex align-items-center" style="width: 100%">
                                    <span>
                                        {{$incidencia->titulo}}
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h6 class="text-center">No existen secciones para el tablón de anuncios</h6>
                @endif
            </div>
        </div>
    </div>


    @section('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="../assets/js/jquery.slimscroll.js"></script>

        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/jszip.min.js"></script>
        <script src="../plugins/datatables/pdfmake.min.js"></script>
        <script src="../plugins/datatables/vfs_fonts.js"></script>
        <script src="../plugins/datatables/buttons.html5.min.js"></script>
        <script src="../plugins/datatables/buttons.print.min.js"></script>
        <script src="../plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="../assets/pages/datatables.init.js"></script>
        <script>
            function validarComunidad() {

            }
        </script>
    @endsection

</div>
@endsection


