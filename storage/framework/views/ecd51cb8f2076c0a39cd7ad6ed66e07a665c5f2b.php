<?php $__env->startSection('style_completmentaire'); ?>
    <style>
        .marquer_presence{
            font-size: 18px;
            font-weight:bold;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

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
        }elseif($le_crowd->etat=='terminer'){
            $couleur = "dark";
            $etat = "Terminé";
        }elseif($le_crowd->etat=='annuler'){
            $couleur = "dark";
            $etat = "Annulé";
        }
    ?>

    <?php echo Session::get('notification',''); ?>

    
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <hr/>
                    <h4 class="card-title text-center">
                        Waricrowd : <?php echo e($le_crowd->titre); ?>

                    </h4>
                    <hr/>
                    <ul>
                        <li>Statut : <mark class="badge badge-<?php echo e($couleur); ?>"><?php echo e($etat); ?></mark> </li>
                        <?php if($le_crowd->motif_intervention_admin !=null): ?> <li><b>Motif Intervention d'administrateur</b> : <mark class="badge badge-info"><?php echo e($le_crowd->motif_intervention_admin); ?></mark> </li> <?php endif; ?>
                        <li>Crée par : <?php echo e($le_crowd->createur->nom_complet); ?></li>
                        <li>Montant objectif : <?php echo e(number_format($le_crowd->montant_objectif,0,',',' ')); ?>  <b><?php echo e($le_crowd->createur->devise_choisie->monaie); ?></b> </li>

                        <?php
                            $pourcentage = round($le_crowd->caisse->montant *100 / $le_crowd->caisse->montant_objectif,2);
                            if($pourcentage <40){
                                $couleur= "danger";
                            }elseif($pourcentage <60){
                                $couleur = "warning";
                            }elseif($pourcentage <100){
                                $couleur = "info";
                            }else{
                                $couleur = "success";
                            }
                        ?>

                        <li>
                            Montant atteind :
                            <span class="badge badge-<?php echo e($couleur); ?>"><?php echo e($pourcentage); ?> %</span> [ <?php echo e(number_format($le_crowd->caisse->montant,0,',',' ')); ?>  <b><?php echo e($le_crowd->createur->devise_choisie->monaie); ?></b>  ]
                        </li>
                        <li> Nombre de soutien : <?php echo e(sizeof($le_crowd->transactions)); ?></li>
                        <li> Creer le  : <?php echo e(date('d/m/Y',strtotime($le_crowd->created_at))); ?></li>
                        
                        <br/>
                        <a href="<?php echo e(route('admin.editer_crowd',[$le_crowd->id])); ?>" class='btn btn-warning' > Editer le crowd</a>

                    </ul>
                    <br/>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center">Validation du Projet</h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="post" action="<?php echo e(route('admin.changer_etat_crowd',[$le_crowd['id']])); ?>">
                        <div class="form-group">
                            <h6 for="exampleInputUsername1">Etat du projet *</h6>
                            <select class="form-control" required name="nouvel_etat">
                                <option selected value="<?php echo e($le_crowd->etat); ?>" ><?php echo e($etat); ?></option>
                                
                                
                                <?php if($le_crowd->etat != 'attente' ): ?> <option value='attente'>En attente</option> <?php endif; ?>
                                <?php if($le_crowd->etat != 'valider' ): ?> <option value='valider'>validé</option> <?php endif; ?>
                                <?php if($le_crowd->etat != 'recaler' ): ?> <option value='recaler' >recalé</option> <?php endif; ?>
                                <?php if($le_crowd->etat != 'annuler' ): ?> <option value="annuler">annulé la collecte</option> <?php endif; ?>
                                <?php if($le_crowd->etat != 'terminer' ): ?> <option value='terminer'>terminé</option> <?php endif; ?>
                            </select>
                            <br/>
                            <h6>Motif</h6>
                            <textarea name="motif_intervention" class="form-control" rows="4"></textarea>
                        </div>
                        <h3 class="text-center">
                            <?php echo method_field('put'); ?>
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning mr-2 text-white">Appliquer les changements</button>
                        </h3>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
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

        <div class="col-md-12 grid-margin stretch-card">
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

    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center">Liste des Transactions</h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                        <td>Nom Complet</td>
                        <td>Montant</td>
                        <td>Date</td>
                        <td>Statut</td>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transactions_du_waricrowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_soutien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item_soutien->souteneur->nom_complet); ?></td>
                                <td><?php echo e(number_format($item_soutien->montant,0,',',' ')); ?> <?php echo e($item_soutien->waricrowd->createur->devise_choisie->monaie); ?></td>
                                <td><?php echo e(date('d/m/Y H:i',strtotime($item_soutien['created_at']))); ?></td>
                                <td class="text-<?php echo e(($item_soutien->statut == 'ACCEPTED')? 'success' : 'danger'); ?>">[ <?php echo e($item_soutien->statut); ?> ]</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/waricrowds/details_waricrowd.blade.php ENDPATH**/ ?>