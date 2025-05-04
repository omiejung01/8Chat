<?php 
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require("../db.inc.php");
//error_reporting(E_ALL);
$group_id = htmlspecialchars($_GET["group_id"]);
$time = date('r');

//echo $group_id;

$str_result = "";

try {
    
    $sql = "SELECT sender_email, message_text, created_time " .  
		"FROM message WHERE void = 0 AND group_id = {$group_id} " .
		"AND created_time > DATE_SUB(NOW(), INTERVAL '8' HOUR) " .
		"ORDER BY -created_time";

   
	//print($sql);
	
	$result = $conn->query($sql);
	//$str_result = "data: ";
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
	//$str_result = $str_result .  "\n {$row['sender_email']} ,{$row['message_text']} ,{$row['created_time']} ,";
		//echo json_encode($row);
		//ob_flush(); flush(); 
        $first = false;
	}

    // End the JSON array
    $str_result = $str_result .  ']';
	//echo ']';
	
	//print($str_result);

} catch (Exception $e) {
    // Handle database connection errors
    // http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} finally {
    // Close the database connection
    //$conn = null;
}

//echo "data: The server time is: {$time}\n\n";
//echo "data: the server time is {$group_id} : {$time}\n\n";
//print("data: the server time is {$group_id} : {$time}\n\n");
print("data:{$str_result}\n\n");
flush();

//echo "data:123";
//ob_flush();
//flush();

?>