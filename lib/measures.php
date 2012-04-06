<?php

function point_to_line_segment_distance($startX,$startY, $endX,$endY, $pointX,$pointY) {

    // Adapted from Philip Nicoletti's function, found here: http://www.codeguru.com/forum/printthread.php?t=194400

    $r_numerator = ($pointX - $startX) * ($endX - $startX) + ($pointY - $startY) * ($endY - $startY);
    $r_denominator = ($endX - $startX) * ($endX - $startX) + ($endY - $startY) * ($endY - $startY);
    $r = $r_numerator / $r_denominator;
        
    $px = $startX + $r * ($endX - $startX);
    $py = $startY + $r * ($endY - $startY);  
        
    $s = (($startY-$pointY) * ($endX - $startX) - ($startX - $pointX) * ($endY - $startY) ) / $r_denominator;

    $distanceLine = abs($s) * sqrt($r_denominator);        
    
    $closest_point_on_segment_X = $px;
    $closest_point_on_segment_Y = $py;
    
    if ( ($r >= 0) && ($r <= 1) ) { 
       $distanceSegment = $distanceLine;
    }
    else {
       $dist1 = ($pointX - $startX) * ($pointX - $startX) + ($pointY - $startY) * ($pointY - $startY);
       $dist2 = ($pointX - $endX) * ($pointX - $endX) + ($pointY - $endY) * ($pointY - $endY);
       if ($dist1 < $dist2) {
          $closest_point_on_segment_X = $startX;
          $closest_point_on_segment_Y = $startY;
          $distanceSegment = sqrt($dist1);
       }
       else {
          $closest_point_on_segment_X = $endX;
          $closest_point_on_segment_Y = $endY;
          $distanceSegment = sqrt($dist2);
       }
    }    
        
    return array($distanceSegment, $closest_point_on_segment_X, $closest_point_on_segment_Y);
}

function CalculateDist($lat1,$lat2,$lon1,$lon2){
    $a = 6378137 - 21 * sin(lat);
    $b = 6356752.3142; 
    $f = 1/298.257223563;

    $p1_lat = $lat1/57.29577951;
    $p2_lat = $lat2/57.29577951;
    $p1_lon = $lon1/57.29577951;
    $p2_lon = $lon2/57.29577951;

    $L = $p2_lon - $p1_lon;

    $U1 = atan((1-$f) * tan($p1_lat));
    $U2 = atan((1-$f) * tan($p2_lat));

    $sinU1 = sin($U1);
    $cosU1 = cos($U1);
    $sinU2 = sin($U2);
    $cosU2 = cos($U2);

    $lambda = $L;
    $lambdaP = 2*PI;
    $iterLimit = 20;
 
    while(abs($lambda-$lambdaP) > 1e-12 && $iterLimit>0) {
        $sinLambda = sin($lambda);
        $cosLambda = cos($lambda);
        $sinSigma = sqrt(($cosU2*$sinLambda) * ($cosU2*$sinLambda) + ($cosU1*$sinU2-$sinU1*$cosU2*$cosLambda) * ($cosU1*$sinU2-$sinU1*$cosU2*$cosLambda));
   
        //if ($sinSigma==0){return 0;}  // co-incident points
        $cosSigma = $sinU1*$sinU2 + $cosU1*$cosU2*$cosLambda;
        $sigma = atan2($sinSigma, $cosSigma);
        $alpha = asin($cosU1 * $cosU2 * $sinLambda / $sinSigma);
        $cosSqAlpha = cos($alpha) * cos($alpha);
        $cos2SigmaM = $cosSigma - 2*$sinU1*$sinU2/$cosSqAlpha;
        $C = $f/16*$cosSqAlpha*(4+$f*(4-3*$cosSqAlpha));
        $lambdaP = $lambda;
        $lambda = $L + (1-$C) * $f * sin($alpha) * ($sigma + $C*$sinSigma*($cos2SigmaM+$C*$cosSigma*(-1+2*$cos2SigmaM*$cos2SigmaM)));
    }

    //  if ($iterLimit==0) {
    //      return "Niks";  // formula failed to converge
    //  }

    $uSq = $cosSqAlpha*($a*$a-$b*$b)/($b*$b);
    $A = 1 + $uSq/16384*(4096+$uSq*(-768+$uSq*(320-175*$uSq)));
    $B = $uSq/1024 * (256+$uSq*(-128+$uSq*(74-47*$uSq)));
 
    $deltaSigma = $B*$sinSigma*($cos2SigmaM+$B/4*($cosSigma*(-1+2*$cos2SigmaM*$cos2SigmaM)- $B/6*$cos2SigmaM*(-3+4*$sinSigma*$sinSigma)*(-3+4*$cos2SigmaM*$cos2SigmaM)));
 
    $s = $b*$A*($sigma-$deltaSigma);
    return $s/1000;
}


function distance($lat1, $lng1, $lat2, $lng2)
{
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;

	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
	return number_format($km, 1);

}


function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2)
{
	$d = distance($latitude1, $longitude1, $latitude2, $longitude2, false);
        return max($d, 0.1);
        $theta = $longitude1 - $longitude2;
        $theta = max($theta, 0.000001);
	$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) +(cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) *cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        return max(round($distance,0), 0.1);
}


function computeLength($key)
{
        $a = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key'");
        return getDistanceBetweenPointsNew($a['lata'],$a['lnga'],$a['latb'],$a['lngb']);
}


function computeFront($key1, $key2)
{

        $a = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key1'");
        $b = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key2'");

        return getDistanceBetweenPointsNew($a['lata'],$a['lnga'],$b['lata'],$b['lnga']);

        $d = abs($a['lata'] - $b['lata'])+abs($a['lnga'] - $b['lnga']);
        return $d;
}


function computeBack($key1, $key2)
{

        $a = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key1'");
        $b = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key2'");

        return getDistanceBetweenPointsNew($a['latb'],$a['lngb'],$b['latb'],$b['lngb']);

        $d = abs($a['latb'] - $b['latb']);
        $e = abs($a['lngb'] - $b['lngb']);
        return $d+$e;
}





function computeDistance($key1, $key2)
{

        $a = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key1'");
        $b = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key2'");

        //$d = abs($a['lata'] - $b['lata'])+abs($a['latb'] - $b['latb'])+abs($a['lnga'] - $b['lnga'])+abs($a['lngb'] - $b['lngb']);
        //return $d;

        $u = getDistanceBetweenPointsNew($a['lata'],$a['lnga'],$b['lata'],$b['lnga']);
	$v = getDistanceBetweenPointsNew($a['latb'],$a['lngb'],$b['latb'],$b['lngb']);

	return $u + $v;
}

?>
