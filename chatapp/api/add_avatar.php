<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");
/*
function fill_zero($number, $target) {
	$str_num = "" . $number;
	
	$len = strlen($str_num);
	$num_zero = $target - $len;
	
	$result = "";
	
	for ($i = 0; $i < $num_zero; $i++) {	
		$result .= "0";
	}
	
	return $result . $number;
}
*/
// Check duplication


function check_email($email, $conn3) {
	$sql3 = "SELECT email FROM user WHERE LOWER(email) LIKE '" . $email . "' AND void = 0 ";
	//print($sql3);
	$result3 = $conn3->query($sql3);
	
	$found = false;
	if ($result3->num_rows > 0) {
		$found = true;
	} 
	return $found;
}


function is_duplicate_display_name($display_name, $conn4) {
	$sql4 = "SELECT display_name FROM user WHERE display_name LIKE '" . $display_name . "' AND void = 0 ";
	//print($sql3);
	$result4 = $conn4->query($sql4);
	
	$found = false;
	if ($result4->num_rows > 0) {
		$found = true;
	} 
	return $found;
}


$email = htmlspecialchars($_GET["email"]);
$location = htmlspecialchars($_GET["location"]);

if (!check_email($email, $conn)) {
	$duplicate = "No email";
	$warning = ["Error" => $duplicate, "result" => "Failure"];
	echo json_encode($warning);
	exit();
}


// generate new ID 
$sql = "SELECT max(avatar_id) as max_id FROM user_avatar ORDER BY avatar_id ";

$result = $conn->query($sql);

$id = 0;

if ($result->num_rows > 0) {	
	while($row = $result->fetch_assoc()) {
    	$id = $row["max_id"];
  	}	
	$id += 1;
} else {	
	$id = 1;
}

$sql2 = "INSERT INTO user_avatar (avatar_id, email, location) " .
		"VALUES ($id,'$email','$location');";
//echo $id;
if ($conn->query($sql2) === TRUE) {
  $result = ["id" => $id, "result" => "Success"];
} else {
  $result = "Error: " . $sql2 . "<br>" . $conn->error;
  //$result = ["result" => "Not success"];
  
}

echo json_encode($result);




//echo json_encode(["message" => "User added successfully"]);

//$data = "Rex Lapis"; 
//$key = "vagomundo";

// Calculate the SHA256 hash
//$hash = hash_hmac('sha256', $data,$key);

//echo "SHA256 hash of '$data': " . $hash . "\n";	



?>