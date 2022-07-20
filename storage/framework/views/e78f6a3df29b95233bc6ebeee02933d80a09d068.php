

<?php $__env->startSection('content'); ?>

    <?php if(session('status')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>
    <div >
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">B-nummer</th>
                    <th scope="col">Material Typ</th>
                    <th scope="col">Versand durch</th>
                    <th scope="col">Versand Datum</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $shippedsample; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hugo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th scope="row"><?php echo e($loop->iteration); ?></th>
                        <td><?php echo e($hugo->identifier); ?></td>
                        <td><?php echo e($hugo->type_of_material); ?></td>
                        <td><?php echo e($hugo->responsible_person); ?></td>
                        <td><?php echo e($hugo->shipping_date); ?></td>
                        <td>
                            <form method="POST" action="<?php echo e(Url('/restore/confirm')); ?>" >
                                <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-secondary"> Probe einlagern
                                <input type="text" value="<?php echo e($hugo->identifier); ?>"     name="bnummer"       hidden>
                                <input type="text" value="<?php echo e($hugo->type_of_material); ?>" name="material"    hidden>
                                <input type="text" value="<?php echo e($hugo->responsible_person); ?>"   name="name"    hidden>
                                <input type="text" value="<?php echo e($hugo->id); ?>"   name="id"    hidden>
                            </button>
                                <input type="text" value="<?php echo e($tank_pos); ?>" name="tank_pos" hidden>
                                <input type="text" value="<?php echo e($con_pos); ?>" name="con_pos" hidden>
                                <input type="text" value="<?php echo e($insert_pos); ?>" name="insert_pos" hidden>
                                <input type="text" value="<?php echo e($sample_pos); ?>" name="sample_pos" hidden>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Sebastian\Documents\GitHub\norg\resources\views/restoreSample.blade.php ENDPATH**/ ?>