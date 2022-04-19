<?php
$la_session = session(\App\Http\Controllers\MenbreController::$cle_session);


$en_retard = false;
if ($la_tontine->caisse != null) {
    $prochaine_date_encaissement = $la_tontine->caisse->prochaine_date_encaissement;
    $en_retard = time() >= strtotime($prochaine_date_encaissement);
}

$statut_transaction = null;
if(isset($_GET['statut_transaction'])){
    $statut_transaction = $_GET['statut_transaction'];
}

$monaie_createur_tontine = $la_tontine->createur->devise_choisie->code;
$monaie_utilisateur_connecter = $la_session['code_devise'];


$quotient_de_conversion =1; //on recupere le quotient puis on fais la conversion localement pour eviter de faire trop d'appel api
if($monaie_createur_tontine != $monaie_utilisateur_connecter){
    $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_tontine,$monaie_utilisateur_connecter);
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
<!-- POUR BOOTSTRAP CONFIRMATION -->
    <style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </style>


    <?php echo Session::get('notification',''); ?>

    <?php if($statut_transaction !=null): ?>
        <?php if($statut_transaction == 'ACCEPTED'): ?>
            <div class='alert alert-success text-center'>Votre paiement a bien été effectué</div>
        <?php else: ?>
            <div class='alert alert-danger text-center'>Echec du paiement</div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(isset($_GET['probleme_lien_paiement'])): ?>
            <div class='alert alert-danger text-center'><?php echo e($_GET['probleme_lien_paiement']); ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?php echo e(route('espace_menbre.liste_tontine')); ?>">RETOUR VERS LA LISTE</a>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="<?php echo e(route('espace_menbre.chat_tontine',[$la_tontine['id']])); ?>"
                               class="badge badge-success">Espace Chat</a>
                        </div>
                    </div>
                    <hr/>
                    <h4 class="card-title text-center">
                        Tontine : <?php echo e($la_tontine->titre); ?>

                        <?php if($la_tontine->createur->id == $la_session['id'] && sizeof($la_tontine->transactions)==0): ?>
                            <br/><br/>
                            <div class="row">
                                <div class="col-md-6 text-center p-2">
                                    <?php if( ($la_tontine->etat == 'constitution') || ($la_tontine->etat == 'prete') ): ?>
                                        <a href="<?php echo e(route('espace_menbre.editer_tontine',[$la_tontine['id']])); ?>"
                                           class="badge badge-success">Editer la tontine</a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 text-center p-2">
                                    <?php if( ($la_tontine->etat == 'constitution') || ($la_tontine->etat == 'prete') ): ?>
                                        <a href="<?php echo e(route('espace_menbre.supprimer_tontine',[$la_tontine['id']])); ?>"
                                           class="badge badge-info">Supprimer la tontine</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <br/>
                        <?php if($la_tontine->etat =='ouverte'): ?>
                            <?php if($en_retard): ?>
                                <span class="clignote badge badge-danger">
                                            Cotisation en retard
                                        </span>
                            <?php endif; ?>
                        <?php endif; ?>
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


                            <small>Par personne</small></li>
                        <?php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = $montant_total * ($pourcentage_frais/100);
                        ?>
                        <li>
                            Montant Objectif : <?php echo e(number_format($montant_total,0,',',' ')); ?> <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b>
                            <?php echo convertir($quotient_de_conversion,$montant_total,); ?>

                        </li>
                        <li>Frais de gestion (<?php echo e($pourcentage_frais); ?>%) : <?php echo e(number_format($frais,2,',',' ')); ?>

                            <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b>
                            / <?php echo e(number_format($montant_total,0,',',' ')); ?>

                            <b><?php echo e($la_tontine->createur->devise_choisie->symbole); ?></b></li>
                        <li> Nombre de participants : <?php echo e(sizeof($la_tontine->participants)); ?>

                            / <?php echo e($la_tontine->nombre_participant); ?> </li>
                        <li> Fréquence de depot : <?php echo e(formater_frequence($la_tontine->frequence_depot_en_jours)); ?></li>
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


                    <?php if($la_tontine->etat =='constitution' ||  $la_tontine->etat =='prete'): ?>
                       
                        <?php if($pret): ?>
                            <?php if($la_tontine->etat =='prete'): ?>
                                <form method="post" action="<?php echo e(route('espace_menbre.ouvrir_tontine',[$la_tontine['id']])); ?>">
                                    <?php if($la_tontine->createur->id == $la_session['id']): ?>
                                        <?php echo csrf_field(); ?>
                                        <h3 class="text-center">
                                            <p class="badge badge-warning text-center">Ouvrez la tontine uniquement si vous êtes pret a
                                                commencer les cotisations.</p>
                                            <button type="submit" class="btn btn-success">Ouvrir la tontine</button>
                                        </h3>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                        <p class=" text-center">La tontine pourra être ouverte une fois le nombre de participants spécifié est atteint
                            specifié atteinds.</p>
                            <?php if($la_tontine->createur->id == $la_session['id']): ?>
                                <h3 class="text-center">
                                    <input type="button" class="btn btn-dark" style="cursor: not-allowed"
                                        value="Ouvrir la tontine"/>
                                </h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php elseif($la_tontine->etat =='terminer'): ?>
                        <p class="badge badge-success text-center">Votre tontine s'est effectuée avec succes vous(le createur) pouvez
                            la relancée!</p>
                        <form method="post" action="<?php echo e(route('espace_menbre.ouvrir_tontine',[$la_tontine['id']])); ?>">
                            <?php if($la_tontine->createur->id == $la_session['id']): ?>
                                <?php echo csrf_field(); ?>
                                <h3 class="text-center">
                                    <p class="badge badge-warning text-center">Ouvrez la tontine uniquement si vous êtes pret a
                                        commencer les cotisations.</p>
                                    <button type="submit" class="btn btn-success">Recommencer les cotisations</button>
                                </h3>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                    <br/>
                    <!--//LISTE MENBRE-->
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <?php if($la_tontine->etat !='fermee' && $la_tontine->etat !='terminer' && !$pret ): ?>
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <h4 class="text-uppercase text-center"> Inviter des amis </h4>
                        <hr>
                        <?php $le_lien = route('espace_menbre.liste_tontine').'?code_invitation='.$la_tontine->identifiant_adhesion ?>

                        Partager sur :
                        <br/>

                        <a href="whatsapp://send?text=Bonjour je t'invite a rejoindre la tontine <<<?php echo e($la_tontine->titre); ?>>> sur WARIBANA via ce lien :
                        <?php echo e($le_lien); ?>"  class="badge badge-success show_on_mobile">Whatsapp</a>

                        <a  class="badge badge-primary show_on_mobile" href="fb-messenger://share/?link=Bonjour je t'invite a rejoindre la tontine <<<?php echo e($la_tontine->titre); ?>>> sur WARIBANA via ce lien :
                        <?php echo e($le_lien); ?>">Messenger</a>

                        <a class="badge badge-info" href="https://twitter.com/share?url=<?php echo e($le_lien); ?>&text=Bonjour je t'invite a rejoindre la tontine <<<?php echo e($la_tontine->titre); ?>>> sur WARIBANA via ce lien :"
                            target="_blank" title="Share on Twitter"> twitter</a>


                       <a target="_blank" class="badge badge-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($le_lien); ?>/&display=popup">
                         Facebook
                        </a>


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
                                        <div class="col-md-6">
                                            <label><small>pays</small></label>
                                            
                                            <select required class="form-control" name="prefixe">
                                                <?php echo App\Http\Controllers\CountryPrefixController::listOptionChoisirPays(); ?>

                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label><small>Telephone</small></label>
                                            <input required class="form-control" placeholder="Entrez votre telephone" type="number" name="telephone" min='1' />
                                        </div>                                      
                                    </div>
                                </div>
                                <h3 class="text-center">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary mr-2 text-uppercase">Envoyer le SMS</button>
                                </h3>
                            </form>
                       
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    
        <div class="row">
            <?php if($la_tontine->etat =='ouverte'): ?>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <hr/>
                            <h4 class="text-center text-uppercase">
                                Cotisation courante
                                <?php if($en_retard): ?>
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
                            <p>Date limite : <b
                                    class="badge badge-warning"> <?php echo e($la_tontine->caisse->prochaine_date_encaissement); ?> </b>
                            </p>
                            
                            <p>Montant à cotiser :
                                <b> <?php echo e(number_format($la_tontine->montant,0,',',' ')); ?> <?php echo e($la_tontine->createur->devise_choisie->monaie); ?></b>
                                <?php echo convertir($quotient_de_conversion,$la_tontine->montant,); ?>

                            </p>
                            <p>
                                Montant en caisse : <span class="marquer_presence text-info">
                                    <?php echo e(number_format($la_tontine->caisse->montant,0,',',' ')); ?> <?php echo convertir($quotient_de_conversion,$la_tontine->caisse->montant,); ?>

                                    / <?php echo e(number_format($la_tontine->caisse->montant_objectif,0,',',' ')); ?> <b><?php echo e($la_tontine->createur->devise_choisie->monaie); ?></b> <?php echo convertir($quotient_de_conversion,$la_tontine->caisse->montant_objectif,); ?>

    
                                </span>
                            </p>
                            <p> de : <small> de <?php echo e(sizeof($liste_ayant_cotiser)); ?>

                                    personne(s)/<?php echo e(sizeof($la_tontine->participants)); ?> <a href="#liste_cotiseur">Voir</a>
                                </small></p>
                            <br/>
                            <?php if($a_deja_cotiser): ?>
                                <h5 class="text-center"><b style="padding: 15px" class="badge-success">Vous avez dejà payer
                                        votre cotisation pour ce tour.</b></h5>
                            <?php else: ?>
                                <h3 class="text-center">
                                     <form action="<?php echo e(route('espace_menbre.paiement_cotisation',[$la_tontine->id])); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <!--<span class="badge badge-info"> le montant sera converti en FCFA(XOF) au guichet </span>-->
                                        
                                        <button class="btn btn-primary" data-toggle="confirmation"
                                            data-btn-ok-label="Continuer" data-btn-ok-class="btn btn-success"
                                            data-btn-cancel-label="Annuler" data-btn-cancel-class="btn btn-danger"
                                            data-title="Confirmer" data-content="Confirmer le paiement ? "
                                        >
                                            Payer ma cotisation
                                        </button>
                                    </form>
                                </h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <hr/>
                        <h4 class="text-center text-uppercase">
                            <?php if($la_tontine->etat =='ouverte'): ?>
                                Ordre de rotation
                            <?php else: ?>
                                Liste des membres
                            <?php endif; ?>
                        </h4>
                        <h6 class="text-center"><small> Par date d’adhésion </small></h6>
                        <hr/>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>Membre</th>
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
                                    <td><?php echo e($item_particpant->nom_complet); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    
    <div class="row">
        <?php if($la_tontine->etat =='ouverte'): ?>
            <div class="col-md-6 grid-margin stretch-card" id="liste_cotiseur">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                        <h4 class="text-center text-uppercase"> Personnes ayant payé leur cotisation </h4>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>Membre</th>
                            <th>Date de paiement</th>
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
        <?php endif; ?>

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
                        <th>Email</th>
                        <th>Statut</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $invitations_envoyees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_envoyee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
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
    
    
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2/dist/bootstrap-confirmation.min.js"></script>
<script>
    $('[data-toggle=confirmation]').confirmation({
       rootSelector: '[data-toggle=confirmation]'
    });
</script>
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

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/tontine/details_tontine.blade.php ENDPATH**/ ?>