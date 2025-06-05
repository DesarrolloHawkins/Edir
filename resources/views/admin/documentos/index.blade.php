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
            background-color: #c9e3f0;
            padding: 10px 20px;
            margin-top: 14px;
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
                <div id="secciones-container" class="mt-4">
                    <button id="crear-seccion" class="btn btn-success mb-3">Crear Sección</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    <!-- Modal para Crear Comunidad -->
    <div class="modal fade" id="modalCrearComunidad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Comunidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearComunidad">
                        @csrf
                        <div class="mb-3">
                            <label for="nombreComunidad" class="form-label">Nombre</label>
                            <input type="text" id="nombreComunidad" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccionComunidad" class="form-label">Dirección</label>
                            <input type="text" id="direccionComunidad" name="direccion" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="codigoComunidad" class="form-label">Código</label>
                            <input type="text" id="codigoComunidad" name="codigo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="informacionAdicional" class="form-label">Información Adicional</label>
                            <textarea id="informacionAdicional" name="informacion_adicional" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagenComunidad" class="form-label">Imagen</label>
                            <input type="file" id="imagenComunidad" name="ruta_imagen" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Sección -->
    <div class="modal fade" id="modalCrearSeccion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Sección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearSeccion">
                        @csrf
                        <!-- Campo oculto para comunidad_id -->
                        <input type="hidden" id="comunidadId" name="comunidad_id">

                        <!-- Nombre de la sección -->
                        <div class="mb-3">
                            <label for="nombreSeccion" class="form-label">Nombre de la Sección</label>
                            <input type="text" id="nombreSeccion" name="nombre" class="form-control" required>
                        </div>

                        <!-- Sección padre -->
                        <div class="mb-3">
                            <label for="seccionPadre" class="form-label">Sección Padre</label>
                            <select id="seccionPadre" name="seccion_padre_id" class="form-select">
                                <option value="">Sin sección padre</option>
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                        </div>

                        <!-- Orden -->
                        <div class="mb-3">
                            <label for="ordenSeccion" class="form-label">Orden</label>
                            <input type="number" id="ordenSeccion" name="orden" class="form-control" value="1">
                        </div>

                        <!-- Imagen asociada -->
                        <div class="mb-3">
                            <label for="rutaImagen" class="form-label">Imagen</label>
                            <input type="file" id="rutaImagen" name="ruta_imagen" class="form-control">
                        </div>

                        <!-- Incidencias -->
                        <div class="mb-3">
                            <label for="seccionIncidencias" class="form-label">Incidencias</label>
                            <textarea id="seccionIncidencias" name="seccion_incidencias" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Subir Documento -->
    <div class="modal fade" id="modalSubirDocumento" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subir Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formSubirDocumento">
                        <input type="hidden" id="seccionId" name="seccion_id">
                        <div class="mb-3">
                            <label for="nombreDocumento" class="form-label">Nombre del Documento</label>
                            <input type="text" id="nombreDocumento" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaDocumento" class="form-label">Fecha</label>
                            <input type="date" id="fechaDocumento" name="fecha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="archivoDocumento" class="form-label">Archivo</label>
                            <input type="file" id="archivoDocumento" name="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            function eliminarDocumento(documentoId, seccionId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará el documento de manera permanente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('documentos.admin.deleteDocument', '') }}/${documentoId}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            success: function () {
                                Swal.fire('Eliminado', 'El documento ha sido eliminado.', 'success');
                                // Recargar los documentos de la sección
                                $(`#documentos-${seccionId}`).trigger('click');
                            },
                            error: function () {
                                Swal.fire('Error', 'Hubo un problema al eliminar el documento.', 'error');
                            }
                        });
                    }
                });
            }

            // Función para obtener icono según el tipo de archivo
            function getFileIcon(fileName) {
                const ext = fileName.split('.').pop().toLowerCase(); // Obtener la extensión del archivo
                const icons = {
                    pdf: '📕',
                    doc: '📄',
                    docx: '📄',
                    jpg: '🖼️',
                    jpeg: '🖼️',
                    png: '🖼️',
                    default: '📁'
                };
                return icons[ext] || icons.default; // Retornar el icono correspondiente o uno por defecto
            }

            function eliminarSeccion(seccionId, comunidadId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará la sección y todas sus sub-secciones.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('secciones.admin.deleteSeccion', '') }}/${seccionId}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            success: function () {
                                Swal.fire('Eliminada', 'La sección ha sido eliminada correctamente.', 'success');
                                // Recargar las secciones de la comunidad
                                $('#comunidad').trigger('change');
                            },
                            error: function () {
                                Swal.fire('Error', 'Hubo un problema al eliminar la sección.', 'error');
                            }
                        });
                    }
                });
            }


            $('.select2').select2();

            // Botón para abrir el modal de crear comunidad
            $('#crear-comunidad').on('click', function () {
                // Generar un código aleatorio de 6 dígitos
                const randomCode = Math.floor(100000 + Math.random() * 900000);
                $('#codigoComunidad').val(randomCode); // Asignar al campo de código
                $('#modalCrearComunidad').modal('show');
            });

            // Crear comunidad
            $('#formCrearComunidad').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: '{{ route('documentos.admin.createComunidad') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        Swal.fire('¡Comunidad creada!', 'La comunidad se ha creado correctamente.', 'success');
                        $('#modalCrearComunidad').modal('hide');
                        location.reload();
                    }
                });
            });

            // Cargar secciones dinámicamente al cambiar la comunidad
            $('#comunidad').on('change', function () {
                const comunidadId = $(this).val();
                if (!comunidadId) return;

                $.ajax({
                    url: `{{ route('documentos.admin.getSecciones', '') }}/${comunidadId}`,
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        const container = $('#secciones-container');
                        container.empty();

                        if (response.status) {
                            container.append('<button id="crear-seccion" class="btn btn-success mb-3">Crear Sección</button>');

                            response.data.forEach(seccion => {
                                container.append(`
                                    <div class="seccion" data-id="${seccion.id}">
                                        <div class="seccion-title">
                                            📂 ${seccion.nombre}
                                            <div class="actions">
                                                <button class="btn btn-primary btn-sm subir-documento" data-id="${seccion.id}">Añadir Documento</button>
                                                <button class="btn btn-danger btn-sm eliminar-seccion" data-id="${seccion.id}">Eliminar Sección</button>
                                            </div>
                                        </div>
                                        <div class="documentos-container" id="documentos-${seccion.id}"></div>
                                    </div>
                                `);
                            });

                            // Asignar evento para los botones de eliminación de sección
                            $('.eliminar-seccion').off('click').on('click', function () {
                                const seccionId = $(this).data('id');
                                const comunidadId = $('#comunidad').val();
                                eliminarSeccion(seccionId, comunidadId);
                            });

                            // Volver a asignar eventos dinámicos después de actualizar el DOM
                            assignEventHandlers();
                        } else {
                            container.append('<button id="crear-seccion" class="btn btn-success mb-3">Crear Sección</button> <p>No hay secciones en esta comunidad.</p>');
                        }
                    }
                });
            })

            // Función para asignar eventos dinámicamente
            function assignEventHandlers() {
                // Botón para abrir el modal de crear sección
                $('#crear-seccion').off('click').on('click', function () {
                    const comunidadId = $('#comunidad').val();
                    if (!comunidadId) {
                        Swal.fire('Error', 'Seleccione una comunidad antes de crear una sección.', 'error');
                        return;
                    }
                    console.log(comunidadId)
                    $('#comunidadId').val(comunidadId);
                    $('#modalCrearSeccion').modal('show');
                });

                // Botón para abrir el modal de subir documento
                $('.subir-documento').off('click').on('click', function () {
                    const seccionId = $(this).data('id');
                    $('#seccionId').val(seccionId);
                    $('#modalSubirDocumento').modal('show');
                });

                 // Al hacer clic en una sección, cargar documentos
                 $('.seccion-title').off('click').on('click', function () {
                    const seccionId = $(this).closest('.seccion').data('id'); // Obtener data-id del contenedor padre
                    const container = $(`#documentos-${seccionId}`);

                    $.ajax({
                        url: `{{ route('documentos.admin.getDocumentos', '') }}/${seccionId}`,
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        success: function (response) {
                            container.empty();
                            if (response.status) {
                                response.data.forEach(doc => {
                                    container.append(`
                                        <div class="documento">
                                            <div class="d-flex flex-row flex-md-row justify-content-between align-items-md-center w-100">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="documento-icon">${getFileIcon(doc.ruta_imagen)}</span>
                                                    <div>
                                                        <div><strong>${doc.nombre}</strong></div>
                                                        <div class="text-muted small">Fecha: ${new Date(doc.fecha).toLocaleDateString()}</div>
                                                    </div>
                                                </div>
                                                <div class="actions mt-md-0">
                                                    <button class="btn btn-sm btn-danger eliminar-documento" data-id="${doc.id}">Eliminar</button>
                                                </div>
                                            </div>
                                        </div>
                                    `);

                                });

                                // Asignar eventos para eliminar documentos
                                $('.eliminar-documento').off('click').on('click', function () {
                                    const documentoId = $(this).data('id');
                                    eliminarDocumento(documentoId, seccionId);
                                });
                            } else {
                                container.append('<p>No hay documentos en esta sección.</p>');
                            }
                        }
                    });
                });
            }
            // Crear sección
            $('#formCrearSeccion').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                console.log(formData)
                $.ajax({
                    url: '{{ route('documentos.admin.createSeccion') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        Swal.fire('¡Sección creada!', 'La sección se ha creado correctamente.', 'success');
                        $('#modalCrearSeccion').modal('hide');
                        $('#comunidad').trigger('change'); // Recargar secciones
                    }
                });
            });

            $('#formSubirDocumento').on('submit', function (e) {
    e.preventDefault();

    // Crear FormData
    const formData = new FormData(this);

    // Verificar si comunidad_id está presente
    const comunidadId = $('#comunidad').val();
    if (!comunidadId) {
        Swal.fire('Error', 'Debe seleccionar una comunidad antes de subir un documento.', 'error');
        return;
    }

    // Agregar manualmente el token CSRF y comunidad_id si no están presentes
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('comunidad_id', comunidadId);

    $.ajax({
        url: '{{ route('documentos.admin.uploadDocument') }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            Swal.fire('¡Documento subido!', 'El documento se ha subido correctamente.', 'success');
            $('#modalSubirDocumento').modal('hide');
            $('#comunidad').trigger('change'); // Recargar secciones y documentos
        },
        error: function (xhr) {
            console.error(xhr.responseJSON); // Para depurar el error exacto
            Swal.fire('Error', 'Hubo un problema al subir el documento.', 'error');
        }
    });
});


            // Inicializar eventos en la primera carga
            assignEventHandlers();
        });
    </script>
@endsection

