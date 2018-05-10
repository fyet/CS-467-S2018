<?php
require_once('../config.php');

//Recipient data
$query = "SELECT l_name, salary FROM recipient;";
$response = mysqli_query($dbc, $query);

//Fetch results into an associative array
$recipients = array();
while($row = mysqli_fetch_assoc($response)){
  $recipients[] = $row;
}

//Print query results as JSON
echo json_encode($recipients);

//Close DB connection
mysqli_close($dbc);
?>
