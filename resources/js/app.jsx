import React, { useEffect, useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';

const rootElement = document.getElementById('react-root');
const pageElement = document.getElementById('react-page');

const parseJson = (value, fallback = {}) => {
    if (! value) {
        return fallback;
    }

    try {
        return JSON.parse(value);
    } catch {
        return fallback;
    }
};

const shell = parseJson(rootElement?.dataset.shell);
const page = pageElement?.dataset.page || 'Landing';
const props = parseJson(pageElement?.textContent);

function csrfInput() {
    return <input type="hidden" name="_token" value={shell.csrf} />;
}

function methodInput(method) {
    return <input type="hidden" name="_method" value={method} />;
}

function formatDate(value, includeTime = false) {
    if (! value) {
        return '-';
    }

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat('nl-NL', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        ...(includeTime ? { hour: '2-digit', minute: '2-digit' } : {}),
    }).format(date);
}

function money(value) {
    return new Intl.NumberFormat('nl-NL', {
        style: 'currency',
        currency: 'EUR',
    }).format(Number(value || 0));
}

function fieldError(errors, field) {
    const messages = errors?.[field];

    if (! messages?.length) {
        return null;
    }

    return <span className="text-danger small">{messages[0]}</span>;
}

function App() {
    const PageComponent = pages[page] || LandingPage;

    return (
        <>
            <Navigation />
            <main className="container py-4">
                {shell.flash?.success && <div className="alert alert-success app-flash">{shell.flash.success}</div>}
                {shell.flash?.error && <div className="alert alert-danger app-flash">{shell.flash.error}</div>}
                <PageComponent {...props} />
            </main>
            <Footer />
            <PrivacyConsent />
        </>
    );
}

function Navigation() {
    const { auth, routes } = shell;

    return (
        <nav className="navbar navbar-expand-lg sticky-top app-navbar">
            <div className="container">
                <a className="navbar-brand fw-semibold d-flex align-items-center gap-2" href={auth.check ? routes.home : routes.landing}>
                    <span className="app-brand-mark">OA</span>
                    <span>Autorijschool Odai</span>
                </a>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu openen">
                    <span className="navbar-toggler-icon" />
                </button>

                <div className="collapse navbar-collapse" id="mainNavbar">
                    <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                        {auth.check ? (
                            <>
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.home}>Dashboard</a></li>
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.instructeurs}>Instructeurs in dienst</a></li>
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.voertuigenAlles}>Alle voertuigen</a></li>
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.lespakketten}>Lespakketten</a></li>
                                {routes.accounts && <li className="nav-item"><a className="nav-link app-nav-link" href={routes.accounts}>Accounts</a></li>}
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.privacy}>Privacy</a></li>
                            </>
                        ) : (
                            <>
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.landing}>Home</a></li>
                                <li className="nav-item"><a className="nav-link app-nav-link" href={routes.privacy}>Privacy</a></li>
                            </>
                        )}
                    </ul>

                    <div className="d-flex align-items-center gap-2">
                        {auth.check ? (
                            <>
                                <span className="badge app-user-badge">{auth.user.name}</span>
                                <form method="post" action={routes.logout}>
                                    {csrfInput()}
                                    <button type="submit" className="btn btn-outline-secondary btn-sm app-logout-btn">Uitloggen</button>
                                </form>
                            </>
                        ) : (
                            <>
                                <a className="btn btn-outline-primary btn-sm" href={routes.login}>Inloggen</a>
                                <a className="btn btn-primary btn-sm" href={routes.register}>Registreren</a>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </nav>
    );
}

function Footer() {
    return (
        <footer className="app-footer">
            <div className="container app-footer-inner">
                <div>
                    <strong>Autorijschool Odai</strong>
                    <p className="mb-0">Veilig, duidelijk en met plezier op weg naar je rijbewijs.</p>
                </div>
                <div className="app-footer-meta">
                    <span>KVK: 12345678</span>
                    <span>info@autorijschoolodai.nl</span>
                    <span>+31 6 1234 5678</span>
                    <a href={shell.routes.privacy}>Privacy</a>
                </div>
            </div>
        </footer>
    );
}

