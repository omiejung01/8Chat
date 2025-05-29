<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");

$email1  = htmlspecialchars($_GET["email1"]);
$email2  = htmlspecialchars($_GET["email2"]);

$sql = "SELECT max(group_id) as max_id FROM chat_group ORDER BY group_id ";
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

$success = false;

$sql2 = "INSERT INTO chat_group (group_id, group_name1, group_name2, group_name3) " .
		"VALUES ($id, '','','');";
//echo $id;
if ($conn->query($sql2) === TRUE) {
  $result = ["id" => $id, "result" => "Success"];
  $success = true;
} else {
  $result = "Error: " . $sql2 . "<br>" . $conn->error;
  $success = false;
  //$result = ["result" => "Not success"];
  
}


echo json_encode($result);




?>