<?php


/*
function showCarpoolersShare($key, $pub, $route)
{
        $table = good_query_table("SELECT * FROM carpools WHERE journey = '$route'");
        $odd = 1;

        // Add the owner of the carpook
        $odd++;
        if ($odd % 2 == 0) $oddClass = 'odd'; else $oddClass = 'even';
        $seenClass = 'unread';
        print sprintf("<tr class='%s %s'>", $oddClass, $seenClass);

        $owner = good_query_assoc("SELECT users.username, users.prikey from users, journeys WHERE journeys.prikey = '$route' AND journeys.owner = users.prikey");
        print "<td><a href='otherProfile.php?key=$pub&idx=".$owner['prikey']."' title='View profile'>".$owner['username']."</a></td>";
        print "<td class='actions'><ul>";
        $tok = rlinkNewMessage($pub, $owner['prikey']);
        print "<li class='contact'><a href='".$tok."' title='Contact '>Contact</a></li>";
        //print "<li class='delete'><a href='form_remove.php?key=$pub&idx=".$owner['prikey']."' title='Show less matches like this'>Delete</a></li></ul>";
        print "</td></tr>";

        foreach($table as $row)
        {

                $profile = good_query_assoc("SELECT * FROM users WHERE prikey = '".$row['guest']."'");
                if($profile['prikey'] == $key) continue;

                $odd++;
                if ($odd % 2 == 0) $oddClass = 'odd'; else $oddClass = 'even';
                $seenClass = 'unread';
                print sprintf("<tr class='%s %s'>", $oddClass, $seenClass);

                print "<td><a href='otherProfile.php?key=$pub&idx=".$profile['prikey']."' title='View profile'>".$profile['username']."</a></td>";
                print "<td class='actions'><ul>";

                $tok = rlinkNewMessage($pub, $profile['prikey']);
                print "<li class='contact'><a href='".$tok."' title='Contact '>Contact</a></li>";
         //       print "<li class='delete'><a href='form_remove.php?key=$pub&idx=".$profile['prikey']."' title='Show less matches like this'>Delete</a></li>";
                print "</ul></td></tr>";


        }
}
*/

function showCarpoolers($key, $pub)
{
        $route = good_query_value("SELECT journey FROM carpools WHERE guest = '$key'");
        $isMine = good_query_value("SELECT COUNT(*) FROM carpools WHERE journey = '$route' AND owner = '$key'");
        $table = good_query_table("SELECT * FROM carpools WHERE journey = '$route' AND guest != '$key'");
        $odd = 1;
        foreach($table as $row)
        {

                $profile = good_query_assoc("SELECT * FROM users WHERE prikey = '".$row['guest']."'");

                $odd++;
                if ($odd % 2 == 0) $oddClass = 'odd'; else $oddClass = 'even';
                $seenClass = 'unread';
                print sprintf("<tr class='%s %s'>", $oddClass, $seenClass);

                print "<td><a href='otherProfile.php?key=$pub&idx=".$profile['prikey']."' title='View profile'>".$profile['username']."</a></td>";
                print "<td class='actions'><ul>";

                $tok = rlinkNewMessage($pub, $profile['prikey']);
                print "<li class='contact'><a href='".$tok."' title='Contact '>Contact</a></li>";
                if($isMine > 0)
                print "<li class='delete'><a href='form_leave.php?key=$pub&idx=".$row['guest']."&idx2=".$row['journey']."' title='Remove from carpool'>Delete</a></li></ul></td></tr>";


        }
}


function showMyJourneys($key,$pub, $justCount = 0)
{
        if($justCount == 1)
        {
                $total = good_query_rows("SELECT COUNT(*) FROM journeys WHERE prikey IN (SELECT journey FROM carpools WHERE guest = '$key')");
                print $total . " of " . $total . " journeys";
                return ;
        }

        $table = good_query_table("SELECT * FROM journeys WHERE prikey IN (SELECT journey FROM carpools WHERE guest = '$key' OR owner = '$key')");
        $odd   = 1;

        foreach($table as $row)
        {
        $potential = good_query_rows(buildJourneyQuery($key));
        $class  = make_class($odd, 0);
        $route = $row['adda'] . " to " . $row['addb'];
        $sharers = countCarpoolers($row['prikey']);
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
        "{{journeylink}}" => linkTo("journey", $pub, $row['prikey']),
        "{{journey}}"     => $row['name'],
        "{{route}}"       => $route,
        "{{returning}}"   => isJourneyReturn($row['returning']),
        "{{sharers}}"     => $sharers,
        "{{potential}}"   => $potential,
        );
        $odd ++;
        $template = load_file("templates/othercarpools.html");
        $template = fill_template($template, $tokens);
        print $template;

        }
}

/*
function showMyJourneys($key,$pub, $justCount = 0)
{
        if($justCount == 1)
        {
                $total = good_query_rows("SELECT COUNT(*) FROM journeys WHERE owner = '$key'");
                print $total . " of " . $total . " journeys";
                return ;
        }

        $table = good_query_table("SELECT * FROM journeys WHERE owner = '$key'");
        $odd   = 1;

        foreach($table as $row)
        {
        $potential = good_query_rows(buildJourneyQuery($key));
        $class  = make_class($odd, 0);
        $route = $row['adda'] . " to " . $row['addb'];
        $sharers = countCarpoolers($row['prikey']);
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
        "{{journeylink}}" => linkTo("journey", $pub, $row['prikey']),
        "{{journey}}"     => $row['name'],
        "{{route}}"       => $route,
        "{{returning}}"   => isJourneyReturn($row['returning']),
        "{{sharers}}"     => $sharers,
        "{{potential}}"   => $potential,
        );
        $odd ++;
        $template = load_file("templates/mycarpool.html");
        $template = fill_template($template, $tokens);
        print $template;

        }
}
*/



?>
