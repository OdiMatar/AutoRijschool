<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'Instructeurs in dienst']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Instructeurs in dienst']); ?>
    <section class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Instructeurs in dienst</h1>
            <p class="text-muted mb-0">Aantal instructeurs: [<?php echo e(count($instructeurs)); ?>]</p>
        </div>
    </section>

    <div class="table-responsive bg-white border rounded-3">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Mobiel</th>
                    <th>Datum in dienst</th>
                    <th>Aantal sterren</th>
                    <th>Voertuigen</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $instructeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($instructeur->VolledigeNaam); ?></td>
                        <td><?php echo e($instructeur->Mobiel); ?></td>
                        <td><?php echo e(\Illuminate\Support\Carbon::parse($instructeur->DatumInDienst)->format('d-m-Y')); ?></td>
                        <td class="fw-bold text-warning-emphasis"><?php echo e($instructeur->AantalSterren); ?></td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm" href="<?php echo e(route('instructeurs.voertuigen.index', $instructeur->Id)); ?>" title="Voertuigen bekijken" aria-label="Voertuigen bekijken">
                                🛻
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
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
<?php /**PATH C:\project\VierKanteWielen\resources\views/instructeurs/index.blade.php ENDPATH**/ ?>