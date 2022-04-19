<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
?>



<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <a href="<?php echo e(route('espace_menbre.details_tontine',[$la_tontine['id']])); ?>">RETOUR</a>
                    <h4 class="card-title text-center">Editer la tontine</h4>
                    <p class="card-description text-center badge-info text-white">
                        Vous ne pourrez plus changer les termes apres le debut des paiements
                    </p>
                    <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_editer_tontine',[$la_tontine['id']])); ?>">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre</label>
                            <input
                                required type="text" class="form-control" name="titre" value="<?php echo e($la_tontine['titre']); ?>"
                                placeholder="Tontine Elegante"
                                <?php echo e(sizeof($la_tontine->transactions) >0 ? "readonly" :""); ?>

                            >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de particpant</label>
                            <input
                                required type="number" onkeypress="return onlyNumberKey(event)"
                                class="form-control" min="2" name="nombre_participant" value="<?php echo e($la_tontine['nombre_participant']); ?>"
                                placeholder="14"
                                <?php echo e(sizeof($la_tontine->transactions) >0 ? "readonly" :""); ?>

                            >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Montant en <b><?php echo e($la_session['devise']); ?></b> (Minimum de <?php echo e(($la_session['code_devise'] == 'XOF') ? '1000' : '5'); ?> <?php echo e($la_session['devise']); ?>)  </label>
                            <input required type="number" onkeypress="return onlyNumberKey(event)"
                                   class="form-control" name="montant" value="<?php echo e($la_tontine['montant']); ?>" placeholder="17500" min="<?php echo e(($la_session['code_devise'] == 'XOF') ? '1000' : '5'); ?>"
                                   <?php echo e(sizeof($la_tontine->transactions) >0 ? "readonly" :""); ?>

                            >

                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword1">Frequence de depot (en jours)</label>
                            <input required min="1" type="number" onkeypress="return onlyNumberKey(event)" class="form-control" name="frequence_depot_en_jours"
                                   value="<?php echo e($la_tontine['frequence_depot_en_jours']); ?>"
                                   placeholder="7"
                                    <?php echo e(sizeof($la_tontine->transactions) >0 ? "readonly" :""); ?>

                            >
                        </div>
                        <h3 class="text-center">

                            <?php if(sizeof($la_tontine->transactions) <1): ?>
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('put'); ?>
                                <button type="submit" class="btn btn-danger mr-2">Modifier la tontine</button>
                            <?php endif; ?>
                        </h3>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/tontine/editer_tontine.blade.php ENDPATH**/ ?>