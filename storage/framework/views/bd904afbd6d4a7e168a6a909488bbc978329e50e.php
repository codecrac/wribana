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
    <?php echo Session::get('notification',''); ?>


    <div class="row">
    <?php if(isset($_GET['action'])): ?>
            <?php if($_GET['action'] == 'profil' ): ?>
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                        <h4 class="card-title text-center">Modifier mon profil</h4>
                        <hr/>
                    </div>
                
                    <div class="card-body">
                        <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_profil',[$le_menbre->id])); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group"  >
                                <label class="text-info">Mot de passe actuel *</label>
                                <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                <br/>
                            </div>
    
                            <div class="form-group">
                                <label>Nom complet *</label>
                                <input required class="form-control" value="<?php echo e($le_menbre->nom_complet); ?>" placeholder="LADDE Yves" type="text" name="nom_complet" />
                                <br/>
                            </div>
    
                            <div class="form-group">
                                <label>Email*</label>
                                <input class="form-control" value="<?php echo e($le_menbre->email); ?>" placeholder="monadresse@gmail.com" type="text" name="email" />
                                <br/>
                            </div>
                    
                            <input  class="form-control" placeholder="Mot de passe" type="hidden" name="mot_de_passe" />
                            <input  class="form-control" placeholder="Confirmer le mot de passe" type="hidden" name="confirmer_mot_de_passe" />
                    
    
                            <h3 class="text-center">
                                <button class="btn btn-primary text-white" type="submit">
                                    Enregistrer les modification <i class="far fa-arrow-right"></i>
                                </button>
                            </h3>
    
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if($_GET['action'] == 'mdp' ): ?>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        
                            <form class="forms-sample" method="post" action="<?php echo e(route('espace_menbre.post_profil',[$le_menbre->id])); ?>">
        
                                <div class="card-header">
                                    <hr/>
                                    <h4 class="card-title text-center">Modifier mon mot de passe</h4>
                                    <hr/>
                                </div>
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="text-info">Mot de passe actuel *</label>
                                    <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                </div>
        
                                <div class="form-group">
                                    <input required class="form-control" value="<?php echo e($le_menbre->nom_complet); ?>" placeholder="LADDE Yves" type="hidden" name="nom_complet" />
                                    <input class="form-control" 
                                        value="<?php echo e($le_menbre->email); ?>" 
                                        placeholder="monadresse@gmail.com" 
                                        type="hidden" 
                                        name="email" />
                                    
                                <div class="form-group">
                                    <label>Nouveau Mot de passe * </label>
                                    <br/>
                                    <small>
                                    <span class="text-danger">-Le de mot de passe doit être composé de :</span><br/>
                                    <span class="text-danger">-Au minimum 8 caractere</span><br/>
                                    <span class="text-danger">-Composer de chiffre et de lettres</span>
                                    </small>
                                    <br/>
                                    <input  class="form-control" 
                                        placeholder="Mot de passe" 
                                        type="password" 
                                        name="mot_de_passe" 
                                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                                        title="Ex : motDePass3"
                                        required />
                                </div>
                                <div class="form-group">
                                    <label>Confirmation du mot de passe* </label>
                                    <input  class="form-control" 
                                        placeholder="Confirmer le mot de passe" 
                                        type="password" 
                                        name="confirmer_mot_de_passe" 
                                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                                        title="Ex : motDePass3" required/>
                                    <br/>
                                </div>
                                <h3 class="text-center">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-primary text-white" type="submit">
                                        Enregistrer les modification <i class="far fa-arrow-right"></i>
                                    </button>
                                </h3>
        
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            <?php endif; ?>
    
            <?php if($_GET['action'] == 'telephone' ): ?>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body text-center">
                           
                            <div class="card-header">
                                <hr/>
                                    <h4 class="text-center">Changer de numero de telephone</h4>
                                <hr/>
                            </div>
                            <p class="card-description">
                                <br/>
                                Nous allons vous envoyer un code de confirmation par sms, utiliser un numero valide,
                                <span class="text-warning">ajouter le prefixe(225,33...) avant le numero</span>.
                                <br/>Exemple : 225 05 05 05 05 05 ou 33 1 23 45 67 89
                            </p>
                            <form method="post" action="<?php echo e(route('espace_menbre.modifier_telephone_compte')); ?>">
                                
                                <div class="form-group"  >
                                    <label class="text-info">Mot de passe actuel *</label>
                                    <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                    <br/>
                                </div>
                                
                                <div class="form-group">
                                    <label>Telephone *</label>
                                    <input required class="form-control" value="<?php echo e($le_menbre->telephone); ?>"
                                           placeholder="2250708080809" type="number" name="nouveau_telephone" />
                                </div>
                                <div class="col-12 text-center">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-success" > Confirmer via sms </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="row text-center">
                <div class='col-12 mb-3'>
                    <hr/>
                        <h3 class="text-center"> Mon Profil </h3>
                    <hr/>
                </div>
                
                <div class='col-md-4'>
                    <a class='btn btn-primary mb-3' href="<?php echo e(route('espace_menbre.profil',[$la_session['id']] )); ?>?action=profil">
                        Modifier mon profil
                    </a>
                </div>
                <div class='col-md-4'>
                    <a class='btn btn-primary mb-3' href="<?php echo e(route('espace_menbre.profil',[$la_session['id']] )); ?>?action=telephone">
                        Changer mon numéro
                    </a>
                </div>
                <div class='col-md-4'>
                    <a class='btn btn-primary mb-3' href="<?php echo e(route('espace_menbre.profil',[$la_session['id']] )); ?>?action=mdp">
                        Modifier mon mot de passe
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>
    </div>
    
<script>
    setTimeout(function(){
        document.getElementById("close_on_dashboard_4").click();
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

<?php echo $__env->make('espace_menbre.base_espace_menbre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/espace_menbre/profil/profil.blade.php ENDPATH**/ ?>