<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
?>




<?php $__env->startSection('style_completmentaire'); ?>
    <style>
        .marquer_presence{
            font-size: 18px;
            font-weight:bold;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <hr/>
        <h3 class="text-center"> Waribank </h3>
    <hr/>
        
    <?php echo Session::get('notification',''); ?>

    <?php echo $statut_transaction; ?>

    
    <?php if(isset($_GET['action'])): ?>
        <div class="row">
                    
                    <?php if($_GET['action']=='recharger'): ?>
                    
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header">
                                    <hr/>
                                    <h4 class="card-title text-center">Recharger mon compte</h4>
                                    <hr/>
                                </div>
                            <div class="card-body">
                           
                            <form method="post" action="<?php echo e(route('espace_menbre.rechargement_waribank')); ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="text-dark">Entrer le montant *</label>
                                         <input type="number" onkeypress="return onlyNumberKey(event)" name="montant_recharge" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="Entrer le montant" /> 
                                    </div>
                                    <div class="col-12 text-center">
                                        <br/>
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-success" > Recharger </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($_GET['action']=='transferer'): ?>
                    
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header">
                                <hr/>
                                <h4 class="card-title text-center">Transfert a un autre compte waribank</h4>
                                <hr/>
                            </div>
                    
                            <div class="card-body">
                               
                                <form method="post" action="<?php echo e(route('espace_menbre.confirmer_waribank')); ?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="text-dark">Entrer le numero du destinataire *</label>
                                            
                                            <div class="col-12">
                                                <label class="text-info">Mot de passe actuel *</label>
                                                <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                                <br/>
                                            </div>
            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label><small>prefixe</small></label>
                                                    
                                                    <select required class="form-control" name="prefixe">
                                                        <?php echo App\Http\Controllers\CountryPrefixController::listOptionChoisirPays(); ?>

                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>telephone</label>
                                                    <input type="number" onkeypress="return onlyNumberKey(event)" name="telephone" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="telephone" />
                                                </div>
                                            </div>
            
                                            <div class="col-12">
                                                <br/><br/>
                                                <label>Montant</label>
                                                <input type="number" onkeypress="return onlyNumberKey(event)" name="montant" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="montant" />
                                            </div>
                                             
                                        </div>
                                        <div class="col-12 text-center">
                                            <br/>
                                            <?php echo csrf_field(); ?>
                                            <button class="btn btn-success" > Transferer </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                    </div>
                    <?php endif; ?>
                
            
            <?php if($_GET['action']=='retirer'): ?>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <hr/>
                                <h4 class="card-title text-center"> MON COMPTE</h4>
                            <hr/>
                        </div>
                        <div class="card-body text-center">
                            <h3>Solde : <?php echo e(number_format($le_menbre->compte->solde,0,',',' ')); ?> <?php echo e($la_session['devise']); ?> <small style="font-size: 14px;text-decoration: underline"> <a href="#details">Details</a> </small> </h3>
                            <br/>
                            <hr/>
                                <h4 class="text-center">Retirer de l'argent</h4>
                            <hr/>
                            <form method="post" action="<?php echo e(route('espace_menbre.confirmer_retrait_dargent')); ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="text-info">Mot de passe actuel *</label>
                                        <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                        <br/>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-dark">Entrer le montant *</label>
                                         <input type="number" onkeypress="return onlyNumberKey(event)" name="montant" required class="form-control" type="form-control" style="border: 1px solid black" placeholder="Entrer le montant" /> 
                                        <!--<input type="number" onkeypress="return onlyNumberKey(event)" name="montant" required class="form-control" type="form-control" style="border: 1px solid black" placeholder="Entrer le montant" />-->
                                    </div>
                                    <div class="col-12 text-center">
                                        <br/>
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-success" > Retirer </button>
                                    </div>
                                </div>
                            </form>
        
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="row" id="details">
    
            <?php if($_GET['action'] == 'h_rechargement' ): ?>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <hr/>
                            <h4 class="card-title text-center text-uppercase"> Historique des rechargements  </h4>
                            <hr/>
                        </div>
                        <div class="card-body text-center table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <th>Date</th>
                                    <th>Solde avant</th>
                                    <th>Montant</th>
                                    <th>Solde apres</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $le_menbre->historique_rechargement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_rechargement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(date("d/m/Y H:m",strtotime($item_rechargement['created_at']))); ?></td>
                                            <td><?php echo e(number_format($item_rechargement->solde_avant,0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                            <td><?php echo e(number_format($item_rechargement['montant'],0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                            <td><?php echo e(number_format($item_rechargement->solde_apres,0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
    
            <?php if($_GET['action'] == 'h_virement' ): ?>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                        <h4 class="card-title text-center text-uppercase"> Historique des virements de tontine   </h4>
                        <hr/>
                    </div>
                    <div class="card-body text-center table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>Date</th>
                                <th>Tontine</th>
                                <th>Montant</th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $le_menbre->historique_virement_tontine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_virement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(date("d/m/Y H:m",strtotime($item_virement['created_at']))); ?></td>
                                        <td><?php echo e($item_virement->tontine->titre); ?></td>
                                        <td><?php echo e(number_format($item_virement['montant'],0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    
        <?php if($_GET['action'] == 'h_t_recus' ): ?>
            <div class="row" id="historie_retraits">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <hr/>
                            <h4 class="card-title text-center text-uppercase"> Historique transfert recus   </h4>
                            <hr/>
                        </div>
                        <div class="card-body text-center table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <th>Date</th>
                                    <th>Expediteur</th>
                                    <th>Montant <br/> (monaie expediteur) </th>
                                    <th>Montant equivatent <br/> ( monaie destinataire) </th>
                                    <th>Destinaire</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $le_menbre->historique_transfert_entrant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_entrant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(date("d/m/Y H:m",strtotime($item_entrant['created_at']))); ?></td>
                                            <td><?php echo e($item_entrant->expediteur->nom_complet); ?></td>
                                            <td><?php echo e(number_format($item_entrant->montant_monaie_expediteur,0,',',' ')); ?> <?php echo e($item_entrant->expediteur->devise_choisie->monaie); ?></td>
                                            <td><?php echo e(number_format($item_entrant->montant_equivalent_destinataire,0,',',' ')); ?> <?php echo e($item_entrant->destinataire->devise_choisie->monaie); ?></td>
                                            <td>Vous</td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if($_GET['action'] == 'h_t_effectue' ): ?>
        <div class="row" id="historie_retraits">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                        <h4 class="card-title text-center text-uppercase"> Historique transfert effectu??s </h4>
                        <hr/>
                    </div>
                    <div class="card-body text-center table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>Date</th>
                                <th>Expediteur</th>
                                <th>Montant <br/> (monaie expediteur) </th>
                                <th>Montant <br/> ( monaie destinataire) </th>
                                <th>[ Telephone ]</th>
                                <th>Destinaire</th>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $le_menbre->historique_tranfert_sortant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_sortant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(date("d/m/Y H:m",strtotime($item_sortant['created_at']))); ?></td>
                                        <td>Vous</td>
                                        <td><?php echo e(number_format($item_sortant->montant_monaie_expediteur,0,',',' ')); ?> <?php echo e($item_sortant->expediteur->devise_choisie->monaie); ?></td>
                                        <td><?php echo e(number_format($item_sortant->montant_equivalent_destinataire,0,',',' ')); ?> <?php echo e($item_sortant->destinataire->devise_choisie->monaie); ?></td>
                                        <td><?php echo e($item_sortant->telephone); ?></td>
                                        <td><?php echo e($item_sortant->destinataire->nom_complet); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    
        <?php if($_GET['action'] == 'h_retrait' ): ?>
            <div class="row" id="historie_retraits">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <hr/>
                            <h4 class="card-title text-center text-uppercase"> Historique des mes retraits </h4>
                            <hr/>
                        </div>
                        <div class="card-body text-center table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <th>Date</th>
                                    <th>Solde Avant</th>
                                    <th>Montant Retir??</th>
                                    <th>Solde Apres</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $le_menbre->historique_retraits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_retrait): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(date("d/m/Y H:m",strtotime($item_retrait['created_at']))); ?></td>
                                            <td><?php echo e(number_format($item_retrait->solde_avant,0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                            <td><?php echo e(number_format($item_retrait->montant_retirer,0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                            <td><?php echo e(number_format($item_retrait->solde_apres,0,',',' ')); ?> <?php echo e($le_menbre->devise_choisie->monaie); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <br/>
        <div class="row">
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=recharger">Recharger mon compte</a>
            </div>
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=retirer"> Retirer de l???argent </a>
            </div>
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=transferer">Transf??rer ?? un compte WARIBANK</a>
            </div>
            
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=h_rechargement">Mes rechargements</a>
            </div>
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=h_virement">Virement de tontine</a>
            </div>
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=h_t_recus">Transferts recus</a>
            </div>
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=h_t_effectue">Tranferts effectu??s</a>
            </div>
            <div class='col-md-4 mb-3'>
                <a class="btn btn-primary" href="<?php echo e(route('espace_menbre.index_waribank',[$la_session['id']] )); ?>?action=h_retrait">Mes retraits</a>
            </div>
        </div>
    <?php endif; ?>

<script>
    setTimeout(function(){
        document.getElementById("close_on_dashboard_3").click();
    },600);
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

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/profil/waribank.blade.php ENDPATH**/ ?>