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
                        Mes Waricrowds ( <?php echo e(sizeof($liste_waricrowd)); ?> )
                        <a class="btn btn-success" href="<?php echo e(route('espace_menbre.creer_un_waricrowd')); ?>">Creer un waricrowd</a>
                    </h3>
                    <hr/>
                </div>
                <?php echo Session::get('notification',''); ?>

                <br/><br/>
                <div class="row">
                    <div class="table-responsive">
                        <table width="100%" class="table" border="1">
                            <thead class="text-center">
                            <th class="tr_bordered">Titre</th>
                            <th class="tr_bordered">Montant Objectif</th>
                            <th class="tr_bordered">Progression Financement</th>
                            <th class="tr_bordered">Statut</th>
                            <th class="tr_bordered">#</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $liste_waricrowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="tr_bordered text-center">
                                    <td class="tr_bordered"><?php echo e($item['titre']); ?></td>
                                    <td class="tr_bordered"> <?php echo e(number_format($item['montant_objectif'],0,',',' ')); ?> <b><?php echo e($item->createur->devise_choisie->symbole); ?></b> </td>
                                    <td class="tr_bordered">
                                        <?php
                                            $pourcentage = round($item->caisse->montant *100 / $item->caisse->montant_objectif,2);
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
                                        <span class="badge badge-<?php echo e($couleur); ?>"><?php echo e($pourcentage); ?> %</span>
                                    </td>
                                    <td class="tr_bordered text-danger">
                                        
                                        <?php
                                            if($item->etat=='valider'){
                                                $couleur= "success";
                                                $etat = "Validé";
                                            }elseif($item->etat=='recaler'){
                                                $couleur = "danger";
                                                $etat = "Recalé";
                                            }elseif($item->etat=='attente'){
                                                $couleur = "dark";
                                                $etat = "En attente";
                                            }
                                        ?>
                                        <b class="badge badge-<?php echo e($couleur); ?>">
                                            <?php echo e($etat); ?>

                                        </b>
                                    </td>

                                    <td class="tr_bordered" style="padding: 8px">
                                        <a href="<?php echo e(route('espace_menbre.details_waricrowd',[$item['id']])); ?>" class="btn btn-primary">Details</a>
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

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/waricrowd/liste.blade.php ENDPATH**/ ?>