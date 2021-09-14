@extends('base_front')

@section('content')

    <!--====== Page Title Start ======-->
    <section class="page-title-area">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-8">
                    <h1 class="page-title">Comment ça marche</h1>
                </div>
                <div class="col-auto">
                    <ul class="page-breadcrumb">
                        <li><a href="{{route('accueil')}}">Accueil</a></li>
                        <li>Comment ça marche</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--====== Page Title End ======-->

    <!--====== About Section Start ======-->
    <section class="about-section-four section-gap">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="about-img mb-md-70">
                        <img src="template/assets/img/about/about-three.jpg" alt="Image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-9">
                    <div class="about-text">
                        <div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> ?
								<span class="heading-shadow-text">Comment ça marche</span>
							</span>
                            <h2 class="title">Comment ça marche ?</h2>
                        </div>
                        <p class="mb-20">
                            Le cercle « Waribana» est un regroupement volontaire de personnes qui épargnent ensemble.
                            Elle consiste à créer un « pot commun »
                            alimenté par les versements réguliers de chaque participant. « Waribana, on s’arrange »
                            inclut aussi un espace de collecte de fond et aussi un crowfounding.
                        </p>
                        <ul class="about-list mt-30">
                            <li><i class="fas fa-check"></i> Créer une tontine</li>
                            <li><i class="fas fa-check"></i> Invitez vos amis</li>
                            <li><i class="fas fa-check"></i> Collecter l'argent</li>
                            <li><i class="fas fa-check"></i> Dépenser son argent</li>
                        </ul>
{{--                        <a href="about.html" class="main-btn mt-40"> Learn More <i class="far fa-arrow-right"></i> </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== About Section End ======-->

    <!--====== Categories Section Start ======-->
    <section class="categories-with-video">
        <div class="categories-area">
            <div class="container">
                <div class="categories-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> Avantages
								<span class="heading-shadow-text">Avantages</span>
							</span>
                                <h2 class="title">Pourquoi Nous</h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            {{--                    <a href="project-1.html" class="main-btn mb-30">View All Category <i class="far fa-angle-right"></i></a>--}}
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center fancy-icon-boxes">
                    <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0s">
                        <div class="fancy-box-item mt-30">
                            <div class="icon">
                                <i class="flaticon-badges"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="project-details.html">Confiance</a></h4>
                                <p>Nous sommes une organisation Certifiées </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="fancy-box-item mt-30">
                            <div class="icon">
                                <i class="flaticon-finance"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="project-details.html">Flexible</a></h4>
                                <p>Faire de la tontine avec des personnes de confiance sans être à proximité.
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="fancy-box-item mt-30">
                            <div class="icon">
                                <i class="flaticon-"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="project-details.html">Securisée</a></h4>
                                <p>Toutes vos transactions sont securisées, nous n'avons accès a vos comptes que lorsque vous effectué des operations</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="fancy-box-item mt-30">
                            <div class="icon">
                                <i class="flaticon-video-camera"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="project-details.html">Service Client</a></h4>
                                <p>Nous sommes là pour vous,vous disposez d'un service client très réactif disponible pour vous aidez 7jours/7 </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="fancy-box-item mt-30">
                            <div class="icon">
                                <i class="flaticon-project-management"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="project-details.html">Pratique</a></h4>
                                <p> Retirez votre argent quelque soit l'endroit et avec le moyen de paiement qui vous convient </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="fancy-box-item mt-30">
                            <div class="icon">
                                <i class="flaticon-salad"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="project-details.html">Commençons</a></h4>
                                <p>Faites un pas vers une epargne plus sûr </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--====== Categories Section End ======-->


@endsection
