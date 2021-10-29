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
		
		<div class="col-12 " style="padding:10px 30px">
			<div class="common-heading mb-30">
				<span class="tagline">
					{{-- <i class="fas fa-plus"></i> Qui Sommes Nous --}}
					<span class="heading-shadow-text"></span>
				</span>
				<h4 class="title text-center">Une solution web <br/> et mobile d’épargnes collaboratives</h2>
			</div>
			<div class="col-md-12 text-center">
				<p>
					L’absence d’accès au système bancaire rend presque vital le système tontinier.
					 Il agit en tant que micro-crédit, ouvert pour les proches. Chacun des individus peut à son tour 
					 emprunter dans la tontine, à condition de rembourser. L’association rotative de l’épargne et du crédit fait 
					 donc référence au système selon lequel les individus empruntent chacun leur tour, pour ensuite rembourser.
					Le rôle des tontines peut être :

				</p>
			</div>
			<div class="row">
				<div class="col-md-6" style="padding-top: 15% ">
                    <img src="/template/assets/img/main-qui-se-soutiennent.jpg" />
				</div>
				<div class="col-md-6">
					<div class="col-12">	
						<ul class="check-list mt-30">
							<li class="wow fadeInUp" data-wow-delay="0s">
								<h5 class="title">Social</h5>
								<p>
									Le rôle de la tontine est avant tout social dans les pays africains. 
									La tontine privilégie le groupe par rapport à l’individu, et peut dicter les comportements.
									Elle est souvent utilisée comme une caisse de prévoyance, à laquelle chacun des membres adhère en
									prévision de risques qui peuvent survenir.
									La tontine est une couverture sociale qui agit dans le cercle familial et amical.
								</p>
							</li>
						</ul>
					</div>
					<div class="col-12">
						<ul class="check-list mt-30">
							<li class="wow fadeInUp" data-wow-delay="0s">
								<h5 class="title">Economique</h5>
								<p>
									Dans ce cas-ci, l’objectif est d’utiliser les fonds pour des investissements à court terme,
									pour des évènements prévus ou imprévisibles, de manière collective ou individuelle.
									En cas d’usage individuel, l’individu qui souhaite emprunter doit d’abord présenter son projet,
									qui doit être accepté par le reste des participants. L’emploi des fonds est parfois surveillé par un membre
									désigné de l’association tontinière.</p>
							</li>
						</ul>
					</div>
					<div class="col-12">
						<ul class="check-list mt-30">
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Financier</h5>
								<p>La tontine peut mobiliser de l’épargne, dans ce cas elle possède un rôle financier. Cette tontine possède la
									particularité d’impliquer une cotisation périodique. Ces cotisations périodiques peuvent être attribuées au membre
									qui en a le plus besoin, ou dans le cas d'un ordre préétabli, elles seront attribuées selon cette planification.</p>
							</li>
						</ul>
					</div>
				</div>
						
			</div>
		</div>

	</section>


	{{-- ========================EXPLICATION TONTINE====================== --}}

	<div class="common-heading mb-30 col-12">
		<span class="tagline">
			{{-- <i class="fas fa-plus"></i> Qui Sommes Nous --}}
			<span class="heading-shadow-text"></span>
		</span>
		<h4 class="title text-center">Waribana, qu’est-ce que c’est ?</h2>
	</div>

	<section class="about-section-three section-gap">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-xl-5 col-lg-7 col-md-9 col-sm-10">
					<div class="about-text mb-lg-50">
						<p>
                            Waribana est une solution de gestion des tontines destinée à toutes personnes souhaitant épargner ou collecter des fonds. 
                            Toutes les périodes, 
                            des proches mettent de l'argent sur la table et la collecte est reversée à chacun d'entre eux à tour de rôle

						</p>
						<ul class="check-list mt-30">

							
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Tontines</h5>
								<p>Opération de Crédit-Épargne. Un crédit pour les uns et une épargne pour les autres.</p>
							</li>
							
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Entre proches</h5>
								<p>Le financement de vos projets se fait entre proches. Nul besoin d'une banque.</p>
							</li>
							
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Simplissime</h5>
								<p>Pas de dossier à constituer. Il suffit de se rassembler avec ceux qu'on aime.</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-xl-7 col-lg-8 col-md-10">
					<div class="about-gallery wow fadeInRight">
						<div class="img-one">
							<img src="template/assets/img/about/about-gallery-1.jpg" height="500px" alt="Image">
						</div>
						<div class="img-two wow fadeInUp">
							<img src="template/assets/img/about/about-gallery-2.jpg" height="300px" alt="Image">
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


	{{-- ========================EXPLICATION Waricrowd====================== --}}

	<div class="common-heading mb-30 col-12">
		<span class="tagline">
			{{-- <i class="fas fa-plus"></i> Qui Sommes Nous --}}
			<span class="heading-shadow-text"> </span>
		</span>
		<h4 class="title text-center">Waricrowd, qu’est-ce que c’est ?</h2>
	</div>

	
	<section class="about-section-three section-gap">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				
				<div class="col-xl-5 col-lg-7 col-md-9 col-sm-10">
					<div class="about-text mb-lg-50">
						<p>
                            Waricrowd, est une solution de financement participatif.
							 Le principe est de vous permettre de participer au financement des projets auxquels vous croyez selon votre choix :
						</p>
						<ul class="check-list mt-30">

							
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Le don</h5>
								<p>Les personnes qui participent au financement font un don du montant de leur choix, sans chercher à avoir quelque chose en retour.</p>
							</li>
							
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">Le prêt</h5>
								<p>Le contributeur prête de l’argent pour financer le projet et attend que l’initiateur du projet le rembourse.</p>
							</li>
							
							<li class="wow fadeInUp" data-wow-delay="0.1s">
								<h5 class="title">La prise de participation dans une entreprise</h5>
								<p>Le contributeur participe au capital financé de l’entreprise et devient actionnaire du projet et peut recevoir des dividendes.</p>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="col-xl-7 col-lg-8 col-md-10">
					<div class="about-gallery wow fadeInRight">
						<div class="img-one">
							<img src="template/assets/img/about/about-gallery-1.jpg" height="500px"  alt="Image">
						</div>
						<div class="img-two wow fadeInUp">
							<img src="template/assets/img/about/about-gallery-2.jpg"  height="300px"  alt="Image">
						</div>
						<div class="pattern">
							<img src="template/assets/img/about/about-gallery-pattern.png" alt="Pattern">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!--====== Feature Section Start ======-->
	<section class="feature-section primary-soft-bg section-gap">
		<div class="container">
			<div class="common-heading text-center mb-30">
				<span class="tagline">
					{{-- <i class="fas fa-plus"></i> Avantages --}}
					{{-- <span class="heading-shadow-text">Avantages</span> --}}
				</span>
				<h2 class="title">Avantages</h2>
			</div>

			<div class="row icon-boxes justify-content-center">
				<div class="col-lg-4 col-md-6 col-sm-9 wow fadeInUp" data-wow-delay="0.1s">
					<div class="icon-box mt-30">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						<h5 class="title">Securisée</h5>
						<p>une organisation certifiée avec toutes les transactions sécurisées </p>
                        <a href="#" class="link"><i class="far fa-check"></i></a>
						<span class="box-index"></span>

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
						<p>faire la tontine avec des personnes de confiance sans être à proximité.</p>
						<a href="#" class="link"><i class="far fa-check"></i></a>
						<span class="box-index"></span>

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
						<h5 class="title">Pratique</h5>
						<p>retirez votre argent quel que soit l’endroit et avec le moyen de paiement qui vous convient</p>
                        <a href="#" class="link"><i class="far fa-check"></i></a>
						<span class="box-index"></span>

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
