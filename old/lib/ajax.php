<?php

include "lib/library.php";

$a = sanitize($_GET['table']);
$b = sanitize($_GET['field']);
$c = sanitize($_GET['amount']);
$d = sanitize($_GET['id']);
$e = sanitize($_GET['keyfield']);
good_query("UPDATE $a SET $b = '$c' WHERE $e = '$d'");
print "Database updated.";


?>
