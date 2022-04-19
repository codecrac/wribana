
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Waribana</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/template_menbre/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/template_menbre/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="/template_menbre/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/template_menbre/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/assets/images/favicon-wari.ico"/>


    <style>
        input,textarea,select{
            border: 1px solid rgba(4,4,4,0.2) !important;
        }

        .clignote {
            animation: blinker 1s linear infinite;
        }

        @keyframes  blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

    <?php echo $__env->yieldContent('style_completmentaire'); ?>
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand brand-logo" href="<?php echo e(route('accueil')); ?>">
                    Waribana
                </a>
                <a class="navbar-brand brand-logo-mini" href="<?php echo e(route('accueil')); ?>">
                    <img src="/assets/images/logo-waribana.png" alt="logo"/>

                </a>
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-sort-variant"></span>
                </button>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <span class="nav-profile-name"> <?php echo e(Auth::user()->name); ?> </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                            <i class="mdi mdi-settings text-primary"></i>
                            Profil
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-logout text-primary"></i>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-white" type="submit">Deconnexion</button>
                            </form>
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">Tableau de bord</span>
                    </a>
                </li>
                <?php if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'administrateur_general' || auth()->user()->role == 'gestionnaire_de_tontine' ): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.les_tontines')); ?>">
                        <i class="mdi mdi-stack-exchange menu-icon"></i>
                        <span class="menu-title">Gestion Tontines</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'administrateur_general' || auth()->user()->role == 'gestionnaire_de_waricrowd' ): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.ajouter_categorie_waricrowd')); ?>">
                            <i class="mdi mdi-dns menu-icon"></i>
                            <span class="menu-title">Categorie Waricrowd</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.les_waricrowds')); ?>">
                            <i class="mdi mdi-database menu-icon"></i>
                            <span class="menu-title">Gestion Waricrowd</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                   aria-controls="ui-basic">
                    <i class="mdi mdi-history menu-icon"></i>
                    <span class="menu-title">Historique Transactions</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <?php if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'administrateur_general' || auth()->user()->role == 'gestionnaire_de_tontine' ): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.historique_transactions_tontine')); ?>"> Tontines  </a> </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'administrateur_general' || auth()->user()->role == 'gestionnaire_de_waricrowd' ): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.historique_transactions_waricrowd')); ?>"> Waricrowd </a></li>
                        <?php endif; ?>    
                    </ul>
                </div>
            </li>
             <?php if(auth()->user()->role == 'super_admin' || auth()->user()->role == 'administrateur_general' ): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.liste_menbres_inscrits')); ?>">
                        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                        <span class="menu-title">Membres Inscrits</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic-2" aria-expanded="false"
                       aria-controls="ui-basic">
                        <i class="mdi mdi-swap-horizontal menu-icon"></i>
                        <span class="menu-title">Versement et retraits</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic-2">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.historique_versements')); ?>"> Historique Versements  </a> </li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.historique_retraits')); ?>"> Historique Retraits </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.definir_contenu_notifications')); ?>">
                        <i class="mdi mdi-bell-ring-outline menu-icon"></i>
                        <span class="menu-title">Contenu Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.parametre')); ?>">
                        <i class="mdi mdi-settings menu-icon"></i>
                        <span class="menu-title">Frais de gestion</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.gestionnaire')); ?>">
                        <i class="mdi mdi-account-star menu-icon"></i>
                        <span class="menu-title">Gestionnaires</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.historique_profil')); ?>">
                        <i class="mdi mdi-history menu-icon"></i>
                        <span class="menu-title">Historique Profil Utilisateur</span>
                    </a>
                </li>
            <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('accueil')); ?>">
                        <i class="mdi mdi-home-outline menu-icon"></i>
                        <span class="menu-title">Retour à l'accueil</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Tout droits réservés</span>
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © WARIBANA 2021</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="/template_menbre/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="/template_menbre/vendors/chart.template_menbre/js/Chart.min.js"></script>
<script src="/template_menbre/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/template_menbre/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/template_menbre/js/off-canvas.js"></script>
<script src="/template_menbre/js/hoverable-collapse.js"></script>
<script src="/template_menbre/js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/template_menbre/js/dashboard.js"></script>
<script src="/template_menbre/js/data-table.js"></script>
<script src="/template_menbre/js/jquery.dataTables.js"></script>
<script src="/template_menbre/js/dataTables.bootstrap4.js"></script>
<!-- End custom js for this page-->
<script src="/template_menbre/js/jquery.cookie.js" type="text/javascript"></script>

<script>
    $(document).ready( function () {
        $('#datatable').DataTable({
              language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.4/i18n/fr_fr.json"
                }
        });
    } );
</script>

<?php echo $__env->yieldContent('script_completmentaire'); ?>

</body>

</html>

<?php /**PATH /home1/waribana/public_html/resources/views/administrateur/base_administrateur.blade.php ENDPATH**/ ?>