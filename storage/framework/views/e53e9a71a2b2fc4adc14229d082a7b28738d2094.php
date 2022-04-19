<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center">Supprimer le waricrowd</h4>
                    <p class="card-description">
                        <span class="text-danger">Cette action est irreversible, Voulez vous confirmez la suppression ?</span>

                    </p>
                    <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_supprimer_waricrowd',[$le_crowd->id])); ?>">
                            <h3 class="text-center">
                                <?php echo method_field('delete'); ?>
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger mr-2">Supprimer le waricrowd</button>
                            </h3>
                    </form>
                    <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.details_waricrowd',[$le_crowd->id])); ?>">RETOUR</a>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/waricrowd/supprimer_waricrowd.blade.php ENDPATH**/ ?>