<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? 'Rijschool Vierkante Wielen'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="<?php echo e(auth()->check() ? route('home') : route('landing')); ?>">
                Rijschool Vierkante Wielen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu openen">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('lesrijpakketten.index')); ?>">Lespakketten Overzicht</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('instructeurs.index')); ?>">Instructeurs</a></li>
                        <?php if(auth()->user()->role === 'administrator'): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('accounts.index')); ?>">Accounts</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('landing')); ?>">Home</a></li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <?php if(auth()->guard()->check()): ?>
                        <span class="badge text-bg-light border"><?php echo e(auth()->user()->name); ?> - <?php echo e(ucfirst(auth()->user()->role)); ?></span>
                        <form method="post" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Uitloggen</button>
                        </form>
                    <?php else: ?>
                        <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('login')); ?>">Inloggen</a>
                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('register')); ?>">Registreren</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php echo e($slot); ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH C:\project\VierKanteWielen\resources\views/components/layout.blade.php ENDPATH**/ ?>