function PrivacyConsent() {
    const [visible, setVisible] = useState(false);

    useEffect(() => {
        setVisible(localStorage.getItem('privacyConsentAccepted') !== 'yes');
    }, []);

    if (! visible) {
        return null;
    }

    return (
        <div className="privacy-consent">
            <div>
                <strong>Privacy en cookies</strong>
                <p className="mb-0">Deze website gebruikt noodzakelijke cookies voor inloggen, beveiliging en formulieren.</p>
            </div>
            <div className="privacy-consent-actions">
                <a className="btn btn-outline-secondary btn-sm" href={shell.routes.privacy}>Privacy lezen</a>
                <button
                    className="btn btn-primary btn-sm"
                    type="button"
                    onClick={() => {
                        localStorage.setItem('privacyConsentAccepted', 'yes');
                        setVisible(false);
                    }}
                >
                    Akkoord
                </button>
            </div>
        </div>
    );
}

function LandingPage() {
    return (
        <>
            <section className="site-hero">
                <div className="site-hero-overlay">
                    <p className="home-kicker">Autorijschool Odai</p>
                    <h1>Rijlessen met rust, structuur en vertrouwen.</h1>
                    <p>Persoonlijke begeleiding voor leerlingen die veilig, zelfstandig en ontspannen de weg op willen. Je leert rijden in duidelijke stappen, met vaste feedback na iedere les.</p>
                    <div className="home-hero-actions">
                        <a href={shell.routes.register} className="btn btn-home-primary">Start met lessen</a>
                        <a href={shell.routes.login} className="btn btn-home-ghost">Inloggen</a>
                    </div>
                </div>
            </section>

            <section className="site-section">
                <div className="site-section-head">
                    <p className="app-page-kicker">Onze aanpak</p>
                    <h2>Rustig leren rijden, helder bijhouden</h2>
                </div>
                <FeatureGrid
                    items={[
                        ['Persoonlijke rijlessen', 'Je oefent op jouw tempo met concrete lesdoelen, zodat iedere les logisch voortbouwt op de vorige.'],
                        ['Veilige planning', 'Instructeurs, voertuigen en beschikbaarheid worden centraal beheerd voor duidelijke afspraken.'],
                        ['Privacy bewust', 'Wij gebruiken alleen gegevens die nodig zijn voor lessen, contact, beveiliging en administratie.', 'Lees privacybeleid', shell.routes.privacy],
                    ]}
                />
            </section>

            <section className="site-split">
                <div>
                    <p className="app-page-kicker">Voor leerlingen</p>
                    <h2>Van eerste les tot examen</h2>
                    <p>Je krijgt uitleg die past bij jouw niveau. We besteden aandacht aan kijkgedrag, voertuigbeheersing, bijzondere verrichtingen en rijden in druk verkeer.</p>
                </div>
                <div>
                    <p className="app-page-kicker">Voor de rijschool</p>
                    <h2>Overzicht in instructeurs en voertuigen</h2>
                    <p>De applicatie ondersteunt het beheren van instructeurs, ziekte/verlof en voertuigtoewijzingen, zodat voertuigen snel opnieuw beschikbaar zijn wanneer dat nodig is.</p>
                </div>
            </section>

            <section className="site-contact-band">
                <div>
                    <h2>Klaar om te starten?</h2>
                    <p className="mb-0">Maak een account aan of log in om je omgeving te openen.</p>
                </div>
                <div className="d-flex flex-wrap gap-2">
                    <a href={shell.routes.register} className="btn btn-dark">Registreren</a>
                    <a href={shell.routes.login} className="btn btn-outline-dark">Inloggen</a>
                </div>
            </section>
        </>
    );
}

