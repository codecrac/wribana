<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2>Bienvenue <small><?php echo e(Auth::user()->name); ?>.</small></h2>
                    </div>
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body dashboard-tabs p-0">
                    <ul class="nav nav-tabs px-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#"
                               role="tab" aria-controls="overview" aria-selected="true">#</a>
                        </li>
                    </ul>
                    <div class="tab-content py-0 px-0">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="d-flex flex-wrap justify-content-xl-between">
                                <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="<?php echo e(route('admin.les_tontines')); ?>"> Tontines </a> </small>
                                        <div class="dropdown">
                                            <h5 class="mb-0 d-inline-block"><?php echo e($nombre_tontine); ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="<?php echo e(route('admin.les_waricrowds')); ?>"> Waricrowds </a> </small>
                                        <h5 class="mr-2 mb-0"><?php echo e($nombre_waricrowd); ?></h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="<?php echo e(route('admin.les_waricrowds',['attente'])); ?>"> Waricrowds en attente </a> </small>
                                        <h5 class="mr-2 mb-0"><?php echo e($nombre_waricrowd_attente); ?></h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="<?php echo e(route('admin.liste_menbres_inscrits')); ?>">Utilisateurs Inscrits</a></small>
                                        <h5 class="mr-2 mb-0"><?php echo e($nombre_menbre); ?></h5>
                                    </div>
                                </div>
                                <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">

                                    <div class="d-flex flex-column justify-content-around">
                                        <h6>Utilisateurs</h6>
                                        <small class="mb-1 text-muted"> <a href="<?php echo e(route('admin.liste_menbres_inscrits',['suspendu'])); ?>"> Suspendu.e.s </a> </small>
                                        <h5 class="mr-2 mb-0"> <?php echo e($nombre_menbre_suspendu); ?> </h5>
                                        
                                        <small class="mb-1 text-muted"> <a href="<?php echo e(route('admin.liste_menbres_inscrits',['banni'])); ?>">Banni.e.s </a> </small>
                                        <h5 class="mr-2 mb-0"> <?php echo e($nombre_menbre_banni); ?> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4>Statistiques de frequentation </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <th>Période</th>
                            <th>Visite(s)</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $statistique_frequentation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item['mois_annee']); ?></td>
                                <td><?php echo e($item['visiteur']); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <img src="/assets/images/logo-waribana.png" />
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

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/dashboard.blade.php ENDPATH**/ ?>