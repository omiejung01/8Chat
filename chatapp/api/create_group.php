<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");

//Steps
//	1. Check for the group that have only two members if yes (go to that group)
//  2. If not create group and go to that group

$email1  = htmlspecialchars($_GET["email1"]);
$email2  = htmlspecialchars($_GET["email2"]);

//sort

if (strcmp($email1,$email2) > 0 ) {
	$temp = $email2;
	$email2 = $email1;
	$email1 = $temp;
}

// find the existing group with these two emails

$found = false;
$group_id_found = 0;


// select the group that have only two members
$group_of_2 = array();

$sql5 = "SELECT group_id, count(user_email) AS nums FROM participate GROUP BY group_id ORDER BY group_id ";
$result5 = $conn->query($sql5);

if ($result5->num_rows > 0) {	
	while($row5 = $result5->fetch_assoc()) {
    	$nums = $row5["nums"];
		$group_id = $row5["group_id"];
		if ($nums == 2) {
			$group_of_2[] = $group_id;
		}
  	}	
}

$len_group_of_2 = count($group_of_2);
//if ($len_group_of_2 > 0) {
//	$found = true;
//}

//$str = 'len_group_of_2: ' . $len_group_of_2;

if ($len_group_of_2 != 0) {
	for ($id = 0; $id < $len_group_of_2; $id++) {
		//$str = 'group_of_2 id: ' . $group_of_2[$id];
		
		if (!$found) {
			$row_group_id = $group_of_2[$id];
			//$str = 'row_group_id: ' . $row_group_id; 			
			// suppose to be 2
			$sql6 = "SELECT user_email FROM participate WHERE group_id = ? ORDER BY user_email ";
			
			$stmt6 = $conn->prepare($sql6);
			$stmt6->bind_param("i", $row_group_id);
		
			if ($stmt6->execute()) {
				$result6 = $stmt6->get_result();
			
				//$result6 = $conn->query($sql6);		
				$row_email = array();
			
				while($row6 = $result6->fetch_assoc()) {
					$row_email[] = $row6["user_email"];
					$group_id_found = $row_group_id;
				}
		
				if (count($row_email) == 2) {
					$diff = false;
					if (strcmp($row_email[0], $email1) != 0) {
						$diff = true;
					}
					if (strcmp($row_email[1], $email2) != 0) {
						$diff = true;
					}
					
					if (!$diff) {
						$found = true;
					}
				}	
			}
		}
	}
	// temp
	//$found = true;
}

if ($found) {
	$result = ["group_id" => $group_id_found, "result" => "Existing"];	
} else {
	// Create new group
	$sql = "SELECT max(group_id) as max_id FROM chat_group ";
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

	//$id = 1;
	$success = false;

	$sql2 = "INSERT INTO chat_group (group_id, group_name1, group_name2, group_name3) " .
			"VALUES (?,'','','');";
			
	$stmt2 = $conn->prepare($sql2);		
	$stmt2->bind_param('i', $id);

	if ($stmt2->execute()) {		
		$result = ["id" => $id, "result" => "Success"];
		$success = true;
	} else {
		$result = "Error: " . $sql2 . "<br>" . $conn->error;
		$success = false;
	}
	
	if ($success) {
		// create new participate 2 times
		$sql3 = "SELECT max(part_id) as max_id FROM participate  ";		
		$result3 = $conn->query($sql3);	
		
		$id3 = 0;			
		if ($result3->num_rows > 0) {
			
			while($row3 = $result3->fetch_assoc()) {
				$id3 = $row3["max_id"];
			}
			$id3 += 1;			
			
			$sql4 = "INSERT INTO participate (part_id, user_email, group_id) " .
			"VALUES (?,?,?); ";
			
			$stmt4 = $conn->prepare($sql4);			
			$stmt4->bind_param("isi", $id3, $email1, $id);
			$insert_participation_success = true;
						
			if ($stmt4->execute() === TRUE) {
				// do nothing
				
			} else {
				$insert_participation_success = false;
			}
			
			$id3 += 1;
			$sql5 = "INSERT INTO participate (part_id, user_email, group_id) " .
			"VALUES (?,?,?);";
			$stmt5 = $conn->prepare($sql5);			
			$stmt5->bind_param("isi", $id3, $email2, $id);
			$insert_participation_success = true;
						
			if ($stmt5->execute() === TRUE) {
				// do nothing
			} else {
				$insert_participation_success = false;
			}
			
			if ($insert_participation_success) {
				$result = ["group_id" => $id, "result" => "Success"];
			}
		}
	}
}
echo json_encode($result);


?>