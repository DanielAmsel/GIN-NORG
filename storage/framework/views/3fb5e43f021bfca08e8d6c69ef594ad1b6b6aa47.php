

<?php if(Auth::user()->role == 'Administrator'): ?>


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
                    <th scope="col">Name</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Rolle</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th scope="row"><?php echo e($loop->iteration); ?></th>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <form action="<?php echo e(url('/manageUser/updateRights')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <select id="Roleselect" class="form-select" name="role">
                                    <option disabled selected value> <?php echo e($user->role); ?> </option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option><?php echo e($role->role_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <td>
                                    <button type="submit" class="btn btn-outline-secondary"> 
                                        <input type="text" value="<?php echo e($user->id); ?>" name="id" hidden> Rechte aktualisieren
                                    </button>
                                </td>
                            </form>
                        </td>

                        <td>
                            <form action="<?php echo e(url('/manageUser/delete')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger"> 
                                    <input type="text" value="<?php echo e($user->id); ?>" name="id" hidden> Nutzer entfernen
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php $__env->stopSection(); ?>

<?php else: ?>

<?php endif; ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Sebastian\Documents\GitHub\norg\resources\views/manageUser.blade.php ENDPATH**/ ?>