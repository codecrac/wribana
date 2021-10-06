@php
    $query = @unserialize(file_get_contents('http://ip-api.com/php/'));
    if($query && $query['status'] == 'success'){
        $country_code = $query['countryCode'];
        $ville = $query['city'];
        $code_postal = $query['zip'];
    }

    $code_prefixe = \App\Http\Controllers\CountryPrefixController::getPrefix($country_code);
    //dd($code_prefixe);
@endphp


@extends('base_front')

@section('style_complementaire')
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

@endsection

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

            <!-- ------------------------UTILE POUR CARTE BANCAIRE -->
                                    <!-- <div style="display:{{($country_code!='') ? 'none' : '' }};background-color:yellow"> -->
                                    <div style="background-color:yellow">
                                        <label>PAYS *</label>
                                            <input required class="form-control" placeholder="CI,US" value="{{$country_code}}" type="text" name="pays" />
                                        <br/>
                                    </div>
                                    
                                    <div class="form-group" style="display:{{($country_code != 'US') ? 'none' : '' }}">
                                        <label>Etat (si vous vivez au etats unis)</label>
                                            <input class="form-control" placeholder="Illinois" type="text" name="etat_us" />
                                        <br/>
                                    </div>

                                    <label>Ville *</label>
                                        <input required class="form-control" placeholder="Yammoussoukro" value="{{$ville}}" type="text" name="ville" />
                                    <br/>
                                    
                                    <label>Code postal</label>
                                        <input class="form-control" placeholder="" value="{{$code_postal}}" type="text" name="code_postal" />
                                    <br/>
                <!-- / ------------------UTILE POUR CARTE BANCAIRE -->
                                    <label>Nom complet *</label>
                                        <input required class="form-control" placeholder="LADDE YVES" type="text" name="nom_complet" />
                                    <br/>

                                    <label>Adresse *</label>
                                        <input required class="form-control" placeholder="Cocody palmeraie" type="text" name="adresse" />
                                    <br/>


                                    <label>Contact *</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><small>prefixe</small></label>
                                            <input required class="form-control" placeholder="prefix" type="number" name="prefixe" value="{{$code_prefixe}}" />
                                        </div>
                                        <div class="col-md-8">
                                            <label><small>Telephone</small></label>
                                            <input required class="form-control" placeholder="Entrez votre telephone" type="number" name="telephone" />
                                        </div>
                                    </div>

                                    <br/>
                                    <label>Email</label>
                                        <input class="form-control" placeholder="monadresse@gmail.com" type="email" name="email" />
                                    <br/>
                                    <label>Mot de passe *</label>
                                        <input required class="form-control" placeholder="Mot de passe" type="password" name="mot_de_passe" />
                                    <br/>
                                    <label>Confirmation du mot de passe *</label>
                                        <input required class="form-control" placeholder="Confirmer le mot de passe" type="password" name="confirmer_mot_de_passe" />
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

@section('script_complementaire')
    <script>
        const phoneInputField = document.querySelector("#telephone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
        const info = document.querySelector(".alert-info");

        function process(event) {
            // event.preventDefault();

            const phoneNumber = phoneInput.getNumber();
            // alert('--'+phoneNumber);

            info.style.display = "";
            info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
        }

        function getIp(callback) {
            fetch('https://ipinfo.io/json?token=<your token>', { headers: { 'Accept': 'application/json' }})
                .then((resp) => resp.json())
                .catch(() => {
                    return {
                        country: 'ci',
                    };
                })
                .then((resp) => callback(resp.country));
        }

        getIp();
    </script>
@endsection
