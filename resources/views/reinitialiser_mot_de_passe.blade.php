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
								<i class="fas fa-plus"></i> Reinitialiser mon mot de passe
								<span class="heading-shadow-text"></span>
							</span>
{{--							<h2 class="title">Se connecter</h2>--}}
						</div>
						<div class="container">
                            <form class="form-group" method="post">
                                <div class="form-group">
                                    <label>Entrer votre numero de telephone ou votre adresse email</label>

                                        <input required class="form-control" placeholder="2250578765467 ou monadresse@gmail.com" type="text" name="identifiant"
                                               autocomplete="off" />
                                    <br/>
                                    @csrf
                                    <button class="main-btn wow fadeInUp" type="submit">
                                            Reinitialiser <i class="far fa-arrow-right"></i>
                                    </button>

                                    <br/><br/>
                                    <h6>
                                        <a href="{{route('connexion_menbre')}}">Se connecter</a>
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
