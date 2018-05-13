<?php
require_once('../config.php');

//Recipient data
$query = "SELECT  recipient.f_name AS 'fname',
                  recipient.l_name AS 'lname',
                  COUNT(award.id) AS 'awardsReceived' FROM award
                  INNER JOIN recipient ON award.recipient_id = recipient.id
                  GROUP BY recipient.id
                  HAVING COUNT(award.id) > 0";
                  
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
