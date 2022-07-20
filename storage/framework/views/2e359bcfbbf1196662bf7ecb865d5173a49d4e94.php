

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
            <th scope="col">Tank Nummer</th>
            <th scope="col">Model</th>
            <th scope="col">Hinzugefügt am</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $activeTanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activeTank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($loop->iteration); ?></th>
                <th scope="row"><?php echo e($activeTank->tank_number); ?></th>
                <th scope="row"><?php echo e($activeTank->modelname); ?></th>
                <th scope="row"><?php echo e($activeTank->created_at); ?></th>
                <th scope="row"><?php echo e($activeTank->id); ?></th>
                    <form method="POST" action="<?php echo e(Url('/tankDestroy')); ?>" >
                        <?php echo csrf_field(); ?>
                        <?php $__currentLoopData = $allSamplesinTank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sample): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $group = $sample->where('pos_tank_nr', $activeTank->tank_number);
                            ?>
                         <?php if($group->count() != 0): ?>
                                <th>
                                    
                                    <button type="submit" class="btn btn-outline-secondary" disabled> Tank Entfernen

                                    </button>
                                </th>
                                <th >
                                    <button type="button" class="btn btn-danger" disabled>Es sind noch Porben im Tank</button>
                                </th>
                                <?php break; ?>
                            <?php else: ?>

                                <th>
                                    <button type="submit" class="btn btn-outline-secondary"> Tank Entfernen
                                        <input value="<?php echo e($activeTank->id); ?>"name="tank_id" hidden>
                                    </button>
                                </th>
                                <th></th>

                                <?php break; ?>

                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </form>
                </td>      
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div id="liveAlertPlaceholder"></div>
    <form action="<?php echo e(url('/addTank')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="col">
            <div class="col">
                <label class="form-label">Tank Nummer</label>
                <input required type="text" class="form-control" name="tank_number">
                <?php $__errorArgs = ['tank_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <br></br>
            </div>
            <div class="col">
                <label for="MaterialSelect" class="form-label">Model</label>
                <select required id="MaterialSelect" class="form-select" name="modelname">
                    <option disabled selected value> -- Bitte Modeltype wählen durch anklicken -- </option>
                    <?php $__currentLoopData = $tankModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option><?php echo e($tank->modelname); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['modelname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <br></br>
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
                        Daten überprüft?
                    </label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Tank hinzufügen</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/manageTanks.blade.php ENDPATH**/ ?>