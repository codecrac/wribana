<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $statut_transaction = null;
    if(isset($_GET['statut_transaction'])){
        $statut_transaction = $_GET['statut_transaction'];
    }

?>



<?php $__env->startSection('style_completmentaire'); ?>
    <style>
        .marquer_presence{
            font-size: 18px;
            font-weight:bold;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class='card-header'>
                    <?php echo Session::get('notification',''); ?>

                    <?php if($statut_transaction !=null): ?>
                        <?php if($statut_transaction == 'ACCEPTED'): ?>
                            <div class='alert alert-success text-center'>Votre paiement a bien été effectué</div>
                        <?php else: ?>
                            <div class='alert alert-danger text-center'>Echec du paiement</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <hr/>
                        <h4 class="card-title text-center">
                            Waricrowd : <?php echo e($le_crowd->titre); ?>

                            <br/><br/>
                            <br/>
                            <!--<?php if($le_crowd->etat == 'attente' ): ?>
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <?php if($le_crowd->createur->id == $la_session['id']): ?>
                                            <a href="<?php echo e(route('espace_menbre.editer_crowd',[$le_crowd['id']])); ?>" class="btn btn-success">Editer le waricrowd</a>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($le_crowd->createur->id == $la_session['id']): ?>
                                             <?php if(sizeof($le_crowd->transactions)==0 ): ?>
                                                <div class="col-md-6 text-center">
                                                    <a href="<?php echo e(route('espace_menbre.supprimer_waricrowd',[$le_crowd['id']])); ?>"
                                                       class="btn btn-info">Supprimer</a>
                                                </div>
                                            <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>-->
                        </h4>
                    <hr/>
                    <ul>
                        
                        <?php
                            if($le_crowd->etat=='valider'){
                                $couleur= "success";
                                $etat = "Validé";
                            }elseif($le_crowd->etat=='recaler'){
                                $couleur = "danger";
                                $etat = "Recalé";
                            }elseif($le_crowd->etat=='attente'){
                                $couleur = "dark";
                                $etat = "En attente";
                            }else{
                                    $couleur= "success";
                                    $etat = "terminé";
                                }
                        ?>
                        <li>Categorie : <?php echo e($le_crowd->categorie->titre); ?> </li>
                        <li>Statut : <mark class="badge badge-<?php echo e($couleur); ?>"><?php echo e($etat); ?></mark> </li>
                        <li>Crée par : <?php echo e($le_crowd->createur->nom_complet); ?></li>
                        <li>Montant objectif : <?php echo e(number_format($le_crowd->montant_objectif,0,',',' ')); ?> <b><?php echo e($le_crowd->createur->devise_choisie->monaie); ?></b> </li>

                        <?php
                            $pourcentage = round($le_crowd->caisse->montant *100 / $le_crowd->caisse->montant_objectif,2);
                        ?>

                        <li> Montant atteint : <b><?php echo e($pourcentage); ?> %</b> [ <?php echo e(number_format($le_crowd->caisse->montant,0,',',' ')); ?> <?php echo e($le_crowd->createur->devise_choisie->symbole); ?> ]</li>
                        <li> Nombre de soutien : <?php echo e(sizeof($le_crowd->transactions)); ?></li>
                        <li> Creer le  : <?php echo e(date('d/m/Y',strtotime($le_crowd->created_at))); ?></li>

                    </ul>
                    <br/>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="text-center">Pitch Video</h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <?php if($le_crowd->lien_pitch_video !=null): ?>
                        <iframe width="100%" src="<?php echo e($le_crowd->lien_pitch_video); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php else: ?>
                        <h3 class="text-center">
                            <img src="<?php echo e(url($le_crowd->image_illustration)); ?>" style="max-width: 200px" />
                        </h3>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <hr/>
                        <h5>Description courte</h5>
                    <hr/>
                    <p class="text-center">
                        <?php echo e($le_crowd->description_courte); ?>

                    </p>
                </div>
            </div>
    </div>
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h5 class="text-center">Description complete</h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <p><?php echo $le_crowd->description_complete; ?></p>
                </div>
            </div>
        </div>

        <?php if($le_crowd->etat=='valider'): ?>
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                           <h5 class="text-center">Soutenir le projet</h5>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">Entrer le montant </h5>
                        <p class="text-center">
                            (en <b><?php echo e($le_crowd->createur->devise_choisie->monaie); ?></b>) 
                        </p>
                        
                        <form method="post" action="<?php echo e(route('espace_menbre.confirmation_soutien_waricrowd')); ?>">
                            <div class="form-group">

                                <input class="form-control" type="hidden" name="id_crowd" value='<?php echo e($le_crowd->id); ?>' required/>
                                <input class="form-control" type="number" onkeypress="return onlyNumberKey(event)" name="montant_soutien" placeholder="150000" min="1" required/>
                                <br/>
                                <h3 class="text-center">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary"> Soutenir </button>
                                </h3>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        
        <?php // dd($le_crowd->id_menbre,$la_session['id']); ?>
        <?php if($le_crowd->id_menbre == $la_session['id'] ): ?>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center"> Historique de Transactions </h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <td>Date</td>
                            <td>Waricrowd</td>
                            <td>Nom Complet</td>
                            <td>Montant</td>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $historique_transactions_waricrowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_soutien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(date('d/m/Y H:m',strtotime($item_soutien['created_at']))); ?></td>
                                <td><a href="<?php echo e(route('admin.details_waricrowd',[$item_soutien->waricrowd->id])); ?>"> <?php echo e($item_soutien->waricrowd->titre); ?> </a></td>
                                <td><?php echo e($item_soutien->souteneur->nom_complet); ?></td>
                                <td><?php echo e(number_format($item_soutien->montant,0,',',' ')); ?> <?php echo e($item_soutien->waricrowd->createur->devise_choisie->monaie); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center"> Mes Transactions </h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <td>Date</td>
                        <td>Montant</td>
                        <td>Statut</td>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $mes_transactions_pour_ce_crowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_soutien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            
                           
                             <?php
                                if($item_soutien->statut=='ACCEPTED'){
                                    $couleur= "success";
                                    $etat = "REUSSI";
                                }elseif($item_soutien->statut=='REFUSED'){
                                    $couleur = "danger";
                                    $etat = "REFUSER";
                                }elseif($item_soutien->statut=='PENDING'){
                                    $couleur = "dark";
                                    $etat = "EN ATTENTE";
                                }
                            ?>
                            <tr>
                                <td><?php echo e(date('d/m/Y H:i',strtotime($item_soutien['created_at']))); ?></td>
                                <td><?php echo e(number_format($item_soutien->montant,0,',',' ')); ?> <?php echo e($item_soutien->waricrowd->createur->devise_choisie->monaie); ?></td>
                                <td> <?php echo e($etat); ?> </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/waricrowd/details.blade.php ENDPATH**/ ?>