function HomePage() {
    const user = shell.auth.user;

    return (
        <div className="home-dashboard">
            <section className="dashboard-hero">
                <div>
                    <p className="home-kicker">Dashboard</p>
                    <h1>Welkom bij Autorijschool Odai</h1>
                    <p>Beheer de dagelijkse operatie vanuit een helder overzicht. Instructeurs, ziekte/verlof en voertuigtoewijzingen staan centraal.</p>
                    <div className="home-hero-actions">
                        <a className="btn btn-home-primary" href={shell.routes.instructeurs}>Instructeurs in dienst</a>
                        <a className="btn btn-home-ghost" href={shell.routes.voertuigenAlles}>Alle voertuigen</a>
                    </div>
                </div>
            </section>

            <section className="home-stats">
                <Stat label="Rol" value={capitalize(user.role)} text={`Ingelogd als ${user.name}`} />
                <Stat label="Belangrijk" value="Ziekte/verlof" text="Maak voertuigen tijdelijk vrij via Instructeurs in dienst." />
                <article className="home-stat-card">
                    <span>Privacy</span>
                    <strong>AVG bewust</strong>
                    <p><a href={shell.routes.privacy}>Bekijk privacybeleid</a></p>
                </article>
            </section>

            <FeatureGrid
                items={[
                    ['Instructeurs', 'Bekijk instructeurs gesorteerd op sterren en meld ziekte/verlof met directe terugkoppeling.', 'Open instructeurs', shell.routes.instructeurs],
                    ['Voertuigen', 'Controleer welke voertuigen actief zijn, toegewezen zijn of opnieuw beschikbaar zijn.', 'Open voertuigen', shell.routes.voertuigenAlles],
                    ['Veilig werken', 'Formulieren gebruiken CSRF-beveiliging, servervalidatie en meldingen na acties.', 'MVC'],
                ]}
            />
        </div>
    );
}

function PrivacyPage() {
    const blocks = [
        ['Welke gegevens gebruiken wij?', 'Wij verwerken accountgegevens, contactgegevens, rollen, rijlesinformatie, voertuigtoewijzingen en technische loggegevens die nodig zijn om de applicatie veilig te laten werken.'],
        ['Waarvoor gebruiken wij gegevens?', 'Gegevens worden gebruikt voor inloggen, planning, instructeursbeheer, voertuigbeheer, beveiliging, foutanalyse en administratieve communicatie.'],
        ['Cookies', 'De website gebruikt noodzakelijke cookies voor sessies, inloggen en formulierbeveiliging. Zonder deze cookies werkt de applicatie niet goed.'],
        ['Beveiliging', 'Formulieren zijn beveiligd met CSRF-controle, wachtwoorden worden gehasht opgeslagen en acties worden waar nodig technisch gelogd.'],
        ['Bewaartermijn', 'Gegevens worden niet langer bewaard dan nodig is voor rijschooladministratie, wettelijke verplichtingen en het oplossen van technische problemen.'],
        ['Contact', 'Vragen over privacy of inzage in gegevens kunnen worden gestuurd naar info@autorijschoolodai.nl.'],
    ];

    return (
        <section className="privacy-page">
            <div className="app-page-heading">
                <p className="app-page-kicker">Privacybeleid</p>
                <h1>Privacy bij Autorijschool Odai</h1>
                <p className="text-muted mb-0">Laatst bijgewerkt: 17 juni 2026</p>
            </div>
            <div className="privacy-grid">
                {blocks.map(([title, text]) => (
                    <article key={title}>
                        <h2>{title}</h2>
                        <p>{text}</p>
                    </article>
                ))}
            </div>
        </section>
    );
}

function LoginPage({ errors = {}, old = {} }) {
    return (
        <AuthCard kicker="Account" title="Inloggen">
            <form method="post" action={shell.routes.loginStore} className="d-grid gap-3">
                {csrfInput()}
                <label className="form-label mb-0">
                    E-mailadres
                    <input className="form-control mt-1" type="email" name="email" defaultValue={old.email || ''} required autoFocus />
                    {fieldError(errors, 'email')}
                </label>
                <label className="form-label mb-0">
                    Wachtwoord
                    <input className="form-control mt-1" type="password" name="password" required />
                    {fieldError(errors, 'password')}
                </label>
                <label className="form-check">
                    <input className="form-check-input" type="checkbox" name="remember" value="1" />
                    <span className="form-check-label">Onthoud mij</span>
                </label>
                <button className="btn btn-primary" type="submit">Inloggen</button>
            </form>
            <p className="mt-3 mb-0">Nog geen account? <a href={shell.routes.register}>Registreren</a></p>
        </AuthCard>
    );
}

