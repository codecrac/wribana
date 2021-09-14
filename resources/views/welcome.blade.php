@extends('base_front')

@section('content')
<section class="hero-area-one">
    <div class="hero-text">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <span class="tagline wow fadeInUp" data-wow-delay="0.3s">une solution web et mobile d’épargne collaborative</span>
                    <h1 class="title wow fadeInUp" data-wow-delay="0.4s">
                        Waribana,<br/> on s’arrange
                    </h1>
                    <a href="#avantages" class="main-btn wow fadeInUp" data-wow-delay="0.5s">
                        Decouvrir <i class="far fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-images">
            <div class="hero-img image-small fancy-bottom wow fadeInLeft" data-wow-delay="0.6s">
                <img src="/template/assets/img/hero/hero-one-small.jpg" alt="Image">
            </div>
            <div class="hero-img main-img wow fadeInUp" data-wow-delay="0.5s">
                <img src="/template/assets/img/hero/hero-one-big.jpg" alt="Image">
            </div>
            <div class="hero-img image-small fancy-top wow fadeInRight" data-wow-delay="0.7s">
                <img src="/template/assets/img/hero/hero-one-small-2.jpg" alt="Image">
            </div>
    </div>
</section>
<!--====== Hero Area End ======-->

<!--====== Categories Section Start ======-->
<section class="popular-categories section-gap" id="avantages">
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
                        <h4 class="title"><a href="project-details.html">Garantie</a></h4>
                        <p>Nous vous remboursons en cas de litige</p>
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
                        <p>Faites un pas vers une epargne plus sur </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Categories Section End ======-->

<!--====== About Section Start ======-->
<section class="about-section-one">
    <div class="container">
        <div class="row align-items-center justify-content-lg-start justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="about-img">
                    <img src="/template/assets/img/about/about-one.jpg" alt="Image">
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-10 offset-xl-1">
                <div class="about-text mt-md-70 mb-md-50">
                    <div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> Qui Sommes Nous
								<span class="heading-shadow-text">Nous</span>
							</span>
                        <h2 class="title">Waribana</h2>
                    </div>
                    <p>
                        Une solution d’entraide, d’ou, une plateforme destinée à toutes personnes souhaitant épargner ou collecter des fonds.
                    </p>

                    <a href="#avantages" class="main-btn wow fadeInUp" data-wow-delay="0.5s">
                        En savoir plus <i class="far fa-arrow-right"></i>
                    </a>
                    {{--<div class="author-note wow fadeInUp">
                        <ul>
                            <li><i class="far fa-check"></i> Non-Profite Crowdfunding Agency</li>
                            <li><i class="far fa-check"></i> We're Successful Institute </li>
                        </ul>
                        <div class="author-info">
                            <div class="author-img">
                                <img src="assets/img/author-thumbs/01.jpg" alt="Image">
                            </div>
                            <h5 class="name">Michel H. Heart</h5>
                            <span class="title">CEO & Founder</span>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== About Section End ======-->

<!--====== Counter Area Start ======-->
<section class="counter-section-one mt-negative">
    <div class="container primary-bg">
        <div class="row counter-boxes justify-content-xl-between justify-content-center">
            <div class="col-12 text-center">

                <div class="icon white-color">
                    <i style="font-size:150px" class="flaticon-solidarity"></i>
                </div>
                <div class="counter-box mb-40 ">
                    <div class="content white-color text-center">
                        <div class="count-wrap" style="display:block">
                            <h3 class="title">
                               Des frais de gestion inedit ! Nous facturons la gestion de votre tontine a hauteur de
                            </h3>
                            <span class="count">1</span>
                           <span class="suffix">%</span>

                        </div>
                    </div>
                </div>
            </div>
          {{--  <div class="col-xl-auto col-lg-5 col-md-5 col-sm-6">
                <div class="counter-box mb-40 icon-left">
                    <div class="icon white-color">
--}}{{--                        <i class="flaticon-crowdfunding"></i>--}}{{--
                    </div>
                    <div class="content white-color">
                        <div class="count-wrap">
                            <span class="count">1</span>
                            <span class="suffix">%</span>
                        </div>
--}}{{--                        <h6 class="title">Global Partners</h6>--}}{{--
                    </div>
                </div>
            </div>
            <div class="col-xl-auto col-lg-5 col-md-5 col-sm-6">
                <div class="counter-box mb-40 icon-left">
                    <div class="icon white-color">
                        <i class="flaticon-crowdfunding"></i>
                    </div>
                    <div class="content white-color">
                        <div class="count-wrap">
                            <span class="count">8565</span>
                            <span class="suffix">+</span>
                        </div>
                        <h6 class="title">Awards Winning</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-auto col-lg-5 col-md-5 col-sm-6">
                <div class="counter-box mb-40 icon-left">
                    <div class="icon white-color">
                        <i class="flaticon-crowdfunding"></i>
                    </div>
                    <div class="content white-color">
                        <div class="count-wrap">
                            <span class="count">4756</span>
                            <span class="suffix">+</span>
                        </div>
                        <h6 class="title">Active Volunteer</h6>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
</section>
<!--====== Counter Area End ======-->

<!--====== Partners Section Start ======-->
<section class="partners-section section-gap section-border-bottom">
    <div class="container">
        <div class="common-heading mb-30">
				<span class="tagline">
					<i class="fas fa-plus"></i> Nos partenaires
					<span class="heading-shadow-text">Ils nous font confiance</span>
				</span>
            <h2 class="title">Nos partenaires</h2>
        </div>
        <div class="row partners-logos-one">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/01.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/02.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/03.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/04.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/05.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/06.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/07.png" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/template/assets/img/partners/08.png" alt="Image"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Partners Section End ======-->

@endsection
