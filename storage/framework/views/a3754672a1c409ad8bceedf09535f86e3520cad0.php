<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $est_connecter  = false;
    if($la_session !=null){
        $est_connecter =true;
        $id_menbre_connecter  = $la_session['id'];
    }
?>

<!DOCTYPE html>
<html lang="fr">

<!--    dev by : yves ladde | http://yvesladde.straton-system.com/     -->
<!--    dev by : yves ladde | http://yvesladde.straton-system.com/     -->
<!--    dev by : yves ladde | http://yvesladde.straton-system.com/     -->

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="language" content="fr">
    <meta http-equiv="content-language" content="fr">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--====== Title ======-->
    <title> Waribana </title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/assets/images/logo-waribana.ico" type="img/ico" />
    <!--====== Animate Css ======-->
    <link rel="stylesheet" href="/template/assets/css/animate.min.css">
    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="/template/assets/css/bootstrap.min.css" />
    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="/template/assets/css/font-awesome.min.css" />
    <!--====== Flaticon css ======-->
    <link rel="stylesheet" href="/template/assets/css/flaticon.css" />
    <!--====== Slick Css ======-->
    <link rel="stylesheet" href="/template/assets/css/slick.min.css" />
    <!--====== Lity Css ======-->
    <link rel="stylesheet" href="/template/assets/css/lity.min.css" />
    <!--====== Main css ======-->
    <link rel="stylesheet" href="/template/assets/css/main.css" />
    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="/template/assets/css/responsive.css" />

    <style>
        @media  only screen and (max-width: 600px) {
          .hide_on_mobile {
            display :none;
          }
        }
    </style>
    <?php echo $__env->yieldContent('style_complementaire'); ?>
</head>

<body>

<!--====== Preloader ======-->
<div id="preloader">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <!--<div class="object" id="object_one"></div>-->
            <!--<div class="object" id="object_two"></div>-->
            <!--<div class="object" id="object_three"></div>-->
            <!--<div class="object" id="object_four"></div>-->
            <img src="https://waribana.net/assets/images/logo-waribana.png" />
        </div>
    </div>
</div>


<!--====== Header Start ======-->
<?php if(isset($is_home)): ?>
    <header class="site-header sticky-header transparent-header topbar-transparent">
<?php else: ?>
    <header class="site-header sticky-header">