function RegisterPage({ roles = {}, errors = {}, old = {} }) {
    return (
        <AuthCard kicker="Nieuw account" title="Registreren">
            <form method="post" action={shell.routes.registerStore} className="d-grid gap-3">
                {csrfInput()}
                <label className="form-label mb-0">
                    Naam
                    <input className="form-control mt-1" name="name" defaultValue={old.name || ''} required autoFocus />
                    {fieldError(errors, 'name')}
                </label>
                <label className="form-label mb-0">
                    E-mailadres
                    <input className="form-control mt-1" type="email" name="email" defaultValue={old.email || ''} required />
                    {fieldError(errors, 'email')}
                </label>
                <label className="form-label mb-0">
                    Rol
                    <select className="form-select mt-1" name="role" defaultValue={old.role || 'instructeur'} required>
                        {Object.entries(roles).map(([value, label]) => <option key={value} value={value}>{label}</option>)}
                    </select>
                    {fieldError(errors, 'role')}
                </label>
                <label className="form-label mb-0">
                    Wachtwoord
                    <input className="form-control mt-1" type="password" name="password" required />
                    {fieldError(errors, 'password')}
                </label>
                <label className="form-label mb-0">
                    Herhaal wachtwoord
                    <input className="form-control mt-1" type="password" name="password_confirmation" required />
                </label>
                <button className="btn btn-primary" type="submit">Registreren</button>
            </form>
            <p className="mt-3 mb-0">Heb je al een account? <a href={shell.routes.login}>Inloggen</a></p>
        </AuthCard>
    );
}

function InstructorsPage({ instructeurs = [] }) {
    const canManage = shell.auth.user?.canManageVehicles;

    return (
        <>
            <section className="app-page-heading d-flex justify-content-between align-items-center">
                <div>
                    <p className="app-page-kicker">Planning en inzetbaarheid</p>
                    <h1>Instructeurs in dienst</h1>
                    <p className="text-muted mb-0">Aantal instructeurs: [{instructeurs.length}]</p>
                </div>
            </section>
            <TableCard>
                <thead>
                    <tr>
                        <th>Voornaam</th>
                        <th>Tussenvoegsel</th>
                        <th>Achternaam</th>
                        <th>Mobiel</th>
                        <th>Datum in dienst</th>
                        <th>Aantal sterren</th>
                        <th>Voertuigen</th>
                        {canManage && <th>Ziekte/Verlof</th>}
                    </tr>
                </thead>
                <tbody>
                    {instructeurs.map((instructeur) => (
                        <tr key={instructeur.Id} className={! instructeur.IsActief ? 'table-warning' : undefined}>
                            <td className="fw-semibold">{instructeur.Voornaam}</td>
                            <td>{instructeur.Tussenvoegsel || '-'}</td>
                            <td>{instructeur.Achternaam}</td>
                            <td>{instructeur.Mobiel}</td>
                            <td>{formatDate(instructeur.DatumInDienst)}</td>
                            <td><span className="stars-cell">{instructeur.AantalSterren}</span></td>
                            <td>
                                <a className="btn btn-outline-primary btn-sm app-icon-button" href={`/instructeurs/${instructeur.Id}/voertuigen`} title="Voertuigen bekijken" aria-label="Voertuigen bekijken">
                                    Auto
                                </a>
                            </td>
                            {canManage && (
                                <td>
                                    <form method="post" action={`/instructeurs/${instructeur.Id}/ziekte-verlof`}>
                                        {csrfInput()}
                                        {methodInput('PATCH')}
                                        <button
                                            className={`btn btn-sm app-icon-button ${instructeur.IsActief ? 'btn-outline-success' : 'btn-outline-warning'}`}
                                            type="submit"
                                            title={instructeur.IsActief ? 'Ziek/met verlof melden' : 'Beter/terug melden'}
                                            aria-label={instructeur.IsActief ? 'Ziek/met verlof melden' : 'Beter/terug melden'}
                                        >
                                            {instructeur.IsActief ? 'OK' : 'Terug'}
                                        </button>
                                    </form>
                                </td>
                            )}
                        </tr>
                    ))}
                </tbody>
            </TableCard>
        </>
    );
}

