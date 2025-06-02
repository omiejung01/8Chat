<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");

$email  = htmlspecialchars($_GET["email"]);

$sql1 = "SELECT group_id FROM participate WHERE user_email = ? AND void = 0 ORDER BY group_id ";
			
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("s", $email);

$json_result = ["result" => "No data"];
if ($stmt1->execute()) {
	$result1 = $stmt1->get_result();
			
	$group_id_list = array();
			
	while($row1 = $result1->fetch_assoc()) {
		$group_id_list[] = $row1["group_id"];
	}
	
	$json_result = ["result" => "Success","group_list" => $group_id_list];
	/*
	$len_group = count($group_id_list);
	if ($len_group > 0) {
		for ($i = 0; $i < $len_group; $i++) {
			$json_result = ["result" => "Success"];
		}			
	}*/
}
echo json_encode($json_result);
?>