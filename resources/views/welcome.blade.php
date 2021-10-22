@extends('base_front')

@section('content')
<section class="hero-area-one">
    <div class="hero-text">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <span class="tagline wow fadeInUp" data-wow-delay="0.3s">Votre solution de financement entre proches</span>
                    {{-- <span class="tagline wow fadeInUp" data-wow-delay="0.3s">une solution web et mobile d’épargne collaborative</span> --}}
                    <h1 class="title wow fadeInUp" data-wow-delay="0.4s">
                        Waribana,<br/> on s’arrange
                    </h1>
                    <a href="{{route('connexion_menbre')}}" class="main-btn wow fadeInUp" data-wow-delay="0.5s">
                        s’identifier  <i class="far fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-images">
            <div class="hero-img image-small fancy-bottom wow fadeInLeft" data-wow-delay="0.6s">
                <img src="/template/assets/img/hero/hero-one-small.jpg" width="400px" alt="Image">
            </div>
            <div class="hero-img main-img wow fadeInUp" data-wow-delay="0.5s">
                <img src="/template/assets/img/hero/hero-one-big.jpg" alt="Image">
            </div>
            <div class="hero-img image-small fancy-top wow fadeInRight" data-wow-delay="0.7s">
                <img src="/template/assets/img/hero/hero-one-small-2.jpg" width="400px" alt="Image">
            </div>
    </div>
</section>
<!--====== Hero Area End ======-->


	<!--====== Section Qui sommes nous ======-->
	<section class="popular-categories section-gap" id="avantages">
		<div class="container">
			<div class="row align-items-center justify-content-lg-start justify-content-center">
				<div class="col-12">
					<div class="about-text mt-md-70 mb-md-50">
						<div class="common-heading mb-30">
							<h2 class="title text-center">Waribana qu’est-ce que c’est ? </h2>
						</div>
						<p>
							Waribana est une solution de gestion des tontines destinée à toutes personnes souhaitant épargner ou collecter des fonds. 
                            Toutes les périodes, 
                            des proches mettent de l'argent sur la table et la collecte est reversée à chacun d'entre eux à tour de rôle
						</p>
					</div>
				</div>  
			</div>     
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="http://imaginationforpeople.org/site_media/uploads/projects/1785/pictures/93a3b99a-2937-4c60-9213-4ded92ffc6c7.jpg.620x300_q85_crop-50%2C50_upscale-1.jpg" />
                </div>
                <div class="col-md-6">
						<div class="author-note wow fadeInUp">

							<ul>
								<li>
                                    <h6>
                                        <br/><br/><br/><br/>
                                        <i class="far fa-check-circle"></i> Tontines
                                    </h6>
                                    <p style="padding-left: 15px">Opération de Crédit-Épargne. Un crédit pour les uns et une épargne pour les autres. </p>
                                </li>
								<li>
                                    <h6>
                                        <br/><br/>
                                        <i class="far fa-check-circle"></i> Entre proches 
                                    </h6>
                                    <p style="padding-left: 15px"> Le financement de vos projets se fait entre proches. Nul besoin d'une banque </p>
                                </li>
								<li>
                                    <h6>
                                        <br/><br/>
                                        <i class="far fa-check-circle"></i> Simplissime
                                    </h6>
                                    <p style="padding-left: 15px"> Pas de dossier à constituer. Il suffit de se rassembler avec ceux qu'on aime. </p>
                                </li>
							</ul>
						</div>
                </div>
            </div>
		</div>
	</section>
	<!--====== About Section End ======-->

        <!--====== En savoir plus ======-->
        <section class="counter-section-one mt-negative">
            <div class="container primary-bg" style="padding-bottom:50px">
                <div class="row counter-boxes justify-content-xl-between justify-content-center">
                        <div class="col-md-6">
                            <h3 class="title text-white"> Waribana, on s’arrange. </h3> 
                        </div>
                        <div class="col-md-5">
                                <a class="btn btn-info" href='{{route('comment_ca_marche')}}'> En savoir plus </a>
                                <a class="btn btn-dark" href='{{route('inscription_menbre')}}'> S'inscrire </a>
                        </div>
                </div>
            </div>
        </section>
        <!--====== Counter Area End ======-->


