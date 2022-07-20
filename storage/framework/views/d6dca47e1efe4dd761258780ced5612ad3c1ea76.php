

<?php $__env->startSection('content'); ?>

    <?php if(session('status')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>

    <?php if(Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat'): ?>
        <script>window.location = "/sentSamples";</script>
    <?php endif; ?>

    <div>
        <table class="table table-hover text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tank Nummer</th>
                <th scope="col">Einsatz</th>
                <th scope="col">Röhrchen</th>
                <th scope="col">Probenplatz</th>
                <th scope="col">B-Nummer</th>
                <th scope="col">Material</th>
                <th scope="col">Verantwortlicher</th>
                <th scope="col">Einlagerungsdatum</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $samples; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sampleOutput): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                    <th scope="row"><?php echo e($sampleOutput->pos_tank_nr); ?></th>
                    <th scope="row"><?php echo e($sampleOutput->pos_insert); ?></th>
                    <th scope="row"><?php echo e($sampleOutput->pos_tube); ?></th>
                    <th scope="row"><?php echo e($sampleOutput->pos_smpl); ?></th>
                    <td><?php echo e($sampleOutput->B_number); ?></td>
                    <td><?php echo e($sampleOutput->type_of_material); ?></td>
                    <td><?php echo e($sampleOutput->responsible_person); ?></td>
                    <td><?php echo e($sampleOutput->storage_date); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(Url('/shipped')); ?>" >
                            <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-secondary"> Probe verschicken
                                    <input type="text" value="<?php echo e($sampleOutput->id); ?>"name="sample_id" hidden>
                                </button>
                        </form>
                    </td>    
                    <td>
                        <form method="POST" action="<?php echo e(Url('/transferSampleDelete')); ?>" >
                            <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-secondary"> Probe entfernen
                                    <input type="text" value="<?php echo e($sampleOutput->id); ?>"name="sample_id" hidden>
                                </button>
                        </form>
                    </td>      
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Sebastian\Documents\GitHub\norg\resources\views/sampleList.blade.php ENDPATH**/ ?>