function AllVehiclesPage({ voertuigen = [] }) {
    const canManage = shell.auth.user?.canManageVehicles;

    return (
        <>
            <PageHeading kicker="Voertuigenbeheer" title="Alle voertuigen" />
            <TableCard>
                <thead>
                    <tr>
                        <th>Type voertuig</th>
                        <th>Type</th>
                        <th>Kenteken</th>
                        <th>Bouwjaar</th>
                        <th>Brandstof</th>
                        <th>Rijbewijscategorie</th>
                        <th>Instructeur naam</th>
                        {canManage && <th>Verwijderen</th>}
                    </tr>
                </thead>
                <tbody>
                    {voertuigen.length ? voertuigen.map((voertuig) => (
                        <tr key={voertuig.Id}>
                            <td><span className="vehicle-type-pill">{voertuig.TypeVoertuig}</span></td>
                            <td className="fw-semibold">{voertuig.Type}</td>
                            <td><span className="vehicle-plate">{voertuig.Kenteken}</span></td>
                            <td>{formatDate(voertuig.Bouwjaar)}</td>
                            <td>{voertuig.Brandstof}</td>
                            <td><span className="vehicle-license-pill">{voertuig.Rijbewijscategorie}</span></td>
                            <td>{voertuig.InstructeurNaam || '-'}</td>
                            {canManage && (
                                <td className="text-end">
                                    <form method="post" action={`/voertuigen/${voertuig.Id}`}>
                                        {csrfInput()}
                                        {methodInput('DELETE')}
                                        <button className="btn btn-outline-danger btn-sm vehicle-delete-button" type="submit" title="Verwijderen" aria-label="Verwijderen">x</button>
                                    </form>
                                </td>
                            )}
                        </tr>
                    )) : (
                        <tr><td colSpan={canManage ? 8 : 7} className="text-center text-muted py-4">Geen voertuigen gevonden.</td></tr>
                    )}
                </tbody>
            </TableCard>
        </>
    );
}

function InstructorVehiclesPage({ instructeur, voertuigen = [] }) {
    const canManage = shell.auth.user?.canManageVehicles;

    return (
        <>
            <InstructorHeader title="Door instructeur gebruikte voertuigen" instructeur={instructeur}>
                {canManage && instructeur.IsActief && <a className="btn btn-primary mt-3" href={`/instructeurs/${instructeur.Id}/voertuigen/beschikbaar`}>Toevoegen voertuig</a>}
            </InstructorHeader>
            <TableCard>
                <thead>
                    <tr>
                        <th>Type voertuig</th>
                        <th>Type</th>
                        <th>Kenteken</th>
                        <th>Bouwjaar</th>
                        <th>Brandstof</th>
                        <th>Rijbewijscategorie</th>
                        {canManage && <th>Wijzigen</th>}
                        {canManage && <th>Verwijderen</th>}
                        {canManage && <th>Toegewezen</th>}
                    </tr>
                </thead>
                <tbody>
                    {voertuigen.length ? voertuigen.map((voertuig) => (
                        <tr key={voertuig.Id}>
                            <td>{voertuig.TypeVoertuig}</td>
                            <td>{voertuig.Type}</td>
                            <td>{voertuig.Kenteken}</td>
                            <td>{formatDate(voertuig.Bouwjaar)}</td>
                            <td>{voertuig.Brandstof}</td>
                            <td>{voertuig.Rijbewijscategorie}</td>
                            {canManage && <td><a className="btn btn-outline-secondary btn-sm" href={`/instructeurs/${instructeur.Id}/voertuigen/${voertuig.Id}/wijzigen`} title="Wijzigen" aria-label="Wijzigen">Wijzig</a></td>}
                            {canManage && (
                                <td>
                                    <form method="post" action={`/instructeurs/${instructeur.Id}/voertuigen/${voertuig.Id}`}>
                                        {csrfInput()}
                                        {methodInput('DELETE')}
                                        <button className="btn btn-outline-danger btn-sm" type="submit" title="Verwijderen" aria-label="Verwijderen">x</button>
                                    </form>
                                </td>
                            )}
                            {canManage && (
                                <td>
                                    {Number(voertuig.IsToegewezen) === 1 ? (
                                        <span className="assignment-status assignment-status-ok" title="Toegewezen aan deze instructeur">OK</span>
                                    ) : (
                                        <form method="post" action={`/instructeurs/${instructeur.Id}/voertuigen/${voertuig.Id}/terugzetten`}>
                                            {csrfInput()}
                                            {methodInput('PATCH')}
                                            <button className="assignment-status assignment-status-missing" type="submit" title={`Opnieuw toewijzen aan ${instructeur.VolledigeNaam}`} aria-label={`Opnieuw toewijzen aan ${instructeur.VolledigeNaam}`}>x</button>
                                        </form>
                                    )}
                                </td>
                            )}
                        </tr>
                    )) : (
                        <tr><td colSpan={canManage ? 9 : 6}>Geen voertuigen toegewezen.</td></tr>
                    )}
                </tbody>
            </TableCard>
        </>
    );
}

