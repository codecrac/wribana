<?php


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
    
?>




<?php $__env->startSection('content'); ?>
<!--====== Page Title Start ======-->
	<section class="about-section-three">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-md-6">

                    <?php echo Session::get('notification',''); ?>


                    <div class="about-text mb-lg-50">
						<div class="common-heading mb-30">
							<span class="tagline">
								
								<span class="heading-shadow-text"></span>
							</span>
							<h2 class="title">Se connecter</h2>
						</div>
						<div class="container">
                            <form class="form-group" method="post" action="<?php echo e(route('post_connexion_menbre')); ?>">
                                <div class="form-group">
                                  <!--  <label>Email ou Telephone(avec prefixe) </label>
                                        <input required class="form-control" placeholder="Email ou Telephone(2250555994041)" type="text" name="identifiant" autocomplete="off" />
                                    -->
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label><small>pays</small></label>
                                            
                                            <select required class="form-control" name="prefixe">
                                                <?php echo App\Http\Controllers\CountryPrefixController::listOptionChoisirPays(); ?>

                                            </select>
                                        </div>
                                        <div class="col-md-7">
                                            <label><small>Telephone</small></label>
                                            <input required class="form-control" placeholder="Entrez votre telephone" type="number" onkeypress="return onlyNumberKey(event)" min="0" inputmode="numeric" name="telephone" />
                                        </div>
                                    </div>
                                    
                                    <br/>
                                    <label>Mot de passe</label>
                                        <input required class="form-control" placeholder="Mot de passe" type="password" name="mot_de_passe" autocomplete="off" />
                                    <br/>
                                    <h6 class='col-12 text-right'>
                                        <a href="<?php echo e(route('reinitialiser_mot_de_passe')); ?>">Mot de passe oublié ?</a>
                                    </h6>
                                    <?php echo csrf_field(); ?>
                                    <button class="main-btn wow fadeInUp" type="submit">
                                            Se connecter <i class="far fa-arrow-right"></i>
                                    </button>

                                    <br/><br/>
                                    <h6>
                                        <a href="<?php echo e(route('inscription_menbre')); ?>">Pas encore membre ? je m'inscris</a>
                                    </h6>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="about-gallery wow fadeInRight hide_on_mobile" >
						<div class="img-one">
							<img src="template/assets/img/about/about-gallery-1.jpg" height="450px" alt="Image">
						</div>
						<div class="img-two wow fadeInUp">
							<img src="template/assets/img/about/about-gallery-2.jpg" height="300px" alt="Image">
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<br/><br/><br/>
	</section>
	<!--====== About Section End ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base_front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/waribana/public_html/resources/views/connexion_menbre.blade.php ENDPATH**/ ?>