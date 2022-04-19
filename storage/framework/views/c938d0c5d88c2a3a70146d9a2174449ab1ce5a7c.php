<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center">Entrer le Code </h4>
                    <p class="card-description">
                        Nous vous avons envoyer un code de confirmation par sms au <b><?php echo e($le_menbre->telephone); ?></b>, patientez 30 secondes.
                        <br/>
                        <a href="<?php echo e(route('espace_menbre.confirmer_compte_menbre')); ?>">je ne l'ai pas reçu</a>
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Entrer le code</label>
                            <div class="col-12">
                                <input required type="tel" class="form-control" name="code" placeholder="7368">
                            </div>
                        </div>
                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary mr-2">Valider</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/profil/entrer_code_confirmation.blade.php ENDPATH**/ ?>