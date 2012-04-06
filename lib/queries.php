<?php

function buildJourneyQueryRange($mlat_a, $mlng_a, $mlat_b, $mlng_b, $range = 100)
{

 $Q = "SELECT
	6371 * acos( 
	      cos(radians( $mlat_a ))
	    * cos(radians( journeys.lata ))
	    * cos(radians( $mlng_a ) - radians( journeys.lnga ))
	    + sin(radians( $mlat_a )) 
	    * sin(radians( journeys.lata ))
	  ) AS greatCircleDistanceStart,
 	
	6371 * acos( 
	      cos(radians( $mlat_b ))
	    * cos(radians( journeys.latb ))
	    * cos(radians( $mlng_b ) - radians( journeys.lngb ))
	    + sin(radians( $mlat_b )) 
	    * sin(radians( journeys.latb ))
	  ) AS greatCircleDistanceEnd
      FROM
        journeys
      HAVING
	greatCircleDistanceStart + greatCircleDistanceEnd < $range
	
     ";

 return $Q;

}

function buildJourneyQuery($key)
{
 $mlat_a = 0;
 $mlng_a = 0;
 $mlat_b = 0;
 $mlng_b = 0;

 $network = good_query_value("SELECT network FROM users WHERE prikey = '$key'");
 $myPreference = good_query_value("SELECT preference FROM users WHERE prikey = '$key'");
 $Q = "SELECT * FROM journeys WHERE owner = '".$key."'";
 $row = good_query_assoc($Q);

 $mlat_a = $row['lata'];
 $mlng_a = $row['lnga'];
 $mlat_b = $row['latb'];
 $mlng_b = $row['lngb'];
 $myA    = $row['frequencysub'];
 $myB    = $row['returningsub'];
 $freq   = $row['frequency'];

 $dlat = $mlat_b - $mlat_a;
 $dlng = $mlng_b - $mlng_a;
 $Q = "SELECT
	
	users.username as own,
        
	journeys.name as name,
        journeys.owner as ownkey,
        journeys.prikey as prikey,


	'$myPreference' AS preferenceA,
	users.preference AS preferenceB,
        
	HOUR(journeys.frequencysub)*60 + MINUTE(journeys.frequencysub) as timeA,
	HOUR(journeys.returningsub)*60 + MINUTE(journeys.returningsub) as timeB,

        HOUR('$myA')*60 + MINUTE('$myA') as myA,
        HOUR('$myB')*60 + MINUTE('$myB') as myB,

	journeys.frequency AS frequencyA,
        '$freq' AS frequencyB,

        (ABS(journeys.lata-$mlat_a)+ABS(journeys.latb-$mlat_b)+ABS(journeys.lnga-$mlng_a)+ABS(journeys.lngb-$mlng_b)) AS metric,
	6371 * acos( 
	      cos(radians( $mlat_a ))
	    * cos(radians( journeys.lata ))
	    * cos(radians( $mlng_a ) - radians( journeys.lnga ))
	    + sin(radians( $mlat_a )) 
	    * sin(radians( journeys.lata ))
	  ) AS greatCircleDistanceStart,
 	
	6371 * acos( 
	      cos(radians( $mlat_b ))
	    * cos(radians( journeys.latb ))
	    * cos(radians( $mlng_b ) - radians( journeys.lngb ))
	    + sin(radians( $mlat_b )) 
	    * sin(radians( journeys.latb ))
	  ) AS greatCircleDistanceEnd,
	
	ATAN2(
		COS($mlat_a)*
		SIN($mlat_b)-
		SIN($mlat_a)*
		COS($mlat_b)*
		COS($mlng_b-$mlng_a), 
		SIN($mlng_b-$mlng_a)*
		COS($mlat_b)) as azimuthStart,

	ATAN2(
		COS(journeys.lata)*
		SIN(journeys.latb)-
		SIN(journeys.lata)*
		COS(journeys.latb)*
		COS(journeys.lngb-journeys.lnga), 
		SIN(journeys.lngb-journeys.lnga)*
		COS(journeys.latb)) as azimuthEnd,
      
        (SELECT weight FROM blacklist WHERE owner = '$key' AND ban = journeys.prikey) AS blackListWeight,

        (SELECT COUNT(guest) FROM carpools WHERE owner = journeys.owner) AS carpoolSize

      FROM
        users,
        journeys

      WHERE
        journeys.owner NOT LIKE '$key' AND
        users.prikey = journeys.owner 
     HAVING
	greatCircleDistanceStart + greatCircleDistanceEnd < 10

      ORDER BY
	blackListWeight ASC, 
         greatCircleDistanceStart + greatCircleDistanceEnd ASC,
	ABS(azimuthStart - azimuthEnd) ASC,
	MOD(myA - timeA + 1440, 1440) ASC,
	MOD(myB - timeB + 1440, 1440) ASC,
	ABS(STRCMP(frequencyA, frequencyB)) ASC,
	ABS(STRCMP(preferenceA, preferenceB)) ASC,
	carpoolSize ASC

      LIMIT 10
     ";

 return $Q;

}

?>
