<?php

/*
function showJourneys($key,$pub, $justCount = 0)
{
	
        if($justCount == 1)
        {
                $total = good_query_rows(buildJourneyQuery($key));
                print $total . " of " . $total . " journeys";
                return ;
        }

        $table = good_query_table(buildJourneyQuery($key));
        $odd   = 1;

        foreach($table as $row)
        {

       //if(good_query_value ("select count(*) from carpools where guest = '".$row['ownkey']."'") > 0)
        {
         //       continue;
        }

        $class  = make_class($odd, 0);

        $tokens = array
        (
        "{{class}}"       => $class,
        "{{blacklink}}"   => linkTo("form_black", $pub, $row['prikey']),
        "{{messagelink}}" => linkTo("newMessage", $pub, $row['ownkey']),
        "{{profilelink}}" => linkTo("otherProfile", $pub, $row['ownkey']),
        "{{name}}"        => $row['own'],
        "{{date}}"        => $row['date'],
        "{{replylink}}"   => linkTo("replyToMessage", $pub, $row['id']),
        "{{deletelink}}"  => linkTo("form_deleteOB", $pub, $row['id']),
        "{{journeylink}}" => linkTo("otherJourney", $pub, $row['prikey']),
        "{{journey}}"     => $row['name'],
        );
        $odd ++;
        $template = load_file("templates/journey.html");
        $template = fill_template($template, $tokens);
        print $template;

        }
}
*/

function showPotentialJourneys($key,$pub, $justCount = 0)
{
        if($justCount == 1)
        {
                $total = good_query_rows(buildJourneyQuery($key));
                print $total . " of " . $total . " journeys";
                return ;
        }
        $routeKey = good_query_value("SELECT prikey FROM journeys WHERE owner = '$key'");
        $table = good_query_table(buildJourneyQuery($key));
        $odd   = 1;

        foreach($table as $row)
        {
//	print $row['carpoolSize'] . "<br>";
//	print $row['blackListWeight'] . "<br>";;
//	print $row['preferenceA'] . " " . $row['preferenceB'] .  " " . "<br>";
//	print $row['greatCircleDistanceStart'] +  $row['greatCircleDistanceEnd'] . "<br>";
	if( good_query_value ("select count(*) from carpools where owner != '".$row['ownkey']."' AND  guest = '".$row['ownkey']."'") > 0)
	{
		continue;
	}

        $class  = make_class($odd, 0);

        $tokens = array
        (
        "{{class}}"       => $class,
        "{{blacklink}}"   => linkTo("form_black", $pub, $row['prikey'], $routeKey),
        "{{messagelink}}" => linkTo("newMessage", $pub, $row['ownkey']),
        "{{profilelink}}" => linkTo("otherProfile", $pub, $row['ownkey']),
        "{{name}}"        => $row['own'],
        "{{date}}"        => $row['date'],
        "{{invitelink}}"  => linkTo("invite", $pub, $row['ownkey'],$routeKey),
        "{{replylink}}"   => linkTo("replyToMessage", $pub, $row['id']),
        "{{deletelink}}"  => linkTo("form_deleteOB", $pub, $row['id']),
        "{{journeylink}}" => linkTo("otherJourney", $pub, $row['prikey']),
        "{{journey}}"     => $row['name'],
        "{{distance}}"    => computeDistance($row['ownkey'], $key),
        );
        $odd ++;
        $template = load_file("templates/potential_journey.html");
        $template = fill_template($template, $tokens);
        print $template;

        }
}




?>
