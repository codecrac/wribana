<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

?>





<?php $__env->startSection('style_completmentaire'); ?>
    <style>
        .tr_bordered{
            border: 1px solid gray !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php echo Session::get('notification',''); ?>

    <hr/>
        <h3 class="text-center"> Invitations recues ( <?php echo e(sizeof($invitation_recues)); ?> ) </h3>
    <hr/>

  <div class="row">
      <div class="table-responsive">
          <table class="table table-striped">
              <thead class="text-center">
                  <tr>
                      <th class="tr_bordered">Envoyée par</th>
                      <th class="tr_bordered">Tontine</th>
                      <th class="tr_bordered">Montant à cotiser</th>
                      <th class="tr_bordered">Fréquence de depot</th>
                      <th class="tr_bordered">Statut</th>
                      <th class="tr_bordered">#</th>
                  </tr>
              </thead>
              <tbody class="text-center">
                  <?php $__currentLoopData = $invitation_recues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_iv_recue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                      <tr>
                          <td class="tr_bordered"><?php echo e($item_iv_recue->menbre_inviteur->nom_complet); ?></td>
                          <td class="tr_bordered"><?php echo e($item_iv_recue->tontine->titre); ?></td>
                          <td class="tr_bordered"><?php echo e(number_format($item_iv_recue->tontine->montant,0,',',' ')); ?> <b><?php echo e($item_iv_recue->menbre_inviteur->devise_choisie->monaie); ?></b> </td>
                          <td class="tr_bordered"><?php echo e(formater_frequence($item_iv_recue->tontine->frequence_depot_en_jours)); ?></td>
                          <td class="tr_bordered"><label class="badge badge-danger"><?php echo e($item_iv_recue['etat']); ?></label></td>
                          <td class="tr_bordered">
                              <a href="#" onclick="deplier_garde_fou('garde_fou_recues_<?php echo e($item_iv_recue['id']); ?>')">Repondre</a>
                              <div class="col-12 garde_fou" id="garde_fou_recues_<?php echo e($item_iv_recue['id']); ?>">
                                  <form method="post" action="<?php echo e(route('espace_menbre.reponse_invitation',[$item_iv_recue['id']])); ?>">
                                      <select class="form-control" name="reponse" required>
                                          <option value>(choisissez)</option>
                                          <option value="acceptee">Accepter</option>
                                          <option value="refusee">Refuser</option>
                                      </select>
                                      <br/>
                                      <?php echo csrf_field(); ?>
                                      <input type="submit" value="valider" class="btn btn-warning">
                                  </form>
                              </div>
                          </td>
                      </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
          </table>
      </div>
  </div>
<?php $__env->stopSection(); ?>


<?php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaine(s)";
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

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/tontine/invitations.blade.php ENDPATH**/ ?>