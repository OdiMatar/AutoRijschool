<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'Home']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Home']); ?>
    <div class="container p-0">
        <div class="bg-white border rounded-3 p-4 p-md-5 mb-4">
            <h1 class="h3 mb-3">Welkom bij Rijschool Vierkante Wielen</h1>
            <p class="text-muted mb-4">
                Dit dashboard helpt je om lesrijpakketten en voertuigen overzichtelijk te beheren.
            </p>
            <a class="btn btn-primary" href="<?php echo e(route('lesrijpakketten.index')); ?>">Lesrijpakketten Overzicht</a>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6 card-title">Lesrijpakketten</h2>
                        <p class="card-text text-muted mb-0">Bekijk alle beschikbare lesrijpakketten en hun details.</p>
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
                            <?php if(auth()->user()->canManageVehicles()): ?>
                                Je bent ingelogd als <?php echo e(auth()->user()->role); ?> en mag voertuiggegevens wijzigen.
                            <?php else: ?>
                                Je bent ingelogd als instructeur met kijkrechten.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\project\VierKanteWielen\resources\views/home.blade.php ENDPATH**/ ?>