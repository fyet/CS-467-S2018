<?php
require_once('../config.php');

//Recipient data
$query = "SELECT  user.f_name AS 'fname',
                  user.l_name AS 'lname',
                  COUNT(award.id) AS 'awardsGiven'
                  FROM award
          INNER JOIN user ON award.user_id = user.id
          GROUP BY user.id
          HAVING COUNT(award.id) > 0";

$response = mysqli_query($dbc, $query);

//Fetch results into an associative array
$granters = array();
while($row = mysqli_fetch_assoc($response)){
  $granters[] = $row;
}

//Print query results as JSON
echo json_encode($granters);

//Close DB connection
mysqli_close($dbc);
?>
