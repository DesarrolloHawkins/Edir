@extends('layouts.appUser')

@section('title', 'Administrar secciones')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .seccion {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .seccion:hover {
            background-color: #f1f1f1;
        }

        .seccion-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .documento {
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .documento-icon {
            font-size: 20px;
            color: #666;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
@endsection

@section('content-principal')
<div>
    <div class="container">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6 col-md-12">
                    <h4 class="page-title">ADMINISTRAR DOCUMENTOS</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if (count($comunidades) > 0)
                    <h5 class="fs-6 text-center">Seleccione Comunidad para mostrar documentos</h5>
                    <select name="comunidad" id="comunidad" class="form-select select2">
                        @foreach ($comunidades as $comunidad)
                            <option value="{{ $comunidad->id }}">{{ $comunidad->nombre }}</option>
                        @endforeach
                    </select>
                @else
                    <h6 class="text-center">No existen comunidades</h6>
                @endif
                <button id="crear-comunidad" class="btn btn-primary mt-3">Crear Comunidad</button>

                <div id="secciones-container" class="mt-4"></div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.select2').select2();

                const fileIcons = {
                    doc: '📄',
                    docx: '📄',
                    pdf: '📕',
                    jpg: '🖼️',
                    jpeg: '🖼️',
                    png: '🖼️',
                    default: '📁'
                };

                function getFileIcon(fileName) {
                    const ext = fileName.split('.').pop().toLowerCase();
                    return fileIcons[ext] || fileIcons.default;
                }

                $('#crear-comunidad').on('click', function () {
                    Swal.fire({
                        title: 'Nueva Comunidad',
                        input: 'text',
                        inputLabel: 'Nombre de la Comunidad',
                        showCancelButton: true,
                        confirmButtonText: 'Crear',
                        preConfirm: (nombre) => {
                            return $.post('{{ route('documentos.admin.createComunidad') }}', {
                                _token: '{{ csrf_token() }}',
                                nombre
                            }).then(response => {
                                if (!response.status) throw new Error(response.mensaje);
                                return response;
                            }).catch(error => {
                                Swal.showValidationMessage(error.message);
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) location.reload(); // Refrescar la página
                    });
                });

                $('#comunidad').on('change', function () {
                    const comunidadId = $(this).val();
                    $.post(`{{ route('documentos.admin.getSecciones', '') }}/${comunidadId}`, {
                        _token: '{{ csrf_token() }}'
                    }, function (response) {
                        const seccionesContainer = $('#secciones-container');
                        seccionesContainer.empty();

                        if (response.status) {
                            response.data.forEach(seccion => {
                                seccionesContainer.append(`
                                    <div class="seccion" data-id="${seccion.id}">
                                        <div class="seccion-title">
                                            📂 ${seccion.nombre}
                                            <button class="btn btn-sm btn-primary subir-documento" data-id="${seccion.id}">Subir Documento</button>
                                            <button class="btn btn-sm btn-success crear-seccion" data-id="${seccion.id}">Nueva Sección</button>
                                        </div>
                                        <div class="documentos-container" id="documentos-${seccion.id}"></div>
                                    </div>
                                `);
                            });

                            $('.subir-documento').on('click', function () {
                                const seccionId = $(this).data('id');
                                Swal.fire({
                                    title: 'Subir Documento',
                                    html: `<input type="file" id="documento-file" class="form-control">`,
                                    showCancelButton: true,
                                    confirmButtonText: 'Subir',
                                    preConfirm: () => {
                                        const file = document.getElementById('documento-file').files[0];
                                        const formData = new FormData();
                                        formData.append('file', file);
                                        formData.append('_token', '{{ csrf_token() }}');
                                        formData.append('seccion_id', seccionId);

                                        return $.ajax({
                                            url: '{{ route('documentos.admin.uploadDocument') }}',
                                            type: 'POST',
                                            data: formData,
                                            contentType: false,
                                            processData: false
                                        }).then(response => {
                                            if (!response.status) throw new Error(response.mensaje);
                                            return response;
                                        }).catch(error => {
                                            Swal.showValidationMessage(error.message);
                                        });
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) cargarDocumentos(seccionId);
                                });
                            });

                            $('.crear-seccion').on('click', function () {
                                const comunidadId = $('#comunidad').val();
                                Swal.fire({
                                    title: 'Nueva Sección',
                                    input: 'text',
                                    inputLabel: 'Nombre de la Sección',
                                    showCancelButton: true,
                                    confirmButtonText: 'Crear',
                                    preConfirm: (nombre) => {
                                        return $.post('{{ route('documentos.admin.createSeccion') }}', {
                                            _token: '{{ csrf_token() }}',
                                            comunidad_id: comunidadId,
                                            nombre
                                        }).then(response => {
                                            if (!response.status) throw new Error(response.mensaje);
                                            return response;
                                        }).catch(error => {
                                            Swal.showValidationMessage(error.message);
                                        });
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) $('#comunidad').trigger('change');
                                });
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
</div>
@endsection
