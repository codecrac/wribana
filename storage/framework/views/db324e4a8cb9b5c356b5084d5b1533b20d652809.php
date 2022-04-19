<?php $__env->startSection('style_completmentaire'); ?>
    <style>
        .tr_bordered{
            border: 1px solid gray !important;
        }

        .clignote {
            animation: blinker 1s linear infinite;
        }

        @keyframes  blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <hr/>
                <h3 class="text-center">
                    Mes Tontines ( <?php echo e(sizeof($mes_tontines)); ?> )
                    <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.ajouter_tontine')); ?>">Nouvelle tontine</a>
                </h3>
                <hr/>
            </div>
            <div class="row">
                <p class="card-title col-12">Adherer a une tontine via le code d'invitation</p>
                <div class="col-12">
                    <form method="post" action="<?php echo e(route('espace_menbre.confirmer_adhesion_tontine')); ?>">

                        <?php if(isset($_GET['code_invitation'])): ?>

                        <div class="row" style='border:1px solid orange;padding:5px'>
                            <div class="col-md-4">
                                <input class="form-control" type="number" value="<?php echo e($_GET['code_invitation']); ?>" name="code_invitation" required placeholder="Entrer le code d'invitation" />
                            </div>
                            <div class="col-md-4">
                                <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-warning">Voir les details de la tontine</button>
                            </div>
                        </div>
                        <?php else: ?>

                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="number"  name="code_invitation" required placeholder="Entrer le code d'invitation" />
                            </div>
                            <div class="col-md-4">
                                <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-success">Adherer à la tontine</button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <?php echo Session::get('notification',''); ?>

            <br/><br/>
            <div class="row">
                <div class="table-responsive">
                    <table width="100%" class="table" border="1">
                        <thead class="text-center">
                        <th class="tr_bordered">Tontine</th>
                        <th class="tr_bordered">Nombre de participants </th>
                        <th class="tr_bordered">Montant à cotiser</th>
                        <th class="tr_bordered">Statut</th>
                        <th class="tr_bordered">Prochaine cotisation</th>
                        <th class="tr_bordered">#</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $mes_tontines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ma_tontine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="tr_bordered text-center">
                                <td class="tr_bordered"><?php echo e($ma_tontine['titre']); ?></td>
                                <td class="tr_bordered"><?php echo e(sizeof($ma_tontine->participants)); ?>/<?php echo e($ma_tontine['nombre_participant']); ?></td>
                                <td class="tr_bordered">
                                    <?php echo e(number_format($ma_tontine['montant'],0,',',' ')); ?> <b><?php echo e($ma_tontine->createur->devise_choisie->monaie); ?></b>
                                    <br/>
                                    <?php echo e(formater_frequence($ma_tontine['frequence_depot_en_jours'])); ?>

                                </td>
                                <td class="tr_bordered">
                                    <?php
                                      if($ma_tontine->etat == 'ouverte'){
                                            $couleur = 'success';
                                    }elseif ($ma_tontine->etat == 'prete'){
                                            $couleur = 'warning';
                                    }else{
                                        $couleur = 'info';
                                    }
                                    ?>
                                    <b class="text-uppercase text-<?php echo e($couleur); ?>">
                                        <?php echo e($ma_tontine->etat); ?>

                                    </b>
                                </td>
                                <td class="tr_bordered">
                                        <?php if($ma_tontine->caisse !=null && $ma_tontine->etat =='ouverte'): ?>
                                            <?php
                                                $aujourdhui = new DateTime("now", new \DateTimeZone("UTC"));
                                                $aujourdhui = $aujourdhui->format("d-m-Y");
                                                $aujourdhui = new DateTime($aujourdhui);

                                                $prochaine_date = $ma_tontine->caisse->prochaine_date_encaissement;
                                                $prochaine_date = new DateTime($prochaine_date);

                                                $interval = $prochaine_date->diff($aujourdhui);
                                                $intervals = $interval->format('%a');

                                                $prochaine_date_encaissement = $ma_tontine->caisse->prochaine_date_encaissement;
                                                $en_retard = time() >= strtotime($prochaine_date_encaissement) ;

                                            ?>

                                            <br/>
                                            <?php if($en_retard): ?>

                                            <span class="clignote badge badge-danger">
                                                Cotisation en retard
                                            </span>
                                            <?php else: ?>
                                                <b class="badge">
                                                    Date limite dans <?php echo e($intervals); ?> jours
                                                </b>
                                                <br/>
                                                <hr/>
                                                <br/>
                                                <b class="badge">
                                                    Tour de : <?php echo e($ma_tontine->caisse->menbre_qui_prend->nom_complet); ?>

                                                </b>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            #
                                        <?php endif; ?>
                                </td>
                                <td class="tr_bordered" style="padding: 8px">
                                    <a href="<?php echo e(route('espace_menbre.details_tontine',[$ma_tontine['id']])); ?>" class="badge badge-primary">Details</a>
                                    <br/><br/>
                                    <a href="<?php echo e(route('espace_menbre.chat_tontine',[$ma_tontine['id']])); ?>" class="badge badge-success">Espace Chat</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>


<?php
    function formater_frequence($frequence_en_jour){

    $resultat = "chaque $frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7 ==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "chaque $nb_semaines semaine(s)";
            }
        }
        return $resultat;
    }
?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/tontine/liste_tontine.blade.php ENDPATH**/ ?>