<?php
require("../db.inc.php");
//error_reporting(E_ALL);
header("Content-Type: application/json");


$group_id = htmlspecialchars($_GET["group_id"]);

$email  = htmlspecialchars($_GET["sender_email"]);



?>