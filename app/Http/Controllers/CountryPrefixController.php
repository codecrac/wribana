<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountryPrefixController extends Controller
{
    public static function getPrefix($coutry_code){

        $countryArray = array(
            'AD' => array('name' => 'ANDORRA', 'code' => '376'),
            'AE' => array('name' => 'UNITED ARAB EMIRATES', 'code' => '971'),
            'AF' => array('name' => 'AFGHANISTAN', 'code' => '93'),
            'AG' => array('name' => 'ANTIGUA AND BARBUDA', 'code' => '1268'),
            'AI' => array('name' => 'ANGUILLA', 'code' => '1264'),
            'AL' => array('name' => 'ALBANIA', 'code' => '355'),
            'AM' => array('name' => 'ARMENIA', 'code' => '374'),
            'AN' => array('name' => 'NETHERLANDS ANTILLES', 'code' => '599'),
            'AO' => array('name' => 'ANGOLA', 'code' => '244'),
            'AQ' => array('name' => 'ANTARCTICA', 'code' => '672'),
            'AR' => array('name' => 'ARGENTINA', 'code' => '54'),
            'AS' => array('name' => 'AMERICAN SAMOA', 'code' => '1684'),
            'AT' => array('name' => 'AUSTRIA', 'code' => '43'),
            'AU' => array('name' => 'AUSTRALIA', 'code' => '61'),
            'AW' => array('name' => 'ARUBA', 'code' => '297'),
            'AZ' => array('name' => 'AZERBAIJAN', 'code' => '994'),
            'BA' => array('name' => 'BOSNIA AND HERZEGOVINA', 'code' => '387'),
            'BB' => array('name' => 'BARBADOS', 'code' => '1246'),
            'BD' => array('name' => 'BANGLADESH', 'code' => '880'),
            'BE' => array('name' => 'BELGIUM', 'code' => '32'),
            'BF' => array('name' => 'BURKINA FASO', 'code' => '226'),
            'BG' => array('name' => 'BULGARIA', 'code' => '359'),
            'BH' => array('name' => 'BAHRAIN', 'code' => '973'),
            'BI' => array('name' => 'BURUNDI', 'code' => '257'),
            'BJ' => array('name' => 'BENIN', 'code' => '229'),
            'BL' => array('name' => 'SAINT BARTHELEMY', 'code' => '590'),
            'BM' => array('name' => 'BERMUDA', 'code' => '1441'),
            'BN' => array('name' => 'BRUNEI DARUSSALAM', 'code' => '673'),
            'BO' => array('name' => 'BOLIVIA', 'code' => '591'),
            'BR' => array('name' => 'BRAZIL', 'code' => '55'),
            'BS' => array('name' => 'BAHAMAS', 'code' => '1242'),
            'BT' => array('name' => 'BHUTAN', 'code' => '975'),
            'BW' => array('name' => 'BOTSWANA', 'code' => '267'),
            'BY' => array('name' => 'BELARUS', 'code' => '375'),
            'BZ' => array('name' => 'BELIZE', 'code' => '501'),
            'CA' => array('name' => 'CANADA', 'code' => '1'),
            'CC' => array('name' => 'COCOS (KEELING) ISLANDS', 'code' => '61'),
            'CD' => array('name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'code' => '243'),
            'CF' => array('name' => 'CENTRAL AFRICAN REPUBLIC', 'code' => '236'),
            'CG' => array('name' => 'CONGO', 'code' => '242'),
            'CH' => array('name' => 'SWITZERLAND', 'code' => '41'),
            'CI' => array('name' => 'COTE D IVOIRE', 'code' => '225'),
            'CK' => array('name' => 'COOK ISLANDS', 'code' => '682'),
            'CL' => array('name' => 'CHILE', 'code' => '56'),
            'CM' => array('name' => 'CAMEROON', 'code' => '237'),
            'CN' => array('name' => 'CHINA', 'code' => '86'),
            'CO' => array('name' => 'COLOMBIA', 'code' => '57'),
            'CR' => array('name' => 'COSTA RICA', 'code' => '506'),
            'CU' => array('name' => 'CUBA', 'code' => '53'),
            'CV' => array('name' => 'CAPE VERDE', 'code' => '238'),
            'CX' => array('name' => 'CHRISTMAS ISLAND', 'code' => '61'),
            'CY' => array('name' => 'CYPRUS', 'code' => '357'),
            'CZ' => array('name' => 'CZECH REPUBLIC', 'code' => '420'),
            'DE' => array('name' => 'GERMANY', 'code' => '49'),
            'DJ' => array('name' => 'DJIBOUTI', 'code' => '253'),
            'DK' => array('name' => 'DENMARK', 'code' => '45'),
            'DM' => array('name' => 'DOMINICA', 'code' => '1767'),
            'DO' => array('name' => 'DOMINICAN REPUBLIC', 'code' => '1809'),
            'DZ' => array('name' => 'ALGERIA', 'code' => '213'),
            'EC' => array('name' => 'ECUADOR', 'code' => '593'),
            'EE' => array('name' => 'ESTONIA', 'code' => '372'),
            'EG' => array('name' => 'EGYPT', 'code' => '20'),
            'ER' => array('name' => 'ERITREA', 'code' => '291'),
            'ES' => array('name' => 'SPAIN', 'code' => '34'),
            'ET' => array('name' => 'ETHIOPIA', 'code' => '251'),
            'FI' => array('name' => 'FINLAND', 'code' => '358'),
            'FJ' => array('name' => 'FIJI', 'code' => '679'),
            'FK' => array('name' => 'FALKLAND ISLANDS (MALVINAS)', 'code' => '500'),
            'FM' => array('name' => 'MICRONESIA, FEDERATED STATES OF', 'code' => '691'),
            'FO' => array('name' => 'FAROE ISLANDS', 'code' => '298'),
            'FR' => array('name' => 'FRANCE', 'code' => '33'),
            'GA' => array('name' => 'GABON', 'code' => '241'),
            'GB' => array('name' => 'UNITED KINGDOM', 'code' => '44'),
            'GD' => array('name' => 'GRENADA', 'code' => '1473'),
            'GE' => array('name' => 'GEORGIA', 'code' => '995'),
            'GH' => array('name' => 'GHANA', 'code' => '233'),
            'GI' => array('name' => 'GIBRALTAR', 'code' => '350'),
            'GL' => array('name' => 'GREENLAND', 'code' => '299'),
            'GM' => array('name' => 'GAMBIA', 'code' => '220'),
            'GN' => array('name' => 'GUINEA', 'code' => '224'),
            'GQ' => array('name' => 'EQUATORIAL GUINEA', 'code' => '240'),
            'GR' => array('name' => 'GREECE', 'code' => '30'),
            'GT' => array('name' => 'GUATEMALA', 'code' => '502'),
            'GU' => array('name' => 'GUAM', 'code' => '1671'),
            'GW' => array('name' => 'GUINEA-BISSAU', 'code' => '245'),
            'GY' => array('name' => 'GUYANA', 'code' => '592'),
            'HK' => array('name' => 'HONG KONG', 'code' => '852'),
            'HN' => array('name' => 'HONDURAS', 'code' => '504'),
            'HR' => array('name' => 'CROATIA', 'code' => '385'),
            'HT' => array('name' => 'HAITI', 'code' => '509'),
            'HU' => array('name' => 'HUNGARY', 'code' => '36'),
            'ID' => array('name' => 'INDONESIA', 'code' => '62'),
            'IE' => array('name' => 'IRELAND', 'code' => '353'),
            'IL' => array('name' => 'ISRAEL', 'code' => '972'),
            'IM' => array('name' => 'ISLE OF MAN', 'code' => '44'),
            'IN' => array('name' => 'INDIA', 'code' => '91'),
            'IQ' => array('name' => 'IRAQ', 'code' => '964'),
            'IR' => array('name' => 'IRAN, ISLAMIC REPUBLIC OF', 'code' => '98'),
            'IS' => array('name' => 'ICELAND', 'code' => '354'),
            'IT' => array('name' => 'ITALY', 'code' => '39'),
            'JM' => array('name' => 'JAMAICA', 'code' => '1876'),
            'JO' => array('name' => 'JORDAN', 'code' => '962'),
            'JP' => array('name' => 'JAPAN', 'code' => '81'),
            'KE' => array('name' => 'KENYA', 'code' => '254'),
            'KG' => array('name' => 'KYRGYZSTAN', 'code' => '996'),
            'KH' => array('name' => 'CAMBODIA', 'code' => '855'),
            'KI' => array('name' => 'KIRIBATI', 'code' => '686'),
            'KM' => array('name' => 'COMOROS', 'code' => '269'),
            'KN' => array('name' => 'SAINT KITTS AND NEVIS', 'code' => '1869'),
            'KP' => array('name' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF', 'code' => '850'),
            'KR' => array('name' => 'KOREA REPUBLIC OF', 'code' => '82'),
            'KW' => array('name' => 'KUWAIT', 'code' => '965'),
            'KY' => array('name' => 'CAYMAN ISLANDS', 'code' => '1345'),
            'KZ' => array('name' => 'KAZAKSTAN', 'code' => '7'),
            'LA' => array('name' => 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'code' => '856'),
            'LB' => array('name' => 'LEBANON', 'code' => '961'),
            'LC' => array('name' => 'SAINT LUCIA', 'code' => '1758'),
            'LI' => array('name' => 'LIECHTENSTEIN', 'code' => '423'),
            'LK' => array('name' => 'SRI LANKA', 'code' => '94'),
            'LR' => array('name' => 'LIBERIA', 'code' => '231'),
            'LS' => array('name' => 'LESOTHO', 'code' => '266'),
            'LT' => array('name' => 'LITHUANIA', 'code' => '370'),
            'LU' => array('name' => 'LUXEMBOURG', 'code' => '352'),
            'LV' => array('name' => 'LATVIA', 'code' => '371'),
            'LY' => array('name' => 'LIBYAN ARAB JAMAHIRIYA', 'code' => '218'),
            'MA' => array('name' => 'MOROCCO', 'code' => '212'),
            'MC' => array('name' => 'MONACO', 'code' => '377'),
            'MD' => array('name' => 'MOLDOVA, REPUBLIC OF', 'code' => '373'),
            'ME' => array('name' => 'MONTENEGRO', 'code' => '382'),
            'MF' => array('name' => 'SAINT MARTIN', 'code' => '1599'),
            'MG' => array('name' => 'MADAGASCAR', 'code' => '261'),
            'MH' => array('name' => 'MARSHALL ISLANDS', 'code' => '692'),
            'MK' => array('name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'code' => '389'),
            'ML' => array('name' => 'MALI', 'code' => '223'),
            'MM' => array('name' => 'MYANMAR', 'code' => '95'),
            'MN' => array('name' => 'MONGOLIA', 'code' => '976'),
            'MO' => array('name' => 'MACAU', 'code' => '853'),
            'MP' => array('name' => 'NORTHERN MARIANA ISLANDS', 'code' => '1670'),
            'MR' => array('name' => 'MAURITANIA', 'code' => '222'),
            'MS' => array('name' => 'MONTSERRAT', 'code' => '1664'),
            'MT' => array('name' => 'MALTA', 'code' => '356'),
            'MU' => array('name' => 'MAURITIUS', 'code' => '230'),
            'MV' => array('name' => 'MALDIVES', 'code' => '960'),
            'MW' => array('name' => 'MALAWI', 'code' => '265'),
            'MX' => array('name' => 'MEXICO', 'code' => '52'),
            'MY' => array('name' => 'MALAYSIA', 'code' => '60'),
            'MZ' => array('name' => 'MOZAMBIQUE', 'code' => '258'),
            'NA' => array('name' => 'NAMIBIA', 'code' => '264'),
            'NC' => array('name' => 'NEW CALEDONIA', 'code' => '687'),
            'NE' => array('name' => 'NIGER', 'code' => '227'),
            'NG' => array('name' => 'NIGERIA', 'code' => '234'),
            'NI' => array('name' => 'NICARAGUA', 'code' => '505'),
            'NL' => array('name' => 'NETHERLANDS', 'code' => '31'),
            'NO' => array('name' => 'NORWAY', 'code' => '47'),
            'NP' => array('name' => 'NEPAL', 'code' => '977'),
            'NR' => array('name' => 'NAURU', 'code' => '674'),
            'NU' => array('name' => 'NIUE', 'code' => '683'),
            'NZ' => array('name' => 'NEW ZEALAND', 'code' => '64'),
            'OM' => array('name' => 'OMAN', 'code' => '968'),
            'PA' => array('name' => 'PANAMA', 'code' => '507'),
            'PE' => array('name' => 'PERU', 'code' => '51'),
            'PF' => array('name' => 'FRENCH POLYNESIA', 'code' => '689'),
            'PG' => array('name' => 'PAPUA NEW GUINEA', 'code' => '675'),
            'PH' => array('name' => 'PHILIPPINES', 'code' => '63'),
            'PK' => array('name' => 'PAKISTAN', 'code' => '92'),
            'PL' => array('name' => 'POLAND', 'code' => '48'),
            'PM' => array('name' => 'SAINT PIERRE AND MIQUELON', 'code' => '508'),
            'PN' => array('name' => 'PITCAIRN', 'code' => '870'),
            'PR' => array('name' => 'PUERTO RICO', 'code' => '1'),
            'PT' => array('name' => 'PORTUGAL', 'code' => '351'),
            'PW' => array('name' => 'PALAU', 'code' => '680'),
            'PY' => array('name' => 'PARAGUAY', 'code' => '595'),
            'QA' => array('name' => 'QATAR', 'code' => '974'),
            'RO' => array('name' => 'ROMANIA', 'code' => '40'),
            'RS' => array('name' => 'SERBIA', 'code' => '381'),
            'RU' => array('name' => 'RUSSIAN FEDERATION', 'code' => '7'),
            'RW' => array('name' => 'RWANDA', 'code' => '250'),
            'SA' => array('name' => 'SAUDI ARABIA', 'code' => '966'),
            'SB' => array('name' => 'SOLOMON ISLANDS', 'code' => '677'),
            'SC' => array('name' => 'SEYCHELLES', 'code' => '248'),
            'SD' => array('name' => 'SUDAN', 'code' => '249'),
            'SE' => array('name' => 'SWEDEN', 'code' => '46'),
            'SG' => array('name' => 'SINGAPORE', 'code' => '65'),
            'SH' => array('name' => 'SAINT HELENA', 'code' => '290'),
            'SI' => array('name' => 'SLOVENIA', 'code' => '386'),
            'SK' => array('name' => 'SLOVAKIA', 'code' => '421'),
            'SL' => array('name' => 'SIERRA LEONE', 'code' => '232'),
            'SM' => array('name' => 'SAN MARINO', 'code' => '378'),
            'SN' => array('name' => 'SENEGAL', 'code' => '221'),
            'SO' => array('name' => 'SOMALIA', 'code' => '252'),
            'SR' => array('name' => 'SURINAME', 'code' => '597'),
            'ST' => array('name' => 'SAO TOME AND PRINCIPE', 'code' => '239'),
            'SV' => array('name' => 'EL SALVADOR', 'code' => '503'),
            'SY' => array('name' => 'SYRIAN ARAB REPUBLIC', 'code' => '963'),
            'SZ' => array('name' => 'SWAZILAND', 'code' => '268'),
            'TC' => array('name' => 'TURKS AND CAICOS ISLANDS', 'code' => '1649'),
            'TD' => array('name' => 'CHAD', 'code' => '235'),
            'TG' => array('name' => 'TOGO', 'code' => '228'),
            'TH' => array('name' => 'THAILAND', 'code' => '66'),
            'TJ' => array('name' => 'TAJIKISTAN', 'code' => '992'),
            'TK' => array('name' => 'TOKELAU', 'code' => '690'),
            'TL' => array('name' => 'TIMOR-LESTE', 'code' => '670'),
            'TM' => array('name' => 'TURKMENISTAN', 'code' => '993'),
            'TN' => array('name' => 'TUNISIA', 'code' => '216'),
            'TO' => array('name' => 'TONGA', 'code' => '676'),
            'TR' => array('name' => 'TURKEY', 'code' => '90'),
            'TT' => array('name' => 'TRINIDAD AND TOBAGO', 'code' => '1868'),
            'TV' => array('name' => 'TUVALU', 'code' => '688'),
            'TW' => array('name' => 'TAIWAN, PROVINCE OF CHINA', 'code' => '886'),
            'TZ' => array('name' => 'TANZANIA, UNITED REPUBLIC OF', 'code' => '255'),
            'UA' => array('name' => 'UKRAINE', 'code' => '380'),
            'UG' => array('name' => 'UGANDA', 'code' => '256'),
            'US' => array('name' => 'UNITED STATES', 'code' => '1'),
            'UY' => array('name' => 'URUGUAY', 'code' => '598'),
            'UZ' => array('name' => 'UZBEKISTAN', 'code' => '998'),
            'VA' => array('name' => 'HOLY SEE (VATICAN CITY STATE)', 'code' => '39'),
            'VC' => array('name' => 'SAINT VINCENT AND THE GRENADINES', 'code' => '1784'),
            'VE' => array('name' => 'VENEZUELA', 'code' => '58'),
            'VG' => array('name' => 'VIRGIN ISLANDS, BRITISH', 'code' => '1284'),
            'VI' => array('name' => 'VIRGIN ISLANDS, U.S.', 'code' => '1340'),
            'VN' => array('name' => 'VIET NAM', 'code' => '84'),
            'VU' => array('name' => 'VANUATU', 'code' => '678'),
            'WF' => array('name' => 'WALLIS AND FUTUNA', 'code' => '681'),
            'WS' => array('name' => 'SAMOA', 'code' => '685'),
            'XK' => array('name' => 'KOSOVO', 'code' => '381'),
            'YE' => array('name' => 'YEMEN', 'code' => '967'),
            'YT' => array('name' => 'MAYOTTE', 'code' => '262'),
            'ZA' => array('name' => 'SOUTH AFRICA', 'code' => '27'),
            'ZM' => array('name' => 'ZAMBIA', 'code' => '260'),
            'ZW' => array('name' => 'ZIMBABWE', 'code' => '263')
        );

        try{
            return $countryArray[$coutry_code]['code'];
        }catch (\Exception $e){
            return '225';
        }
    }

    public static function listOptionChoisirPays(){
        $listOptionChoisirPays = "
            <optgroup label='Other countries'>
                <option data-countryCode='GB' value='44' Selected>UK (+44)</option>
                <option data-countryCode='US' value='1'>USA (+1)</option>
                <option data-countryCode='DZ' value='213'>Algeria (+213)</option>
                <option data-countryCode='AD' value='376'>Andorra (+376)</option>
                <option data-countryCode='AO' value='244'>Angola (+244)</option>
                <option data-countryCode='AI' value='1264'>Anguilla (+1264)</option>
                <option data-countryCode='AG' value='1268'>Antigua &amp; Barbuda (+1268)</option>
                <option data-countryCode='AR' value='54'>Argentina (+54)</option>
                <option data-countryCode='AM' value='374'>Armenia (+374)</option>
                <option data-countryCode='AW' value='297'>Aruba (+297)</option>
                <option data-countryCode='AU' value='61'>Australia (+61)</option>
                <option data-countryCode='AT' value='43'>Austria (+43)</option>
                <option data-countryCode='AZ' value='994'>Azerbaijan (+994)</option>
                <option data-countryCode='BS' value='1242'>Bahamas (+1242)</option>
                <option data-countryCode='BH' value='973'>Bahrain (+973)</option>
                <option data-countryCode='BD' value='880'>Bangladesh (+880)</option>
                <option data-countryCode='BB' value='1246'>Barbados (+1246)</option>
                <option data-countryCode='BY' value='375'>Belarus (+375)</option>
                <option data-countryCode='BE' value='32'>Belgium (+32)</option>
                <option data-countryCode='BZ' value='501'>Belize (+501)</option>
                <option data-countryCode='BJ' value='229'>Benin (+229)</option>
                <option data-countryCode='BM' value='1441'>Bermuda (+1441)</option>
                <option data-countryCode='BT' value='975'>Bhutan (+975)</option>
                <option data-countryCode='BO' value='591'>Bolivia (+591)</option>
                <option data-countryCode='BA' value='387'>Bosnia Herzegovina (+387)</option>
                <option data-countryCode='BW' value='267'>Botswana (+267)</option>
                <option data-countryCode='BR' value='55'>Brazil (+55)</option>
                <option data-countryCode='BN' value='673'>Brunei (+673)</option>
                <option data-countryCode='BG' value='359'>Bulgaria (+359)</option>
                <option data-countryCode='BF' value='226'>Burkina Faso (+226)</option>
                <option data-countryCode='BI' value='257'>Burundi (+257)</option>
                <option data-countryCode='KH' value='855'>Cambodia (+855)</option>
                <option data-countryCode='CM' value='237'>Cameroon (+237)</option>
                <option data-countryCode='CA' value='1'>Canada (+1)</option>
                <option data-countryCode='CV' value='238'>Cape Verde Islands (+238)</option>
                <option data-countryCode='KY' value='1345'>Cayman Islands (+1345)</option>
                <option data-countryCode='CF' value='236'>Central African Republic (+236)</option>
                <option data-countryCode='CL' value='56'>Chile (+56)</option>
                <option data-countryCode='CN' value='86'>China (+86)</option>
                <option data-countryCode='CO' value='57'>Colombia (+57)</option>
                <option data-countryCode='KM' value='269'>Comoros (+269)</option>
                <option data-countryCode='CG' value='242'>Congo (+242)</option>
                <option data-countryCode='CK' value='682'>Cook Islands (+682)</option>
                <option data-countryCode='CR' value='506'>Costa Rica (+506)</option>
                <option data-countryCode='CI' value='225' selected>Côte d'Ivoire (+225)</option>
                <option data-countryCode='HR' value='385'>Croatia (+385)</option>
                <option data-countryCode='CU' value='53'>Cuba (+53)</option>
                <option data-countryCode='CY' value='90392'>Cyprus North (+90392)</option>
                <option data-countryCode='CY' value='357'>Cyprus South (+357)</option>
                <option data-countryCode='CZ' value='42'>Czech Republic (+42)</option>
                <option data-countryCode='DK' value='45'>Denmark (+45)</option>
                <option data-countryCode='DJ' value='253'>Djibouti (+253)</option>
                <option data-countryCode='DM' value='1809'>Dominica (+1809)</option>
                <option data-countryCode='DO' value='1809'>Dominican Republic (+1809)</option>
                <option data-countryCode='EC' value='593'>Ecuador (+593)</option>
                <option data-countryCode='EG' value='20'>Egypt (+20)</option>
                <option data-countryCode='SV' value='503'>El Salvador (+503)</option>
                <option data-countryCode='GQ' value='240'>Equatorial Guinea (+240)</option>
                <option data-countryCode='ER' value='291'>Eritrea (+291)</option>
                <option data-countryCode='EE' value='372'>Estonia (+372)</option>
                <option data-countryCode='ET' value='251'>Ethiopia (+251)</option>
                <option data-countryCode='FK' value='500'>Falkland Islands (+500)</option>
                <option data-countryCode='FO' value='298'>Faroe Islands (+298)</option>
                <option data-countryCode='FJ' value='679'>Fiji (+679)</option>
                <option data-countryCode='FI' value='358'>Finland (+358)</option>
                <option data-countryCode='FR' value='33'>France (+33)</option>
                <option data-countryCode='GF' value='594'>French Guiana (+594)</option>
                <option data-countryCode='PF' value='689'>French Polynesia (+689)</option>
                <option data-countryCode='GA' value='241'>Gabon (+241)</option>
                <option data-countryCode='GM' value='220'>Gambia (+220)</option>
                <option data-countryCode='GE' value='7880'>Georgia (+7880)</option>
                <option data-countryCode='DE' value='49'>Germany (+49)</option>
                <option data-countryCode='GH' value='233'>Ghana (+233)</option>
                <option data-countryCode='GI' value='350'>Gibraltar (+350)</option>
                <option data-countryCode='GR' value='30'>Greece (+30)</option>
                <option data-countryCode='GL' value='299'>Greenland (+299)</option>
                <option data-countryCode='GD' value='1473'>Grenada (+1473)</option>
                <option data-countryCode='GP' value='590'>Guadeloupe (+590)</option>
                <option data-countryCode='GU' value='671'>Guam (+671)</option>
                <option data-countryCode='GT' value='502'>Guatemala (+502)</option>
                <option data-countryCode='GN' value='224'>Guinea (+224)</option>
                <option data-countryCode='GW' value='245'>Guinea - Bissau (+245)</option>
                <option data-countryCode='GY' value='592'>Guyana (+592)</option>
                <option data-countryCode='HT' value='509'>Haiti (+509)</option>
                <option data-countryCode='HN' value='504'>Honduras (+504)</option>
                <option data-countryCode='HK' value='852'>Hong Kong (+852)</option>
                <option data-countryCode='HU' value='36'>Hungary (+36)</option>
                <option data-countryCode='IS' value='354'>Iceland (+354)</option>
                <option data-countryCode='IN' value='91'>India (+91)</option>
                <option data-countryCode='ID' value='62'>Indonesia (+62)</option>
                <option data-countryCode='IR' value='98'>Iran (+98)</option>
                <option data-countryCode='IQ' value='964'>Iraq (+964)</option>
                <option data-countryCode='IE' value='353'>Ireland (+353)</option>
                <option data-countryCode='IL' value='972'>Israel (+972)</option>
                <option data-countryCode='IT' value='39'>Italy (+39)</option>
                <option data-countryCode='JM' value='1876'>Jamaica (+1876)</option>
                <option data-countryCode='JP' value='81'>Japan (+81)</option>
                <option data-countryCode='JO' value='962'>Jordan (+962)</option>
                <option data-countryCode='KZ' value='7'>Kazakhstan (+7)</option>
                <option data-countryCode='KE' value='254'>Kenya (+254)</option>
                <option data-countryCode='KI' value='686'>Kiribati (+686)</option>
                <option data-countryCode='KP' value='850'>Korea North (+850)</option>
                <option data-countryCode='KR' value='82'>Korea South (+82)</option>
                <option data-countryCode='KW' value='965'>Kuwait (+965)</option>
                <option data-countryCode='KG' value='996'>Kyrgyzstan (+996)</option>
                <option data-countryCode='LA' value='856'>Laos (+856)</option>
                <option data-countryCode='LV' value='371'>Latvia (+371)</option>
                <option data-countryCode='LB' value='961'>Lebanon (+961)</option>
                <option data-countryCode='LS' value='266'>Lesotho (+266)</option>
                <option data-countryCode='LR' value='231'>Liberia (+231)</option>
                <option data-countryCode='LY' value='218'>Libya (+218)</option>
                <option data-countryCode='LI' value='417'>Liechtenstein (+417)</option>
                <option data-countryCode='LT' value='370'>Lithuania (+370)</option>
                <option data-countryCode='LU' value='352'>Luxembourg (+352)</option>
                <option data-countryCode='MO' value='853'>Macao (+853)</option>
                <option data-countryCode='MK' value='389'>Macedonia (+389)</option>
                <option data-countryCode='MG' value='261'>Madagascar (+261)</option>
                <option data-countryCode='MW' value='265'>Malawi (+265)</option>
                <option data-countryCode='MY' value='60'>Malaysia (+60)</option>
                <option data-countryCode='MV' value='960'>Maldives (+960)</option>
                <option data-countryCode='ML' value='223'>Mali (+223)</option>
                <option data-countryCode='MT' value='356'>Malta (+356)</option>
                <option data-countryCode='MH' value='692'>Marshall Islands (+692)</option>
                <option data-countryCode='MQ' value='596'>Martinique (+596)</option>
                <option data-countryCode='MR' value='222'>Mauritania (+222)</option>
                <option data-countryCode='YT' value='269'>Mayotte (+269)</option>
                <option data-countryCode='MX' value='52'>Mexico (+52)</option>
                <option data-countryCode='FM' value='691'>Micronesia (+691)</option>
                <option data-countryCode='MD' value='373'>Moldova (+373)</option>
                <option data-countryCode='MC' value='377'>Monaco (+377)</option>
                <option data-countryCode='MN' value='976'>Mongolia (+976)</option>
                <option data-countryCode='MS' value='1664'>Montserrat (+1664)</option>
                <option data-countryCode='MA' value='212'>Morocco (+212)</option>
                <option data-countryCode='MZ' value='258'>Mozambique (+258)</option>
                <option data-countryCode='MN' value='95'>Myanmar (+95)</option>
                <option data-countryCode='NA' value='264'>Namibia (+264)</option>
                <option data-countryCode='NR' value='674'>Nauru (+674)</option>
                <option data-countryCode='NP' value='977'>Nepal (+977)</option>
                <option data-countryCode='NL' value='31'>Netherlands (+31)</option>
                <option data-countryCode='NC' value='687'>New Caledonia (+687)</option>
                <option data-countryCode='NZ' value='64'>New Zealand (+64)</option>
                <option data-countryCode='NI' value='505'>Nicaragua (+505)</option>
                <option data-countryCode='NE' value='227'>Niger (+227)</option>
                <option data-countryCode='NG' value='234'>Nigeria (+234)</option>
                <option data-countryCode='NU' value='683'>Niue (+683)</option>
                <option data-countryCode='NF' value='672'>Norfolk Islands (+672)</option>
                <option data-countryCode='NP' value='670'>Northern Marianas (+670)</option>
                <option data-countryCode='NO' value='47'>Norway (+47)</option>
                <option data-countryCode='OM' value='968'>Oman (+968)</option>
                <option data-countryCode='PW' value='680'>Palau (+680)</option>
                <option data-countryCode='PA' value='507'>Panama (+507)</option>
                <option data-countryCode='PG' value='675'>Papua New Guinea (+675)</option>
                <option data-countryCode='PY' value='595'>Paraguay (+595)</option>
                <option data-countryCode='PE' value='51'>Peru (+51)</option>
                <option data-countryCode='PH' value='63'>Philippines (+63)</option>
                <option data-countryCode='PL' value='48'>Poland (+48)</option>
                <option data-countryCode='PT' value='351'>Portugal (+351)</option>
                <option data-countryCode='PR' value='1787'>Puerto Rico (+1787)</option>
                <option data-countryCode='QA' value='974'>Qatar (+974)</option>
                <option data-countryCode='RE' value='262'>Reunion (+262)</option>
                <option data-countryCode='RO' value='40'>Romania (+40)</option>
                <option data-countryCode='RU' value='7'>Russia (+7)</option>
                <option data-countryCode='RW' value='250'>Rwanda (+250)</option>
                <option data-countryCode='SM' value='378'>San Marino (+378)</option>
                <option data-countryCode='ST' value='239'>Sao Tome &amp; Principe (+239)</option>
                <option data-countryCode='SA' value='966'>Saudi Arabia (+966)</option>
                <option data-countryCode='SN' value='221'>Senegal (+221)</option>
                <option data-countryCode='CS' value='381'>Serbia (+381)</option>
                <option data-countryCode='SC' value='248'>Seychelles (+248)</option>
                <option data-countryCode='SL' value='232'>Sierra Leone (+232)</option>
                <option data-countryCode='SG' value='65'>Singapore (+65)</option>
                <option data-countryCode='SK' value='421'>Slovak Republic (+421)</option>
                <option data-countryCode='SI' value='386'>Slovenia (+386)</option>
                <option data-countryCode='SB' value='677'>Solomon Islands (+677)</option>
                <option data-countryCode='SO' value='252'>Somalia (+252)</option>
                <option data-countryCode='ZA' value='27'>South Africa (+27)</option>
                <option data-countryCode='ES' value='34'>Spain (+34)</option>
                <option data-countryCode='LK' value='94'>Sri Lanka (+94)</option>
                <option data-countryCode='SH' value='290'>St. Helena (+290)</option>
                <option data-countryCode='KN' value='1869'>St. Kitts (+1869)</option>
                <option data-countryCode='SC' value='1758'>St. Lucia (+1758)</option>
                <option data-countryCode='SD' value='249'>Sudan (+249)</option>
                <option data-countryCode='SR' value='597'>Suriname (+597)</option>
                <option data-countryCode='SZ' value='268'>Swaziland (+268)</option>
                <option data-countryCode='SE' value='46'>Sweden (+46)</option>
                <option data-countryCode='CH' value='41'>Switzerland (+41)</option>
                <option data-countryCode='SI' value='963'>Syria (+963)</option>
                <option data-countryCode='TW' value='886'>Taiwan (+886)</option>
                <option data-countryCode='TJ' value='7'>Tajikstan (+7)</option>
                <option data-countryCode='TH' value='66'>Thailand (+66)</option>
                <option data-countryCode='TG' value='228'>Togo (+228)</option>
                <option data-countryCode='TO' value='676'>Tonga (+676)</option>
                <option data-countryCode='TT' value='1868'>Trinidad &amp; Tobago (+1868)</option>
                <option data-countryCode='TN' value='216'>Tunisia (+216)</option>
                <option data-countryCode='TR' value='90'>Turkey (+90)</option>
                <option data-countryCode='TM' value='7'>Turkmenistan (+7)</option>
                <option data-countryCode='TM' value='993'>Turkmenistan (+993)</option>
                <option data-countryCode='TC' value='1649'>Turks &amp; Caicos Islands (+1649)</option>
                <option data-countryCode='TV' value='688'>Tuvalu (+688)</option>
                <option data-countryCode='UG' value='256'>Uganda (+256)</option>
                <!-- <option data-countryCode='GB' value='44'>UK (+44)</option> -->
                <option data-countryCode='UA' value='380'>Ukraine (+380)</option>
                <option data-countryCode='AE' value='971'>United Arab Emirates (+971)</option>
                <option data-countryCode='UY' value='598'>Uruguay (+598)</option>
                <!-- <option data-countryCode='US' value='1'>USA (+1)</option> -->
                <option data-countryCode='UZ' value='7'>Uzbekistan (+7)</option>
                <option data-countryCode='VU' value='678'>Vanuatu (+678)</option>
                <option data-countryCode='VA' value='379'>Vatican City (+379)</option>
                <option data-countryCode='VE' value='58'>Venezuela (+58)</option>
                <option data-countryCode='VN' value='84'>Vietnam (+84)</option>
                <option data-countryCode='VG' value='84'>Virgin Islands - British (+1284)</option>
                <option data-countryCode='VI' value='84'>Virgin Islands - US (+1340)</option>
                <option data-countryCode='WF' value='681'>Wallis &amp; Futuna (+681)</option>
                <option data-countryCode='YE' value='969'>Yemen (North)(+969)</option>
                <option data-countryCode='YE' value='967'>Yemen (South)(+967)</option>
                <option data-countryCode='ZM' value='260'>Zambia (+260)</option>
                <option data-countryCode='ZW' value='263'>Zimbabwe (+263)</option>
            </optgroup>";

            return $listOptionChoisirPays;
        }
}
