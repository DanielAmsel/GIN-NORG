

<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>

    <?php if(Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat'): ?>
        <script>window.location = "/sampleList";</script>
    <?php endif; ?>

    <div>
        <table class="table table-hover text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">B-nummer</th>
                <th scope="col">Material Typ</th>
                <th scope="col">Verantwortlicher</th>
                <th scope="col">Einlagerungsdatum</th>
                <th scope="col">Auslagerungsdatum</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $removedSamples; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sampleOutput): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                    <td><?php echo e($sampleOutput->identifier); ?></td>
                    <td><?php echo e($sampleOutput->type_of_material); ?></td>
                    <td><?php echo e($sampleOutput->responsible_person); ?></td>
                    <td><?php echo e($sampleOutput->storage_date); ?></td>
                    <td><?php echo e($sampleOutput->removal_date); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/removedSamples.blade.php ENDPATH**/ ?>