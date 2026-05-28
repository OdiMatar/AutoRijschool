<x-layout title="Home">
    <div class="container p-0">
        <div class="bg-white border rounded-3 p-4 p-md-5 mb-4">
            <h1 class="h3 mb-3">Welkom bij Rijschool Vierkante Wielen</h1>
            <p class="text-muted mb-4">
                Dit dashboard helpt je om instructeurs en voertuigen overzichtelijk te beheren.
            </p>
            <a class="btn btn-primary" href="{{ route('instructeurs.index') }}">Ga naar instructeurs</a>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6 card-title">Instructeurs</h2>
                        <p class="card-text text-muted mb-0">Bekijk alle instructeurs en hun basisgegevens.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6 card-title">Voertuigen</h2>
                        <p class="card-text text-muted mb-0">Bekijk toegewezen en beschikbare voertuigen.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6 card-title">Jouw rol</h2>
                        <p class="card-text text-muted mb-0">
                            @if (auth()->user()->canManageVehicles())
                                Je bent ingelogd als {{ auth()->user()->role }} en mag voertuiggegevens wijzigen.
                            @else
                                Je bent ingelogd als instructeur met kijkrechten.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
