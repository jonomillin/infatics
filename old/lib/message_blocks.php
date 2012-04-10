<?php
function showOutbox($key,$pub, $justCount=0)
{
        if($justCount == 1)
        {
                $total = good_query_value("SELECT COUNT(*) FROM outbox WHERE sender = '$key' AND deleted  = '0' ORDER BY date DESC");
                print $total . " of " . $total . " messages";
                return ;
        }

        $table = good_query_table("SELECT * FROM outbox WHERE sender = '$key' AND deleted  = '0' ORDER BY date DESC");
        $odd   = 1;

        foreach($table as $row)
        {

        $receiver  = $row['receiver'];
        $profile = good_query_assoc("SELECT * FROM users WHERE prikey ='$receiver'");
        $class   = make_class($odd, $row['seen']);

        $tokens = array
        (
        "{{class}}"       => $class,
        "{{messagelink}}" => linkTo("sentMessage", $pub, $row['id']),
        "{{profilelink}}" => linkTo("otherProfile", $pub, $receiver),
        "{{subject}}"     => $row['subject'],
        "{{name}}"        => $profile['username'],
        "{{date}}"        => subtleDate($row['date']),
        "{{replylink}}"   => linkTo("replyToMessage", $pub, $row['id']),
        "{{deletelink}}"  => linkTo("form_deleteOB", $pub, $row['id']),
        );
        $odd ++;
        $template = load_file("templates/inbox.html");
        $template = fill_template($template, $tokens);
        print $template;

        }



}

function showInbox($key,$pub, $justCount=0, $onlyNew="")
{
       if($onlyNew == 1)
       {
	$onlyNew = "AND seen='0'";
       } 
       if($justCount == 1)
        {
                $total = good_query_value("SELECT COUNT(*) FROM inbox WHERE receiver = '$key' AND deleted  = '0' $onlyNew ORDER BY date DESC");
                print $total . " of " . $total . " messages";
                return ;
        }

        $table = good_query_table("SELECT * FROM inbox WHERE receiver = '$key' AND deleted  = '0' $onlyNew ORDER BY date DESC");
        $odd   = 1;

        foreach($table as $row)
        {

        $sender  = $row['sender'];
        $profile = good_query_assoc("SELECT * FROM users WHERE prikey ='$sender'");
        $class   = make_class($odd, $row['seen']);
        $type    = make_type($row['type']);

        $tokens = array
        (
        "{{class}}"       => $class,
        "{{messagelink}}" => linkTo($type, $pub, $row['id']),
        "{{profilelink}}" => linkTo("otherProfile", $pub, $row['sender']),
        "{{subject}}"     => $row['subject'],
        "{{name}}"        => $profile['username'],
        "{{date}}"        => subtleDate($row['date']),
        "{{replylink}}"   => linkTo("replyToMessage", $pub, $row['id']),
        "{{deletelink}}"  => linkTo("form_deleteIB", $pub, $row['id']),
        );
        $odd ++;
        $template = load_file("templates/inbox.html");
        $template = fill_template($template, $tokens);
        print $template;

        }



}

function showTrash($key, $pub, $justCount=0)
{
        if($justCount == 1)
        {
                $total = good_query_value("(SELECT COUNT(*) FROM inbox WHERE receiver = '$key' AND deleted  = '1' ORDER BY date DESC)");
                print $total . " of " . $total . " messages";
                return ;
        }

        $table = good_query_table("(SELECT * FROM inbox WHERE receiver = '$key' AND deleted  = '1' ORDER BY date DESC)");
        $odd   = 1;

        foreach($table as $row)
        {

        $sender  = $row['sender'];
        $profile = good_query_assoc("SELECT * FROM users WHERE prikey ='$sender'");
        $class   = make_class($odd, $row['seen']);
        $type    = make_type($row['type']);

        $tokens = array
        (
        "{{class}}"       => $class,
        "{{messagelink}}" => linkTo($type, $pub, $row['id']),
        "{{profilelink}}" => linkTo("otherProfile", $pub, $row['sender']),
        "{{subject}}"     => $row['subject'],
        "{{name}}"        => $profile['username'],
        "{{date}}"        => subtleDate($row['date']),
        "{{replylink}}"   => linkTo("replyToMessage", $pub, $row['id']),
        );
        $odd ++;
        $template = load_file("templates/trash.html");
        $template = fill_template($template, $tokens);
        print $template;

        }



}


?>
