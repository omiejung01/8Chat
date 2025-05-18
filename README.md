# 8Chat
Minimal chat application that all text message disappear after 8 hours.
# Database Design
Entities

User (<ins>User ID</ins>, Email, Display name, First name, Last name) 

User_Login (<ins>User ID</ins>, Email, IP Address)

Group (<ins>Group ID</ins>, Group Name1,Group Name2,Group name 3, bColor1,bColor2,bColor3,fColor1,fColor2,fColor3)

Participate (<ins>Part ID</ins>, User ID, Group ID)

Message (<ins>Msg ID</ins>, Group_ID, sender_email, Text, Timestamp)

# Database Fields
Please include these fields in every table.
VOID
created_time
edited_time
edited_by

# Limitation
"Group name" can be changed 3 times

# db.inc.php
Please put this code in your chatapp/db.inc.php

# todo
Profile picture with media server, and upload panel to media server.


```
<?php

$servername = "localhost"; // Or your host name (e.g., "db.example.com")
$username = "<your username>";
$password = "<your password>";
$dbname = "<your database name>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>
```
