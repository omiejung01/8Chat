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


function is_duplicate_email($email, $conn3) {
	$sql3 = "SELECT email FROM user WHERE email LIKE '" . $email . "' AND void = 0 ";
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
$display_name = htmlspecialchars($_GET["display_name"]);
$first_name = htmlspecialchars($_GET["first_name"]);
$last_name = htmlspecialchars($_GET["last_name"]);
// Status	
$remark = htmlspecialchars($_GET["remark"]);


if (is_duplicate_email($email, $conn)) {
	$duplicate = "Email is already existed.";
	$warning = ["Error" => $duplicate, "result" => "Failure"];
	echo json_encode($warning);
	exit();
}

if (is_duplicate_display_name($display_name, $conn)) {
	$duplicate = "Display name is already taken.";
	$warning = ["Error" => $duplicate, "result" => "Failure"];
	echo json_encode($warning);
	exit();
}


// generate new ID 
$sql = "SELECT max(user_id) as max_id FROM user ORDER BY user_id ";
$result = $conn->query($sql);

$id = "";

if ($result->num_rows > 0) {	
	while($row = $result->fetch_assoc()) {
    	$id = $row["max_id"];
  	}
	
	$id += 1;
	 
} else {
	
	$id = 1;
}

$sql2 = "INSERT INTO user (user_id, email, display_name, first_name, last_name, remark) " .
		"VALUES ('$id','$email','$display_name','$first_name','$last_name','$remark');";
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