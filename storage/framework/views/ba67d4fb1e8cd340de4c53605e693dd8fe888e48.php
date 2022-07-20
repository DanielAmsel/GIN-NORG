
<?php $__env->startSection('onDefault'); ?>
<h2>Der Admin hat Ihnen noch keine Rolle zugewiesen</h2>
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat'): ?>
                        <script>window.location = "/sampleList";</script>
                    <?php endif; ?>

                    <div class="accordion accordion-flush container center_div" id="tankTable">
                        <?php $__currentLoopData = $storageTanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storagetank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $fill = round(1/600 * $samples->where('pos_tank_nr', $storagetank->tank_number)->count('pos_tank_nr') * 100);
                            ?>
                            <div class="accordion-item ">
                                <h2 class="accordion-header" id="tank<?php echo e($storagetank->tank_number); ?>">
                                    <div class="progress">
                                        <?php switch($fill):
                                            case ($fill <= 50): ?>
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($fill); ?>%;" aria-valuenow="<?php echo e($fill); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e($fill); ?>%</div>
                                                <?php break; ?>
                                            <?php case ($fill > 50 && $fill <= 85): ?>
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($fill); ?>%;" aria-valuenow="<?php echo e($fill); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e($fill); ?>%</div>
                                                <?php break; ?>
                                            <?php case ($fill > 85): ?>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo e($fill); ?>%;" aria-valuenow="<?php echo e($fill); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e($fill); ?>%</div>
                                            <?php break; ?>

                                        <?php endswitch; ?>

                                    </div>
                                    <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTank<?php echo e($storagetank->tank_number); ?>" aria-expanded="false" aria-controls="collapseTank<?php echo e($storagetank->tank_number); ?>">

                                        <?php if( $samples->where('pos_tank_nr', $storagetank->tank_number)->count('pos_insert') == 10): ?>
                                            <div class = "bg-danger p-2 badge bg-primary text-wrap"> Tank <?php echo e($storagetank->tank_number); ?> </div>
                                        <?php else: ?>
                                            <div class = "bg-success p-2 badge bg-primary text-wrap"> Tank <?php echo e($storagetank->tank_number); ?> </div>
                                        <?php endif; ?>

                                    </button>

                                </h2>
                                <div id="collapseTank<?php echo e($storagetank->tank_number); ?>" class="accordion-collapse collapse" aria-labelledby="tank<?php echo e($storagetank->tank_number); ?>" data-bs-parent="#tankTable">
                                    <div class="accordion-body ">

                                        <!-- Container Logik -->
                                        <div class="accordion accordion-flush" id="containerTable<?php echo e($storagetank->tank_number); ?>">
                                            <?php for($insert=1; $insert <= $insertValue ; $insert++): ?>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="container<?php echo e($insert); ?>">
                                                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapsecontainer<?php echo e($storagetank->tank_number); ?><?php echo e($insert); ?>" aria-expanded="true" aria-controls="collapsecontainer<?php echo e($insert); ?>">

                                                            <?php if( $samples->where('pos_tank_nr', $storagetank->tank_number)->where('pos_insert', $insert)->count('pos_tube') == 12): ?>
                                                                <div class = "bg-danger p-2 badge bg-primary text-wrap"> Container <?php echo e($insert); ?> </div>
                                                            <?php else: ?>
                                                                <div class = "bg-success p-2 badge bg-primary text-wrap"> Container <?php echo e($insert); ?> </div>
                                                            <?php endif; ?>

                                                        </button>
                                                    </h2>
                                                    <div id="collapsecontainer<?php echo e($storagetank->tank_number); ?><?php echo e($insert); ?>" class="accordion-collapse collapse toggle" aria-labelledby="container<?php echo e($insert); ?>" data-bs-parent="#containerTable<?php echo e($storagetank->tank_number); ?>">
                                                        <div class="accordion-body">
                                                            <!-- Tube Logik -->

                                                            <div class="accordion accordion-flush" id="insertTable<?php echo e($storagetank->tank_number); ?><?php echo e($insert); ?>">
                                                                <?php for($tubes=1; $tubes <= $tubesValue ; $tubes++): ?>


                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="insert<?php echo e($tubes); ?>">
                                                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseinsert<?php echo e($storagetank->tank_number); ?><?php echo e($insert); ?><?php echo e($tubes); ?>" aria-expanded="true" aria-controls="collapse<?php echo e($tubes); ?>">
                                                                                <?php if( $samples->where('pos_tank_nr', $storagetank->tank_number)->where('pos_insert', $insert)->where('pos_tube', $tubes)->count('pos_smpl') == 5): ?>
                                                                                    <div class = "bg-danger p-2 badge bg-primary text-wrap"> Einsatz <?php echo e($tubes); ?> </div>
                                                                                <?php else: ?>
                                                                                    <div class = "bg-success p-2 badge bg-primary text-wrap"> Einsatz <?php echo e($tubes); ?> </div>
                                                                                <?php endif; ?>
                                                                            </button>
                                                                        </h2>
                                                                      <div id="collapseinsert<?php echo e($storagetank->tank_number); ?><?php echo e($insert); ?><?php echo e($tubes); ?>" class="accordion-collapse collapse" aria-labelledby="insert<?php echo e($tubes); ?>" data-bs-parent="#insertTable<?php echo e($storagetank->tank_number); ?><?php echo e($insert); ?>">
                                                                        <div class="accordion-body">
                                                                                                                              <!-- Sample Logik-->
                                                                                    <?php for($sample=1; $sample <= $sampleValue ; $sample++): ?>
                                                                                        <?php
                                                                                            $selecetedSample = $samples->where('pos_tank_nr', $storagetank->tank_number)->where('pos_insert', $insert)->where('pos_tube', $tubes)->where('pos_smpl', $sample);
                                                                                        ?>
                                                                                        <div class="btn-group">

                                                                                            <?php if( $selecetedSample->value('pos_smpl') == $sample): ?>
                                                                                                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Probe <?php echo e($sample); ?> </button>
                                                                                                <ul class="dropdown-menu">
                                                                                                        <li><a class="dropdown-item" ><?php echo e($selecetedSample->value('B_number')); ?>             </a></li>
                                                                                                        <li><a class="dropdown-item" ><?php echo e($selecetedSample->value('responsible_person')); ?>   </a></li>
                                                                                                        <li><a class="dropdown-item" ><?php echo e($selecetedSample->value('type_of_material')); ?>     </a></li>
                                                                                                        <li><a class="dropdown-item" ><?php echo e($selecetedSample->value('storage_date')); ?>         </a></li>
                                                                                                        <li><hr class="dropdown-divider">                                                       </li>
                                                                                                        <li>
                                                                                                            <form method="POST" action="<?php echo e(Url('/shipped')); ?>" >
                                                                                                                <?php echo csrf_field(); ?>
                                                                                                                    <li >
                                                                                                                        <button type="submit" class="dropdown-item"> Probe verschicken
                                                                                                                            <input type="text" value="<?php echo e($selecetedSample->value('id')); ?>"name="sample_id" hidden>
                                                                                                                        </button>
                                                                                                                    </li>
                                                                                                            </form>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                            <form method="POST" action="<?php echo e(Url('/transfer')); ?>" >
                                                                                                                <?php echo csrf_field(); ?>
                                                                                                                    <li >
                                                                                                                        <button type="submit" class="dropdown-item"> Probe entfernen
                                                                                                                            <input type="text" value="<?php echo e($selecetedSample->value('id')); ?>"name="sample_id" hidden>
                                                                                                                        </button>
                                                                                                                    </li>
                                                                                                            </form>
                                                                                                        </li>
                                                                                                </ul>
                                                                                            <?php else: ?>
                                                                                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Position <?php echo e($sample); ?> </button>
                                                                                                <ul class="dropdown-menu">
                                                                                                    <form method="POST" action="<?php echo e(Url('newSamples/pos')); ?>" >
                                                                                                        <?php echo csrf_field(); ?>
                                                                                                            <li >
                                                                                                                <button type="submit" class="dropdown-item"> Probe einlagern
                                                                                                                    <input type="text" value="<?php echo e($storagetank->tank_number); ?>"     name="tank_pos"     hidden>
                                                                                                                    <input type="text" value="<?php echo e($insert); ?>" name="con_pos"      hidden>
                                                                                                                    <input type="text" value="<?php echo e($tubes); ?>"   name="insert_pos"   hidden>
                                                                                                                    <input type="text" value="<?php echo e($sample); ?>"    name="sample_pos"   hidden>
                                                                                                                </button>
                                                                                                            </li>
                                                                                                    </form>
                                                                                                    <li>
                                                                                                        <form method="POST" action="<?php echo e(Url('/restore')); ?>" >
                                                                                                            <?php echo csrf_field(); ?>
                                                                                                                <li >
                                                                                                                    <button type="submit" class="dropdown-item"> Erneut einlagern
                                                                                                                        <input type="text" value="<?php echo e($storagetank->tank_number); ?>"     name="tank_pos"     hidden>
                                                                                                                        <input type="text" value="<?php echo e($insert); ?>" name="con_pos"      hidden>
                                                                                                                        <input type="text" value="<?php echo e($tubes); ?>"   name="insert_pos"   hidden>
                                                                                                                        <input type="text" value="<?php echo e($sample); ?>"    name="sample_pos"   hidden>
                                                                                                                    </button>
                                                                                                                </li>
                                                                                                        </form>
                                                                                                    </li>
                                                                                                </ul>




                                                                                            <?php endif; ?>


                                                                                        </div>

                                                                                    <?php endfor; ?>

                                                                                </div>
                                                                        </div>
                                                                      </div>
                                                                <?php endfor; ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/home.blade.php ENDPATH**/ ?>