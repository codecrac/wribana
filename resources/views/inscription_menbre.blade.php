@extends('base_front')

@section('content')
	<!--====== About Section Start ======-->
	<section class="about-section-three section-gap">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-xl-5 col-lg-7 col-md-9 col-sm-10">

                    {!! Session::get('notification','') !!}

                    <div class="about-text mb-lg-50">
						<div class="common-heading mb-30">
							<span class="tagline">
								<i class="fas fa-plus"></i> Inscription
								<span class="heading-shadow-text">Espace Menbre</span>
							</span>
							<h2 class="title">Inscription</h2>
						</div>
						<div class="container">
                            <form class="form-group" method="post" action="{{route('post_inscription_menbre')}}">
                                <div class="form-group">
                                    <label>Nom complet *</label>
                                        <input required class="form-control" placeholder="Email ou Telephone" type="text" name="nom_complet" />
                                    <br/>
                                    <label>Telephone *</label>
                                        <input required class="form-control" placeholder="Email ou Telephone" type="number" name="telephone" />
                                    <br/>
                                    <label>Email</label>
                                        <input class="form-control" placeholder="Email ou Telephone" type="text" name="email" />
                                    <br/>
                                    <label>Mot de passe *</label>
                                        <input required class="form-control" placeholder="Mot de passe" type="password" name="mot_de_passe" />
                                    <br/>
                                    <label>Confirmation du mot de passe *</label>
                                        <input required class="form-control" placeholder="Mot de passe" type="password" name="confirmer_mot_de_passe" />
                                    <br/>

                                    @csrf
                                    <button class="main-btn wow fadeInUp" type="submit">
                                            Je m'inscris <i class="far fa-arrow-right"></i>
                                    </button>

                                    <br/><br/>
                                    <h6>
                                        <a href="{{route('connexion_menbre')}}">déja menbre ? connectez vous.</a>
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
