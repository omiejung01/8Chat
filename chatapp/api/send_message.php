<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");


$group_id = htmlspecialchars($_GET["group_id"]);
$sender_email  = htmlspecialchars($_GET["sender_email"]);
$message_text = htmlspecialchars($_GET["message_text"]);


// generate new ID 
$sql = "SELECT max(message_id) as max_id FROM message ORDER BY message_id ";

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


$sql2 = "INSERT INTO message (message_id,group_id,sender_email,message_text) VALUES ($id,$group_id,'$sender_email','$message_text');";
//echo $id;
if ($conn->query($sql2) === TRUE) {
  $result = ["id" => $id, "result" => "Success"];
} else {
  $result = "Error: " . $sql2 . "<br>" . $conn->error;
  //$result = ["result" => "Not success"];
}

echo json_encode($result);

?>

