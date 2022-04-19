<?php
$la_session = session(\App\Http\Controllers\MenbreController::$cle_session);


$monaie_createur_tontine = $la_tontine->createur->devise_choisie->code;
$monaie_utilisateur_connecter = $la_session['code_devise'];


$quotient_de_conversion =1; //on recupere le quotient puis on fais la conversion localement pour eviter de faire trop d'appel api
if($monaie_createur_tontine != $monaie_utilisateur_connecter){
    try{
        $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_tontine,$monaie_utilisateur_connecter);
    }catch(Exception $e){
        echo 'conversion des montant en cours';
        $quotient_de_conversion = 0;
    }
}

function convertir($quotient,$montant) //pour l'esthetic dans le code html
{
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
    $monaie_utilisateur_connecter = $la_session['devise'];
    $reponse =  \App\Http\Controllers\CurrencyConverterController::convertir_si_necessaire($quotient,$montant,$monaie_utilisateur_connecter);
    return $reponse;
}

?>




<?php $__env->startSection('style_completmentaire'); ?>
    <style>
        .marquer_presence {
            font-size: 18px;
            font-weight: bold;
        }

        .show_on_mobile {
           display: none;
        }

        @media  only screen and (max-width: 768px) {
            .show_on_mobile {
                display: inline-block;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo Session::get('notification',''); ?>

    
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo e(route('espace_menbre.liste_tontine')); ?>"> RETOUR </a>
                </div>
                <div class="card-body">
                    <hr/>
                    <h4 class="card-title text-center">
                        Tontine : <?php echo e($la_tontine->titre); ?>

                    </h4>
                    <hr/>
                    <ul>
                        <li>Statut :
                            <mark
                                class="badge badge-<?php echo e($la_tontine->etat=='ouverte' ? 'success' :'danger'); ?>"><?php echo e($la_tontine->etat); ?></mark>
                        </li>
                        <?php if($la_tontine->motif_intervention_admin !=null): ?>
                            <li><b>Motif Intervention d'administrateur</b> :
                                <mark class="badge badge-info"><?php echo e($la_tontine->motif_intervention_admin); ?></mark>
                            </li> <?php endif; ?>
                        <li>Crée par : <?php echo e($la_tontine->createur->nom_complet); ?></li>
                        <li>Montant à cotiser : 
                            <?php echo e(number_format($la_tontine->montant,0,',',' ')); ?>

                            <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b>

                                <?php echo convertir($quotient_de_conversion,$la_tontine->montant,); ?>


                            <small>par personnes</small></li>
                        <?php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = $montant_total * (1/100);
                        ?>
                        <li>
                            Montant Objectif : <?php echo e(number_format($montant_total,0,',',' ')); ?> <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b>  
                            <?php echo convertir($quotient_de_conversion,$montant_total,); ?>

                        </li>
                        <li>Frais de gestion (1%) : <?php echo e(number_format($frais,2,',',' ')); ?>

                            <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b>
                            / <?php echo e(number_format($montant_total,0,',',' ')); ?>

                            <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b></li>
                        <li> Nombre de participant : <?php echo e(sizeof($la_tontine->participants)); ?>

                            / <?php echo e($la_tontine->nombre_participant); ?> </li>
                        <li> Frequence de depot : <?php echo e(formater_frequence($la_tontine->frequence_depot_en_jours)); ?></li>
                    </ul>


                    <?php if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant): ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <form method="post" action="<?php echo e(route('espace_menbre.adhesion_via_code_invitation')); ?>">
                                        <input class="form-control" value="<?php echo e($la_tontine->identifiant_adhesion); ?>" type="hidden" name="code_invitation" required 
                                            placeholder="Entrer le code d'invitation" />
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success">Continuer et Adherer</button>
                                    </form>
                                </div>
                                <div class="col-md-6 text-center">
                                    <a href="<?php echo e(route('espace_menbre.accueil')); ?>" class="btn btn-danger"> Retour </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <h3 class="text-center"><b class="badge badge-success">Complet !</b></h3>
                    <?php endif; ?>

                    <br/>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <?php if($la_tontine->etat !='fermee' && $la_tontine->etat !='terminer'): ?>
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <h4 class="text-uppercase text-center"> Inviter des amis </h4>
                        <hr>
                        <?php $le_lien = route('espace_menbre.liste_tontine').'?code_invitation='.$la_tontine->identifiant_adhesion ?>
                        
                        Partager sur :
                        <br/>
                        
                        <a href="whatsapp://send?text=Bonjour je t'invite a rejoindre la tontine <<<?php echo e($la_tontine->titre); ?>>> sur WARIBANA via ce lien :
                        <?php echo e($le_lien); ?>"  class="btn btn-success show_on_mobile">Whatsapp</a>
                        
                        <a  class="btn btn-primary show_on_mobile" href="fb-messenger://share/?link=Bonjour je t'invite a rejoindre la tontine <<<?php echo e($la_tontine->titre); ?>>> sur WARIBANA via ce lien :
                        <?php echo e($le_lien); ?>">Messenger</a>
                        
                        <a class="btn btn-info" href="https://twitter.com/share?url=<?php echo e($le_lien); ?>&text=Bonjour je t'invite a rejoindre la tontine <<<?php echo e($la_tontine->titre); ?>>> sur WARIBANA via ce lien :" 
                            target="_blank" title="Share on Twitter"> twitter</a>

                        
                       <a target="_blank" class="btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($le_lien); ?>/&display=popup">
                         Facebook
                        </a>
                        
                        <?php if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant): ?>
                            
                            <hr/>
                                <h5 class="text-uppercase text-center"> ou utiliser </h5>
                            <hr/>
                                <p class="card-description">
                                    <b> le code invitation : <?php echo e($la_tontine->identifiant_adhesion); ?></b>
                                <br/>
                                    <b>le lien d'adhesion</b> : <?php echo e($le_lien); ?> </p> <br/>
                            <hr/>
                                <h5 class="text-uppercase text-center"> Inviter via email </h5>
                            <hr/>

                            <form class="forms-sample" method="post"
                                  action="<?php echo e(route('espace_menbre.post_inviter_des_amis',[$la_tontine['id']])); ?>">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Liste des Emails</label>
                                    <input required type="text" class="form-control text-lowercase" name="liste_emails"
                                           placeholder="adresse1@gmail.com,adresse2@gmail.com">
                                </div>
                                <h3 class="text-center">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary mr-2">Envoyer les invitations</button>
                                </h3>
                            </form>

                            <hr/>
                                <h5 class="text-uppercase text-center"> Inviter via sms </h5>
                            <hr/>
                            
                            <form class="forms-sample" method="post"
                                  action="<?php echo e(route('espace_menbre.post_envoyer_invitation_via_sms',[$la_tontine['id']])); ?>">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Prefixe</label><br/>
                                            <input required type="number" class="form-control text-lowercase" name="prefixe"
                                           placeholder="225,33...">
                                        </div>
                                        <div class="col-md-8">
                                            <label>Telephone</label><br/>
                                            <input required type="number" class="form-control text-lowercase" name="telephone"
                                           placeholder="0555005500">
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-center">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary mr-2 text-uppercase">Envoyer le SMS</button>
                                </h3>
                            </form>
                        <?php else: ?>
                            <h3 class="text-center"><b class="badge badge-success">Complet !</b></h3>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
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

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/tontine/confirmer_adhesion_tontine.blade.php ENDPATH**/ ?>