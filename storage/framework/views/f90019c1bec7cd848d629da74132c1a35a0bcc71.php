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
                            Utilisateurs Inscrits ( <?php echo e(sizeof($liste_menbres_inscrits)); ?>  )
                            <?php if($filtre!=null): ?>
                                <span class='text-uppercase'> [ Filtre : <?php echo e($filtre); ?> ] </span> <small><b><a class='text-danger' href='<?php echo e(route('admin.liste_menbres_inscrits')); ?>'>x</a></b> </small> 
                            <?php endif; ?>
                        </h3>
                    <hr/>

                </div>
                <br/><br/>
                <div class="row">
                    <div class="table-responsive">
                        <table width="100%" class="table text-left" border="1" id="datatable">
                            <thead class="text-left">
                                <th>#(ordre inscription)</th>
                                <th>Membre</th>
                                <th>Contact</th>
                                <th>Devise</th>
                                <th>Etat</th>
                                <th>#</th>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                            <?php $__currentLoopData = $liste_menbres_inscrits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_menbre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">#<?php echo e($i++); ?></td>
                                    <td> 
                                        Nom complet : <b><?php echo e($item_menbre->nom_complet); ?></b>  <br/>
                                        pays-ville : <?php echo e($item_menbre->pays); ?>, <?php echo e($item_menbre->ville); ?>  <br/>
                                        Etat USA : <?php echo e($item_menbre->etat_us); ?>  <br/>
                                        Adresse : <?php echo e($item_menbre->adresse); ?>  <br/>
                                    </td>
                                    <td>
                                       Tel :  <?php echo e($item_menbre->telephone); ?> <br/>
                                       Email :  <?php echo e($item_menbre->email); ?> <br/>
                                     </td>
                                     <td>
                                         <?php if($item_menbre->devise_choisie != null): ?>
                                            <?php echo e($item_menbre->devise_choisie->code); ?> (<?php echo e($item_menbre->devise_choisie->monaie); ?>) 
                                        <?php else: ?>
                                          -
                                        <?php endif; ?>    
                                        <br/>
                                     </td>
                                    <td>
                                        <h3>
                                            <span class="badge badge-<?php echo e($item_menbre->etat =='suspendu' || $item_menbre->etat =='banni' ? 'danger' : 'success'); ?>"><?php echo e($item_menbre->etat); ?></span>
                                        </h3>
                                    </td>
                                    <td>
                                        <button type="button" onclick="deplier_garde_fou('garde_fou_menbre_<?php echo e($item_menbre['id']); ?>')">Intervenir</button>
                                        <div class="col-12 garde_fou" id="garde_fou_menbre_<?php echo e($item_menbre['id']); ?>">

                                            <form method="post" action="<?php echo e(route('admin.suspendre_menbre',[$item_menbre['id']])); ?>">
                                                <br/>
                                                <h6>Etat du compte utilisateur</h6>
                                                <br/>
                                                <select class="form-control" required name="nouvel_etat">
                                                    <option selected value="<?php echo e($item_menbre->etat); ?>" ><?php echo e($item_menbre->etat); ?></option>
                                                    <option value="actif">actif</option>
                                                    <option value="suspendu">suspendu</option>
                                                    <option value="banni">banni</option>
                                                </select>
                                                <br/>
                                                <h6>Motif</h6>
                                                <br/>
                                                <textarea name="motif_intervention" class="form-control" placeholder="Entrer le motif de votre intervention" rows="4"><?php echo e($item_menbre->motif_intervention_admin); ?></textarea>
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

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/liste_menbres_inscrits.blade.php ENDPATH**/ ?>