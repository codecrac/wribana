@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp


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
        input,textarea{
            border: 1px solid rgba(4,4,4,0.2) !important;
        }

        .clignote {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

    @yield('style_completmentaire')
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand brand-logo" href="{{route('accueil')}}">
                    Waribana
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{route('accueil')}}">
                    <img src="/assets/images/logo-waribana.png" alt="logo"/>
{{--                    Waribana--}}
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
                        <span class="nav-profile-name"> {{$la_session['nom_complet']}} ({{$la_session['devise']}}) </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{route('espace_menbre.profil',[$la_session['id']] ) }}">
                            <i class="mdi mdi-settings text-primary"></i>
                            Profil
                        </a>
                        <a class="dropdown-item" href="{{route('espace_menbre.deconnexion')}}">
                            <i class="mdi mdi-logout text-primary"></i>
                            Deconnexion
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
                    <a class="nav-link" href="{{route('espace_menbre.accueil')}}">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                       aria-controls="ui-basic"
                       id="close_on_dashboard_1" 
                       >
                        <i class="mdi mdi-stack-exchange menu-icon"></i>
                        <span class="menu-title">Tontines</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="{{route('espace_menbre.ajouter_tontine')}}">Creer une Tontine</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('espace_menbre.liste_tontine')}}"> Mes Tontines  </a> </li>
                            <li class="nav-item"><a class="nav-link" href="{{route('espace_menbre.invitations')}}">Invitations</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth"
                     aria-expanded="false" aria-controls="auth"
                      id="close_on_dashboard_2"
                     >
                        <i class="mdi mdi-account-multiple menu-icon"></i>
                            <span class="menu-title">Waricrowd</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="{{route('espace_menbre.creer_un_waricrowd')}}">Creer un Waricrowd</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route('espace_menbre.liste_waricrowd')}}"> Mes Waricrowds  </a> </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('espace_menbre.projets_soutenus')}}">
                                    <span class="menu-title">Projets Soutenus</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('decouvrir_projets')}}">
                                    <span class="menu-title">Decouvrir les projets</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('espace_menbre.profil',[$la_session['id']] ) }}">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">Mon Profil</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('espace_menbre.profil',[$la_session['id']] ) }}">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">Waribank </span>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{route('espace_menbre.deconnexion') }}">
                        <i class="mdi mdi-logout menu-icon"></i>
                        <span class="menu-title">Deconnexion</span>
                    </a>
                </li> --}}

            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Tout droits réservés</span>
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © akassoh.ci 2021</span>
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




{{--<script src="./js/app.js"></script>--}}
@yield('script_completmentaire')

</body>

</html>

