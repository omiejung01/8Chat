<?php

require("../db.inc.php");
error_reporting(E_ALL);
header('Content-Type: application/json');
header('Cache-Control: no-cache');

$group_id = htmlspecialchars($_GET["group_id"]);

try {
    
    $sql = "SELECT sender_email,message_text,created_time " . 
	"FROM message WHERE void = 0 AND group_id = " . $group_id . 
	" ORDER BY -created_time ";
   
	//print($sql);
	$result = $conn->query($sql);
	$str_result = '';
    // Start the JSON array
	$str_result = $str_result . '[';
	//echo '[';
	
    $first = true;

	while($row = $result->fetch_assoc()) {
        if (!$first) {
            $str_result = $str_result . ',';
			//echo ',';
        }
		
        $str_result = $str_result .  json_encode($row);
		//echo json_encode($row);
		ob_flush(); flush(); 
        $first = false;
	}

    // End the JSON array
    $str_result = $str_result .  ']';
	//echo ']';
	
	$hash = hash('sha256', $str_result);	
	$display = array("Hash" => $hash);
	print(json_encode($display));

} catch (Exception $e) {
    // Handle database connection errors
    //http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} finally {
    // Close the database connection
    $conn = null;
}


?>