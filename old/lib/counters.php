<?php

// Count the number of carpoolers on a jounrney given the journey key.
function countCarpoolers($journeyKey)
{
        $SQL = "SELECT COUNT(guest) FROM carpools WHERE journey = '$journeyKey'";
        $count = good_query_value($SQL);
        return $count;
}


function countJourneysReg($a, $b, $c, $d)
{
        return good_query_rows(buildJourneyQueryRange($a, $b, $c, $d));


}

function countJourneys($key)
{
        return good_query_rows(buildJourneyQuery($key));

}

function countTraffic($key)
{
        $count = good_query_value("SELECT COUNT(*) FROM traffic WHERE receiver = '$key' AND seen = '0' AND deleted = '0'");
        return $count;
}

function countMessages($key)
{
        $count = good_query_value("SELECT COUNT(*) FROM inbox WHERE receiver = '$key' AND seen = '0' AND deleted = '0'");
        return $count;
}

function countAllTraffic($key)
{
                return good_query_value("SELECT COUNT(*) FROM traffic WHERE receiver = '$key' AND deleted = '0'");
}


function countJourneys2($key)
{
                return good_query_rows(buildJourneyQuery($key));
}



?>
