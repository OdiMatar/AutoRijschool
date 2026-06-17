<x-layout title="Dashboard">
    <div class="home-dashboard">
        <section class="dashboard-hero">
            <div>
                <p class="home-kicker">Dashboard</p>
                <h1>Welkom bij Autorijschool Odai</h1>
                <p>
                    Beheer de dagelijkse operatie vanuit een helder overzicht. Instructeurs, ziekte/verlof en
                    voertuigtoewijzingen staan centraal.
                </p>
                <div class="home-hero-actions">
                    <a class="btn btn-home-primary" href="{{ route('instructeurs.index') }}">Instructeurs in dienst</a>
                    <a class="btn btn-home-ghost" href="{{ route('voertuigen.alles') }}">Alle voertuigen</a>
                </div>
            </div>
        </section>

        <section class="home-stats">
            <article class="home-stat-card">
                <span>Rol</span>
                <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                <p>Ingelogd als {{ auth()->user()->name }}</p>
            </article>
            <article class="home-stat-card">
                <span>Belangrijk</span>
                <strong>Ziekte/verlof</strong>
                <p>Maak voertuigen tijdelijk vrij via Instructeurs in dienst.</p>
            </article>
            <article class="home-stat-card">
                <span>Privacy</span>
                <strong>AVG bewust</strong>
                <p><a href="{{ route('privacy') }}">Bekijk privacybeleid</a></p>
            </article>
        </section>

        <section class="home-feature-grid">
            <article class="home-feature-card">
                <h2>Instructeurs</h2>
                <p>Bekijk instructeurs gesorteerd op sterren en meld ziekte/verlof met directe terugkoppeling.</p>
                <a href="{{ route('instructeurs.index') }}">Open instructeurs</a>
            </article>
            <article class="home-feature-card">
                <h2>Voertuigen</h2>
                <p>Controleer welke voertuigen actief zijn, toegewezen zijn of opnieuw beschikbaar zijn.</p>
                <a href="{{ route('voertuigen.alles') }}">Open voertuigen</a>
            </article>
            <article class="home-feature-card">
                <h2>Veilig werken</h2>
                <p>Formulieren gebruiken CSRF-beveiliging, servervalidatie en meldingen na acties.</p>
                <span class="home-feature-chip">MVC</span>
            </article>
        </section>
    </div>
</x-layout>