function AvailableVehiclesPage({ instructeur, voertuigen = [] }) {
    return (
        <>
            <InstructorHeader title="Alle beschikbare voertuigen" instructeur={instructeur}>
                <a className="btn btn-secondary" href={`/instructeurs/${instructeur.Id}/voertuigen`}>Terug</a>
            </InstructorHeader>
            <TableCard striped>
                <thead>
                    <tr>
                        <th>Type voertuig</th>
                        <th>Type</th>
                        <th>Kenteken</th>
                        <th>Bouwjaar</th>
                        <th>Brandstof</th>
                        <th>Rijbewijscategorie</th>
                        <th>Toevoegen</th>
                        <th>Wijzigen</th>
                    </tr>
                </thead>
                <tbody>
                    {voertuigen.map((voertuig) => (
                        <tr key={voertuig.Id}>
                            <td>{voertuig.TypeVoertuig}</td>
                            <td>{voertuig.Type}</td>
                            <td>{voertuig.Kenteken}</td>
                            <td>{formatDate(voertuig.Bouwjaar)}</td>
                            <td>{voertuig.Brandstof}</td>
                            <td>{voertuig.Rijbewijscategorie}</td>
                            <td><a className="btn btn-outline-primary btn-sm" href={`/instructeurs/${instructeur.Id}/voertuigen/${voertuig.Id}/wijzigen`} title="Toevoegen" aria-label="Toevoegen">+</a></td>
                            <td><a className="btn btn-outline-secondary btn-sm" href={`/instructeurs/${instructeur.Id}/voertuigen/${voertuig.Id}/wijzigen`} title="Wijzigen" aria-label="Wijzigen">Wijzig</a></td>
                        </tr>
                    ))}
                </tbody>
            </TableCard>
        </>
    );
}

function EditVehiclePage({ instructeur, voertuig, instructeurs = [], typeVoertuigen = [], brandstoffen = [], errors = {}, old = {} }) {
    const selectedInstructor = old.InstructeurId || voertuig.InstructeurId || instructeur.Id;
    const selectedType = old.TypeVoertuigId || voertuig.TypeVoertuigId;
    const selectedFuel = old.Brandstof || voertuig.Brandstof;

    return (
        <>
            <section className="d-flex justify-content-between align-items-center mb-3">
                <h1 className="h3 mb-0">Wijzigen voertuiggegevens</h1>
                <a className="btn btn-secondary" href={`/instructeurs/${instructeur.Id}/voertuigen`}>Terug</a>
            </section>
            <form className="card card-body border shadow-sm" method="post" action={`/instructeurs/${instructeur.Id}/voertuigen/${voertuig.Id}`}>
                {csrfInput()}
                {methodInput('PUT')}
                <div className="mb-3">
                    <label className="form-label">
                        Instructeur:
                        <select className="form-select" name="InstructeurId" defaultValue={selectedInstructor} required>
                            {instructeurs.map((rijInstructeur) => <option key={rijInstructeur.Id} value={rijInstructeur.Id}>{rijInstructeur.VolledigeNaam}</option>)}
                        </select>
                    </label>
                </div>
                <div className="mb-3">
                    <label className="form-label">
                        Type voertuig:
                        <select className="form-select" name="TypeVoertuigId" defaultValue={selectedType} required>
                            {typeVoertuigen.map((typeVoertuig) => <option key={typeVoertuig.Id} value={typeVoertuig.Id}>{typeVoertuig.TypeVoertuig}</option>)}
                        </select>
                    </label>
                </div>
                <div className="mb-3">
                    <label className="form-label">
                        Type:
                        <input className="form-control" name="Type" defaultValue={old.Type || voertuig.Type} required />
                        {fieldError(errors, 'Type')}
                    </label>
                </div>
                <div className="mb-3">
                    <label className="form-label">
                        Bouwjaar:
                        <input className="form-control" value={formatDate(voertuig.Bouwjaar)} readOnly />
                    </label>
                </div>
                <fieldset className="mb-3">
                    <legend className="col-form-label pt-0">Brandstof:</legend>
                    {brandstoffen.map((brandstof) => (
                        <div className="form-check form-check-inline" key={brandstof}>
                            <input className="form-check-input" type="radio" name="Brandstof" value={brandstof} defaultChecked={selectedFuel === brandstof} required />
                            <label className="form-check-label">{brandstof}</label>
                        </div>
                    ))}
                    {fieldError(errors, 'Brandstof')}
                </fieldset>
                <div className="mb-3">
                    <label className="form-label">
                        Kenteken:
                        <input className="form-control" name="Kenteken" defaultValue={old.Kenteken || voertuig.Kenteken} maxLength="10" required />
                        {fieldError(errors, 'Kenteken')}
                    </label>
                </div>
                <div className="d-flex justify-content-end">
                    <button className="btn btn-primary" type="submit">Wijzig</button>
                </div>
            </form>
        </>
    );
}

