<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
?>



<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center">Creer une tontine</h4>
                    <p class="card-description">
                        Créez votre tontine et invitez vos amis à y participer.
                    </p>
                    <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_ajouter_tontine')); ?>">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Titre</label>
                                <input required type="text" id="input_titre" class="form-control" name="titre" 
                                        placeholder="Tontine Elegante" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre de particpants</label>
                                <input required type="number" onkeypress="return onlyNumberKey(event)" id="input_nb_participant" min="2" class="form-control" name="nombre_participant" placeholder="14">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Montant en <b><?php echo e($la_session['devise']); ?></b> (Minimum de <?php echo e(($la_session['code_devise'] == 'XOF') ? '1000' : '5'); ?> <?php echo e($la_session['devise']); ?>)  </label>
                                <input required type="number" onkeypress="return onlyNumberKey(event)" id="input_montant" min="<?php echo e(($la_session['code_devise'] == 'XOF') ? '1000' : '5'); ?>" class="form-control" name="montant" placeholder="17500">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Fréquence de cotisation (en jours)</label>
                                <input required type="number" onkeypress="return onlyNumberKey(event)" id="input_frequence" min="1" class="form-control" name="frequence_depot_en_jours" placeholder="7">
                            </div>
                            <h3 class="text-center">
                                <?php echo csrf_field(); ?>
                                <button type="hidden"
                                         type="submit" class="btn btn-primary mr-2"
                                         style="display: none"
                                         id="btn_soumettre_creation_tontine">Creer la tontine</button>
                                
                                <button type="button" 
                                    class="btn btn-primary mr-2" 
                                    onclick="resumer_modal()"
                                    class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"
                                    >
                                    Creer la tontine
                                </button>
                            </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>



    
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">RESUME DE LA TONTINE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5> Titre :  </h5>
                    </div>
                    <div class="col-md-6">
                        <h5 id="modal_titre">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-md-6">
                        <h5> Nombre de participant :  </h5>
                    </div>
                    <div class="col-md-6">
                        <h5 id="modal_nb_participant">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-md-6">
                        <h5> 
                            Montant en <b><?php echo e($la_session['devise']); ?><b> :
                            <br/> (montant à cotiser par personne))  
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <h5 id="modal_montant">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-md-6">
                        <h5> Fréquence de cotisation <br/> (en jours) : </h5>
                    </div>
                    <div class="col-md-6">
                        <h5 id="modal_frequence">   </h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="button"  class="btn btn-success" onclick="soumettre_le_formulaire()">Continuer et creer</button>
            </div>
          </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script_completmentaire'); ?>
    <script>
        function resumer_modal(){
            let categorie = document.getElementById('input_categorie');
            let nb_participant = document.getElementById('input_nb_participant').value;
            document.getElementById('modal_titre').innerHTML = document.getElementById('input_titre').value;
            document.getElementById('modal_nb_participant').innerHTML = nb_participant;
            document.getElementById('modal_montant').innerHTML = document.getElementById('input_montant').value;
            document.getElementById('modal_frequence').innerHTML = document.getElementById('input_frequence').value;
        }

        function soumettre_le_formulaire(){
            
           $('#exampleModalCenter').modal('toggle');
           setTimeout(
               function(){
                  document.getElementById("btn_soumettre_creation_tontine").click();
           }, 500);
            
        }
      
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/tontine/creer_tontine.blade.php ENDPATH**/ ?>