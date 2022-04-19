<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $have_transactions = $le_crowd->transactions;
    if(sizeof($have_transactions)>0){
      $have_transactions =true;
    }else{
        $have_transactions = false;
    }
?>



<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.details_waricrowd',[$le_crowd->id])); ?>">RETOUR</a>
                </div>
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>

                    <h4 class="card-title text-center">Editer un waricrowd</h4>
                    <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_editer_crowd',[$le_crowd->id])); ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Categories</label>
                            <select required class="form-control" name="id_categorie_waricrowd">
                                <option value="<?php echo e($le_crowd->id_categorie); ?>"><?php echo e($le_crowd->categorie->titre); ?></option>
                                <?php $__currentLoopData = $liste_categorie_waricrowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item_categorie['id']); ?>"><?php echo e($item_categorie['titre']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group" style="display: <?php echo e($have_transactions ? 'none' : ''); ?>">
                            <label for="exampleInputUsername1">Titre *</label>
                            <input required type="text" class="form-control" name="titre" value="<?php echo e($le_crowd->titre); ?>" placeholder="Tontine Elegante">
                        </div>


                        <div class="form-group" style="display: <?php echo e($have_transactions ? 'none' : ''); ?>">
                            <label for="exampleInputUsername1">Objectif de financement (Montant)  en <b><?php echo e($la_session['devise']); ?></b> *</label>
                            <input required type="number" class="form-control" name="montant_objectif"
                                   value="<?php echo e($le_crowd->montant_objectif); ?>" placeholder="Tontine Elegante"
                                    <?php echo e($have_transactions ? 'readonly' : ''); ?>

                            >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Pitch Video</label>
                            <input type="text" class="form-control" name="lien_pitch_video" value="<?php echo e($le_crowd->lien_pitch_video); ?>" placeholder="Tontine Elegante">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description courte *</label>
                            <textarea class="form-control" name="description_courte" maxlength="220" rows="5"><?php echo e($le_crowd->description_courte); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description complete *</label>
                            <textarea class="form-control" name="description_complete"  rows="20" cols="5"><?php echo e($le_crowd->description_complete); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Selection pour changer l'image d'illustration</label>
                            <br/>
                            <?php if($le_crowd['image_illustration']!=null): ?>
                                <img src="<?php echo e(url($le_crowd->image_illustration)); ?>" style="max-width: 200px" />
                            <?php endif; ?>
                            <br/>
                            <input  type="file" class="form-control" name="image_illustration">
                        </div>

                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary mr-2">Soumettre mon projet</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <hr/>
                <h4>Comment ça marche</h4>
            <hr/>
            <iframe width="100%" src="https://www.youtube.com/embed/DzH5aRoMYLw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/waricrowd/editer.blade.php ENDPATH**/ ?>