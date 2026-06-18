import React, { useEffect, useMemo, useState } from 'react';
import './styles.css';

const instructors = [
    { id: 1, firstName: 'Odai', middleName: '', lastName: 'Matar', phone: '+31 6 1234 5678', since: '2021-03-15', stars: '*****', active: true },
    { id: 2, firstName: 'Sara', middleName: 'de', lastName: 'Vries', phone: '+31 6 8765 4321', since: '2022-09-01', stars: '****', active: true },
    { id: 3, firstName: 'Yassin', middleName: '', lastName: 'Akkari', phone: '+31 6 2222 1111', since: '2020-01-20', stars: '*****', active: false },
];

const vehicles = [
    { id: 1, vehicleType: 'Personenauto', type: 'Volkswagen Golf', plate: 'OD-123-A', year: '2022-01-01', fuel: 'Benzine', category: 'B', instructor: 'Odai Matar' },
    { id: 2, vehicleType: 'Personenauto', type: 'Toyota Yaris', plate: 'RS-456-B', year: '2021-01-01', fuel: 'Hybride', category: 'B', instructor: 'Sara de Vries' },
    { id: 3, vehicleType: 'Motor', type: 'Yamaha MT-07', plate: 'MT-777-C', year: '2023-01-01', fuel: 'Benzine', category: 'A', instructor: '-' },
];

const packages = [
    { id: 1, name: 'Starterpakket', lessons: 10, price: 599, category: 'Auto', description: 'Voor leerlingen die rustig willen beginnen met basiscontrole en verkeersinzicht.', note: 'Inclusief voortgangsgesprek.' },
    { id: 2, name: 'Examenklaar', lessons: 25, price: 1399, category: 'Auto', description: 'Compleet traject van voertuigbeheersing tot zelfstandig rijden in druk verkeer.', note: 'Meest gekozen pakket.' },
    { id: 3, name: 'Motorrijles A', lessons: 15, price: 949, category: 'Motor', description: 'Gerichte lessen voor AVB en AVD met duidelijke feedback per onderdeel.', note: 'Beschikbaarheid in overleg.' },
];

const accounts = [
    { id: 1, name: 'Odai Matar', email: 'info@autorijschoolodai.nl', role: 'administrator', createdAt: '2026-06-01T09:30:00' },
    { id: 2, name: 'Sara de Vries', email: 'sara@example.test', role: 'instructeur', createdAt: '2026-06-08T11:00:00' },
];

function App() {
    const [route, setRoute] = useHashRoute();
    const [signedIn, setSignedInState] = useState(() => localStorage.getItem('odaiDemoSignedIn') === 'yes');

    const setSignedIn = (value) => {
        setSignedInState(value);
        localStorage.setItem('odaiDemoSignedIn', value ? 'yes' : 'no');
    };

    const currentPage = signedIn ? route : (['privacy', 'login', 'register'].includes(route) ? route : 'landing');

    useEffect(() => {
        document.title = `${labelFor(currentPage)} | Autorijschool Odai`;
    }, [currentPage]);

    return (
        <>
            <Navigation route={currentPage} setRoute={setRoute} signedIn={signedIn} setSignedIn={setSignedIn} />
            <main className="container py-4">
                {currentPage === 'landing' && <Landing setRoute={setRoute} />}
                {currentPage === 'dashboard' && <Dashboard setRoute={setRoute} />}
                {currentPage === 'privacy' && <Privacy />}
                {currentPage === 'login' && <Login setSignedIn={setSignedIn} setRoute={setRoute} />}
                {currentPage === 'register' && <Register setSignedIn={setSignedIn} setRoute={setRoute} />}
                {currentPage === 'instructeurs' && <Instructors />}
                {currentPage === 'voertuigen' && <Vehicles />}
                {currentPage === 'lespakketten' && <LessonPackages />}
                {currentPage === 'accounts' && <Accounts />}
            </main>
            <Footer setRoute={setRoute} />
            <PrivacyConsent setRoute={setRoute} />
        </>
    );
}

