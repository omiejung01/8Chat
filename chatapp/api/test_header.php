<?php 
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require("../db.inc.php");
//error_reporting(E_ALL);
$group_id = htmlspecialchars($_GET["group_id"]);
$time = date('r');

$key =$_SERVER['apikey'];


if ($myObj == null) {
	$key = 'No key';
}

$myObj->key = $key;

//print("data:{$str_result}\n\n");
print (json_encode($myObj));
flush();



?>