<?php


function performSanitization()
{
good_open();

$_GET = array_map('trim', $_GET);
$_POST = array_map('trim', $_POST);
$_COOKIE = array_map('trim', $_COOKIE);
$_REQUEST = array_map('trim', $_REQUEST);

$_GET = array_map('strip_tags', $_GET);
$_POST = array_map('strip_tags', $_POST);
$_COOKIE = array_map('strip_tags', $_COOKIE);
$_REQUEST = array_map('strip_tags', $_REQUEST);

$_GET = array_map('mysql_real_escape_string', $_GET);
$_POST = array_map('mysql_real_escape_string', $_POST);
$_COOKIE = array_map('mysql_real_escape_string', $_COOKIE);
$_REQUEST = array_map('mysql_real_escape_string', $_REQUEST);
}


function sanitize($qer)
{

good_open();
//      return $qer;
//      print $qer;
//      print "<br>";
//      print mysql_real_escape_string(strip_tags(($qer)));
//      print "<br>";
//      print reverse_escape(mysql_real_escape_string(strip_tags(($qer))));

//      print "<hr>";

        return mysql_real_escape_string(strip_tags(($qer)));
}

function check_email($email)
{
        // First, we check that there's one @ symbol,
        // and that the lengths are right.
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
        {
        return false;

        }

        // Split it into sections to make life easier
    $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);

        for ($i = 0; $i < sizeof($local_array); $i++)
        {
                if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&.'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i]))
                {
                        return false;
                }

        }

        // Check if domain is IP. If not,
        // it should be valid domain name
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
        {
                $domain_array = explode(".", $email_array[1]);
                if (sizeof($domain_array) < 2)
                {
                        return false; // Not enough parts to domain
                }

                for ($i = 0; $i < sizeof($domain_array); $i++)
                {
                        if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])| .([A-Za-z0-9]+))$",     $domain_array[$i]))
                        {
                                return false;
                        }
                }
        }
        return true;
}




?>
