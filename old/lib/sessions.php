<?php

function make_key()
{
        return md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
}

function check_key($key)
{
        $sql = "SELECT COUNT(*) FROM accounts WHERE prikey = '".$key."'";
        $result = good_query_value($sql);
        if($result == 1)
                return true;
        else
                return false;
}

function unmask($key)
{
        $sql = sprintf("SELECT id FROM session WHERE session_key = '%s'", $key);
        return good_query_value($sql);
}

function session_check($key)
{
        global $BASE_URL;

        // $get actual key
        $sql = "SELECT prikey FROM session WHERE pubkey = '".$key."' AND location = '".$_SERVER['REMOTE_ADDR']."'";
        $pkey = good_query_value($sql);

        if(check_key($pkey) == false)
        {
                header("Location: $BASE_URL/index.php?msg=35");
                exit;
        }

        $ts = good_query_value("SELECT UNIX_TIMESTAMP(ts) FROM session WHERE prikey = '".$pkey."'");
        if(time() - $ts > 900)
        {
              header("Location: $BASE_URL/login.php?msg=22");
              exit;
        }


        good_query("UPDATE session SET ts = NOW() WHERE  prikey = '".$pkey."'");

        return $pkey;
}
?>
