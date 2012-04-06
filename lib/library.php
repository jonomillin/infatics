<?php

$BASE_NAME	   = "Curious-Orange";
$BASE_HOST         = "localhost";
$BASE_USER         = "root";
$BASE_PASSWORD     = "gcwwj492";
$BASE_DATABASE     = "infatics";
$BASE_URL          = "http://www.curious-orange.com";
$BASE_DIR          = "/home/ncvp2/www/orange";
$BASE_LOCATION     = "uk";
$BASE_LANGUAGE     = "en";
$BASE_PREFIX   	   = "@gmail.com";
$BASE_DEPLOY  	   = "bottom_up";
$BASE_NETWORK  	   = "Open";
$BASE_NETWORK_SIZE = 100;
$BASE_CURRENCY	   = "GBP";
$BASE_LOGO	   = "img/logo.png";
$TYPE_PAYFOR   = 0;
$TYPE_PAYBACK  = 1;
$CODE_REGEX = array
(
	"uk" => "^((([A-Z]{1,2}[0-9][0-9A-Z]{0,1})(\ )*([0-9][A-Z]{2}))|(GIR\ 0AA))$", 
	"us" => "^\d{5}(-\d{4})?$",
);

$PAGES = array
(
    "profile"         	=> "profile.php",
    "dashboard"       	=> "dashboard.php",
    "message"         	=> "message.php",
    "journey"         	=> "journey.php",
    "help"            	=> "help.php",
    "journeys"        	=> "journeys.php",
    "messages"        	=> "messages.php",
    "sentMessages"          => "sendMessage.php",
    "trash"                 => "trash.php",
    "invite"                => "newInvite.php",
    "replyToSMessage"       => "replyToSMessage.php",
    "contact"               => "contact.php.php",
	"replyToMessage"        => "replyToMessage.php",
	"receivedInvite"        => "receivedInvite.php",
	"journeyDeletedMessage" => "journeyDeletedMessage.php",
  	"otherProfile"	 	=> "otherProfile.php",
  	"otherJourney"	 	=> "otherJourney.php",
	"form_deleteIB"		=> "form_deleteIB.php",
	"form_deleteOB"		=> "form_deleteOB.php",
	"sentMessage"		=> "sentMessage.php",
	"newMessage"		=> "newMessage.php",
	"form_black"		=> "form_black.php",
	"journey"		=> "journey.php",
	"trafficReport"		=> "trafficReport.php",
	"form_deleteTR"		=> "form_deleteTR.php",
);

$ERRORS = array
(
        0  => array("type"=>"negative", "message"=>"Incorrect username and/or password"),
        1  => array("type"=>"negative", "message"=> "Please enter a description of what you paid for"),
        2  => array("type"=>"negative", "message"=> "Please enter a valid amount of money, e.g., 120:45."),
        3  => array("type"=>"negative", "message"=> "Please select at least one person."),
        4  => array("type"=>"negative", "message"=> "Please enter an amount greater than or equal to 0.01."),
        5  => array("type"=>"negative", "message"=> "Please enter an amount less than 100,000.00."),
        6  => array("type"=>"negative", "message"=> "Please enter a username."),
        7  => array("type"=>"negative", "message"=> "Please enter a password."),
        8  => array("type"=>"negative", "message"=> "The password fields are not the same."),
        9  => array("type"=>"negative", "message"=> "Please enter a valid email address."),
        10 => array("type"=>"negative", "message"=> "That username is already taken."),
        11 => array("type"=>"negative", "message"=> "Please add at least one name to the ledger."),
        12 => array("type"=>"negative", "message"=> "Please accept the terms."),
        13 => array("type"=>"negative", "message"=> "Password is incorrect."),
        14 => array("type"=>"negative", "message"=> "Your session has expired please login again."),
        15 => array("type"=>"negative", "message"=> "Please enter a new password."),
        16 => array("type"=>"negative", "message"=> "There already is / was a user with that name, please choose a new one."),
        17 => array("type"=>"negative", "message"=> "Please enter a name for the new user."),
        18 => array("type"=>"positive", "message"=> "Your changes have been saved."),
        19 => array("type"=>"negative", "message"=> "Someone cannot pay themselves back."),
        20 => array("type"=>"positive", "message"=> "You cannot split a payment with just yourself."),
        21 => array("type"=>"negative", "message"=> "Invalid email address."),
        22 => array("type"=>"negative", "message"=> "Your session has expired due to inactivity, please login again."),
        23 => array("type"=>"negative", "message"=> "That username is already taken."),
        24 => array("type"=>"positive", "message"=> "Please follow the instructions in the welcome email to activate your account."),
		25 => array("type"=>"positive", "message"=> "Your account was successfully activated"),
		26 => array("type"=>"negative", "message"=> "Free network limit reached"),
		27 => array("type"=>"negative", "message"=> "Passwords do not match."),
		28 => array("type"=>"positive", "message"=> "Find some carpoolers for your journey and get in contact. You can invite them to join you on your route as well."),
		29 => array("type"=>"negative", "message"=> "The start postal code is not valid. Please check that it is a valid UK postal code."),
		30 => array("type"=>"negative", "message"=> "The destination postal code is not valid. Please check that it is a valid UK postal code."),
		31 => array("type"=>"negative", "message"=> "Invalid time."),
		32 => array("type"=>"negative", "message"=> "Please enter a valid email address."),
		33 => array("type"=>"negative", "message"=> "The total amount must add up to the total spent."),
		34 => array("type"=>"negative", "message"=> "The total percentages must add up to 100.00."),
		35 => array("type"=>"negative", "message"=> "Your session has expired please log in again."),
);

