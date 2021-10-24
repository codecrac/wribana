@php


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

$ip_info = ip_info();
//dd($ip_info);

$country_code = $ip_info['country_code'];
$ville = $ip_info['city'];
//$code_postal = $ip_info['zip'];


$code_prefixe = \App\Http\Controllers\CountryPrefixController::getPrefix($country_code);
    
@endphp


@extends('base_front')

@section('content')
<!--====== Page Title Start ======-->
	<section class="about-section-three section-gap">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-md-6">

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
                                  <!--  <label>Email ou Telephone(avec prefixe) </label>
                                        <input required class="form-control" placeholder="Email ou Telephone(2250555994041)" type="text" name="identifiant" autocomplete="off" />
                                    -->
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="text-danger"><small>prefixe</small></label>
                                            {{-- <input required class="text-danger form-control" placeholder="prefix" type="number" name="prefixe" value="{{$code_prefixe}}" required /> --}}
                                            <select required class="form-control" name="prefixe">
                                                {!! App\Http\Controllers\CountryPrefixController::listOptionChoisirPays() !!}
                                            </select>
                                        </div>
                                        <div class="col-md-7">
                                            <label><small>Telephone</small></label>
                                            <input required class="form-control" placeholder="Entrez votre telephone" type="number" name="telephone" />
                                        </div>
                                    </div>
                                    
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
				<div class="col-md-6">
					<div class="about-gallery wow fadeInRight">
						<div class="img-one">
							<img src="template/assets/img/about/about-gallery-1.jpg" width="500px" alt="Image">
						</div>
						<div class="img-two wow fadeInUp">
							<img src="template/assets/img/about/about-gallery-2.jpg" width="400px" alt="Image">
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
