<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");

$email  = htmlspecialchars($_GET["email"]);

$sql1 = "SELECT group_id FROM participate WHERE user_email = ? AND void = 0 ORDER BY group_id ";
			
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("s", $email);

$json_result = ["result" => "No data"];

$group_id_list = array();

if ($stmt1->execute()) {
	$result1 = $stmt1->get_result();
			
			
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

$sql2 = "SELECT user_email FROM participate WHERE group_id = ? AND void = 0 ORDER BY user_email ";
		
$group_count = count($group_id_list);
		
for ($i = 0 ; $i < $group_count; $i++) {
			
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i",$group_id_list[$i]);

$list_email = array();

	if ($stmt2->execute()) {
		$result2 = $stmt2->get_result();
		
		$email_list = array();
								
		while($row2 = $result2->fetch_assoc()) {
			$email_list[] = $row2["user_email"];
		}
		$list_email[] = $email_list;
		//$json_result = ["result" => "Success","group_list" => $group_id_list];

	}
	$json_result = ["result" => "Success","list_email" => $list_email];

}

echo json_encode($json_result);
?>