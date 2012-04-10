<?php

function err($GET)
{
 if(!isset($GET['msg'])) return ;
 $identifier = $GET['msg'];
 global $ERRORS;
 $sub = $ERRORS[$identifier];
 if($sub['type'] == "negative")
	 $ret = sprintf("<div class='errorMsg'>%s</div>", strtoupper($sub['message']));
 else if ($sub['type'] == "positive")
	 $ret = sprintf("<div class='errorMsgG'>%s</div>", strtoupper($sub['message']));
 print $ret;
}

?>
