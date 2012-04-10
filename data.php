<?php

include "lib/library.php";

$count = $_GET['count'];
$time  = $_GET['time'];

$SQL = sprintf("INSERT INTO captures (time, count) VALUES ('%s', '%s')", $time, $count);
good_query($SQL);

print "DATA RECEIVED - INF.COM";
?>
