<x-layout title="Autorijschool Odai">
    <section class="site-hero">
        <div class="site-hero-overlay">
            <p class="home-kicker">Autorijschool Odai</p>
            <h1>Rijlessen met rust, structuur en vertrouwen.</h1>
            <p>
                Persoonlijke begeleiding voor leerlingen die veilig, zelfstandig en ontspannen de weg op willen.
                Je leert rijden in duidelijke stappen, met vaste feedback na iedere les.
            </p>
            <div class="home-hero-actions">
                <a href="{{ route('register') }}" class="btn btn-home-primary">Start met lessen</a>
                <a href="{{ route('login') }}" class="btn btn-home-ghost">Inloggen</a>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-section-head">
            <p class="app-page-kicker">Onze aanpak</p>
            <h2>Rustig leren rijden, helder bijhouden</h2>
        </div>
        <div class="home-feature-grid">
            <article class="home-feature-card">
                <h2>Persoonlijke rijlessen</h2>
                <p>Je oefent op jouw tempo met concrete lesdoelen, zodat iedere les logisch voortbouwt op de vorige.</p>
            </article>
            <article class="home-feature-card">
                <h2>Veilige planning</h2>
                <p>Instructeurs, voertuigen en beschikbaarheid worden centraal beheerd voor duidelijke afspraken.</p>
            </article>
            <article class="home-feature-card">
                <h2>Privacy bewust</h2>
                <p>Wij gebruiken alleen gegevens die nodig zijn voor lessen, contact, beveiliging en administratie.</p>
                <a href="{{ route('privacy') }}">Lees privacybeleid</a>
            </article>
        </div>
    </section>

    <section class="site-split">
        <div>
            <p class="app-page-kicker">Voor leerlingen</p>
            <h2>Van eerste les tot examen</h2>
            <p>
                Je krijgt uitleg die past bij jouw niveau. We besteden aandacht aan kijkgedrag, voertuigbeheersing,
                bijzondere verrichtingen en rijden in druk verkeer.
            </p>
        </div>
        <div>
            <p class="app-page-kicker">Voor de rijschool</p>
            <h2>Overzicht in instructeurs en voertuigen</h2>
            <p>
                De applicatie ondersteunt het beheren van instructeurs, ziekte/verlof en voertuigtoewijzingen, zodat
                voertuigen snel opnieuw beschikbaar zijn wanneer dat nodig is.
            </p>
        </div>
    </section>

    <section class="site-contact-band">
        <div>
            <h2>Klaar om te starten?</h2>
            <p class="mb-0">Maak een account aan of log in om je omgeving te openen.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('register') }}" class="btn btn-dark">Registreren</a>
            <a href="{{ route('login') }}" class="btn btn-outline-dark">Inloggen</a>
        </div>
    </section>
</x-layout>
