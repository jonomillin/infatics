<?php

function showTraffic($key,$pub, $justCount = 0, $unseen = 0)
{

	if($unseen == 1)
          $unseen = "AND seen='0'";
        else
          $unseen = "";


        if($justCount == 1)
        {
                $total = good_query_rows("SELECT COUNT(*) FROM traffic WHERE receiver = '$key' AND $unseen AND deleted = '0'");
                print $total . " of " . $total . " journeys";
                return ;
        }

        $table = good_query_table("SELECT * FROM traffic WHERE receiver = '$key' $unseen AND deleted = '0'");
        $odd   = 1;

        foreach($table as $row)
        {
        $potential = good_query_rows(buildJourneyQuery($key));
        $class  = make_class($odd, $row['seen']);
        $route = $row['adda'] . " to " . $row['addb'];
        $sharers = countCarpoolers($row['prikey']);
	$journey = good_query_value("SELECT name from journeys WHERE prikey = '".$row['journey']."'");
	$tokens = array
        (
        "{{class}}"       => $class,
        "{{blacklink}}"   => linkTo("form_black", $pub, $row['prikey']),
        "{{messagelink}}" => linkTo("newMessage", $pub, $row['ownkey']),
        "{{profilelink}}" => linkTo("otherProfile", $pub, $row['ownkey']),
        "{{name}}"        => $row['own'],
        "{{date}}"        => subtleDate($row['date']),
	"{{subject}}"	  => $row['subject'],
        "{{replylink}}"   => linkTo("replyToMessage", $pub, $row['id']),
        "{{deletelink}}"  => linkTo("form_deleteOB", $pub, $row['id']),
        "{{journeylink}}" => linkTo("trafficReport", $pub, $row['id']),
        "{{journey}}"     => $journey,
        "{{route}}"       => $route,
        "{{returning}}"   => isJourneyReturn($row['returning']),
        "{{sharers}}"     => $sharers,
        "{{potential}}"   => $potential,
	"{{delete}}" 	  => linkTo("form_deleteTR", $pub, $row['id']),
	"{{trafficlink}}" => linkTo("trafficReport", $pub, $row['id']),
        );
        $odd ++;
        $template = load_file("templates/traffic.html");
        $template = fill_template($template, $tokens);
        print $template;

        }
}






?>