<?php endif; ?>
    <div class="header-topbar d-none d-sm-block">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <ul class="contact-info">
                        <li><a href="#"><i class="far fa-envelope"></i> <span class="__cf_email__" > info@waribana.ci </span></a></li>
                        <li><a href="#"><i class="far fa-map-marker-alt"></i> Cocody, Riviera 3 Sideci</a></li>
                    </ul>
                </div>
                <div class="col-auto d-none d-md-block">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-wrapper">
        <div class="container">
            <div class="navbar-inner">
                <div class="site-logo">
                    <a href="<?php echo e(route("accueil")); ?>"><img src="/assets/images/logo-waribana.png" style="max-height: 40px;" alt="Waribana"></a>
                </div>
                <div class="nav-menu">
                    <ul>
                        <li class="<?php echo e(isset($is_home) ? "current" : ""); ?>">
                            <a href="<?php echo e(route('accueil')); ?>">Accueil</a>
                        </li>
                        <li class="<?php echo e(isset($is_apropos) ? "current" : ""); ?>">
                            <a href="<?php echo e(route("apropos")); ?>">Qui sommes nous</a>
                        </li>
                        <li class="<?php echo e(isset($is_comment_ca_marche) ? "current" : ""); ?>">
                            <a href="<?php echo e(route("comment_ca_marche")); ?>">Comment ça marche</a>
                        </li>
                        <li class="<?php echo e(isset($is_decouvrir_projets) ? "current" : ""); ?>">
                            <a href="<?php echo e(route("decouvrir_projets")); ?>">Decouvrir les projets</a>
                        </li>

                        <li class="<?php echo e(isset($is_faq) ? "current" : ""); ?>">
                            <a href="<?php echo e(route("faq")); ?>">FAQ</a>
                        </li>
                        
                        <li class="<?php echo e(isset($is_contact) ? "current" : ""); ?>">
                            <a href="<?php echo e(route("contact")); ?>">Contact</a>
                        </li>

                        <?php if(!$est_connecter): ?>
                            <li>
                                <a href="<?php echo e(route("inscription_menbre")); ?>">S'inscrire</a>
                            </li>
                            <li>
                                <a href="<?php echo e(route("connexion_menbre")); ?>">Se connecter</a>
                            </li>
                        <?php else: ?>
                            <li class="<?php echo e(isset($is_apropos) ? "current" : ""); ?>">
                                <a href="<?php echo e(route("espace_menbre.accueil")); ?>">Mon compte</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                 <div class="navbar-extra d-flex align-items-center">
                     
                    <a href="#" class="nav-toggler">
                        <span></span>
                    </a>
                    
                </div> 
            </div>
        </div>
    </div>
    <div class="mobile-menu-panel">
        <div class="panel-logo">
            <a href="<?php echo e(route("accueil")); ?>"><img src="/assets/images/logo-waribana.png" style="max-height: 40px;" alt="Waribana"></a>
        </div>
        <ul class="panel-menu">
            <li class="<?php echo e(isset($is_home) ? "current" : ""); ?>">
                <a href="<?php echo e(route('accueil')); ?>">Accueil</a>
            </li>
            <li class="<?php echo e(isset($is_apropos) ? "current" : ""); ?>">
                <a href="<?php echo e(route("apropos")); ?>">Qui sommes nous</a>
            </li>
            <li class="<?php echo e(isset($is_comment_ca_marche) ? "current" : ""); ?>">
                <a href="<?php echo e(route("comment_ca_marche")); ?>">Comment ça marche</a>
            </li>
            <li class="<?php echo e(isset($is_decouvrir_projets) ? "current" : ""); ?>">
                <a href="<?php echo e(route("decouvrir_projets")); ?>">Decouvrir les projets</a>
            </li>

            <li class="<?php echo e(isset($is_faq) ? "current" : ""); ?>">
                <a href="<?php echo e(route("faq")); ?>">FAQ</a>
            </li>
            
            <li class="<?php echo e(isset($is_contact) ? "current" : ""); ?>">
                <a href="<?php echo e(route("contact")); ?>">Contact</a>
            </li>
            
            <?php if(!$est_connecter): ?>
                <li>
                    <a href="<?php echo e(route("inscription_menbre")); ?>">S'inscrire</a>
                </li>
                <li>
                    <a href="<?php echo e(route("connexion_menbre")); ?>">Se connecter</a>
                </li>
            <?php else: ?>
                <li class="<?php echo e(isset($is_apropos) ? "current" : ""); ?>">
                    <a href="<?php echo e(route("espace_menbre.accueil")); ?>">Mon compte</a>
                </li>
            <?php endif; ?>
        </ul>
        <div class="panel-extra">
            <a href="<?php echo e(route("connexion_menbre")); ?>" class="main-btn nav-btn d-none d-sm-inline-block">
                Se Connecter <i class="far fa-arrow-right"></i>
            </a>
        </div>
        <a href="#" class="panel-close">
            <i class="fal fa-times"></i>
        </a>
    </div>
</header>
<!--====== Header End ======-->

<?php echo $__env->yieldContent("content"); ?>

<!--====== Footer Start ======-->
<footer class="site-footer">
    <div class="footer-content-area">
        <div class="copyright-area">
                <div class="row flex-md-row-reverse">
                    <div class="col-md-6">
                        <ul class="social-icons">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <p class="copyright-text">© 2021 <a href="#">Waribana</a>. Tous droits réservés</p>
                    </div>
                </div>
            </div>
    </div>
</footer>
<!--====== Footer End ======-->

<!--====== jquery js ======-->
<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="/template/assets/js/jquery.min.js"></script>
<!--====== Bootstrap js ======-->
<script src="/template/assets/js/bootstrap.min.js"></script>
<!--====== Inview js ======-->
<script src="/template/assets/js/jquery.inview.min.js"></script>
<!--====== Slick js ======-->
<script src="/template/assets/js/slick.min.js"></script>
<!--====== Lity js ======-->
<script src="/template/assets/js/lity.min.js"></script>
<!--====== Wow js ======-->
<script src="/template/assets/js/wow.min.js"></script>
<!--====== Main js ======-->
<script src="/template/assets/js/main.js"></script>

<script>
   function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)){
            // alert("only number");
            return false;
        }
        return true;
    }
</script>
    <?php echo $__env->yieldContent("script_complementaire"); ?>
</body>


</html>
<?php /**PATH C:\Users\yvess\Desktop\waribana\resources\views/base_front.blade.php ENDPATH**/ ?>