$TEMPLATES = array
(
       "message_odd"   => "message_odd.html",
       "message_even"  => "message_odd.html",
       "journey_odd"   => "message_odd.html",
       "journey_even"  => "message_odd.html",
);

$POST_CODE = array
(
	"AB" => "Aberdeen",
	"AL" => "St Albans",
	"B"  => "Birmingham",
	"BA" => "Bath",
	"BB" => "Blackburn",
	"BD" => "Bradford",
	"BH" => "Bournemouth",
	"BL" => "Bolton",
	"BN" => "Brighton",
	"BR" => "Bromley",
	"BS" => "Bristol",
	"BT" => "Belfast",
	"CA" => "Carlisle",
	"CB" => "Cambridge",
	"CF" => "Cardiff",
	"CH" => "Chester",
	"CM" => "Chelmsford",
	"CO" => "Colchester",
	"CR" => "Croydon",
	"CT" => "Canterbury",
	"CV" => "Coventry",
	"CW" => "Crewe",
	"DA" => "Dartford",
	"DD" => "Dundee",
	"DE" => "Derby",
	"DG" => "Dumfries and Galloway",
	"DH" => "Durham",
	"DL" => "Darlington",
	"DN" => "Doncaster",
	"DT" => "Dorchester",
	"DY" => "Dudley",
	"E"  => "London E",
	"EC" => "London EC",
	"EH" => "Edinburgh",
	"EN" => "Enfield",
	"EX" => "Exeter",
	"FK" => "Falkirk and Stirling",
	"FY" => "Blackpool",
	"G"  => "Glasgow",
	"GL" => "Gloucester",
	"GU" => "Guildford",
	"HA" => "Harrow",
	"HD" => "Huddersfield",
	"HG" => "Harrogate",
	"HP" => "Hemel Hempstead",
	"HR" => "Hereford",
	"HS" => "Outer Hebrides",
	"HU" => " Hull",
	"HX" => "Halifax",
	"IG" => "Ilford",
	"IP" => "Ipswich",
	"IV" => "Inverness",
	"KA" => "Kilmarnock",
	"KT" => "Kingston upon Thames",
	"KW" => "Kirkwall",
	"KY" => "Kirkcaldy",
	"L"  => "Liverpool",
	"LA" => "Lancaster",
	"LD" => "Llandrindod Wells",
	"LE" => "Leicester",
	"LL" => "Llandudno",
	"LN" => "Lincoln",
	"LS" => "Leeds",
	"LU" => "Luton",
	"M"  => "Manchester",
	"ME" => "Maidstone",
	"MK" => "Milton Keynes",
	"ML" => "Motherwell",
	"N"  => "London N",
	"NE" => "Newcastle upon Tyne",
	"NG" => "Nottingham",
	"NN" => "Northampton",
	"NP" => "Newport",
	"NR" => "Norwich",
	"NW" => "London NW",
	"OL" => "Oldham",
	"OX" => "Oxford",
	"PA" => "Paisley",
	"PE" => "Peterborough",
	"PH" => "Perth",
	"PL" => "Plymouth",
	"PO" => "Portsmouth",
	"PR" => "Preston",
	"RG" => "Reading",
	"RH" => "Redhill",
	"RM" => "Romford",
	"S"  => "Sheffield",
	"SA" => "Swansea",
	"SE" => "London SE",
	"SG" => "Stevenage",
	"SK" => "Stockport",
	"SL" => "Slough",
	"SM" => "Sutton",
	"SN" => "Swindon",
	"SO" => "Southampton",
	"SP" => "Salisbury Plain",
	"SR" => "Sunderland",
	"SS" => "Southend-on-Sea",
	"ST" => "Stoke-on-Trent",
	"SW" => "London SW",
	"SY" => "Shrewsbury",
	"TA" => "Taunton",
	"TD" => "Tweeddale",
	"TF" => " Telford",
	"TN" => "Tonbridge",
	"TQ" => "Torquay",
	"TR" => "Truro",
	"TS" => "Teesside",
	"TW" => " Twickenham",
	"UB" => "Uxbridge",
	"W"  => " London W",
	"WA" => "Warrington",
	"WC" => "London WC",
	"WD" => "Watford",
	"WF" => "Wakefield",
	"WN" => "Wigan",
	"WR" => "Worcester",
	"WS" => "Walsall",
	"WV" => "Wolverhampton",
	"YO" => "York",
	"ZE" => "Lerwick / Zetland",
);

function debug()
{

 print "<Strong>POST VARIABLES</Strong><br>";
 foreach($_POST as $k => $v)
 {
     print $k . " -> " . $v . "<Br>";
 }

 print "<Strong>GET VARIABLES</Strong><br>";
 foreach($_GET as $k => $v)
 {
    print $k . " -> " . $v . "<Br>";
 }
}


include "good_query.php";
include "error_table.php";
include "phplive_x.php";
include "measures.php";
include "sessions.php";
include "messaging.php";
include "statistics.php";
include "checking.php";
include "linkers.php";
include "utility.php";
include "message_blocks.php";
include "dashboard_blocks.php";
include "journey_blocks.php";
include "traffic_blocks.php";
include "queries.php";
include "actions.php";
include "counters.php";

?>
