@extends('layouts.appUser')

@section('title', 'Administrar Comunidades')

@section('content-principal')
<div class="container">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <h4 class="page-title">COMUNIDADES</h4>
            </div>
            <div class="col-sm-12 mt-3 text-center">
                <a href="{{ route('comunidades.create') }}" class="btn btn-primary">Crear Comunidad</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Código</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comunidades as $comunidad)
                <tr>
                    <td>{{ $comunidad->id }}</td>
                    <td>{{ $comunidad->nombre }}</td>
                    <td>{{ $comunidad->direccion }}</td>
                    <td>{{ $comunidad->codigo }}</td>
                    <td>
                        <a href="{{ route('comunidades.edit', $comunidad->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <button class="btn btn-sm btn-danger eliminar-comunidad" data-id="{{ $comunidad->id }}">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        {{ $comunidades->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const eliminarBtns = document.querySelectorAll('.eliminar-comunidad');

    eliminarBtns.forEach(button => {
        button.addEventListener('click', function () {
            const comunidadId = this.getAttribute('data-id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás deshacer esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST'; // Cambiado a POST
                    form.action = `/admin/comunidades/${comunidadId}`;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});

</script>
@endsection
