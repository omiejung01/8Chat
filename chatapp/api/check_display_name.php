<?php
require("../db.inc.php");
error_reporting(E_ALL);
header("Content-Type: application/json");

function is_duplicate_display_name($display_name, $conn4) {
	$display_name = strtolower($display_name);
	
	$sql4 = "SELECT display_name FROM user WHERE LOWER(display_name) LIKE '" . $display_name . "' AND void = 0 ";
	$result4 = $conn4->query($sql4);
	
	$found = false;
	if ($result4->num_rows > 0) {
		$found = true;
	} 
	return $found;
}

$display_name = htmlspecialchars($_GET["display_name"]);

$result = ["Available display name" => $display_name, "result" => "Success"];

if (is_duplicate_display_name($display_name, $conn)) {
	$duplicate = "Display name is already taken";
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

