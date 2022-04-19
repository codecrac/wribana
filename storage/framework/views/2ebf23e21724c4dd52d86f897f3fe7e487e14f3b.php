<?php
$la_session = session(\App\Http\Controllers\MenbreController::$cle_session);


$monaie_createur_crowd = $le_crowd->createur->devise_choisie->code;
$monaie_utilisateur_connecter = $la_session['code_devise'];

$quotient_de_conversion =1; //on recupere le quotient puis on fais la conversion localement pour eviter de faire trop d'appel api
if($monaie_createur_crowd != $monaie_utilisateur_connecter){
    $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_crowd,$monaie_utilisateur_connecter);
    // dd($quotient_de_conversion);
}

function convertir($quotient,$montant) //pour l'esthetic dans le code html
{
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
    $monaie_utilisateur_connecter = $la_session['devise'];
    $reponse =  \App\Http\Controllers\CurrencyConverterController::convertir_si_necessaire($quotient,$montant,$monaie_utilisateur_connecter);
    return $reponse;
}
?>





<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="card-title text-center">Confirmer votre soutien</h4>
                    <hr/>
                </div>
                <div class="card-body text-left text-uppercase">
                    <?php echo Session::get('notification',''); ?>

                    <hr/>
                        <h5>WARICROWD : <?php echo e($le_crowd->titre); ?></h5>
                    <hr/>
                        <h5>Objectif : <?php echo e(number_format($le_crowd->caisse->montant_objectif,0,',',' ')); ?> <?php echo e($le_crowd->createur->devise_choisie->monaie); ?> 
                            <?php echo convertir($quotient_de_conversion,$le_crowd->caisse->montant_objectif); ?> </h5>
                    <hr/>
                        <h5>Montant atteinds : <?php echo e(number_format( $le_crowd->caisse->montant,0,',',' ')); ?> <?php echo e($le_crowd->createur->devise_choisie->monaie); ?>

                             <?php echo convertir($quotient_de_conversion,$le_crowd->caisse->montant); ?> </h5>
                    <hr/>
                        <h5>Votre soutien : <?php echo e(number_format($montant_soutien,0,',',' ')); ?> <?php echo e($le_crowd->createur->devise_choisie->monaie); ?> 
                            <?php echo convertir($quotient_de_conversion,$montant_soutien); ?> </h5>
                    <hr/>

                    <form action="<?php echo e(route('espace_menbre.soutenir_projet',[$le_crowd->id])); ?>" method="post">
                        <input type="hidden" value="<?php echo e($montant_soutien); ?>" name="montant_soutien">

                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <!--<span class="badge badge-info"> le montant sera converti en FCFA(XOF) au guichet </span>-->
                            <button type="submit" class="btn btn-primary" style="">Confirmer</button>
                            <a class='btn btn-default' href="<?php echo e(route('details_projet',[$le_crowd->id])); ?>" >Annuler</a>
                        </h3>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <hr/>
            <h4>Comment ça marche</h4>
            <hr/>
            <iframe width="100%" src="https://www.youtube.com/embed/DzH5aRoMYLw" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/waricrowd/confirmer_soutien_waricrowd.blade.php ENDPATH**/ ?>