<?php $__env->startSection('content'); ?>

<?php if($le_menbre->etat == 'attente'): ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center">Confirmer votre numero de telephone</h4>
                    <p class="card-description">
                        Nous allons vous envoyer un code de confirmation par sms, utiliser un numero valide,
                        <span class="text-warning">ajouter le prefixe sans le (+) avant le numero</span>.
                        <br/>Exemple : 2250505050505 ou 33123456789
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Utiliser ce numero</label>
                            <div class="row">
                                <div class="col-9">
                                    <input required type="tel" class="form-control" name="telephone"
                                           value="<?php echo e($le_menbre->telephone); ?>" minlength="10" placeholder="2250101010101">
                                </div>
                            </div>
                        </div>
                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary mr-2">Envoyer le message</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php elseif($le_menbre->devise == null): ?>

    <div class="row">
    <div class="offset-md-3 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php echo Session::get('notification',''); ?>


                <h4 class="card-title text-center">Choisissez votre monaie</h4>
                <p class="card-description">
                    Cette monaie sera associee a vos tontines,waricrowds et toutes vos transactions,
                    <span class="text-warning">Vous ne pourrez pas la modifiée plus tard</span>.
                </p>
                <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_choisir_devise')); ?>">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Utiliser cette monaie</label>
                        <div class="row">
                            <div class="col-9">
                                <select class="form-control" name="id_devise" required>
                                    <option>(Choisissez)</option>
                                    <?php $__currentLoopData = $les_devises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_devise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item_devise->id); ?>"><?php echo e($item_devise->code); ?> (<?php echo e($item_devise->monaie); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-center">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary mr-2">ENREGISTRER MON CHOIX</button>
                    </h3>
                </form>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <?php
        header('Location:/');
    ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/profil/confirmation_de_compte.blade.php ENDPATH**/ ?>