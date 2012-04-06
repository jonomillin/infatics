<?php

function getStatistics($key)
{
        $a = good_query_assoc("SELECT * FROM journeys WHERE owner = '$key'");
        $start = good_query_value("SELECT registered FROM users WHERE prikey = '$key'");
        $daysActive = (int)(strtotime(date("Y-m-d"))-(strtotime($start))) / (60 * 60 * 24);

        $D = computeLength($key);

        $days = 5;
        if($a['frequency'] == "Daily")
        {
                $days = 7;


        }

        $statA = $D * $daysActive;
        if($days = 5) $statA = $statA * 5 / 7;

        $statB = 200 * $statA / 1000;

        $statC = $statA * 2.59;
        $d = getDistanceBetweenPointsNew($a['lata'],$a['lnga'],$a['latb'],$a['lngb']);
        $stats = array(number_format($statA, 2),number_format($statB, 2),number_format($statC, 2));
        return $stats;
}


?>