function LessonPackagesPage({ lesrijpakketten = [], categorieen = [], geselecteerdeCategorie = '' }) {
    const [activePackage, setActivePackage] = useState(null);

    return (
        <>
            <section className="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 className="h3 mb-1">Lesrijpakketten Overzicht</h1>
                    <p className="text-muted mb-0">Aantal beschikbare pakketten: [{lesrijpakketten.length}]</p>
                </div>
            </section>
            <div className="bg-white border rounded-3 p-3 mb-3">
                <form method="get" action={shell.routes.lespakketten} className="row g-2 align-items-end">
                    <div className="col-md-9">
                        <label htmlFor="categorie" className="form-label mb-1">Categorie</label>
                        <select id="categorie" name="categorie" className="form-select" defaultValue={geselecteerdeCategorie}>
                            <option value="">Alle categorieen</option>
                            {categorieen.map((categorie) => <option value={categorie} key={categorie}>{categorie}</option>)}
                        </select>
                    </div>
                    <div className="col-md-3 d-grid">
                        <button type="submit" className="btn btn-primary">Toon Lespakketten</button>
                    </div>
                </form>
            </div>
            <div className="table-responsive bg-white border rounded-3">
                <table className="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Aantal Lessen</th>
                            <th>Prijs</th>
                            <th>Categorie</th>
                            <th>Beschrijving</th>
                            <th>Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        {lesrijpakketten.length ? lesrijpakketten.map((pakket) => (
                            <tr key={pakket.id}>
                                <td className="fw-bold">{pakket.Naam}</td>
                                <td>{pakket.Lessen} lessen</td>
                                <td className="text-success fw-bold">{money(pakket.Prijs)}</td>
                                <td>{pakket.Categorie ? <span className="badge bg-info">{pakket.Categorie}</span> : <span className="text-muted">-</span>}</td>
                                <td>{pakket.Beschrijving ? <small className="text-muted">{pakket.Beschrijving.slice(0, 50)}{pakket.Beschrijving.length > 50 ? '...' : ''}</small> : <span className="text-muted">-</span>}</td>
                                <td><button type="button" className="btn btn-outline-primary btn-sm" onClick={() => setActivePackage(pakket)}>Info</button></td>
                            </tr>
                        )) : (
                            <tr>
                                <td colSpan="6" className="text-center text-muted py-4">
                                    {geselecteerdeCategorie === 'Theorie' ? 'Er zijn geen lespakketten bekend die behoren bij de geselecteerde categorie' : 'Geen lespakketten beschikbaar'}
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
            {activePackage && <PackageModal pakket={activePackage} onClose={() => setActivePackage(null)} />}
        </>
    );
}

function AccountsPage({ accounts = [] }) {
    const onlyAdmin = accounts.length === 1 && accounts[0].role === 'administrator';

    return (
        <>
            <section className="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 className="h3 mb-1">Accounts</h1>
                    <p className="text-muted mb-0">Overzicht van alle geregistreerde accounts.</p>
                </div>
            </section>
            {onlyAdmin && <div className="alert alert-info mb-3">Er zijn geen accounts behalve de adminaccount.</div>}
            <div className="table-responsive bg-white border rounded-3">
                <table className="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>E-mailadres</th>
                            <th>Rol</th>
                            <th>Geregistreerd op</th>
                        </tr>
                    </thead>
                    <tbody>
                        {accounts.map((account) => (
                            <tr key={account.id || account.email}>
                                <td>{account.name}</td>
                                <td>{account.email}</td>
                                <td><span className="badge text-bg-light border">{capitalize(account.role)}</span></td>
                                <td>{formatDate(account.created_at, true)}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    );
}

function StatusPage({ title, message, redirectUrl }) {
    useEffect(() => {
        const timeout = setTimeout(() => {
            window.location.assign(redirectUrl);
        }, 3000);

        return () => clearTimeout(timeout);
    }, [redirectUrl]);

    return (
        <section className="status-page">
            <h1 className="h3">{title}</h1>
            <div className="status-message">{message}</div>
        </section>
    );
}

function AuthCard({ kicker, title, children }) {
    return (
        <section className="d-grid auth-page">
            <div className="card shadow-sm auth-card">
                <div className="card-body p-4">
                    <p className="text-uppercase small fw-semibold text-secondary mb-2">{kicker}</p>
                    <h1 className="h3 mb-4">{title}</h1>
                    {children}
                </div>
            </div>
        </section>
    );
}

function FeatureGrid({ items }) {
    return (
        <div className="home-feature-grid">
            {items.map(([title, text, action, href]) => (
                <article className="home-feature-card" key={title}>
                    <h2>{title}</h2>
                    <p>{text}</p>
                    {href ? <a href={href}>{action}</a> : action ? <span className="home-feature-chip">{action}</span> : null}
                </article>
            ))}
        </div>
    );
}

function Stat({ label, value, text }) {
    return (
        <article className="home-stat-card">
            <span>{label}</span>
            <strong>{value}</strong>
            <p>{text}</p>
        </article>
    );
}

function PageHeading({ kicker, title }) {
    return (
        <section className="app-page-heading">
            <div>
                <p className="app-page-kicker">{kicker}</p>
                <h1>{title}</h1>
            </div>
        </section>
    );
}

function InstructorHeader({ title, instructeur, children }) {
    return (
        <section className="app-page-heading d-flex justify-content-between align-items-start">
            <div>
                <p className="app-page-kicker">Voertuigtoewijzing</p>
                <h1>{title}</h1>
                <div className="text-muted">
                    <p className="mb-1">Naam: [{instructeur.VolledigeNaam}]</p>
                    <p className="mb-1">Datum in dienst: [{formatDate(instructeur.DatumInDienst)}]</p>
                    <p className="mb-0">Aantal sterren: [{instructeur.AantalSterren}]</p>
                </div>
                {children}
            </div>
        </section>
    );
}

function TableCard({ children, striped = false }) {
    return (
        <div className="vehicle-table-card">
            <div className="table-responsive">
                <table className={`table vehicle-table align-middle mb-0 ${striped ? 'table-striped table-hover' : ''}`}>
                    {children}
                </table>
            </div>
        </div>
    );
}

function PackageModal({ pakket, onClose }) {
    return (
        <>
            <div className="modal fade show d-block" tabIndex="-1" aria-modal="true" role="dialog">
                <div className="modal-dialog modal-dialog-centered">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h2 className="modal-title fs-5">{pakket.Naam}</h2>
                            <button type="button" className="btn-close" aria-label="Sluiten" onClick={onClose} />
                        </div>
                        <div className="modal-body">
                            <p className="mb-2"><strong>Aantal lessen:</strong> {pakket.Lessen}</p>
                            <p className="mb-2"><strong>Prijs:</strong> {money(pakket.Prijs)}</p>
                            <p className="mb-2"><strong>Categorie:</strong> {pakket.Categorie || '-'}</p>
                            <p className="mb-2"><strong>Volledige beschrijving:</strong> {pakket.Beschrijving || 'Geen beschrijving beschikbaar.'}</p>
                            <p className="mb-0"><strong>Opmerking:</strong> {pakket.Opmerking || 'Geen extra opmerkingen.'}</p>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" onClick={onClose}>Sluiten</button>
                        </div>
                    </div>
                </div>
            </div>
            <div className="modal-backdrop fade show" onClick={onClose} />
        </>
    );
}

function capitalize(value = '') {
    return value.charAt(0).toUpperCase() + value.slice(1);
}

const pages = {
    Landing: LandingPage,
    Home: HomePage,
    Privacy: PrivacyPage,
    Login: LoginPage,
    Register: RegisterPage,
    Instructors: InstructorsPage,
    AllVehicles: AllVehiclesPage,
    InstructorVehicles: InstructorVehiclesPage,
    AvailableVehicles: AvailableVehiclesPage,
    EditVehicle: EditVehiclePage,
    LessonPackages: LessonPackagesPage,
    Accounts: AccountsPage,
    Status: StatusPage,
};

if (rootElement) {
    createRoot(rootElement).render(<App />);
}
