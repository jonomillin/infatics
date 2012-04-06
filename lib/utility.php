<?php

/*
	Display the date in a friendly manner
 */
function isInOwnCarpool($key)
{
 return (good_query_value("SELECT COUNT(*) FROM carpools WHERE owner = '$key' AND guest = '$key'") == 1);
}

function getJourney($key)
{
        return good_query_value("SELECT journey FROM carpools WHERE guest = '$key'");
}



function carpoolSize($key)
{
 $route = getJourney($key);
 return (good_query_value("SELECT COUNT(*) FROM carpools WHERE journey = '$route'"));
}


function isCarpooling($key)
{
 $route = getJourney($key);
 return (good_query_value("SELECT COUNT(*) FROM carpools WHERE journey = '$route'") > 1);
}

function regMatch($txt, $pattern)
{
	return (preg_match($pattern, $txt) > 0);
}


function subtleDate ($time, $day_limit = 5, $long_format = 'M j')
{
	$_DAY = 60*60*24;
	$diff = mktime() - strtotime($time);
	switch ($diff)
	{
		case ($diff < 60):    return 'Less than a minute ago';
		case ($diff < 120):   return '1 minute ago';
		case ($diff < 3600):   return (int)($diff / 60) . ' minutes ago';
		case ($diff < $_DAY): return (int)($diff / (60*60)) . ' hours ago';
		case ($diff < $_DAY*2): return 'Yesterday';
		case (floor($diff/$_DAY) < $day_limit): return floor(($diff/$_DAY)) . ' days ago';
		default: return date($long_format, strtotime($time));
		
	}
}


function trunc($text, $len)
{
        if(strlen($text) > $len)
        {
                return substr($text, 0, $len-3) . "...";
        }
        else
        {
                return $text;
        }
}

function isJourneyReturn($returning)
{
        if($returning == "Yes")
        {
                return "(and back)";
        }
        else
        {
                return "";
        }
}

function make_class($counter, $seen)
{
        $ret = "";

        if($counter % 2 == 0)
         $ret = $ret . "even ";
        else
         $ret = $ret . "odd ";

        if($seen == "1")
         $ret = $ret . "read";
        else
         $ret = $ret . "unread";

        return $ret;
}

function fill_template($template, $tokens)
{
        foreach($tokens as $k => $v)
        {
                $template = str_replace($k, $v, $template);
        }
        return $template;
}
	


function outputPreference($val)
{
      if($val == 1) print "<td class='chosen'>Yes</td><td class='notChosen'>No</td><td class='notChosen'>No</td>";
      if($val == 2) print "<td class='notChosen'>No</td><td class='chosen'>Yes</td><td class='notChosen'>Nos</td>";
      if($val == 3) print "<td class='notChosen'>No</td><td class='notChosen'>No</td><td class='chosen'>Yes</td>";
}


function kron($a, $b, $c, $d="")
{
        if($a == $b) print $c; else print $d;
}

function show($message)
{
        foreach($message as $k => $v)
        {
                print $k . " " . $v . "<Br>";
        }
}

function getTextNumber($ordinal)
{
        if($ordinal > 11) $ordinal = 11;
        $texts = array("","one","two","three","four","five","six","seven","eight","nine","ten","tenPlus");
        return $texts[$ordinal];
}


function make_type($ordinal)
{
        if($ordinal == 0) return "receivedInvite";
        if($ordinal == 1) return "journeyDeletedMessage";
        if($ordinal == 2) return "message";
}


function messageCode($ordinal)
{
        if($ordinal == 0) return "receivedInvite.php";
        if($ordinal == 1) return "journeyDeletedMessage.php";
        if($ordinal == 2) return "message.php";
}

function load_file($selection)
{
        global $BASE_DIR;
        $path = $selection;
        $fh = fopen($path, 'r');
        $data = fread($fh, filesize($path));
        fclose($fh);
        return $data;
}


function reverse_escape($str)
{
  $search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
  $replace=array("\\","\0","\n","\r","\x1a","'",'"');
  return str_replace($search,$replace,$str);
}


function show_row($sql)
{
$table = good_query_assoc($sql);
echo "<table border='1'>";
foreach($table as $k => $v)
{
        echo "<tr>";
        echo "<td>$k</td><td>$v</td>";
        echo "</tr>";
}
echo "</table>";


}



function show_table($sql)
{
$table = good_query_table($sql);
echo "<table border='1'>";
foreach($table as $row)
{
        echo "<tr>";
        foreach($row as $column=>$cell)
        {
                $k = $cell;
                if(!$cell) $k = "_";
                echo "<td>".$k."</td>";
        }
        echo "</tr>";
}
echo "</table>";


}



?>
