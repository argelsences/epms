<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends ReadOnlyBase
{
    //
    protected $countries = [ 
        ["name"=> "Afghanistan", "code"=> "AF"], 
        ["name"=> "Aland Islands", "code"=> "AX"], 
        ["name"=> "Albania", "code"=> "AL"], 
        ["name"=> "Algeria", "code"=> "DZ"], 
        ["name"=> "American Samoa", "code"=> "AS"], 
        ["name"=> "AndorrA", "code"=> "AD"], 
        ["name"=> "Angola", "code"=> "AO"], 
        ["name"=> "Anguilla", "code"=> "AI"], 
        ["name"=> "Antarctica", "code"=> "AQ"], 
        ["name"=> "Antigua and Barbuda", "code"=> "AG"], 
        ["name"=> "Argentina", "code"=> "AR"], 
        ["name"=> "Armenia", "code"=> "AM"], 
        ["name"=> "Aruba", "code"=> "AW"], 
        ["name"=> "Australia", "code"=> "AU"], 
        ["name"=> "Austria", "code"=> "AT"], 
        ["name"=> "Azerbaijan", "code"=> "AZ"], 
        ["name"=> "Bahamas", "code"=> "BS"], 
        ["name"=> "Bahrain", "code"=> "BH"], 
        ["name"=> "Bangladesh", "code"=> "BD"], 
        ["name"=> "Barbados", "code"=> "BB"], 
        ["name"=> "Belarus", "code"=> "BY"], 
        ["name"=> "Belgium", "code"=> "BE"], 
        ["name"=> "Belize", "code"=> "BZ"], 
        ["name"=> "Benin", "code"=> "BJ"], 
        ["name"=> "Bermuda", "code"=> "BM"], 
        ["name"=> "Bhutan", "code"=> "BT"], 
        ["name"=> "Bolivia", "code"=> "BO"], 
        ["name"=> "Bosnia and Herzegovina", "code"=> "BA"], 
        ["name"=> "Botswana", "code"=> "BW"], 
        ["name"=> "Bouvet Island", "code"=> "BV"], 
        ["name"=> "Brazil", "code"=> "BR"], 
        ["name"=> "British Indian Ocean Territory", "code"=> "IO"], 
        ["name"=> "Brunei Darussalam", "code"=> "BN"], 
        ["name"=> "Bulgaria", "code"=> "BG"], 
        ["name"=> "Burkina Faso", "code"=> "BF"], 
        ["name"=> "Burundi", "code"=> "BI"], 
        ["name"=> "Cambodia", "code"=> "KH"], 
        ["name"=> "Cameroon", "code"=> "CM"], 
        ["name"=> "Canada", "code"=> "CA"], 
        ["name"=> "Cape Verde", "code"=> "CV"], 
        ["name"=> "Cayman Islands", "code"=> "KY"], 
        ["name"=> "Central African Republic", "code"=> "CF"], 
        ["name"=> "Chad", "code"=> "TD"], 
        ["name"=> "Chile", "code"=> "CL"], 
        ["name"=> "China", "code"=> "CN"], 
        ["name"=> "Christmas Island", "code"=> "CX"], 
        ["name"=> "Cocos (Keeling) Islands", "code"=> "CC"], 
        ["name"=> "Colombia", "code"=> "CO"], 
        ["name"=> "Comoros", "code"=> "KM"], 
        ["name"=> "Congo", "code"=> "CG"], 
        ["name"=> "Congo, The Democratic Republic of the", "code"=> "CD"], 
        ["name"=> "Cook Islands", "code"=> "CK"], 
        ["name"=> "Costa Rica", "code"=> "CR"], 
        ["name"=> "Cote D'Ivoire", "code"=> "CI"], 
        ["name"=> "Croatia", "code"=> "HR"], 
        ["name"=> "Cuba", "code"=> "CU"], 
        ["name"=> "Cyprus", "code"=> "CY"], 
        ["name"=> "Czech Republic", "code"=> "CZ"], 
        ["name"=> "Denmark", "code"=> "DK"], 
        ["name"=> "Djibouti", "code"=> "DJ"], 
        ["name"=> "Dominica", "code"=> "DM"], 
        ["name"=> "Dominican Republic", "code"=> "DO"], 
        ["name"=> "Ecuador", "code"=> "EC"], 
        ["name"=> "Egypt", "code"=> "EG"], 
        ["name"=> "El Salvador", "code"=> "SV"], 
        ["name"=> "Equatorial Guinea", "code"=> "GQ"], 
        ["name"=> "Eritrea", "code"=> "ER"], 
        ["name"=> "Estonia", "code"=> "EE"], 
        ["name"=> "Ethiopia", "code"=> "ET"], 
        ["name"=> "Falkland Islands (Malvinas)", "code"=> "FK"], 
        ["name"=> "Faroe Islands", "code"=> "FO"], 
        ["name"=> "Fiji", "code"=> "FJ"], 
        ["name"=> "Finland", "code"=> "FI"], 
        ["name"=> "France", "code"=> "FR"], 
        ["name"=> "French Guiana", "code"=> "GF"], 
        ["name"=> "French Polynesia", "code"=> "PF"], 
        ["name"=> "French Southern Territories", "code"=> "TF"], 
        ["name"=> "Gabon", "code"=> "GA"], 
        ["name"=> "Gambia", "code"=> "GM"], 
        ["name"=> "Georgia", "code"=> "GE"], 
        ["name"=> "Germany", "code"=> "DE"], 
        ["name"=> "Ghana", "code"=> "GH"], 
        ["name"=> "Gibraltar", "code"=> "GI"], 
        ["name"=> "Greece", "code"=> "GR"], 
        ["name"=> "Greenland", "code"=> "GL"], 
        ["name"=> "Grenada", "code"=> "GD"], 
        ["name"=> "Guadeloupe", "code"=> "GP"], 
        ["name"=> "Guam", "code"=> "GU"], 
        ["name"=> "Guatemala", "code"=> "GT"], 
        ["name"=> "Guernsey", "code"=> "GG"], 
        ["name"=> "Guinea", "code"=> "GN"], 
        ["name"=> "Guinea-Bissau", "code"=> "GW"], 
        ["name"=> "Guyana", "code"=> "GY"], 
        ["name"=> "Haiti", "code"=> "HT"], 
        ["name"=> "Heard Island and Mcdonald Islands", "code"=> "HM"], 
        ["name"=> "Holy See (Vatican City State)", "code"=> "VA"], 
        ["name"=> "Honduras", "code"=> "HN"], 
        ["name"=> "Hong Kong", "code"=> "HK"], 
        ["name"=> "Hungary", "code"=> "HU"], 
        ["name"=> "Iceland", "code"=> "IS"], 
        ["name"=> "India", "code"=> "IN"], 
        ["name"=> "Indonesia", "code"=> "ID"], 
        ["name"=> "Iran, Islamic Republic Of", "code"=> "IR"], 
        ["name"=> "Iraq", "code"=> "IQ"], 
        ["name"=> "Ireland", "code"=> "IE"], 
        ["name"=> "Isle of Man", "code"=> "IM"], 
        ["name"=> "Israel", "code"=> "IL"], 
        ["name"=> "Italy", "code"=> "IT"], 
        ["name"=> "Jamaica", "code"=> "JM"], 
        ["name"=> "Japan", "code"=> "JP"], 
        ["name"=> "Jersey", "code"=> "JE"], 
        ["name"=> "Jordan", "code"=> "JO"], 
        ["name"=> "Kazakhstan", "code"=> "KZ"], 
        ["name"=> "Kenya", "code"=> "KE"], 
        ["name"=> "Kiribati", "code"=> "KI"], 
        ["name"=> "Korea, Democratic People's Republic of", "code"=> "KP"], 
        ["name"=> "Korea, Republic of", "code"=> "KR"], 
        ["name"=> "Kuwait", "code"=> "KW"], 
        ["name"=> "Kyrgyzstan", "code"=> "KG"], 
        ["name"=> "Lao People's Democratic Republic", "code"=> "LA"], 
        ["name"=> "Latvia", "code"=> "LV"], 
        ["name"=> "Lebanon", "code"=> "LB"], 
        ["name"=> "Lesotho", "code"=> "LS"], 
        ["name"=> "Liberia", "code"=> "LR"], 
        ["name"=> "Libyan Arab Jamahiriya", "code"=> "LY"], 
        ["name"=> "Liechtenstein", "code"=> "LI"], 
        ["name"=> "Lithuania", "code"=> "LT"], 
        ["name"=> "Luxembourg", "code"=> "LU"], 
        ["name"=> "Macao", "code"=> "MO"], 
        ["name"=> "Macedonia, The Former Yugoslav Republic of", "code"=> "MK"], 
        ["name"=> "Madagascar", "code"=> "MG"], 
        ["name"=> "Malawi", "code"=> "MW"], 
        ["name"=> "Malaysia", "code"=> "MY"], 
        ["name"=> "Maldives", "code"=> "MV"], 
        ["name"=> "Mali", "code"=> "ML"], 
        ["name"=> "Malta", "code"=> "MT"], 
        ["name"=> "Marshall Islands", "code"=> "MH"], 
        ["name"=> "Martinique", "code"=> "MQ"], 
        ["name"=> "Mauritania", "code"=> "MR"], 
        ["name"=> "Mauritius", "code"=> "MU"], 
        ["name"=> "Mayotte", "code"=> "YT"], 
        ["name"=> "Mexico", "code"=> "MX"], 
        ["name"=> "Micronesia, Federated States of", "code"=> "FM"], 
        ["name"=> "Moldova, Republic of", "code"=> "MD"], 
        ["name"=> "Monaco", "code"=> "MC"], 
        ["name"=> "Mongolia", "code"=> "MN"], 
        ["name"=> "Montenegro", "code"=> "ME"],
        ["name"=> "Montserrat", "code"=> "MS"],
        ["name"=> "Morocco", "code"=> "MA"], 
        ["name"=> "Mozambique", "code"=> "MZ"], 
        ["name"=> "Myanmar", "code"=> "MM"], 
        ["name"=> "Namibia", "code"=> "NA"], 
        ["name"=> "Nauru", "code"=> "NR"], 
        ["name"=> "Nepal", "code"=> "NP"], 
        ["name"=> "Netherlands", "code"=> "NL"], 
        ["name"=> "Netherlands Antilles", "code"=> "AN"], 
        ["name"=> "New Caledonia", "code"=> "NC"], 
        ["name"=> "New Zealand", "code"=> "NZ"], 
        ["name"=> "Nicaragua", "code"=> "NI"], 
        ["name"=> "Niger", "code"=> "NE"], 
        ["name"=> "Nigeria", "code"=> "NG"], 
        ["name"=> "Niue", "code"=> "NU"], 
        ["name"=> "Norfolk Island", "code"=> "NF"], 
        ["name"=> "Northern Mariana Islands", "code"=> "MP"], 
        ["name"=> "Norway", "code"=> "NO"], 
        ["name"=> "Oman", "code"=> "OM"], 
        ["name"=> "Pakistan", "code"=> "PK"], 
        ["name"=> "Palau", "code"=> "PW"], 
        ["name"=> "Palestinian Territory, Occupied", "code"=> "PS"], 
        ["name"=> "Panama", "code"=> "PA"], 
        ["name"=> "Papua New Guinea", "code"=> "PG"], 
        ["name"=> "Paraguay", "code"=> "PY"], 
        ["name"=> "Peru", "code"=> "PE"], 
        ["name"=> "Philippines", "code"=> "PH"], 
        ["name"=> "Pitcairn", "code"=> "PN"], 
        ["name"=> "Poland", "code"=> "PL"], 
        ["name"=> "Portugal", "code"=> "PT"], 
        ["name"=> "Puerto Rico", "code"=> "PR"], 
        ["name"=> "Qatar", "code"=> "QA"], 
        ["name"=> "Reunion", "code"=> "RE"], 
        ["name"=> "Romania", "code"=> "RO"], 
        ["name"=> "Russian Federation", "code"=> "RU"], 
        ["name"=> "RWANDA", "code"=> "RW"], 
        ["name"=> "Saint Helena", "code"=> "SH"], 
        ["name"=> "Saint Kitts and Nevis", "code"=> "KN"], 
        ["name"=> "Saint Lucia", "code"=> "LC"], 
        ["name"=> "Saint Pierre and Miquelon", "code"=> "PM"], 
        ["name"=> "Saint Vincent and the Grenadines", "code"=> "VC"], 
        ["name"=> "Samoa", "code"=> "WS"], 
        ["name"=> "San Marino", "code"=> "SM"], 
        ["name"=> "Sao Tome and Principe", "code"=> "ST"], 
        ["name"=> "Saudi Arabia", "code"=> "SA"], 
        ["name"=> "Senegal", "code"=> "SN"], 
        ["name"=> "Serbia", "code"=> "RS"], 
        ["name"=> "Seychelles", "code"=> "SC"], 
        ["name"=> "Sierra Leone", "code"=> "SL"], 
        ["name"=> "Singapore", "code"=> "SG"], 
        ["name"=> "Slovakia", "code"=> "SK"], 
        ["name"=> "Slovenia", "code"=> "SI"], 
        ["name"=> "Solomon Islands", "code"=> "SB"], 
        ["name"=> "Somalia", "code"=> "SO"], 
        ["name"=> "South Africa", "code"=> "ZA"], 
        ["name"=> "South Georgia and the South Sandwich Islands", "code"=> "GS"], 
        ["name"=> "Spain", "code"=> "ES"], 
        ["name"=> "Sri Lanka", "code"=> "LK"], 
        ["name"=> "Sudan", "code"=> "SD"], 
        ["name"=> "Suriname", "code"=> "SR"], 
        ["name"=> "Svalbard and Jan Mayen", "code"=> "SJ"], 
        ["name"=> "Swaziland", "code"=> "SZ"], 
        ["name"=> "Sweden", "code"=> "SE"], 
        ["name"=> "Switzerland", "code"=> "CH"], 
        ["name"=> "Syrian Arab Republic", "code"=> "SY"], 
        ["name"=> "Taiwan, Province of China", "code"=> "TW"], 
        ["name"=> "Tajikistan", "code"=> "TJ"], 
        ["name"=> "Tanzania, United Republic of", "code"=> "TZ"], 
        ["name"=> "Thailand", "code"=> "TH"], 
        ["name"=> "Timor-Leste", "code"=> "TL"], 
        ["name"=> "Togo", "code"=> "TG"], 
        ["name"=> "Tokelau", "code"=> "TK"], 
        ["name"=> "Tonga", "code"=> "TO"], 
        ["name"=> "Trinidad and Tobago", "code"=> "TT"], 
        ["name"=> "Tunisia", "code"=> "TN"], 
        ["name"=> "Turkey", "code"=> "TR"], 
        ["name"=> "Turkmenistan", "code"=> "TM"], 
        ["name"=> "Turks and Caicos Islands", "code"=> "TC"], 
        ["name"=> "Tuvalu", "code"=> "TV"], 
        ["name"=> "Uganda", "code"=> "UG"], 
        ["name"=> "Ukraine", "code"=> "UA"], 
        ["name"=> "United Arab Emirates", "code"=> "AE"], 
        ["name"=> "United Kingdom", "code"=> "GB"], 
        ["name"=> "United States", "code"=> "US"], 
        ["name"=> "United States Minor Outlying Islands", "code"=> "UM"], 
        ["name"=> "Uruguay", "code"=> "UY"], 
        ["name"=> "Uzbekistan", "code"=> "UZ"], 
        ["name"=> "Vanuatu", "code"=> "VU"], 
        ["name"=> "Venezuela", "code"=> "VE"], 
        ["name"=> "Viet Nam", "code"=> "VN"], 
        ["name"=> "Virgin Islands, British", "code"=> "VG"], 
        ["name"=> "Virgin Islands, U.S.", "code"=> "VI"], 
        ["name"=> "Wallis and Futuna", "code"=> "WF"], 
        ["name"=> "Western Sahara", "code"=> "EH"], 
        ["name"=> "Yemen", "code"=> "YE"], 
        ["name"=> "Zambia", "code"=> "ZM"], 
        ["name"=> "Zimbabwe", "code"=> "ZW"] 
    ];

    /*protected $timezones = [
        ['name' =>'America/Adak'],
        'name' =>'America/Atka',
        'name' =>'America/Anchorage',
        'name' =>'America/Juneau',
        'name' =>'America/Nome',
        'name' =>'America/Yakutat',
        'name' =>'America/Dawson',
        'name' =>'America/Ensenada',
        'name' =>'America/Los_Angeles',
        'name' =>'America/Tijuana',
        'name' =>'America/Vancouver',
        'name' =>'America/Whitehorse',
        'name' =>'Canada/Pacific',
        'name' =>'Canada/Yukon',
        'name' =>'Mexico/BajaNorte',
        'name' =>'America/Boise',
        'name' =>'America/Cambridge_Bay',
        'name' =>'America/Chihuahua',
        'name' =>'America/Dawson_Creek',
        'name' =>'America/Denver', 
        'name' =>'America/Edmonton',
        'name' =>'America/Hermosillo', 
        'name' =>'America/Inuvik', 
        'name' =>'America/Mazatlan' ,
        'name' =>'America/Phoenix', 
        'name' =>'America/Shiprock', 
        'name' =>'America/Yellowknife', 
        'name' =>'Canada/Mountain' ,
        'name' =>'Mexico/BajaSur', 
        'name' =>'America/Belize', 
        'name' =>'America/Cancun', 
        'name' =>'America/Chicago' ,
        'name' =>'America/Costa_Rica', 
        'name' =>'America/El_Salvador' ,
        'name' =>'America/Guatemala' ,
        'name' =>'America/Knox_IN' ,
        'name' =>'America/Managua', 
        'name' =>'America/Menominee' ,
        'name' =>'America/Merida' ,
        'name' =>'America/Mexico_City' ,
        'name' =>'America/Monterrey' ,
        'name' =>'America/Rainy_River' ,
        'name' =>'America/Rankin_Inlet' ,
        'name' =>'America/Regina' ,
        'name' =>'America/Swift_Current' ,
        'name' =>'America/Tegucigalpa', 
        'name' =>'America/Winnipeg' ,
        'name' =>'Canada/Central' ,
        'name' =>'Canada/East-Saskatchewan' ,
        'name' =>'Canada/Saskatchewan' ,
        'name' =>'Chile/EasterIsland' ,
        'name' =>'Mexico/General' ,
        'name' =>'America/Atikokan', 
        'name' =>'America/Bogota' ,
        'name' =>'America/Cayman' ,
        'name' =>'America/Coral_Harbour' ,
        'name' =>'America/Detroit' ,
        'name' =>'America/Fort_Wayne' ,
        'name' =>'America/Grand_Turk', 
        'name' =>'America/Guayaquil' ,
        'name' =>'America/Havana' ,
        'name' =>'America/Indianapolis' ,
        'name' =>'America/Iqaluit' ,
        'name' =>'America/Jamaica' ,
        'name' =>'America/Lima' ,
        'name' =>'America/Louisville', 
        'name' =>'America/Montreal' ,
        'name' => 'America/Nassau' ,
        'name' =>'America/New_York' ,
        'name' => 'America/Nipigon' ,
        'name' =>'America/Panama' ,
        'name' =>'America/Pangnirtung', 
        'name' =>'America/Port-au-Prince', 
        'name' =>'America/Resolute' ,
        'name' =>'America/Thunder_Bay', 
        'name' =>'America/Toronto' ,
        'name' =>'Canada/Eastern' ,
        'name' =>'America/Caracas', 
        'name' =>'America/Anguilla', 
        'name' =>'America/Antigua', 
        'name' =>'America/Aruba' ,
        'name' =>'America/Asuncion', 
        'name' =>'America/Barbados' ,
        'name' =>'America/Blanc-Sablon' ,
        'name' =>'America/Boa_Vista' ,
        'name' =>'America/Campo_Grande', 
        'name' =>'America/Cuiaba' ,
        'name' =>'America/Curacao' ,
        'name' =>'America/Dominica', 
        'name' =>'America/Eirunepe' ,
        'name' =>'America/Glace_Bay' ,
        'name' =>'America/Goose_Bay' ,
        'name' =>'America/Grenada' ,
        'name' =>'America/Guadeloupe', 
        'name' =>'America/Guyana' ,
        'name' =>'America/Halifax' ,
        'name' =>'America/La_Paz' ,
        'name' =>'America/Manaus' ,
        'name' =>'America/Marigot', 
        'name' =>'America/Martinique' ,
        'name' =>'America/Moncton' ,
        'name' =>'America/Montserrat', 
        'name' =>'America/Port_of_Spain', 
        'name' =>'America/Porto_Acre', 
        'name' =>'America/Porto_Velho' ,
        'name' =>'America/Puerto_Rico', 
        'name' =>'America/Rio_Branco' ,
        'name' =>'America/Santiago' ,
        'name' =>'America/Santo_Domingo' ,
        'name' =>'America/St_Barthelemy' ,
        'name' =>'America/St_Kitts' ,
        'name' =>'America/St_Lucia' ,
        'name' =>'America/St_Thomas' ,
        'name' =>'America/St_Vincent', 
        'name' =>'America/Thule' ,
        'name' =>'America/Tortola' ,
        'name' =>'America/Virgin' ,
        'name' =>'Antarctica/Palmer' ,
        'name' =>'Atlantic/Bermuda' ,
        'name' =>'Atlantic/Stanley' ,
        'name' =>'Brazil/Acre' ,
        'name' =>'Brazil/West' ,
        'name' =>'Canada/Atlantic', 
        'name' =>'Chile/Continental' ,
        'name' =>'America/St_Johns' ,
        'name' =>'Canada/Newfoundland' ,
        'name' =>'America/Araguaina' ,
        'name' =>'America/Bahia' ,
        'name' =>'America/Belem' ,
        'name' =>'America/Buenos_Aires' ,
        'name' =>'America/Catamarca' ,
        'name' =>'America/Cayenne' ,
        'name' =>'America/Cordoba' ,
        'name' =>'America/Fortaleza' ,
        'name' =>'America/Godthab' ,
        'name' =>'America/Jujuy' ,
        'name' =>'America/Maceio' ,
        'name' =>'America/Mendoza' ,
        'name' =>'America/Miquelon' ,
        'name' =>'America/Montevideo', 
        'name' =>'America/Paramaribo', 
        'name' =>'America/Recife', 
        'name' =>'America/Rosario' ,
        'name' =>'America/Santarem', 
        'name' =>'America/Sao_Paulo' ,
        'name' =>'Antarctica/Rothera', 
        'name' =>'Brazil/East' ,
        'name' =>'America/Noronha' ,
        'name' =>'Atlantic/South_Georgia', 
        'name' =>'Brazil/DeNoronha' ,
        'name' =>'America/Scoresbysund' ,
        'name' =>'Atlantic/Azores' ,
        'name' =>'Atlantic/Cape_Verde' ,
        'name' =>'Africa/Abidjan' ,
        'name' =>'Africa/Accra', 
        'name' =>'Africa/Bamako' ,
        'name' =>'Africa/Banjul' ,
        'name' =>'Africa/Bissau' ,
        'name' =>'Africa/Casablanca' ,
        'name' =>'Africa/Conakry' ,
        'name' =>'Africa/Dakar' ,
        'name' =>'Africa/El_Aaiun' ,
        'name' =>'Africa/Freetown' ,
        'name' =>'Africa/Lome' ,
        'name' =>'Africa/Monrovia' ,
        'name' =>'Africa/Nouakchott' ,
        'name' =>'Africa/Ouagadougou' ,
        'name' =>'Africa/Sao_Tome' ,
        'name' =>'Africa/Timbuktu' ,
        'name' =>'America/Danmarkshavn' ,
        'name' =>'Atlantic/Canary' ,
        'name' =>'Atlantic/Faeroe' ,
        'name' => 'Atlantic/Faroe' ,
        'name' =>'Atlantic/Madeira' ,
        'name' =>'Atlantic/Reykjavik' ,
        'name' =>'Atlantic/St_Helena' ,
        'name' =>'Europe/Belfast' ,
        'name' =>'Europe/Dublin' ,
        'name' =>'Europe/Guernsey' ,
        'name' =>'Europe/Isle_of_Man' ,
        'name' =>'Europe/Jersey' ,
        'name' =>'Europe/Lisbon' ,
        'name' =>'Europe/London' ,
        'name' =>'Africa/Algiers' ,
        'name' =>'Africa/Bangui' ,
        'name' =>'Africa/Brazzaville' ,
        'name' =>'Africa/Ceuta' ,
        'name' =>'Africa/Douala' ,
        'name' =>'Africa/Kinshasa' ,
        'name' =>'Africa/Lagos' ,
        'name' =>'Africa/Libreville' ,
        'name' =>'Africa/Luanda' ,
        'name' =>'Africa/Malabo' ,
        'name' =>'Africa/Ndjamena' ,
        'name' =>'Africa/Niamey' ,
        'name' =>'Africa/Porto-Novo' ,
        'name' =>'Africa/Tunis' ,
        'name' =>'Africa/Windhoek' ,
        'name' =>'Arctic/Longyearbyen' ,
        'name' =>'Atlantic/Jan_Mayen' ,
        'name' =>'Europe/Amsterdam' ,
        'name' =>'Europe/Andorra' ,
        'name' =>'Europe/Belgrade' ,
        'name' =>'Europe/Berlin' ,
        'name' =>'Europe/Bratislava', 
        'name' =>'Europe/Brussels' ,
        'name' =>'Europe/Budapest' ,
        'name' =>'Europe/Copenhagen', 
        'name' =>'Europe/Gibraltar' ,
        'name' =>'Europe/Ljubljana' ,
        'name' =>'Europe/Luxembourg' ,
        'name' =>'Europe/Madrid' ,
        'name' =>'Europe/Malta' ,
        'name' =>'Europe/Monaco' ,
        'name' =>'Europe/Oslo' ,
        'name' =>'Europe/Paris' ,
        'name' =>'Europe/Podgorica', 
        'name' =>'Europe/Prague' ,
        'name' =>'Europe/Rome' ,
        'name' =>'Europe/San_Marino', 
        'name' =>'Europe/Sarajevo' ,
        'name' =>'Europe/Skopje' ,
        'name' =>'Europe/Stockholm' ,
        'name' =>'Europe/Tirane' ,
        'name' =>'Europe/Vaduz' ,
        'name' =>'Europe/Vatican' ,
        'name' =>'Europe/Vienna' ,
        'name' =>'Europe/Warsaw' ,
        'name' =>'Europe/Zagreb' ,
        'name' =>'Europe/Zurich' ,
        'name' =>'Africa/Blantyre' ,
        'name' =>'Africa/Bujumbura' ,
        'name' =>'Africa/Cairo' ,
        'name' =>'Africa/Gaborone' ,
        'name' =>'Africa/Harare' ,
        'name' =>'Africa/Johannesburg', 
        'name' =>'Africa/Kigali' ,
        'name' =>'Africa/Lubumbashi' ,
        'name' =>'Africa/Lusaka' ,
        'name' =>'Africa/Maputo' ,
        'name' =>'Africa/Maseru' ,
        'name' =>'Africa/Mbabane' ,
        'name' =>'Africa/Tripoli' ,
        'name' =>'Asia/Amman' ,
        'name' =>'Asia/Beirut' ,
        'name' =>'Asia/Damascus', 
        'name' =>'Asia/Gaza' ,
        'name' =>'Asia/Istanbul' ,
        'name' =>'Asia/Jerusalem' ,
        'name' =>'Asia/Nicosia' ,
        'name' =>'Asia/Tel_Aviv' ,
        'name' =>'Europe/Athens' ,
        'name' =>'Europe/Bucharest', 
        'name' =>'Europe/Chisinau' ,
        'name' =>'Europe/Helsinki', 
        'name' =>'Europe/Istanbul' ,
        'name' =>'Europe/Kaliningrad', 
        'name' =>'Europe/Kiev' ,
        'name' =>'Europe/Mariehamn', 
        'name' =>'Europe/Minsk' ,
        'name' =>'Europe/Nicosia', 
        'name' =>'Europe/Riga' ,
        'name' =>'Europe/Simferopol' ,
        'name' =>'Europe/Sofia' ,
        'name' =>'Europe/Tallinn' ,
        'name' =>'Europe/Tiraspol' ,
        'name' =>'Europe/Uzhgorod' ,
        'name' =>'Europe/Vilnius' ,
        'name' =>'Europe/Zaporozhye' ,
        'name' =>'Africa/Addis_Ababa' ,
        'name' =>'Africa/Asmara' ,
        'name' =>'Africa/Asmera' ,
        'name' =>'Africa/Dar_es_Salaam', 
        'name' =>'Africa/Djibouti' ,
        'name' =>'Africa/Kampala', 
        'name' =>'Africa/Khartoum' ,
        'name' =>'Africa/Mogadishu', 
        'name' =>'Africa/Nairobi' ,
        'name' =>'Antarctica/Syowa', 
        'name' =>'Asia/Aden' ,
        'name' =>'Asia/Baghdad' ,
        'name' =>'Asia/Bahrain' ,
        'name' =>'Asia/Kuwait' ,
        'name' =>'Asia/Qatar' ,
        'name' =>'Europe/Moscow' ,
        'name' =>'Europe/Volgograd' ,
        'name' =>'Indian/Antananarivo' ,
        'name' =>'Indian/Comoro' ,
        'name' =>'Indian/Mayotte' ,
        'name' =>'Asia/Tehran' ,
        'name' =>'Asia/Baku' ,
        'name' =>'Asia/Dubai' ,
        'name' =>'Asia/Muscat' ,
        'name' =>'Asia/Tbilisi' ,
        'name' =>'Asia/Yerevan' ,
        'name' =>'Europe/Samara' ,
        'name' =>'Indian/Mahe' ,
        'name' =>'Indian/Mauritius' ,
        'name' =>'Indian/Reunion' ,
        'name' =>'Asia/Kabul' ,
        'name' =>'Asia/Aqtau' ,
        'name' =>'Asia/Aqtobe' ,
        'name' =>'Asia/Ashgabat' ,
        'name' =>'Asia/Ashkhabad' ,
        'name' =>'Asia/Dushanbe' ,
        'name' =>'Asia/Karachi' ,
        'name' =>'Asia/Oral' ,
        'name' =>'Asia/Samarkand' ,
        'name' =>'Asia/Tashkent' ,
        'name' =>'Asia/Yekaterinburg' ,
        'name' =>'Indian/Kerguelen' ,
        'name' =>'Indian/Maldives' ,
        'name' =>'Asia/Calcutta' ,
        'name' =>'Asia/Colombo' ,
        'name' =>'Asia/Kolkata' ,
        'name' =>'Asia/Katmandu' ,
        'name' =>'Antarctica/Mawson' ,
        'name' =>'Antarctica/Vostok', 
        'name' =>'Asia/Almaty' ,
        'name' =>'Asia/Bishkek' ,
        'name' =>'Asia/Dacca' ,
        'name' =>'Asia/Dhaka' ,
        'name' =>'Asia/Novosibirsk' ,
        'name' =>'Asia/Omsk' ,
        'name' =>'Asia/Qyzylorda', 
        'name' =>'Asia/Thimbu' ,
        'name' =>'Asia/Thimphu' ,
        'name' =>'Indian/Chagos' ,
        'name' =>'Asia/Rangoon' ,
        'name' =>'Indian/Cocos' ,
        'name' =>'Antarctica/Davis' ,
        'name' =>'Asia/Bangkok' ,
        'name' =>'Asia/Ho_Chi_Minh', 
        'name' =>'Asia/Hovd' ,
        'name' =>'Asia/Jakarta', 
        'name' =>'Asia/Krasnoyarsk' ,
        'name' => 'Asia/Phnom_Penh', 
        'name' =>'Asia/Pontianak' ,
        'name' =>'Asia/Saigon' ,
        'name' =>'Asia/Vientiane' ,
        'name' =>'Indian/Christmas' ,
        'name' =>'Antarctica/Casey' ,
        'name' =>'Asia/Brunei' ,
        'name' =>'Asia/Choibalsan' ,
        'name' =>'Asia/Chongqing' ,
        'name' =>'Asia/Chungking' ,
        'name' =>'Asia/Harbin' ,
        'name' =>'Asia/Hong_Kong' ,
        'name' =>'Asia/Irkutsk' ,
        'name' =>'Asia/Kashgar' ,
        'name' =>'Asia/Kuala_Lumpur' ,
        'name' =>'Asia/Kuching' ,
        'name' =>'Asia/Macao' ,
        'name' =>'Asia/Macau' ,
        'name' =>'Asia/Makassar' ,
        'name' =>'Asia/Manila' ,
        'name' =>'Asia/Shanghai' ,
        'name' =>'Asia/Singapore' ,
        'name' =>'Asia/Taipei' ,
        'name' =>'Asia/Ujung_Pandang' ,
        'name' =>'Asia/Ulaanbaatar' ,
        'name' =>'Asia/Ulan_Bator' ,
        'name' =>'Asia/Urumqi' ,
        'name' =>'Australia/Perth' ,
        'name' =>'Australia/West' ,
        'name' =>'Australia/Eucla' ,
        'name' =>'Asia/Dili' ,
        'name' =>'Asia/Jayapura' ,
        'name' =>'Asia/Pyongyang' ,
        'name' =>'Asia/Seoul' ,
        'name' =>'Asia/Tokyo' ,
        'name' =>'Asia/Yakutsk' ,
        'name' =>'Australia/Adelaide' ,
        'name' =>'Australia/Broken_Hill' ,
        'name' =>'Australia/Darwin' ,
        'name' =>'Australia/North' ,
        'name' =>'Australia/South' ,
        'name' =>'Australia/Yancowinna' ,
        'name' =>'Antarctica/DumontDUrville', 
        'name' =>'Asia/Sakhalin' ,
        'name' =>'Asia/Vladivostok' ,
        'name' =>'Australia/ACT' ,
        'name' =>'Australia/Brisbane' ,
        'name' =>'Australia/Canberra' ,
        'name' =>'Australia/Currie' ,
        'name' =>'Australia/Hobart' ,
        'name' =>'Australia/Lindeman' ,
        'name' =>'Australia/Melbourne' ,
        'name' =>'Australia/NSW' ,
        'name' =>'Australia/Queensland' ,
        'name' =>'Australia/Sydney' ,
        'name' =>'Australia/Tasmania' ,
        'name' =>'Australia/Victoria', 
        'name' =>'Australia/LHI' ,
        'name' =>'Australia/Lord_Howe' ,
        'name' =>'Asia/Magadan' ,
        'name' =>'Antarctica/McMurdo' ,
        'name' =>'Antarctica/South_Pole' ,
        'name' =>'Asia/Anadyr' ,
        'name' =>'Asia/Kamchatka' ,
    ];*/
    protected $timezones = [
        ['America/Adak'],
        'America/Atka',
        'America/Anchorage',
        'America/Juneau',
        'America/Nome',
        'America/Yakutat',
        'America/Dawson',
        'America/Ensenada',
        'America/Los_Angeles',
        'America/Tijuana',
        'America/Vancouver',
        'America/Whitehorse',
        'Canada/Pacific',
        'Canada/Yukon',
        'Mexico/BajaNorte',
        'America/Boise',
        'America/Cambridge_Bay',
        'America/Chihuahua',
        'America/Dawson_Creek',
        'America/Denver', 
        'America/Edmonton',
        'America/Hermosillo', 
        'America/Inuvik', 
        'America/Mazatlan' ,
        'America/Phoenix', 
        'America/Shiprock', 
        'America/Yellowknife', 
        'Canada/Mountain' ,
        'Mexico/BajaSur', 
        'America/Belize', 
        'America/Cancun', 
        'America/Chicago' ,
        'America/Costa_Rica', 
        'America/El_Salvador' ,
        'America/Guatemala' ,
        'America/Knox_IN' ,
        'America/Managua', 
        'America/Menominee' ,
        'America/Merida' ,
        'America/Mexico_City' ,
        'America/Monterrey' ,
        'America/Rainy_River' ,
        'America/Rankin_Inlet' ,
        'America/Regina' ,
        'America/Swift_Current' ,
        'America/Tegucigalpa', 
        'America/Winnipeg' ,
        'Canada/Central' ,
        'Canada/East-Saskatchewan' ,
        'Canada/Saskatchewan' ,
        'Chile/EasterIsland' ,
        'Mexico/General' ,
        'America/Atikokan', 
        'America/Bogota' ,
        'America/Cayman' ,
        'America/Coral_Harbour' ,
        'America/Detroit' ,
        'America/Fort_Wayne' ,
        'America/Grand_Turk', 
        'America/Guayaquil' ,
        'America/Havana' ,
        'America/Indianapolis' ,
        'America/Iqaluit' ,
        'America/Jamaica' ,
        'America/Lima' ,
        'America/Louisville', 
        'America/Montreal' ,
         'America/Nassau' ,
        'America/New_York' ,
         'America/Nipigon' ,
        'America/Panama' ,
        'America/Pangnirtung', 
        'America/Port-au-Prince', 
        'America/Resolute' ,
        'America/Thunder_Bay', 
        'America/Toronto' ,
        'Canada/Eastern' ,
        'America/Caracas', 
        'America/Anguilla', 
        'America/Antigua', 
        'America/Aruba' ,
        'America/Asuncion', 
        'America/Barbados' ,
        'America/Blanc-Sablon' ,
        'America/Boa_Vista' ,
        'America/Campo_Grande', 
        'America/Cuiaba' ,
        'America/Curacao' ,
        'America/Dominica', 
        'America/Eirunepe' ,
        'America/Glace_Bay' ,
        'America/Goose_Bay' ,
        'America/Grenada' ,
        'America/Guadeloupe', 
        'America/Guyana' ,
        'America/Halifax' ,
        'America/La_Paz' ,
        'America/Manaus' ,
        'America/Marigot', 
        'America/Martinique' ,
        'America/Moncton' ,
        'America/Montserrat', 
        'America/Port_of_Spain', 
        'America/Porto_Acre', 
        'America/Porto_Velho' ,
        'America/Puerto_Rico', 
        'America/Rio_Branco' ,
        'America/Santiago' ,
        'America/Santo_Domingo' ,
        'America/St_Barthelemy' ,
        'America/St_Kitts' ,
        'America/St_Lucia' ,
        'America/St_Thomas' ,
        'America/St_Vincent', 
        'America/Thule' ,
        'America/Tortola' ,
        'America/Virgin' ,
        'Antarctica/Palmer' ,
        'Atlantic/Bermuda' ,
        'Atlantic/Stanley' ,
        'Brazil/Acre' ,
        'Brazil/West' ,
        'Canada/Atlantic', 
        'Chile/Continental' ,
        'America/St_Johns' ,
        'Canada/Newfoundland' ,
        'America/Araguaina' ,
        'America/Bahia' ,
        'America/Belem' ,
        'America/Buenos_Aires' ,
        'America/Catamarca' ,
        'America/Cayenne' ,
        'America/Cordoba' ,
        'America/Fortaleza' ,
        'America/Godthab' ,
        'America/Jujuy' ,
        'America/Maceio' ,
        'America/Mendoza' ,
        'America/Miquelon' ,
        'America/Montevideo', 
        'America/Paramaribo', 
        'America/Recife', 
        'America/Rosario' ,
        'America/Santarem', 
        'America/Sao_Paulo' ,
        'Antarctica/Rothera', 
        'Brazil/East' ,
        'America/Noronha' ,
        'Atlantic/South_Georgia', 
        'Brazil/DeNoronha' ,
        'America/Scoresbysund' ,
        'Atlantic/Azores' ,
        'Atlantic/Cape_Verde' ,
        'Africa/Abidjan' ,
        'Africa/Accra', 
        'Africa/Bamako' ,
        'Africa/Banjul' ,
        'Africa/Bissau' ,
        'Africa/Casablanca' ,
        'Africa/Conakry' ,
        'Africa/Dakar' ,
        'Africa/El_Aaiun' ,
        'Africa/Freetown' ,
        'Africa/Lome' ,
        'Africa/Monrovia' ,
        'Africa/Nouakchott' ,
        'Africa/Ouagadougou' ,
        'Africa/Sao_Tome' ,
        'Africa/Timbuktu' ,
        'America/Danmarkshavn' ,
        'Atlantic/Canary' ,
        'Atlantic/Faeroe' ,
         'Atlantic/Faroe' ,
        'Atlantic/Madeira' ,
        'Atlantic/Reykjavik' ,
        'Atlantic/St_Helena' ,
        'Europe/Belfast' ,
        'Europe/Dublin' ,
        'Europe/Guernsey' ,
        'Europe/Isle_of_Man' ,
        'Europe/Jersey' ,
        'Europe/Lisbon' ,
        'Europe/London' ,
        'Africa/Algiers' ,
        'Africa/Bangui' ,
        'Africa/Brazzaville' ,
        'Africa/Ceuta' ,
        'Africa/Douala' ,
        'Africa/Kinshasa' ,
        'Africa/Lagos' ,
        'Africa/Libreville' ,
        'Africa/Luanda' ,
        'Africa/Malabo' ,
        'Africa/Ndjamena' ,
        'Africa/Niamey' ,
        'Africa/Porto-Novo' ,
        'Africa/Tunis' ,
        'Africa/Windhoek' ,
        'Arctic/Longyearbyen' ,
        'Atlantic/Jan_Mayen' ,
        'Europe/Amsterdam' ,
        'Europe/Andorra' ,
        'Europe/Belgrade' ,
        'Europe/Berlin' ,
        'Europe/Bratislava', 
        'Europe/Brussels' ,
        'Europe/Budapest' ,
        'Europe/Copenhagen', 
        'Europe/Gibraltar' ,
        'Europe/Ljubljana' ,
        'Europe/Luxembourg' ,
        'Europe/Madrid' ,
        'Europe/Malta' ,
        'Europe/Monaco' ,
        'Europe/Oslo' ,
        'Europe/Paris' ,
        'Europe/Podgorica', 
        'Europe/Prague' ,
        'Europe/Rome' ,
        'Europe/San_Marino', 
        'Europe/Sarajevo' ,
        'Europe/Skopje' ,
        'Europe/Stockholm' ,
        'Europe/Tirane' ,
        'Europe/Vaduz' ,
        'Europe/Vatican' ,
        'Europe/Vienna' ,
        'Europe/Warsaw' ,
        'Europe/Zagreb' ,
        'Europe/Zurich' ,
        'Africa/Blantyre' ,
        'Africa/Bujumbura' ,
        'Africa/Cairo' ,
        'Africa/Gaborone' ,
        'Africa/Harare' ,
        'Africa/Johannesburg', 
        'Africa/Kigali' ,
        'Africa/Lubumbashi' ,
        'Africa/Lusaka' ,
        'Africa/Maputo' ,
        'Africa/Maseru' ,
        'Africa/Mbabane' ,
        'Africa/Tripoli' ,
        'Asia/Amman' ,
        'Asia/Beirut' ,
        'Asia/Damascus', 
        'Asia/Gaza' ,
        'Asia/Istanbul' ,
        'Asia/Jerusalem' ,
        'Asia/Nicosia' ,
        'Asia/Tel_Aviv' ,
        'Europe/Athens' ,
        'Europe/Bucharest', 
        'Europe/Chisinau' ,
        'Europe/Helsinki', 
        'Europe/Istanbul' ,
        'Europe/Kaliningrad', 
        'Europe/Kiev' ,
        'Europe/Mariehamn', 
        'Europe/Minsk' ,
        'Europe/Nicosia', 
        'Europe/Riga' ,
        'Europe/Simferopol' ,
        'Europe/Sofia' ,
        'Europe/Tallinn' ,
        'Europe/Tiraspol' ,
        'Europe/Uzhgorod' ,
        'Europe/Vilnius' ,
        'Europe/Zaporozhye' ,
        'Africa/Addis_Ababa' ,
        'Africa/Asmara' ,
        'Africa/Asmera' ,
        'Africa/Dar_es_Salaam', 
        'Africa/Djibouti' ,
        'Africa/Kampala', 
        'Africa/Khartoum' ,
        'Africa/Mogadishu', 
        'Africa/Nairobi' ,
        'Antarctica/Syowa', 
        'Asia/Aden' ,
        'Asia/Baghdad' ,
        'Asia/Bahrain' ,
        'Asia/Kuwait' ,
        'Asia/Qatar' ,
        'Europe/Moscow' ,
        'Europe/Volgograd' ,
        'Indian/Antananarivo' ,
        'Indian/Comoro' ,
        'Indian/Mayotte' ,
        'Asia/Tehran' ,
        'Asia/Baku' ,
        'Asia/Dubai' ,
        'Asia/Muscat' ,
        'Asia/Tbilisi' ,
        'Asia/Yerevan' ,
        'Europe/Samara' ,
        'Indian/Mahe' ,
        'Indian/Mauritius' ,
        'Indian/Reunion' ,
        'Asia/Kabul' ,
        'Asia/Aqtau' ,
        'Asia/Aqtobe' ,
        'Asia/Ashgabat' ,
        'Asia/Ashkhabad' ,
        'Asia/Dushanbe' ,
        'Asia/Karachi' ,
        'Asia/Oral' ,
        'Asia/Samarkand' ,
        'Asia/Tashkent' ,
        'Asia/Yekaterinburg' ,
        'Indian/Kerguelen' ,
        'Indian/Maldives' ,
        'Asia/Calcutta' ,
        'Asia/Colombo' ,
        'Asia/Kolkata' ,
        'Asia/Katmandu' ,
        'Antarctica/Mawson' ,
        'Antarctica/Vostok', 
        'Asia/Almaty' ,
        'Asia/Bishkek' ,
        'Asia/Dacca' ,
        'Asia/Dhaka' ,
        'Asia/Novosibirsk' ,
        'Asia/Omsk' ,
        'Asia/Qyzylorda', 
        'Asia/Thimbu' ,
        'Asia/Thimphu' ,
        'Indian/Chagos' ,
        'Asia/Rangoon' ,
        'Indian/Cocos' ,
        'Antarctica/Davis' ,
        'Asia/Bangkok' ,
        'Asia/Ho_Chi_Minh', 
        'Asia/Hovd' ,
        'Asia/Jakarta', 
        'Asia/Krasnoyarsk' ,
         'Asia/Phnom_Penh', 
        'Asia/Pontianak' ,
        'Asia/Saigon' ,
        'Asia/Vientiane' ,
        'Indian/Christmas' ,
        'Antarctica/Casey' ,
        'Asia/Brunei' ,
        'Asia/Choibalsan' ,
        'Asia/Chongqing' ,
        'Asia/Chungking' ,
        'Asia/Harbin' ,
        'Asia/Hong_Kong' ,
        'Asia/Irkutsk' ,
        'Asia/Kashgar' ,
        'Asia/Kuala_Lumpur' ,
        'Asia/Kuching' ,
        'Asia/Macao' ,
        'Asia/Macau' ,
        'Asia/Makassar' ,
        'Asia/Manila' ,
        'Asia/Shanghai' ,
        'Asia/Singapore' ,
        'Asia/Taipei' ,
        'Asia/Ujung_Pandang' ,
        'Asia/Ulaanbaatar' ,
        'Asia/Ulan_Bator' ,
        'Asia/Urumqi' ,
        'Australia/Perth' ,
        'Australia/West' ,
        'Australia/Eucla' ,
        'Asia/Dili' ,
        'Asia/Jayapura' ,
        'Asia/Pyongyang' ,
        'Asia/Seoul' ,
        'Asia/Tokyo' ,
        'Asia/Yakutsk' ,
        'Australia/Adelaide' ,
        'Australia/Broken_Hill' ,
        'Australia/Darwin' ,
        'Australia/North' ,
        'Australia/South' ,
        'Australia/Yancowinna' ,
        'Antarctica/DumontDUrville', 
        'Asia/Sakhalin' ,
        'Asia/Vladivostok' ,
        'Australia/ACT' ,
        'Australia/Brisbane' ,
        'Australia/Canberra' ,
        'Australia/Currie' ,
        'Australia/Hobart' ,
        'Australia/Lindeman' ,
        'Australia/Melbourne' ,
        'Australia/NSW' ,
        'Australia/Queensland' ,
        'Australia/Sydney' ,
        'Australia/Tasmania' ,
        'Australia/Victoria', 
        'Australia/LHI' ,
        'Australia/Lord_Howe' ,
        'Asia/Magadan' ,
        'Antarctica/McMurdo' ,
        'Antarctica/South_Pole' ,
        'Asia/Anadyr' ,
        'Asia/Kamchatka' ,
    ];
}
