<div class="container-fluid">
    <div class="page-title-box">
        <div class="row">
            <div class="col-sm-12">
                <h1 style="text-align: center">SELECCIONA UN CLUB</h1>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($clubs as $club)
            <div class="col-sm-6 col-xl-4">
                <div class="card"
                    style="height: 90% !important; justify-content: center !important; align-items: center !important; flex-direction: row !important">
                    <div class="card-heading p-4">
                        <button type="button" class="btn"
                            wire:click.prevent="seleccionarClub('{{ $club->id }}')">
                            <h3 style="text-align: center !important">{{ $club->nombre }}</h3>
                            <img src='{{ asset('assets/images/' . $club->club_logo) }}'>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
