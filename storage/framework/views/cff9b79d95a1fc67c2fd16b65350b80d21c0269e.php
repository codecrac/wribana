<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $en_retard=false;
    if($la_tontine->caisse !=null){
        $prochaine_date_encaissement = $la_tontine->caisse->prochaine_date_encaissement;
        $en_retard = time() >= strtotime($prochaine_date_encaissement) ;
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

    <?php echo Session::get('notification',''); ?>


    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <hr/>
                        <h4 class="card-title text-center">
                            Tontine : <?php echo e($la_tontine->titre); ?>

                            
                            <br/>
                            <?php if($la_tontine->etat !='fermee' && $la_tontine->etat !='suspendue'): ?>
                                <?php if($en_retard): ?>
                                    <span class="clignote badge badge-danger">
                                            Cotisation en retard
                                        </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </h4>
                    <hr/>
                    <ul>
                        <li>Statut : <mark class="badge badge-<?php echo e($la_tontine->etat=='ouverte' ? 'success' :'danger'); ?>"><?php echo e($la_tontine->etat); ?></mark> </li>
                        <?php if($la_tontine->motif_intervention_admin !=null): ?> <li><b>Motif Intervention d'administrateur</b> : <mark class="badge badge-info"><?php echo e($la_tontine->motif_intervention_admin); ?></mark> </li> <?php endif; ?>
                        <li>Crée par : <?php echo e($la_tontine->createur->nom_complet); ?></li>
                        <li>Montant à cotiser : <?php echo e(number_format($la_tontine->montant,0,',',' ')); ?> <?php echo e($la_tontine->createur->devise_choisie->monaie); ?> <small>par personnes</small> </li>
                        <li> Nombre de participant : <?php echo e(sizeof($la_tontine->participants)); ?> / <?php echo e($la_tontine->nombre_participant); ?> </li>
                        <?php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = round($montant_total * (1/100));
                        ?>
                        <li>Frais de gestion (1%) : <?php echo e(number_format($frais,0,',',' ')); ?> <?php echo e($la_tontine->createur->devise_choisie->monaie); ?> / <?php echo e(number_format($montant_total,0,',',' ')); ?> <?php echo e($la_tontine->createur->devise_choisie->monaie); ?> </li>
                        <li> Frequence de depot : <?php echo e(formater_frequence($la_tontine->frequence_depot_en_jours)); ?></li>
                        <li> Tour de :
                            <mark class="badge badge-primary marquer_presence">
                                <?php if($la_tontine->caisse !=null): ?>
                                    <?php echo e($la_tontine->caisse->menbre_qui_prend->nom_complet); ?>

                                <?php else: ?>
                                    #
                                <?php endif; ?>
                            </mark>
                        </li>

                    </ul>

                    <br/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <hr>
                        <h4 class="text-uppercase text-center"> Changer l'etat de la tontine </h4>
                    <hr>
                        <br/>
                        <p class="card-description">

                        </p>
                        <form class="forms-sample" method="post" action="<?php echo e(route('admin.changer_etat_tontine',[$la_tontine['id']])); ?>">
                            <div class="form-group">
                                <h6 for="exampleInputUsername1">Etat de la tontine *</h6>
                                <select class="form-control" required name="nouvel_etat">
                                    <option selected value="<?php echo e($la_tontine->etat); ?>" ><?php echo e($la_tontine->etat); ?></option>
                                    <option value="constitution">constitution</option>
                                    <option value="ouverte">ouverte</option>
                                    <option value="fermee" >fermee</option>
                                    <option value="suspendue" >suspendue</option>
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
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >
                            Cotisation courante
                            <?php if($en_retard && $la_tontine->etat =='ouverte'): ?>
                                <span class="clignote badge badge-danger">
                                    Cotisation en retard
                                </span>
                            <?php endif; ?>
                        </h4>
                    <hr/>
                    <br/>
                        <p>Tour de :
                            <b class="badge badge-info marquer_presence">
                                <?php if($la_tontine->caisse !=null): ?>
                                    <?php echo e($la_tontine->caisse->menbre_qui_prend->nom_complet); ?>

                                <?php else: ?>
                                    #
                                <?php endif; ?>
                            </b>
                        </p>

                        <p>Montant à cotiser : <b> <?php echo e(number_format($la_tontine->montant,0,',',' ')); ?> <?php echo e($la_tontine->createur->devise_choisie->monaie); ?></b> </p>
                        <?php if($la_tontine->etat =='ouverte'): ?>
                        <p>Date limite : <b class="badge badge-warning"> <?php echo e($la_tontine->caisse->prochaine_date_encaissement); ?> </b> </p>

                        <p>
                                    Montant en caisse : <span class="marquer_presence text-info">
                                        <?php echo e(number_format($la_tontine->caisse->montant,0,',',' ')); ?> / <?php echo e(number_format($la_tontine->caisse->montant_objectif,0,',',' ')); ?> <?php echo e($la_tontine->createur->devise_choisie->monaie); ?>

                                    </span>
                                </p>
                                <p> de : <small> de <?php echo e(sizeof($liste_ayant_cotiser)); ?> personne(s)/<?php echo e(sizeof($la_tontine->participants)); ?> <a href="#liste_cotiseur">Voir</a> </small> </p>
                            <br/>
                        <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >Liste des membres</h4>
                        <h6 class="text-center"> <small> dans l'ordre de rotation </small> </h6>
                    <hr/>
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <th>#</th>
                            <th>Membre</th>
                            <th>#</th>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                            <?php $__currentLoopData = $la_tontine->participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_particpant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($la_tontine->caisse !=null): ?>
                                            <b class="<?php echo e($la_tontine->caisse->menbre_qui_prend->id == $item_particpant->id ? 'badge badge-info' : ''); ?>">
                                                <?php echo e($i++); ?>

                                            </b>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($item_particpant->nom_complet); ?>

                                        <h3>
                                            <span class="badge badge-<?php echo e($item_particpant->etat =='suspendu'? 'danger' : 'success'); ?>"><?php echo e($item_particpant->etat); ?></span>
                                        </h3>
                                    </td>
                                    <td>
                                        <button type="button" onclick="deplier_garde_fou('garde_fou_menbre_<?php echo e($item_particpant['id']); ?>')">Agir</button>
                                        <div class="col-12 garde_fou" id="garde_fou_menbre_<?php echo e($item_particpant['id']); ?>">

                                            <form method="post" action="<?php echo e(route('admin.suspendre_menbre',[$item_particpant['id']])); ?>">
                                                <br/>
                                                <h6>Etat du compte utilisateur</h6>
                                                <br/>
                                                    <select class="form-control" required name="nouvel_etat">
                                                        <option selected value="<?php echo e($item_particpant->etat); ?>" ><?php echo e($item_particpant->etat); ?></option>
                                                        <option value="actif">actif</option>
                                                        <option value="suspendu">suspendu</option>
                                                    </select>
                                                <br/>
                                                    <h6>Motif</h6>
                                                    <br/>
                                                    <textarea name="motif_intervention" class="form-control" placeholder="Entrer le motif de votre intervention" rows="4"><?php echo e($item_particpant->motif_intervention_admin); ?></textarea>
                                                <br/>
                                                <?php echo method_field('put'); ?>
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger"> Appliquer les modifications</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if($la_tontine->etat =='ouverte'): ?>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card" id="liste_cotiseur">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                            <h4 class="text-center text-uppercase"> Personnes ayant payer leur cotisation pour le tour courant </h4>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Membre</th>
                                <th>Date paiement</th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $liste_ayant_cotiser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_ayant_cotiser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item_ayant_cotiser->cotiseur->nom_complet); ?></td>
                                        <td><?php echo e(date("d/m/Y H:i",strtotime($item_ayant_cotiser->updated_at))); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="text-center text-uppercase"> Invitations envoyees </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Envoyer par</th>
                            <th>Email Inviter</th>
                            <th>Statut</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invitations_envoyees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_envoyee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item_envoyee->menbre_inviteur->nom_complet); ?></td>
                                    <td><?php echo e($item_envoyee->email_inviter); ?></td>
                                    <td>
                                        <?php
                                            $couleur = "primary";
                                            if($item_envoyee->etat == "acceptee"){
                                                $couleur = "success";
                                            }elseif($item_envoyee->etat == "refusee"){
                                                $couleur = "danger";
                                            }elseif($item_envoyee->etat == "expiree"){
                                                $couleur = "dark";
                                            }
                                        ?>
                                        <b class="badge badge-<?php echo e($couleur); ?>"> <?php echo e($item_envoyee->etat); ?> </b>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($la_tontine->caisse !=null): ?>
        
        <div class="row">
        <div class="col-md-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="text-center text-uppercase"> Toutes Les Transactions </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="datatable">
                        <thead>
                        <th>Membre</th>
                        <th>Date paiement</th>
                        <th>Tour de</th>
                        <th>Rotation No</th>
                        <th>Statut</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transactions_de_la_tontine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item_transaction->cotiseur->nom_complet); ?></td>
                                <td><?php echo e(date("d/m/Y H:i",strtotime($item_transaction->updated_at))); ?></td>
                                <td><?php echo e($item_transaction->menbre_qui_prend->nom_complet); ?></td>
                                <td><?php echo e($item_transaction->tontine->caisse->index_ouverture); ?></td>
                                <td class="text-<?php echo e(($item_transaction->statut == 'ACCEPTED') ? 'success' : 'danger'); ?>"> [ <?php echo e($item_transaction->statut); ?> ]</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaines";
            }
        }
        return $resultat;
    }
?>


<?php $__env->startSection('script_completmentaire'); ?>
    <script>
        window.onload = function() {
            fermer_tous_les_garde_fou();
        };

        function deplier_garde_fou(id){
            var le_garde_fou = document.getElementById(id);
            if(le_garde_fou.style.display =='none'){
                le_garde_fou.style.display = '';
            }else{
                le_garde_fou.style.display = 'none';
            }

        }

        function fermer_tous_les_garde_fou(){
            var tous_les_garde_fou = document.querySelectorAll('.garde_fou');
            for(var i=0; i<tous_les_garde_fou.length; i++){
                tous_les_garde_fou[i].style.display = "none";
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/tontines/details_tontine.blade.php ENDPATH**/ ?>