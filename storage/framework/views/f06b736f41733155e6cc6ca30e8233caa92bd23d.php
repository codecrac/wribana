<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
?>





<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class=" col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="card-title text-center">TRANSFERT WARIBANK</h4>
                    <hr/>
                </div>
                <div class="card-body text-left text-uppercase">
                    <?php echo Session::get('notification',''); ?>

                    <hr/>
                        <h5>TELEPHONE : <?php echo e($numero_complet); ?></h5>
                    <hr/>
                    <hr/>
                        <h5>DESTINATAIRE : <?php echo e($le_destinataire->nom_complet); ?></h5>
                    <hr/>
                    <hr/>
                        <h5>MONTANT (monaie expediteur) : <?php echo e($montant_en_monaie_expediteur); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?> </h5>
                    <hr/>
                    <hr/>
                        <h5>MONTANT EQUIVALENT (monaie destinataire) : <?php echo e($le_montant_equivalent_pour_destinataire); ?> <?php echo e($le_destinataire->devise_choisie->monaie); ?></h5>
                    <hr/>
                        

                    <form method="post" action="<?php echo e(route('espace_menbre.effectuer_tranfert_waribank')); ?>">
                        <input type="hidden" value="<?php echo e($numero_complet); ?>" name="numero_destinataire">
                        <input type="hidden" value="<?php echo e($le_destinataire->id); ?>" name="id_destinataire">
                        <input type="hidden" value="<?php echo e($montant_en_monaie_expediteur); ?>" name="montant_expediteur">
                        <input type="hidden" value="<?php echo e($le_montant_equivalent_pour_destinataire); ?>" name="montant_destinataire">

                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary" style="">Confirmer</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/profil/confimer_transfert_waribank.blade.php ENDPATH**/ ?>