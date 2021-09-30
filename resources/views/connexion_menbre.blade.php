@extends('base_front')

@section('content')
<!--====== Page Title Start ======-->
	<section class="about-section-three section-gap">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-xl-5 col-lg-7 col-md-9 col-sm-10">

                    {!! Session::get('notification','') !!}

                    <div class="about-text mb-lg-50">
						<div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> Se Connecter
								<span class="heading-shadow-text"></span>
							</span>
							<h2 class="title">Se connecter</h2>
						</div>
						<div class="container">
                            <form class="form-group" method="post" action="{{route('post_connexion_menbre')}}">
                                <div class="form-group">
                                    <label>Email ou Telephone</label>
                                        <input required class="form-control" placeholder="Email ou Telephone" type="text" name="identifiant" autocomplete="off" />
                                    <br/>
                                    <label>Mot de passe</label>
                                        <input required class="form-control" placeholder="Mot de passe" type="password" name="mot_de_passe" autocomplete="off" />
                                    <br/>
                                    <h6>
                                        <a href="{{route('reinitialiser_mot_de_passe')}}">Mot de passe oublié ?</a>
                                    </h6>
                                    @csrf
                                    <button class="main-btn wow fadeInUp" type="submit">
                                            Se connecter <i class="far fa-arrow-right"></i>
                                    </button>

                                    <br/><br/>
                                    <h6>
                                        <a href="{{route('inscription_menbre')}}">Pas encore menbre ? je m'inscris</a>
                                    </h6>
                                </div>
                            </form>
                        </div>
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

@endsection
