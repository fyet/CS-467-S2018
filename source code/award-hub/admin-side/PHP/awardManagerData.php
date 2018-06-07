<?php
require_once '../../database-resources/config.php';

//Recipient data
$query = "SELECT manager.f_name AS 'fname',
          manager.l_name AS 'lname',
          COUNT( award.id ) AS 'awardCount',
          FLOOR( AVG( recipient.salary ) ) AS 'avgSalary',
          COUNT( DISTINCT recipient.id ) AS 'awardedEmployeeCount'
          FROM award
          INNER JOIN recipient ON award.recipient_id = recipient.id
          INNER JOIN manager ON recipient.manager_id = manager.id
          GROUP BY manager.id";

$response = mysqli_query($dbc, $query);

//Fetch results into an associative array
$managers= array();
while($row = mysqli_fetch_assoc($response)){
  $managers[] = $row;
}

//Print query results as JSON
echo json_encode($managers);

//Close DB connection
mysqli_close($dbc);
?>
