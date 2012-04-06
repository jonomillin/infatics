<?php



function add_interval_end($me, $date)
{
        $SQL = sprintf("UPDATE intervals SET open='0', end='%s' WHERE prikey = '$me' AND open ='1'", $date);
        good_query($SQL);
}

function add_interval_start($me, $date, $distance, $size, $day_travelled, $route, $trips)
{
        $SQL = sprintf("INSERT INTO intervals (prikey, start, size, distance, day_travelled, route, open, trips) VALUES
                                              ('%s',   '%s',  '%s', '%s',     '%s',          '%s,   '%s')", $me, $date, $size, $day_travelled, $route, '1', $trips);
        good_query($SQL);
}


function on_join($me, $them)
{
        if(!isCarpooling($them))
        {
                $route = good_query_assoc("SELECT * FROM journeys WHERE prikey = '$them'");
                $key = $them;
                $date = time();
                $distance = measure($route['lata'], $route['lnga'], $route['latb'], $route['lngb']);
                $size = carpoolSize($them) + 1;
                $code = $rote['frequecy_sub'];
                if($code == 'Daily') $day_travelled = 1;
                if($code == 'Weekdays') $day_travelled = 0;
                if($code == 'Weekends') $day_travelled = 2;
                $routekey = $route['prikey'];

	}



}

function on_leave($me, $them)
{



}

// actionGateway, show, count, is, build.
function actionGateway($fromKey, $action, $toKey="", $routeKey="")
{
	global $BASE_URL;
	global $BASE_NAME;
        good_query("INSERT INTO log (ts, prikey, text) VALUES (NOW(),'$fromKey','$action')");


        if($action == "MESSAGED")
        {
         $p = good_query_value("SELECT c0 FROM users WHERE prikey = '$toKey'");
         if($p == 1)
         {
                $username = good_query_value("SELECT username FROM users WHERE prikey = '$fromKey'");
                $body = load_file("templates/message.tmp");
		$body = str_replace("%%base%%", $BASE_NAME, $body);
		$body = str_replace("%%link%%", "$BASE_URL/login.php", $body);
                $body = str_replace("%%username%%", $username, $body);
                emailMessage($toKey, "You have received a message on $BASE_NAME.", $body);
         }
        }

        if($action == "INVITED")
        {
         $p = good_query_value("SELECT c0 FROM users WHERE prikey = '$toKey'");
         if($p == 1)
         {
                $username = good_query_value("SELECT username FROM users WHERE prikey = '$fromKey'");
                $body = load_file("templates/invited.tmp");
		$body = str_replace("%%base%%", $BASE_NAME, $body);
		$body = str_replace("%%link%%", "$BASE_URL/login.php", $body);
                $body = str_replace("%%username%%", $username, $body);
                emailMessage($toKey, "You have received an invitation on $BASE_NAME.", $body);
         }
        }

        if($action == "UPDATED JOURNEY")
        {
         $p = good_query_value("SELECT c1 FROM users WHERE prikey = '$fromKey'");
         if($p == 1)
         {
                $username = good_query_value("SELECT username FROM users WHERE prikey = '$fromKey'");
                $body = load_file("templates/changed.tmp");
		$body = str_replace("%%base%%", $BASE_NAME, $body);
		$body = str_replace("%%link%%", "$BASE_URL/login.php", $body);
                $body = str_replace("%%username%%", $username, $body);
                emailToCarpool($routeKey, "Your carpool has been changed.", $body, 0);
         }
        }

        if($action == "ACCEPTED INVITATION")
        {
         $p = good_query_value("SELECT c2 FROM users WHERE prikey = '$toKey'");
         if($p == 1)
         {
                $username = good_query_value("SELECT username FROM users WHERE prikey = '$fromKey'");
                $body = load_file("templates/message.tmp");
		$body = str_replace("%%base%%", $BASE_NAME, $body);
		$body = str_replace("%%link%%", "$BASE_URL/login.php", $body);
                $body = str_replace("%%username%%", $username, $body);

                emailMessage($toKey, "Your carpool invitation has been accepted.", $body);
         }
        }


}



?>
