@extends('base_front')

@section('content')
<!--====== Page Title Start ======-->
	<section class="page-title-area">
		<div class="container">
			<div class="row align-items-center justify-content-between">
				<div class="col-lg-8">
					<h1 class="page-title">Qui Sommes Nous</h1>
				</div>
				<div class="col-auto">
					<ul class="page-breadcrumb">
						<li><a href="{{route('accueil')}}">Accueil</a></li>
						<li>Qui Sommes Nous</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!--====== Page Title End ======-->

	<!--====== About Section Start ======-->
	<section class="about-section-three section-gap">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-xl-5 col-lg-7 col-md-9 col-sm-10">
					<div class="about-text mb-lg-50">
						<div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> Qui Sommes Nous
								<span class="heading-shadow-text">?</span>
							</span>
							<h2 class="title">Une solution web et mobile d’épargnes collaboratives</h2>
						</div>
						<p>
                            « Waribana, on s’arrange » est une solution web et mobile d’épargnes collaboratives.
                            Une solution d’entraide, une plateforme destinée à toutes personnes souhaitant épargner ou collecter des fonds.
						</p>
						<ul class="check-list mt-30">
							<li class="wow fadeInUp" data-wow-delay="0s">
								<h5 class="title">Une solution d’entraide</h5>
								<p>Ce projet à pour but d’aider toute personnes en situation de difficultés de remplir les obligations liées à sa responsabilité
                                    à travers des cotisations à plusieurs.</p>
							</li>
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Business</h5>
								<p>la plateforme est également destinée à toutes structures financières souhaitant établir une relation de partenariat.</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-xl-7 col-lg-8 col-md-10">
					<div class="about-gallery wow fadeInRight">
						<div class="img-one">
							<img src="template/assets/img/about/about-gallery-1.jpg" alt="Image">
						</div>
						<div class="img-two wow fadeInUp">
							<img src="template/assets/img/about/about-gallery-2.jpg" alt="Image">
						</div>
						<div class="pattern">
							<img src="template/assets/img/about/about-gallery-pattern.png" alt="Pattern">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--====== About Section End ======-->
	<!--====== Feature Section Start ======-->
	<section class="feature-section primary-soft-bg section-gap">
		<div class="container">
			<div class="common-heading text-center mb-30">
				<span class="tagline">
					<i class="fas fa-plus"></i> Avantages
					<span class="heading-shadow-text">Avantages</span>
				</span>
				<h2 class="title">Pourquoi Nous</h2>
			</div>

			<div class="row icon-boxes justify-content-center">
				<div class="col-lg-4 col-md-6 col-sm-9 wow fadeInUp" data-wow-delay="0.1s">
					<div class="icon-box mt-30">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						<h5 class="title">Securisée</h5>
						<p>Toutes vos transactions sont securisées, nous n'avons accès a vos comptes que lorsque vous effectué des operations</p>
                        <a href="#" class="link"><i class="far fa-check"></i></a>
						<span class="box-index">01</span>

						<div class="box-img">
{{--							<img src="template/assets/img/icon-box-bg.jpg" alt="image">--}}
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-9 wow fadeInUp" data-wow-delay="0.2s">
					<div class="icon-box mt-30">
						<div class="icon">
                            <i class="flaticon-social-care"></i>
						</div>
						<h5 class="title">Flexible</h5>
						<p>Faire de la tontine avec des personnes de confiance sans être à proximité,
                            faciliter le financement de projet individuel ou commun.</p>
						<a href="#" class="link"><i class="far fa-check"></i></a>
						<span class="box-index">02</span>

						<div class="box-img">
{{--							<img src="template/assets/img/icon-box-bg.jpg" alt="image">--}}
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-9 wow fadeInUp" data-wow-delay="0.3s">
					<div class="icon-box mt-30">
						<div class="icon">
							<i class="flaticon-phone-call"></i>
						</div>
						<h5 class="title">Service Client</h5>
						<p>Nous sommes là pour vous,n service client très réactif disponible pour vous aidez 7jours/7 </p>
                        <a href="#" class="link"><i class="far fa-check"></i></a>
						<span class="box-index">03</span>

						<div class="box-img">
{{--							<img src="template/assets/img/icon-box-bg.jpg" alt="image">--}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--====== Feature Section End ======-->

@endsection
