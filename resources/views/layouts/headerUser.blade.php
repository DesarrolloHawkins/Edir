<div class="d-flex flex-row align-items-center justify-content-between px-3 py-2 border-bottom">
    <div class="notificaciones fs-5 color-primario position-relative" id="alerta-icono" style="cursor: pointer;">
        <i class="fa-solid fa-bell"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            id="contador-alertas"
            style="display: none; min-width: 22px; height: 22px; font-size: 0.75rem; line-height: 22px; text-align: center; padding: 0;">
            0
        </span>

    </div>

    <div class="logo">
        <a href="{{route('home')}}">
            <h1 class="fs-5 fw-bold color-primario">EDIR</h1>
        </a>
    </div>
    <div class="user fs-5 color-secundario">
        <a href="{{ route('perfil.index') }}" class="text-decoration-none text-reset">
            @php $user = Auth::user(); @endphp

            @if($user && $user->image)
                <img src="{{ asset('storage/' . $user->image) }}"
                     alt="Avatar"
                     style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
            @else
                <i class="fa-solid fa-user"></i>
            @endif
        </a>
    </div>

</div>
<div class="modal fade" id="modalAlertas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alertas no leídas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenido-alertas">
                <p>Cargando alertas...</p>
            </div>
        </div>
    </div>
</div>

