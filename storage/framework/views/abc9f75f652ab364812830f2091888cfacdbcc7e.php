<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center">CREER UN GESTIONNAIRE</h4>
                    <p class="card-description">
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Type de gestionnaire</label>
                            <select required  class="form-control" name="role"
                                   placeholder="Categorie Elegante">
                                <option value='gestionnaire_de_tontine' >Gestionnaire de Tontine</option>
                                <option value='gestionnaire_de_waricrowd' >Gestionnaire de Waricrowd</option>
                                <option value='administrateur_general' >Administrateur General</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputUsername1">Nom complet</label>
                            <input required type="text" class="form-control" name="nom_complet"
                                   >
                        </div>
                        <br/>
                        
                        <div class="form-group">
                            <label for="exampleInputUsername1">Email</label>
                            <input required type="text" class="form-control" name="email"
                                   >
                        </div>
                        <p class="text-danger text-center" ><b>le mot de passe par defaut est : waribana</b> </p>
                        <br/>
                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary mr-2">Creer le gestionnaire</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-1 col-md-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center text-uppercase">Liste des GESTIONNAIRES</h4>
                    <p class="card-description">
                    </p>
                    <table class="table table-striped">
                        <thead>
                        <th>Titre</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $liste_gestionnaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($item->name); ?>

                                </td>
                                <td>
                                    <?php echo e($item->email); ?>

                                </td>
                                <td>
                                    <?php echo e(str_replace('_',' ',$item->role)); ?>

                                </td>
                                <td>
                                    <button type="button"
                                            onclick="deplier_garde_fou('garde_fou_recues_<?php echo e($item['id']); ?>')"
                                            class="badge badge-info">Agir
                                    </button>
                                    <div class="row garde_fou" id="garde_fou_recues_<?php echo e($item['id']); ?>">
                                        <form class="forms-sample row" method="post"
                                              action="<?php echo e(route('admin.modifier_gestionnaire',[$item['id']])); ?>">
                                            
                                            <div class="form-group col-12">
                                                <h6 class="text-center" for="exampleInputUsername1">Habilitation</h6>
                                                    <select class='form-control' name='role'>
                                                        <option value='<?php echo e($item->role); ?>' > <?php echo e(str_replace('_',' ',$item->role)); ?> </option>
                                                        
                                                        <option value='gestionnaire_de_tontine' >Gestionnaire de Tontine</option>
                                                        <option value='gestionnaire_de_waricrowd' >Gestionnaire de Waricrowd</option>
                                                        <option value='administrateur_general' >Administrateur General</option>
                                                    </select>
                                               
                                               <br/>
                                                <h6 class="text-center" for="exampleInputUsername1">Etat du compte</h6>
                                                
                                                    <select class='form-control' name='etat'>
                                                        <option value='<?php echo e($item->etat); ?>' > <?php echo e(str_replace('_',' ',$item->etat)); ?> </option>
                                                        
                                                        <option value='actif' >Actif</option>
                                                        <option value='suspendu' >Suspendu</option>
                                                    </select>
                                                
                                                <br/>
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('put'); ?>
                                                <button type="submit" class="btn btn-warning mr-2">Enregistrer</button>
                                                     
                                            </div>
                                            
                                        </form>
                                        <div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script_completmentaire'); ?>
    <script>
        window.onload = function () {
            fermer_tous_les_garde_fou();
        };

        function deplier_garde_fou(id) {
            var le_garde_fou = document.getElementById(id);
            if (le_garde_fou.style.display == 'none') {
                le_garde_fou.style.display = '';
            } else {
                le_garde_fou.style.display = 'none';
            }

        }

        function fermer_tous_les_garde_fou() {
            var tous_les_garde_fou = document.querySelectorAll('.garde_fou');
            for (var i = 0; i < tous_les_garde_fou.length; i++) {
                tous_les_garde_fou[i].style.display = "none";
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/gestionnaires/index.blade.php ENDPATH**/ ?>