function useHashRoute() {
    const getRoute = () => window.location.hash.replace('#/', '') || 'landing';
    const [route, setRouteState] = useState(getRoute);

    useEffect(() => {
        const onHashChange = () => setRouteState(getRoute());
        window.addEventListener('hashchange', onHashChange);
        return () => window.removeEventListener('hashchange', onHashChange);
    }, []);

    const setRoute = (nextRoute) => {
        window.location.hash = `/${nextRoute}`;
        setRouteState(nextRoute);
    };

    return [route, setRoute];
}

function Navigation({ route, setRoute, signedIn, setSignedIn }) {
    return (
        <nav className="navbar navbar-expand-lg sticky-top app-navbar">
            <div className="container">
                <button className="navbar-brand fw-semibold d-flex align-items-center gap-2 btn btn-link text-decoration-none p-0" onClick={() => setRoute(signedIn ? 'dashboard' : 'landing')}>
                    <span className="app-brand-mark">OA</span>
                    <span>Autorijschool Odai</span>
                </button>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu openen">
                    <span className="navbar-toggler-icon" />
                </button>
                <div className="collapse navbar-collapse" id="mainNavbar">
                    <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                        {(signedIn ? ['dashboard', 'instructeurs', 'voertuigen', 'lespakketten', 'accounts', 'privacy'] : ['landing', 'privacy']).map((item) => (
                            <li className="nav-item" key={item}>
                                <button className={`nav-link app-nav-link btn btn-link ${route === item ? 'active' : ''}`} onClick={() => setRoute(item)}>
                                    {labelFor(item)}
                                </button>
                            </li>
                        ))}
                    </ul>
                    <div className="d-flex align-items-center gap-2">
                        {signedIn ? (
                            <>
                                <span className="badge app-user-badge">Odai</span>
                                <button className="btn btn-outline-secondary btn-sm app-logout-btn" onClick={() => { setSignedIn(false); setRoute('landing'); }}>Uitloggen</button>
                            </>
                        ) : (
                            <>
                                <button className="btn btn-outline-primary btn-sm" onClick={() => setRoute('login')}>Inloggen</button>
                                <button className="btn btn-primary btn-sm" onClick={() => setRoute('register')}>Registreren</button>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </nav>
    );
}

function Landing({ setRoute }) {
    return (
        <>
            <section className="site-hero">
                <div className="site-hero-overlay">
                    <p className="home-kicker">Autorijschool Odai</p>
                    <h1>Rijlessen met rust, structuur en vertrouwen.</h1>
                    <p>Persoonlijke begeleiding voor leerlingen die veilig, zelfstandig en ontspannen de weg op willen.</p>
                    <div className="home-hero-actions">
                        <button className="btn btn-home-primary" onClick={() => setRoute('register')}>Start met lessen</button>
                        <button className="btn btn-home-ghost" onClick={() => setRoute('login')}>Inloggen</button>
                    </div>
                </div>
            </section>
            <section className="site-section">
                <div className="site-section-head">
                    <p className="app-page-kicker">Onze aanpak</p>
                    <h2>Rustig leren rijden, helder bijhouden</h2>
                </div>
                <FeatureGrid items={[
                    ['Persoonlijke rijlessen', 'Je oefent op jouw tempo met concrete lesdoelen, zodat iedere les logisch voortbouwt op de vorige.'],
                    ['Veilige planning', 'Instructeurs, voertuigen en beschikbaarheid staan overzichtelijk bij elkaar.'],
                    ['Privacy bewust', 'Wij gebruiken alleen gegevens die nodig zijn voor lessen, contact en administratie.'],
                ]} />
            </section>
            <section className="site-contact-band">
                <div>
                    <h2>Klaar om te starten?</h2>
                    <p className="mb-0">Open de React demo en bekijk de rijschoolomgeving zonder Laravel of Herd.</p>
                </div>
                <button className="btn btn-dark" onClick={() => setRoute('register')}>Registreren</button>
            </section>
        </>
    );
}

function Dashboard({ setRoute }) {
    return (
        <div className="home-dashboard">
            <section className="dashboard-hero">
                <div>
                    <p className="home-kicker">Dashboard</p>
                    <h1>Welkom bij Autorijschool Odai</h1>
                    <p>Beheer instructeurs, voertuigen en pakketten vanuit een pure React interface.</p>
                    <div className="home-hero-actions">
                        <button className="btn btn-home-primary" onClick={() => setRoute('instructeurs')}>Instructeurs in dienst</button>
                        <button className="btn btn-home-ghost" onClick={() => setRoute('voertuigen')}>Alle voertuigen</button>
                    </div>
                </div>
            </section>
            <section className="home-stats">
                <Stat label="Stack" value="React + Vite" text="Geen Laravel, geen Herd, geen PHP runtime." />
                <Stat label="Instructeurs" value={String(instructors.length)} text="Demo-overzicht met inzetbaarheid." />
                <Stat label="Voertuigen" value={String(vehicles.length)} text="Beschikbare lesvoertuigen per categorie." />
            </section>
        </div>
    );
}

function Instructors() {
    return (
        <>
            <PageHeading kicker="Planning en inzetbaarheid" title="Instructeurs in dienst" subtitle={`Aantal instructeurs: [${instructors.length}]`} />
            <TableCard>
                <thead>
                    <tr>
                        <th>Voornaam</th><th>Tussenvoegsel</th><th>Achternaam</th><th>Mobiel</th><th>Datum in dienst</th><th>Aantal sterren</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {instructors.map((instructor) => (
                        <tr key={instructor.id} className={!instructor.active ? 'table-warning' : undefined}>
                            <td className="fw-semibold">{instructor.firstName}</td>
                            <td>{instructor.middleName || '-'}</td>
                            <td>{instructor.lastName}</td>
                            <td>{instructor.phone}</td>
                            <td>{formatDate(instructor.since)}</td>
                            <td><span className="stars-cell">{instructor.stars}</span></td>
                            <td><span className={`badge ${instructor.active ? 'text-bg-success' : 'text-bg-warning'}`}>{instructor.active ? 'Actief' : 'Verlof'}</span></td>
                        </tr>
                    ))}
                </tbody>
            </TableCard>
        </>
    );
}

function Vehicles() {
    return (
        <>
            <PageHeading kicker="Voertuigenbeheer" title="Alle voertuigen" />
            <TableCard>
                <thead>
                    <tr>
                        <th>Type voertuig</th><th>Type</th><th>Kenteken</th><th>Bouwjaar</th><th>Brandstof</th><th>Rijbewijscategorie</th><th>Instructeur naam</th>
                    </tr>
                </thead>
                <tbody>
                    {vehicles.map((vehicle) => (
                        <tr key={vehicle.id}>
                            <td><span className="vehicle-type-pill">{vehicle.vehicleType}</span></td>
                            <td className="fw-semibold">{vehicle.type}</td>
                            <td><span className="vehicle-plate">{vehicle.plate}</span></td>
                            <td>{formatDate(vehicle.year)}</td>
                            <td>{vehicle.fuel}</td>
                            <td><span className="vehicle-license-pill">{vehicle.category}</span></td>
                            <td>{vehicle.instructor}</td>
                        </tr>
                    ))}
                </tbody>
            </TableCard>
        </>
    );
}

function LessonPackages() {
    const [category, setCategory] = useState('');
    const [activePackage, setActivePackage] = useState(null);
    const categories = useMemo(() => [...new Set(packages.map((pakket) => pakket.category))], []);
    const shown = category ? packages.filter((pakket) => pakket.category === category) : packages;

    return (
        <>
            <PageHeading kicker="Pakketten" title="Lesrijpakketten Overzicht" subtitle={`Aantal beschikbare pakketten: [${shown.length}]`} />
            <div className="bg-white border rounded-3 p-3 mb-3">
                <label className="form-label mb-1" htmlFor="categorie">Categorie</label>
                <select id="categorie" className="form-select" value={category} onChange={(event) => setCategory(event.target.value)}>
                    <option value="">Alle categorieen</option>
                    {categories.map((item) => <option key={item} value={item}>{item}</option>)}
                </select>
            </div>
            <div className="home-feature-grid">
                {shown.map((pakket) => (
                    <article className="home-feature-card" key={pakket.id}>
                        <h2>{pakket.name}</h2>
                        <p>{pakket.description}</p>
                        <strong>{money(pakket.price)}</strong>
                        <div className="mt-3">
                            <button className="btn btn-outline-primary btn-sm" onClick={() => setActivePackage(pakket)}>Info</button>
                        </div>
                    </article>
                ))}
            </div>
            {activePackage && <PackageModal pakket={activePackage} onClose={() => setActivePackage(null)} />}
        </>
    );
}

function Accounts() {
    return (
        <>
            <PageHeading kicker="Beheer" title="Accounts" subtitle="Overzicht van alle demo-accounts." />
            <TableCard>
                <thead><tr><th>Naam</th><th>E-mailadres</th><th>Rol</th><th>Geregistreerd op</th></tr></thead>
                <tbody>
                    {accounts.map((account) => (
                        <tr key={account.id}>
                            <td>{account.name}</td>
                            <td>{account.email}</td>
                            <td><span className="badge text-bg-light border">{capitalize(account.role)}</span></td>
                            <td>{formatDate(account.createdAt, true)}</td>
                        </tr>
                    ))}
                </tbody>
            </TableCard>
        </>
    );
}

function Login({ setSignedIn, setRoute }) {
    return <AuthCard kicker="Account" title="Inloggen" button="Inloggen" onSubmit={() => { setSignedIn(true); setRoute('dashboard'); }} />;
}

function Register({ setSignedIn, setRoute }) {
    return <AuthCard kicker="Nieuw account" title="Registreren" button="Registreren" onSubmit={() => { setSignedIn(true); setRoute('dashboard'); }} register />;
}

function AuthCard({ kicker, title, button, onSubmit, register = false }) {
    return (
        <section className="d-grid auth-page">
            <div className="card shadow-sm auth-card">
                <div className="card-body p-4">
                    <p className="text-uppercase small fw-semibold text-secondary mb-2">{kicker}</p>
                    <h1 className="h3 mb-4">{title}</h1>
                    <form className="d-grid gap-3" onSubmit={(event) => { event.preventDefault(); onSubmit(); }}>
                        {register && <label className="form-label mb-0">Naam<input className="form-control mt-1" required autoFocus /></label>}
                        <label className="form-label mb-0">E-mailadres<input className="form-control mt-1" type="email" required autoFocus={!register} /></label>
                        {register && <label className="form-label mb-0">Rol<select className="form-select mt-1" defaultValue="leerling"><option value="leerling">Leerling</option><option value="instructeur">Instructeur</option></select></label>}
                        <label className="form-label mb-0">Wachtwoord<input className="form-control mt-1" type="password" required /></label>
                        <button className="btn btn-primary" type="submit">{button}</button>
                    </form>
                </div>
            </div>
        </section>
    );
}

function Privacy() {
    const blocks = [
        ['Welke gegevens gebruiken wij?', 'Deze React-versie gebruikt alleen lokale demo-data in de browser.'],
        ['Cookies', 'Alleen de privacy-keuze wordt in localStorage onthouden.'],
        ['Beveiliging', 'Er is geen Laravel sessie, database of server-side accountlaag gekoppeld.'],
        ['Contact', 'Vragen kunnen worden gestuurd naar info@autorijschoolodai.nl.'],
    ];

    return (
        <section className="privacy-page">
            <PageHeading kicker="Privacybeleid" title="Privacy bij Autorijschool Odai" subtitle="Laatst bijgewerkt: 18 juni 2026" />
            <div className="privacy-grid">
                {blocks.map(([title, text]) => <article key={title}><h2>{title}</h2><p>{text}</p></article>)}
            </div>
        </section>
    );
}

function Footer({ setRoute }) {
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
                    <button className="btn btn-link p-0" onClick={() => setRoute('privacy')}>Privacy</button>
                </div>
            </div>
        </footer>
    );
}

function PrivacyConsent({ setRoute }) {
    const [visible, setVisible] = useState(false);

    useEffect(() => {
        setVisible(localStorage.getItem('privacyConsentAccepted') !== 'yes');
    }, []);

    if (!visible) return null;

    return (
        <div className="privacy-consent">
            <div>
                <strong>Privacy en cookies</strong>
                <p className="mb-0">Deze React website gebruikt localStorage om je keuze te onthouden.</p>
            </div>
            <div className="privacy-consent-actions">
                <button className="btn btn-outline-secondary btn-sm" onClick={() => setRoute('privacy')}>Privacy lezen</button>
                <button className="btn btn-primary btn-sm" onClick={() => { localStorage.setItem('privacyConsentAccepted', 'yes'); setVisible(false); }}>Akkoord</button>
            </div>
        </div>
    );
}

function FeatureGrid({ items }) {
    return <div className="home-feature-grid">{items.map(([title, text]) => <article className="home-feature-card" key={title}><h2>{title}</h2><p>{text}</p></article>)}</div>;
}

function Stat({ label, value, text }) {
    return <article className="home-stat-card"><span>{label}</span><strong>{value}</strong><p>{text}</p></article>;
}

function PageHeading({ kicker, title, subtitle }) {
    return <section className="app-page-heading"><p className="app-page-kicker">{kicker}</p><h1>{title}</h1>{subtitle && <p className="text-muted mb-0">{subtitle}</p>}</section>;
}

function TableCard({ children }) {
    return <div className="vehicle-table-card"><div className="table-responsive"><table className="table vehicle-table align-middle mb-0">{children}</table></div></div>;
}

function PackageModal({ pakket, onClose }) {
    return (
        <>
            <div className="modal fade show d-block" tabIndex="-1" aria-modal="true" role="dialog">
                <div className="modal-dialog modal-dialog-centered">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h2 className="modal-title fs-5">{pakket.name}</h2>
                            <button type="button" className="btn-close" aria-label="Sluiten" onClick={onClose} />
                        </div>
                        <div className="modal-body">
                            <p className="mb-2"><strong>Aantal lessen:</strong> {pakket.lessons}</p>
                            <p className="mb-2"><strong>Prijs:</strong> {money(pakket.price)}</p>
                            <p className="mb-2"><strong>Categorie:</strong> {pakket.category}</p>
                            <p className="mb-2"><strong>Beschrijving:</strong> {pakket.description}</p>
                            <p className="mb-0"><strong>Opmerking:</strong> {pakket.note}</p>
                        </div>
                        <div className="modal-footer"><button type="button" className="btn btn-secondary" onClick={onClose}>Sluiten</button></div>
                    </div>
                </div>
            </div>
            <div className="modal-backdrop fade show" onClick={onClose} />
        </>
    );
}

function labelFor(route) {
    return {
        landing: 'Home',
        dashboard: 'Dashboard',
        instructeurs: 'Instructeurs in dienst',
        voertuigen: 'Alle voertuigen',
        lespakketten: 'Lespakketten',
        accounts: 'Accounts',
        privacy: 'Privacy',
    }[route] || route;
}

function formatDate(value, includeTime = false) {
    return new Intl.DateTimeFormat('nl-NL', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        ...(includeTime ? { hour: '2-digit', minute: '2-digit' } : {}),
    }).format(new Date(value));
}

function money(value) {
    return new Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(value);
}

function capitalize(value) {
    return value.charAt(0).toUpperCase() + value.slice(1);
}

export default App;
