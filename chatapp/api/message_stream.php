<?php 

require("../db.inc.php");
//error_reporting(E_ALL);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$group_id = htmlspecialchars($_GET["group_id"]);

try {
    // Your SQL query (adjust as needed)
    $sql = "SELECT sender_email,message_text,created_time FROM message WHERE void = 0 ORDER BY created_time ";
   
	$result = $conn->query($sql);

    // Start the JSON array
    //echo '[';
    $first = true;
	while($row = $result->fetch_assoc()) {
        //if (!$first) {
        //    echo ',';
        //}
		echo '[';
    	
        echo json_encode($row);
		ob_flush(); flush(); 
        $first = false;
		echo ']';
    }
    // End the JSON array
    //echo ']';

} catch (Exception $e) {
    // Handle database connection errors
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} finally {
    // Close the database connection
    $conn = null;
}


?>