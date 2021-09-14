<!DOCTYPE html>
<html lang="zxx">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--====== Title ======-->
    <title> Funden - Crowdfunding & Charity HTML Template || Home One </title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/template/assets/img/favicon.ico" type="img/png" />
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
</head>

<body>

<!--====== Preloader ======-->
{{--<div id="preloader">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="object" id="object_one"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_four"></div>
        </div>
    </div>
</div>--}}


<!--====== Header Start ======-->
@isset($is_home)
    <header class="site-header sticky-header transparent-header topbar-transparent">
@else
    <header class="site-header sticky-header">
@endisset
    <div class="header-topbar d-none d-sm-block">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <ul class="contact-info">
                        <li><a href="#"><i class="far fa-envelope"></i> <span class="__cf_email__"
                                                                              data-cfemail="bac9cfcacad5c8cefaddd7dbd3d694d9d5d7">
                                    info@waribana.ci </span></a></li>
                        <li><a href="#"><i class="far fa-map-marker-alt"></i> Cocody, Riviera Palmeraie</a></li>
                    </ul>
                </div>
                <div class="col-auto d-none d-md-block">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
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
                    <a href="index.html"><img src="/template/assets/img/logo.png" alt="Funden"></a>
                </div>
                <div class="nav-menu">
                    <ul>
                        <li class="current">
                            <a href="{{route('accueil')}}">Accueil</a>
                        </li>
                        <li>
                            <a href="{{route('comment_ca_marche')}}">Comment ça marche</a>
                        </li>
                        <li>
                            <a href="{{route('apropos')}}">Qui Sommes Nous</a>
                        </li>
                        <li>
                            <a href="{{route('faq')}}">FAQ</a>
                        </li>
                        <li><a href="{{route('contact')}}">Contact</a></li>
                    </ul>
                </div>
                <div class="navbar-extra d-flex align-items-center">
                    <a href="events.html" class="main-btn nav-btn d-none d-sm-inline-block">
                        Se Connecter <i class="far fa-arrow-right"></i>
                    </a>
                    <a href="#" class="nav-toggler">
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-menu-panel">
        <div class="panel-logo">
            <a href="index.html"><img src="/template/assets/img/logo-white.png" alt="Funden"></a>
        </div>
        <ul class="panel-menu">
            <li class="current">
                <a href="index.html">Home</a>
                <ul class="submenu">
                    <li><a href="index.html">Home One</a></li>
                    <li><a href="index-2.html">Home Two</a></li>
                </ul>
            </li>
            <li>
                <a href="project-1.html">Project</a>
                <ul class="submenu">
                    <li><a href="project-1.html">Project One</a></li>
                    <li><a href="project-2.html">Project Two</a></li>
                    <li><a href="project-3.html">Project Three</a></li>
                    <li><a href="project-details.html">Project Details</a></li>
                </ul>
            </li>
            <li>
                <a href="events.html">Events</a>
            </li>
            <li>
                <a href="news-standard.html">News</a>
                <ul class="submenu">
                    <li><a href="news-standard.html">News Standard</a></li>
                    <li><a href="news-details.html">News Details</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Pages</a>
                <ul class="submenu">
                    <li><a href="about.html">About</a></li>
                    <li><a href="company-overview.html">Company Overview</a></li>
                    <li><a href="team-member.html">Team Member</a></li>
                    <li><a href="pricing.html">Pricing</a></li>
                    <li><a href="{{route('faq')}}">FAQ</a></li>
                </ul>
            </li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <div class="panel-extra">
            <a href="#" class="main-btn btn-white">
                Donate Now <i class="far fa-arrow-right"></i>
            </a>
        </div>
        <a href="#" class="panel-close">
            <i class="fal fa-times"></i>
        </a>
    </div>
</header>
<!--====== Header End ======-->

@yield('content')

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
                            <li><a href="#"><i class="fab fa-behance"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
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

</body>


</html>
