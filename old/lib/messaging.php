<?php

function emailMessage($toKey, $subject, $body)
{
	global $BASE_NAME;
        $headers = "From: $BASE_NAME Support <noreply@zoomatelo.com>\r\n";
        $email = good_query_value("SELECT email FROM users WHERE prikey = '$toKey'");
        mail($email, $subject, $body, $headers);
}

function emailToCarpool($routeKey, $subject, $body, $andSelf = 1)
{
        if($andSelf)
	{
        	$ownerKey = good_query_value("SELECT owner FROM journeys WHERE prikey = '$routeKey'");
        	emailMessage($ownerKey, $subject, $body);
	}

        $table = good_query_table("SELECT guest FROM carpools WHERE journey = '$routeKey'");
        foreach($table as $row)
        {
                $toKey = $row['guest'];
                emailMessage($toKey, $subject, $body);
        }
}

function sendMessage($fromKey, $toKey, $subject, $body, $type = '2')
{
        $subject = trunc($subject, 42);
        $body    = trunc($body, 1000);

        $SQL = sprintf("INSERT INTO inbox (sender, receiver, subject, body, seen, deleted, type) VALUES ('%s','%s','%s','%s','%s','%s','%s')", $fromKey, $toKey, $subject, $body, '0', '0', $type);
        good_query($SQL);
        $SQL = sprintf("INSERT INTO outbox (sender, receiver, subject, body, seen, deleted, type) VALUES ('%s','%s','%s','%s','%s','%s','%s')", $fromKey, $toKey, $subject, $body, '1', '0', $type);
        good_query($SQL);
}

function sendToCarpool($fromKey, $routeKey, $subject, $body, $andSelf = 1)
{
	if($andSelf)
	{
        	$ownerKey = good_query_value("SELECT owner FROM journeys WHERE prikey = '$routeKey'");
        	sendMessage($fromKey, $ownerKey, $subject, $body);
	}

        $table = good_query_table("SELECT guest FROM carpools WHERE journey = '$routeKey'");
        foreach($table as $row)
        {
                $toKey = $row['guest'];
                sendMessage($fromKey, $toKey, $subject, $body);
        }
}


?>
