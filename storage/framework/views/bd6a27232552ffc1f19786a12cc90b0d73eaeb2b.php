<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $est_connecter  = false;
    if($la_session !=null){
        $est_connecter =true;
        $id_menbre_connecter  = $la_session['id'];
    }
    
    
    $statut_transaction = null;
    if(isset($_GET['statut_transaction'])){
        $statut_transaction = $_GET['statut_transaction'];
    }

?>




<?php $__env->startSection('content'); ?>

    <!--====== Project Details Area Start ======-->
    <section class="project-details-area section-gap-extra-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="project-thumb mb-md-50">
                        <?php if($le_crowd->lien_pitch_video!=null): ?>
                            <iframe width="100%" height="400px" src="<?php echo e($le_crowd->lien_pitch_video); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php else: ?>
                            <img src="<?php echo e(url($le_crowd->image_illustration)); ?>" style="max-width: 100%" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    
                     <?php echo Session::get('notification',''); ?>

                    
                    <?php if(isset($_GET['probleme_lien_paiement'])): ?>
                            <div class='alert alert-danger text-center'><?php echo e($_GET['probleme_lien_paiement']); ?></div>
                    <?php endif; ?>
                    <?php if($statut_transaction !=null): ?>
                        <?php if($statut_transaction == 'ACCEPTED'): ?>
                            <div class='alert alert-success text-center'>Votre paiement a bien été effectué</div>
                        <?php else: ?>
                            <div class='alert alert-danger text-center'>Echec du paiement</div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <br/>
                    <div class="project-summery">
                        <a href="<?php echo e(route('decouvrir_projets')); ?>" class="category">Retour</a>
                        <h3 class="project-title">
                            <?php echo e($le_crowd->titre); ?>

                        </h3>
                        <?php echo Session::get('notification',''); ?>

                        <div class="meta">
                            <div class="author">
                                de :
                                <a href="#"><?php echo e($le_crowd->createur->nom_complet); ?></a>
                            </div>
                            <a href="#" class="date"><i class="far fa-calendar-alt"></i><?php echo e(date('d-m/Y',strtotime($le_crowd->created_at))); ?></a>
                        </div>
                        <div class="project-funding-info">
                            <div class="info-box" style="width: 185px">
                                <span><?php echo e(number_format($le_crowd->montant_objectif,0,',',' ')); ?>  <?php echo e($le_crowd->createur->devise_choisie->symbole); ?></span>
                                <span class="info-title">Objectif</span>
                            </div>
                            <div class="info-box" style="width: 185px">
                                <span><?php echo e(number_format($le_crowd->caisse->montant,0,',',' ')); ?>  <?php echo e($le_crowd->createur->devise_choisie->symbole); ?></span>
                                <span class="info-title">Montant atteinds</span>
                            </div>
                        </div>
                        <div class="project-raised clearfix">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="raised-label">
                                    
                                </div>
                                <?php
                                    $pourcentage = round($le_crowd->caisse->montant *100 / $le_crowd->caisse->montant_objectif,2);
                                ?>
                                <div class="percent-raised"><?php echo e($pourcentage); ?>%</div>
                            </div>
                            <div class="stats-bar" data-value="<?php echo e($pourcentage); ?>">
                                <div class="bar-line"></div>
                            </div>
                        </div>
                        <div class="project-form">
                            
                            <?php if(isset($_GET['probleme_lien_paiement'])): ?>
                                    <div class='alert alert-danger text-center'><?php echo e($_GET['probleme_lien_paiement']); ?></div>
                            <?php endif; ?>
                            
                            <?php if($statut_transaction !=null): ?>
                                <?php if($statut_transaction == 'ACCEPTED'): ?>
                                    <div class='alert alert-success text-center'>Votre paiement a bien été effectué</div>
                                <?php else: ?>
                                    <div class='alert alert-danger text-center'>Echec du paiement</div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if($est_connecter): ?>
                        <form method="post" action="<?php echo e(route('espace_menbre.confirmation_soutien_waricrowd')); ?>">
                                    <div class="form-group">

                                        <input class="form-control" type="hidden" name="id_crowd" value='<?php echo e($le_crowd->id); ?>' required/>
                                        <b>(montant en <b class='text-uppercase text-danger' ><?php echo e($le_crowd->createur->devise_choisie->monaie); ?></b>)</b>
                                        <input class="form-control" type="number" onkeypress="return onlyNumberKey(event)" name="montant_soutien" placeholder="150000" min="1" required/>
                                        <h3 class="text-center">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="main-btn"> Soutenir le projet  <i class="far fa-arrow-right"></i></button>
                                        </h3>
                                    </div>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('connexion_menbre')); ?>" type="submit" class="main-btn"> Connectez vous pour soutenir un projet  <i class="far fa-arrow-right"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="project-details-tab">

                        <div class="tab-content" id="projectTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="description-content">
                                            <h4 class="description-title"><?php echo e($le_crowd->titre); ?></h4>

                                            <hr/>
                                                <?php echo e($le_crowd->description_courte); ?>

                                            <hr/>

                                            <?php echo e($le_crowd->description_complete); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-10">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="update" role="tabpanel">
                                Update
                            </div>
                            <div class="tab-pane fade" id="bascker-list" role="tabpanel">
                                Bascker List
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                Reviews
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== Project Details Area End ======-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('base_front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/details_projet.blade.php ENDPATH**/ ?>