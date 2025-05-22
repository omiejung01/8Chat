<?php
require("../db.inc.php");
error_reporting(E_ALL);
header("Content-Type: application/json");

//$email = '';
$display_name = '';
$first_name = '';
$last_name = '';
$status = '';
$remark = '';
$avatar = '';

$email = htmlspecialchars($_GET["email"]);

function get_user_from_email($mail, $conn3) {
	$mail = strtolower($mail);
	$sql3 = "SELECT email, display_name, first_name, last_name, status,remark FROM user WHERE LOWER(email) LIKE '" . $mail . "' AND void = 0 ";
	//print($sql3);
	$result3 = $conn3->query($sql3);
	
	global $display_name, $first_name , $last_name, $status, $remark;
	
	while($row = $result3->fetch_assoc()) {
		//$email = $row["email"];
		$display_name = $row["display_name"];
		$first_name = $row["first_name"];
		$last_name = $row["last_name"];
		$status = $row["status"];
		$remark = $row["remark"];
  	}		
	
	$found = false;
	if ($result3->num_rows > 0) {
		$found = true;		
  	} 
	return $found;
}

// Start here

// get avatar
$sql4 = "SELECT location FROM user_avatar WHERE LOWER(email) LIKE '" . $email . "' AND void = 0 ";
$result4 = $conn->query($sql4);
while($row = $result4->fetch_assoc()) {
	//$email = $row["email"];
	$avatar = $row["location"];
}


if (get_user_from_email($email, $conn)) {	
		
	$result = [
	"result" => "Success",
	"email" => $email, 
	"display_name" => $display_name, 
	"first_name" => $first_name, 
	"last_name" => $last_name, 
	"status" => $status, 
	"remark" => $remark,
	"avatar" => $avatar
	];
	
	echo json_encode($result);
	exit();
}
$warning_message = "No user";
$warning = ["Error" => $warning_message, "result" => "Failure"];
echo json_encode($warning);



//echo json_encode(["message" => "User added successfully"]);

//$data = "Rex Lapis"; 
//$key = "vagomundo";

// Calculate the SHA256 hash
//$hash = hash_hmac('sha256', $data,$key);

//echo "SHA256 hash of '$data': " . $hash . "\n";	



?>

