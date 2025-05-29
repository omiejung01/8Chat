<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");

$group_id = htmlspecialchars($_GET["group_id"]);
$email  = htmlspecialchars($_GET["email"]);


function is_email_in_group($email, $conn3) {
	$sql3 = "SELECT email FROM user WHERE email LIKE '" . $email . "' AND void = 0 ";
	//print($sql3);
	$result3 = $conn3->query($sql3);
	
	$found = false;
	if ($result3->num_rows > 0) {
		$found = true;
	} 
	return $found;
}

// Check 






?>