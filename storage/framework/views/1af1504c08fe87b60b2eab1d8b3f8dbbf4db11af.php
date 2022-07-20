

<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>
    <form action="<?php echo e(url('/newSamples/pos/confirm')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="col center">
            <table class="table table-striped">
                <input type="text" value="<?php echo e($tank_pos); ?>" name="tank_pos" hidden>
                <input type="text" value="<?php echo e($con_pos); ?>" name="con_pos" hidden>
                <input type="text" value="<?php echo e($insert_pos); ?>" name="insert_pos" hidden>
                <input type="text" value="<?php echo e($sample_pos); ?>" name="sample_pos" hidden>
                <thead>
                <tr>
                    <th scope="col">Tank</th>
                    <th scope="col">Einsatz</th>
                    <th scope="col">Röhrchen</th>
                    <th scope="col">Probenplatz</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo e($tank_pos); ?></td>
                    <td><?php echo e($con_pos); ?></td>
                    <td><?php echo e($insert_pos); ?></td>
                    <td><?php echo e($sample_pos); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col">
            <label for="email" class="form-label">Eingelagert von</label>
            <input type="email" class="form-control" id="email" value="<?php echo e(Auth::user()->email); ?>" readonly>
        </div>
        <div class="col">
            <label for="bnummer" class="form-label"  >B-Nummer</label>
            <input required type="text" class="form-control" name="bnummer" autofocus="autofocus">
        </div>
        <div class="col">
            <label for="MaterialSelect" class="form-label">Material-Typ</label>
            <select required id="MaterialSelect" class="form-select" name="materialtyp">
                <option disabled selected value> -- Bitte Materialtyp wählen durch anklicken -- </option>
                <?php $__currentLoopData = $material; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option><?php echo e($material->type_of_material); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col">
            Datum
        </div>
        <div class="col">
            <p><b><script>document.write(new Date().toLocaleDateString())</script></b></p>
        </div>


        <div class="col">
            <div class="form-check">
                <input required class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    Daten Überprüft ?
                </label>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Einlagern</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Sebastian\Documents\GitHub\norg\resources\views/newSamples.blade.php ENDPATH**/ ?>