<?php
include "lib/library.php";


function show_ajax($tablename, $prikey)
{


	$fields = array();

	print "<table class='small' border='1'>";
	// Print table header
	$table = good_query_table("SHOW COLUMNS FROM $tablename");
	
	print "<tr class='small'>";
	foreach($table as $row)
	{
		print "<td>".ucfirst($row['Field'])."</td>";
		array_push($fields, $row['Field']);
	}
	print "</tr>";


	$table = good_query_table("SELECT * FROM $tablename");
	
	foreach($table as $row)
	{
		print "<tr class='small'>";
		$k = 0;
		foreach($row as $element)
		{	
			$pk = $row[$prikey];
			$id = make_key();
                        $name = $fields[$k];
			$k ++;
			
			print "<td><input class='small' size='10' onchange=\"javascript:loadXMLDoc('$tablename', '$pk','$id','$name', '$prikey');\" type='text' id='$id' value='$element'/></td>\n";
		}
		print "</tr>";
	}
	print "</table>";
	



}

?>


<html>

<head>

<link rel="stylesheet" href="admin.css" type="text/css" media="screen" />

<script type="text/javascript">

function loadXMLDoc(p0, p1, p2, p3, p4)
{
	if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
	else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

	xmlhttp.onreadystatechange=function()
        {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
 	     document.getElementById('output').innerHTML = xmlhttp.responseText;
	    }
				  }

	p2 = document.getElementById(p2).value;

//	alert("ajax.php?id="+p0+"&amount="+p2);
	xmlhttp.open("GET","ajax.php?table="+p0+"&field="+p3+"&amount="+p2+"&id="+p1+"&keyfield="+p4,true);
	xmlhttp.send();
}




</script>


</head>


<body>
<h1><?php print $BASE_NAME; ?> Admin Control</h1>

Registered users: <? print good_query_value("SELECT COUNT(*) FROM users"); ?><br>
Current active sessions: <? print good_query_value("SELECT COUNT(*) FROM session WHERE NOW() - ts < 900"); ?><br>

<? print show_table("SELECT DISTINCT (users.username) FROM session, users WHERE users.prikey = session.prikey AND NOW() - session.ts < 900"); ?><br>

<div id='output'></div>

<h2>Recent Activity</h2>
<? show_table("SELECT username, log.* FROM users, log WHERE users.prikey = log.prikey ORDER BY ts DESC LIMIT 20"); ?>

<h2>Users</h2>
<? show_ajax("users", "prikey"); ?>
<h2>Journeys</h2>
<? show_ajax("journeys", "prikey"); ?>
<h2>Inbox</h2>
<? show_ajax("inbox", "id"); ?>
<h2>Traffic</h2>
<? show_ajax("traffic", "id"); ?>
<h2>Carpools</h2>
<? show_ajax("carpools", "id"); ?>
</font>
</body>
</html>




