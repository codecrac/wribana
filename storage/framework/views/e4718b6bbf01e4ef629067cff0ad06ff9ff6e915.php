<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo Session::get('notification',''); ?>


                    <h4 class="card-title text-center">Creer une categorie de waricrowd</h4>
                    <p class="card-description">
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre</label>
                            <input required type="text" class="form-control" name="titre"
                                   placeholder="Categorie Elegante">
                        </div>
                        <h3 class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary mr-2">Creer la categorie</button>
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


                    <h4 class="card-title text-center">Liste des categories de waricrowd</h4>
                    <p class="card-description">
                    </p>
                    <table class="table table-striped">
                        <thead>
                        <th>titre</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $liste_categorie_waricrowd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($item->titre); ?>

                                </td>
                                <td>
                                    <button type="button"
                                            onclick="deplier_garde_fou('garde_fou_recues_<?php echo e($item['id']); ?>')"
                                            class="badge badge-info">Agir
                                    </button>
                                    <div class="row garde_fou" id="garde_fou_recues_<?php echo e($item['id']); ?>">
                                        <form class="forms-sample row" method="post"
                                              action="<?php echo e(route('admin.modifier_categorie_waricrowd',[$item['id']])); ?>">
                                            <div class="form-group col-12">

                                                <h6 class="text-center" for="exampleInputUsername1">Modifer la
                                                    categorie</h6>
                                                <input required type="text" class="form-control" name="titre"
                                                       value="<?php echo e($item['titre']); ?>" placeholder="Categorie Elegante">
                                            </div>
                                            
                                            <?php if(auth()->user()->role == 'super_admin' ): ?>
                                                <div class="text-center col-12">
                                                    <?php echo method_field('put'); ?>
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-warning mr-2">OK</button>
                                                    <br/><br/>
                                                    <a href="<?php echo e(route('admin.effacer_categorie_waricrowd',[$item->id])); ?>"
                                                       class="btn btn-danger">Supprimer</a>
                                                </div>
                                            <?php endif; ?>
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

<?php echo $__env->make('administrateur.base_administrateur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/administrateur/waricrowds/categories/index.blade.php ENDPATH**/ ?>