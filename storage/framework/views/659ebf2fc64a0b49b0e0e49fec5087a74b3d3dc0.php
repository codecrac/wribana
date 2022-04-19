
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
                                    Frais de gestion
                                <hr/>
                                <br/>
                                <?php echo Session::get('notification',''); ?>

                                <br/>
                                
                                <form method="POST">
                                    <div class="row">
                                        <div class='col-md-5'>
                                            <h6> Pourcentage actuel : </h6>
                                            <h3 style="font-size:100px"> <?php echo e($les_parametres->pourcentage_frais); ?> <small>%</small> </h3>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-12">
                                                <h5>Changer le pourcentage</h5>
                                            </div>
                                            <div class="col-12">
                                                <input class="form-control" value="<?php echo e($les_parametres->pourcentage_frais); ?>" name="pourcentage_frais" onkeypress="return onlyNumberKey(event)" type="number">
                                            </div>
                                            <br/>
                                            <?php echo csrf_field(); ?>
                                            <button class='btn btn-warning' type='submit' >Enregistrer</button>
                                        </div>
                                    </div>
                                </form>
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
    
   function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)){
            // alert("only number");
            return false;
        }
        return true;
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
<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/frais_de_gestion.blade.php ENDPATH**/ ?>