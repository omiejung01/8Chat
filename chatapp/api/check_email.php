<?php
require("../db.inc.php");
error_reporting(E_ALL);
header("Content-Type: application/json");


function is_duplicate_email($email, $conn3) {
	$email = strtolower($email);
	$sql3 = "SELECT email FROM user WHERE LOWER(email) LIKE '" . $email . "' AND void = 0 ";
	//print($sql3);
	$result3 = $conn3->query($sql3);
	
	$found = false;
	if ($result3->num_rows > 0) {
		$found = true;
	} 
	return $found;
}

$email = htmlspecialchars($_GET["email"]);

$result = ["Available email" => $email, "result" => "Success"];

if (is_duplicate_email($email, $conn)) {
	$duplicate = "Email is already taken";
	$warning = ["Error" => $duplicate, "result" => "Failure"];
	echo json_encode($warning);
	exit();
}
echo json_encode($result);

//echo json_encode(["message" => "User added successfully"]);

//$data = "Rex Lapis"; 
//$key = "vagomundo";

// Calculate the SHA256 hash
//$hash = hash_hmac('sha256', $data,$key);

//echo "SHA256 hash of '$data': " . $hash . "\n";	



?>

