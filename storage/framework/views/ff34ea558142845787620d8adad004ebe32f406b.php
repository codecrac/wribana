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
      <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header text-uppercase text-center">
                                <hr/>
                                    historique retraits des membres ( <?php echo e(sizeof($historique_retraits)); ?> )
                                <hr/>
                                <br/>
                                <form method="get">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5>Afficher les transactions</h5>
                                            <?php if($date_debut!=null): ?>
                                                <a href="<?php echo e(route('admin.historique_versements')); ?>" class="btn btn-danger">x</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>du</h5>
                                            <input class="form-control" value="<?php echo e($date_debut); ?>" name="date_debut" type="datetime-local">
                                        </div>
                                        <div class="col-md-3">
                                            <h5>au</h5>
                                            <input class="form-control" name="date_fin" type="datetime-local" value="<?php echo e($date_fin); ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <h5>&nbsp;</h5>
                                            <button type="submit" class="btn btn-success">Ok</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                               <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Date</th>
                                        <th>Membre</th>
                                        <th>Solde Avant</th>
                                        <th>Montant Retiré</th>
                                        <th>Solde Après </th>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $historique_retraits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_retrait): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(date("d/m/Y H:m",strtotime($item_retrait['created_at']))); ?></td>
                                                <td><?php echo e($item_retrait->menbre->nom_complet); ?></td>
                                                <td><?php echo e(number_format($item_retrait->solde_avant,0,',',' ')); ?> <?php echo e($item_retrait->menbre->devise_choisie->monaie); ?></td>
                                                <td><?php echo e(number_format($item_retrait->montant_retirer,0,',',' ')); ?> <?php echo e($item_retrait->menbre->devise_choisie->monaie); ?></td>
                                                <td><?php echo e(number_format($item_retrait->solde_apres,0,',',' ')); ?> <?php echo e($item_retrait->menbre->devise_choisie->monaie); ?></td>
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


<?php
    function formater_frequence($frequence_en_jour){

    $resultat = "chaque $frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7 ==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "chaque $nb_semaines semaines";
            }
        }
        return $resultat;
    }
?>

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/historique_retraits.blade.php ENDPATH**/ ?>