<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'Rijschool Vierkante Wielen']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Rijschool Vierkante Wielen']); ?>
    <section class="rounded-4 p-4 p-lg-5 mb-4 text-light shadow-lg" style="background: linear-gradient(130deg, #0f172a 0%, #14532d 52%, #f97316 100%);">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <p class="mb-2 text-uppercase fw-bold small text-warning">Rijschool Vierkante Wielen</p>
                <h1 class="display-5 fw-bold mb-3">Slim leren rijden met duidelijke begeleiding</h1>
                <p class="lead mb-4">
                    Wij helpen je veilig en zelfverzekerd de weg op. Plan lessen, volg je voortgang en blijf in contact
                    met je instructeur via een gebruiksvriendelijk platform.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-warning btn-lg fw-semibold shadow">Direct inschrijven</a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg shadow-sm">Inloggen leerling/instructeur</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="p-4 rounded-4 border border-light border-opacity-50 shadow" style="background-color: rgba(255, 255, 255, .16);">
                    <h2 class="h5 mb-3">Waarom kiezen voor ons?</h2>
                    <ul class="mb-0 ps-3">
                        <li>Persoonlijke aanpak per leerling</li>
                        <li>Heldere lesdoelen en feedback</li>
                        <li>Flexibel plannen op mobiel en desktop</li>
                        <li>Inzicht in lessen, examens en tegoed</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <article class="h-100 p-4 bg-white border rounded-4 shadow-sm">
                <h2 class="h6 text-uppercase fw-bold mb-2">Eigenaar</h2>
                <p class="mb-0 text-muted">Frank van Dijk leidt de rijschool met focus op kwaliteit en veiligheid.</p>
            </article>
        </div>
        <div class="col-md-6 col-xl-3">
            <article class="h-100 p-4 bg-white border rounded-4 shadow-sm">
                <h2 class="h6 text-uppercase fw-bold mb-2">Medewerkers</h2>
                <p class="mb-0 text-muted">Ervaren instructeurs met aandacht voor jouw tempo en leerstijl.</p>
            </article>
        </div>
        <div class="col-md-6 col-xl-3">
            <article class="h-100 p-4 bg-white border rounded-4 shadow-sm">
                <h2 class="h6 text-uppercase fw-bold mb-2">Doelstelling</h2>
                <p class="mb-0 text-muted">Leerlingen veilig, zelfstandig en met vertrouwen laten afrijden.</p>
            </article>
        </div>
        <div class="col-md-6 col-xl-3">
            <article class="h-100 p-4 bg-white border rounded-4 shadow-sm">
                <h2 class="h6 text-uppercase fw-bold mb-2">Routebeschrijving</h2>
                <p class="mb-0 text-muted">Vestiging: Dorpsstraat 14, Amsterdam. Goed bereikbaar met OV en auto.</p>
            </article>
        </div>
    </section>

    <section class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="h-100 p-4 bg-white border rounded-4 shadow-sm">
                <h2 class="h4 mb-3">Diensten voor leerlingen</h2>
                <p class="text-muted">
                    Bekijk je rooster, ophaaladres, lesdoelen, commentaar, exameninformatie en lessen-tegoed. Je kunt
                    lessen wijzigen of annuleren en je eigen profielgegevens beheren.
                </p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="h-100 p-4 bg-white border rounded-4 shadow-sm">
                <h2 class="h4 mb-3">Diensten voor instructeurs en rijschoolhouder</h2>
                <p class="text-muted mb-0">
                    Instructeurs plannen lessen, plaatsen resultaten en melden zich ziek via formulieren. De
                    rijschoolhouder beheert leerlingen, instructeurs, mededelingen en optioneel het wagenpark.
                </p>
            </div>
        </div>
    </section>

    <section class="rounded-4 p-4 p-lg-5 shadow-sm" style="background: linear-gradient(110deg, #fef08a 0%, #fdba74 45%, #f97316 100%);">
        <div class="row g-3 align-items-center">
            <div class="col-lg-8">
                <h2 class="h3 mb-2">Klaar om te starten met lessen?</h2>
                <p class="mb-0">
                    Schrijf je in voor lessen of lespakketten. Wil je eerst advies? Vraag eenvoudig extra informatie aan.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-dark btn-lg shadow">Start je inschrijving</a>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH C:\project\VierKanteWielen\resources\views/landing.blade.php ENDPATH**/ ?>