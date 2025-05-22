<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");

$email = htmlspecialchars($_GET["email"]);
$last_name = htmlspecialchars($_GET["last_name"]);

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

if (!check_email($email, $conn)) {
	$duplicate = "No email";
	$warning = ["Error" => $duplicate, "result" => "Failure"];
	echo json_encode($warning);
	exit();
}


$sql2 = "UPDATE user SET last_name = ? WHERE email LIKE ? ";

$stmt = $conn->prepare($sql2);

$stmt->bind_param('ss', $lname, $this_mail);

$lname = $last_name;
$this_mail = $email;

$stmt->execute();

$num = $stmt->affected_rows;

//echo $id;
if ($num >= 1) {
  $result = ["result" => "Success"];
} else {
  $result = "Error: " . $sql2 . "<br>" . $conn->error;
  //$result = ["result" => "Not success"];
  
}

echo json_encode($result);


?>