<!--====== Section Avantages ======-->
<section class="popular-categories" id="avantages">
    <div class="container">
        <div class="categories-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="common-heading mb-30">
							<span class="tagline">
    {{--								<i class="fas fa-plus"></i>--}}
								<span class="heading-shadow-text"></span>
							</span>
                        <h2 class="title">Avantages</h2>
                    </div>
                </div>
                <div class="col-auto">
    {{--                    <a href="project-1.html" class="main-btn mb-30">View All Category <i class="far fa-angle-right"></i></a>--}}
                </div>
            </div>
        </div>
        <div class="row justify-content-center fancy-icon-boxes">
            {{-- <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0s">
                <div class="fancy-box-item mt-30">
                    <div class="icon">
                        <i class="flaticon-badges"></i>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="project-details.html">Confiance</a></h4>
                        <p>Une organisation certifiée</p>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.1s">
                <div class="fancy-box-item mt-30">
                    <div class="icon">
                        <i class="flaticon-finance"></i>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="project-details.html">Flexible</a></h4>
                        <p>faire la tontine avec des personnes de confiance sans être à proximité</p>
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
                        <p>retirez votre argent quel que soit l’endroit et avec le moyen de paiement qui vous convient </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.2s">
                <div class="fancy-box-item mt-30">
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="project-details.html">Securisée</a></h4>
                        <p>une organisation certifiée avec toutes les transactions sécurisées </p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.3s">
                <div class="fancy-box-item mt-30">
                    <div class="icon">
                        <i class="flaticon-video-camera"></i>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="project-details.html">Service Client</a></h4>
                        <p>Un service client très réactif et disponible 7jours/7</p>
                    </div>
                </div>
            </div> --}}
            
            {{-- <div class="col-xl-4 col-md-6 col-sm-10 wow fadeInUp" data-wow-delay="0.5s">
                <div class="fancy-box-item mt-30">
                    <div class="icon">
                        <i class="flaticon-salad"></i>
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="project-details.html">Commençons</a></h4>
                        <p>Faites un pas vers une épargne plus sûre</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
<!--====== Categories Section End ======-->



<!--====== Section Comment ça marche ======-->
	<section class="popular-categories" id="avantages">
		<div class="container">
            <div class="col-12">
                <h2 class="title text-center">Comment ça marche ? </h2>
            </div>
			<div class="row align-items-center justify-content-lg-start justify-content-center">
                <div class="col-12">
                    <div class="about-text mt-md-70 mb-md-50">
                        <div class="common-heading mb-30">
                            <br/><br/>
                            <h5 class="text-uppercase text-center"> Tontine Waribana  </h5>
                        </div>
                        <p>
                            Avec la tontine Waribana, à chaque période, l'argent constitué est versé automatiquement à l'un de vos proches 
                            en fonction de l'ordre que vous avez défini.
                        </p>
                        <br/>
                        <div class="col-12 text-center">
                            <img src="http://www.talenbiz.com/wp-content/uploads/2016/06/mobile_afrique_1_stocklib_1-1014x487.jpg" />
                        </div>
                        <br/>
                        <div class='row'>
                            <div class="col-md-4"> 
                                <b> <i class="fa fa-check-circle"></i> Créer une tontine</b>
                                 Définissez le nombre de personnes, le montant régulier et la fréquence et le tour est joué 
                            </div>
                            <div class="col-md-4"> 
                                <b> <i class="fa fa-check-circle"></i> Invitez vos amis</b>
                                C'est avec vos proches que vous pouvez désormais effectuer vos opérations de crédit ou d'épargne.
                            </div>
                            <div class="col-md-4"> 
                                <b> <i class="fa fa-check-circle"></i>  Collecter à tour de rôle</b>
                                Chaque période, vous mettez une somme prédéfinie. La totalité sera reversée à chacun d'entre vous à tour de rôle
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 section-gap">
                    <div class="about-text mt-md-70 mb-md-50">
                        <div class="common-heading mb-30">
                            <h5 class="text-uppercase text-center"> Waricrowd  </h5>
                        </div>
                        <p>
                            Avec le Waricrowd, vous pouvez collecter une multitude de petits dons
                                afin de financer vos projets. Vous pouvez également soutenir des projets.
                        </p>
                        <br/>
                        <div class="col-12 text-center">
                            <img src="https://businesspress.net/wp-content/uploads/2021/04/Crowdfunding-696x464.jpg" />
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6 text-center"> <b> <i class="fa fa-check-circle"></i> Soumettre son projet</b> </div>
                            <div class="col-md-6 text-center"> <b> <i class="fa fa-check-circle"></i> Soutenir un projet</b> </div>
                        </div>

                    </div>
                </div>
			</div>
		</div>
	</section>
	<!--====== About Section End ======-->


        <!--====== En savoir plus ======-->
        <section class="counter-section-one mt-negative">
            <div class="container" style="padding-bottom:50px">
                <div class="col-12 text-center">
                    <a class="main-btn" style="background-color:#fff;color:#22f" href='{{route('inscription_menbre')}}'>S'inscrire </a>
                </div>
            </div>
        </section>
        <!--====== Counter Area End ======-->

<!--====== About Section Start ======-->
<section class="about-section-one section-gap">
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
								<span class="heading-shadow-text">{{--Nous--}}</span>
							</span>
                        <h2 class="title">Waribana</h2>
                    </div>
                    <p>
                        Une solution d’entraide, d’où, une plateforme destinée à toutes personnes souhaitant épargner 
                        ou collecter des fonds.
                    </p>

                    <a href="{{route('comment_ca_marche')}}" class="main-btn wow fadeInUp" data-wow-delay="0.5s">
                        En savoir plus <i class="far fa-arrow-right"></i>
                    </a>
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
                    {{-- <i style="font-size:150px" class="flaticon-solidarity"></i> --}}
                </div>
                <div class="counter-box mb-40 ">
                    <div class="content white-color text-center">
                        <div class="count-wrap" style="display:block">
                            <h3 class="title">
                                Des frais de gestion inédit,
                            
                                <span class="count">1</span>
                                <span class="suffix">%</span>
                                seulement
                            </h3>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Counter Area End ======-->

<!--====== Partners Section Start ======-->
<section class="partners-section section-gap section-border-bottom">
    <div class="container">
        <div class="common-heading mb-30">
				<span class="tagline">
					<!--<i class="fas fa-plus"></i> Nos partenaires-->
					<span class="heading-shadow-text"><!--Ils nous font confiance--></span>
				</span>
            <h2 class="title">Nos partenaires</h2>
        </div>
        <div class="row partners-logos-one">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/assets/partenaires/bgfi.jpg" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/assets/partenaires/moov-africa.jpeg" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="https://www.africaguinee.com/sites/default/files/field/image/orange_40_3.jpg" alt="Image"></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="logo mt-30">
                    <a href="#"><img src="/assets/partenaires/mtn.jpg" alt="Image"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Partners Section End ======-->

@endsection
