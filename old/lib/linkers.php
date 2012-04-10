<?

function linkTo($page, $key="", $idx="", $idx2="", $msg="")
{
        global $BASE_URL;
        global $PAGES;

        $url = $BASE_URL."/".$PAGES[$page]."?";
        if($key  != "") $url = $url."key="  .$key;
        if($idx  != "") $url = $url."&idx=" .$idx;
        if($idx2 != "") $url = $url."&idx2=".$idx2;
        if($msg  != "") $url = $url."&msg=" .$msg;
        return $url;
}


function rlinkReplyMessage($key, $idx)
{
       return "replyToMessage.php?key=$key&idx=$idx";
}



function rlinkSReplyMessage($key, $idx)
{
       return "replyToSMessage.php?key=$key&idx=$idx";
}

function linkReplyMessage($key, $idx)
{
        print "replyToMessage.php?key=$key&idx=$idx";
}



function linkEditPW($key)
{
        print "editPW.php?key=$key";
}


function linkEditProfile($key)
{
        print "editProfile.php?key=$key";
}

function linkNewMessage($key)
{
        print "newMessage.php?key=$key";
}

function linkTrash($key)
{
        print "trash.php?key=$key";
}

function linkSentMessages($key)
{
        print "sentMessages.php?key=$key";
}

function linkDashboard($key)
{
        print "dashboard.php?key=$key";
}

function linkJourneys($key)
{
        print "journeys.php?key=$key";
}


function linkTraffic($key)
{
        print "traffic.php?key=$key";
}

function linkMessages($key)
{
        print "messages.php?key=$key";
}

function linkProfile($key)
{
        print "profile.php?key=$key";
}

function linkOtherJourney($key, $idx)
{
        return "otherJourney.php?key=$key&idx=$idx";
}


function linkOtherProfile($key, $idx)
{
        return "otherProfile.php?key=$key&idx=$idx";
}

function rlinkNewMessage($pub, $idx="")
{
        return "newMessage.php?key=$pub&idx=$idx";
}

function rlinkNewInvite($pub, $key, $journey)
{
        return "newInvite.php?key=$pub&idx=$key&idx2=$journey";
}

function rlinkDeleteSG($pub)
{
        return "deleteSuggested.php?key=$pub";
}

?>
