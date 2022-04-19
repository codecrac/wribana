<?php $__env->startSection('content'); ?>

    <div class="col-auto">
        <div class="common-heading mb-30">
							<span class="tagline">
								<!--<i class="fas fa-plus"></i> +-->
								<span class="heading-shadow-text"><!--Soutenez ou faites financer votre projet --></span>
							</span>
            <h2 class="title text-center">WARICROWDS</h2>
        </div>
    </div>

    <div class="container">
        <form>
            <div class="row">
                <div class="col-md-8">
                    <div class='row'>
                        <div class="col-md-2 pt-2">
                            <h4>Catégorie</h4>
                        </div>
                        <div class='col-md-4'>
                            <select name="id_categorie">
                                <?php if($la_categorie !=null): ?>
                                    <option value="<?php echo e($la_categorie->id); ?>"><?php echo e($la_categorie->titre); ?></option>
                                <?php else: ?>
                                    <option value>(selectionner)</option>
                                <?php endif; ?>
                                <option value="0">Toutes les categories</option>
                                <?php $__currentLoopData = $liste_categorie; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item['id']); ?>"><?php echo e($item->titre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class='col-md-1 text-left pt-2' >
                            <button type="submit" class="btn btn-dark">Trier</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <br/><br/>
    <!--====== Project Area Start ======-->
    <section class="project-section section-gap-extra-bottom primary-soft-bg">
        <div class="container">
            <div class="row project-items justify-content-center project-style-one">

                <?php if(sizeof($liste_waricrowd)>0): ?>
                    <?php $__currentLoopData = $liste_waricrowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_crowd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="project-item mb-30">
                            <div class="thumb"
                                 style="background-image: url('/<?php echo e($item_crowd['image_illustration']); ?>');"></div>
                            <div class="content">
                                <div class="cats">
                                    <a href="?id_categorie=<?php echo e($item_crowd->categorie->id); ?>"><?php echo e($item_crowd->categorie->titre); ?></a>
                                </div>
                                
                                <h5>
                                    <a href="<?php echo e(route('details_projet',[$item_crowd->id])); ?>"><?php echo e(Str::limit($item_crowd['titre'], $limit = 120, $end = '...')); ?></a>
                                </h5>
                                <div class="project-stats">
                                    <?php
                                        $pourcentage = round($item_crowd->caisse->montant *100 / $item_crowd->caisse->montant_objectif,2);
                                    ?>
                                    <?php if($pourcentage > 0): ?>
                                        <div class="stats-value">
                                            <span class="value-title">Montant Objectif : <span class="value"> <?php echo e(number_format($item_crowd->caisse->montant_objectif,0,',',' ')); ?> <?php echo e($item_crowd->createur->devise_choisie->monaie); ?> </span></span>
                                            <span class="stats-percentage"><?php echo e($pourcentage); ?>%</span>
                                        </div>
                                        <div class="stats-bar" data-value="<?php echo e($pourcentage); ?>">
                                            <div class="bar-line"></div>
                                        </div>
                                    <?php else: ?>
                                        <!-- div pour maintenir l'alignement -->
                                        <div style="height: 40px">
                                            <?php echo e(Str::limit($item_crowd->description_courte,80)); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                <span> porteur : <?php echo e($item_crowd->createur->nom_complet); ?> </span>
                                <br/>
                                <span class="date"><i class="far fa-calendar-alt"></i> <?php echo e(date('d-m-Y',strtotime($item_crowd['created_at']))); ?></span>

                                <h3 class="text-center">
                                    <a class="btn btn-dark" href="<?php echo e(route('details_projet',[$item_crowd->id])); ?>">Decouvrir
                                        le projet</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <hr/>
                        <a  href="<?php echo e(route("espace_menbre.creer_un_waricrowd")); ?>"
                            class="main-btn nav-btn d-none d-sm-inline-block">
                            Soyez le premier a lancé un waricrowd.
                            <i class="far fa-arrow-right"></i>
                        </a>
                    <hr/>
                <?php endif; ?>

                
            </div>
        </div>
    </section>
    <!--====== Project Area End ======-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('base_front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/liste_waricrowd.blade.php ENDPATH**/ ?>