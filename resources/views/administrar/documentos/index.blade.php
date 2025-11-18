@extends('layouts.appUser')

@section('title', 'Administrar Documentos')

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
    </style>
@endsection

@section('content-principal')
<div>
    <div class="container">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6 col-md-12">
                    <h4 class="page-title">VER DOCUMENTOS</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if (count($secciones) > 0)
                    <div id="secciones-container" class="mt-4">
                        @include('administrar.documentos.partials.secciones-tree', ['secciones' => $secciones, 'nivel' => 0])
                    </div>
                @else
                    <h6 class="text-center">No hay secciones disponibles.</h6>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
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

            // Cargar documentos al hacer clic en una sección
            $('.seccion-title').on('click', function () {
                const seccionId = $(this).closest('.seccion').data('id');
                const container = $(`#documentos-${seccionId}`);

                $.ajax({
                    url: `{{ route('documentosUser.getDocumentos', '') }}/${seccionId}`,
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
                                            <div class="actions mt-2 mt-md-0">
                                                <a href="{{ url('storage') }}/${doc.ruta_imagen}" target="_blank" class="btn btn-sm btn-info">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                `);

                            });
                        } else {
                            container.append('<p>No hay documentos en esta sección.</p>');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Hubo un problema al cargar los documentos.', 'error');
                    }
                });
            });
        });
    </script>
@endsection
