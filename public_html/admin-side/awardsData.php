<?php
require_once('../config.php');

//Data for awards given by date
$query = "SELECT accolade_date, COUNT(id) AS 'awardsGiven' FROM award GROUP BY award.accolade_date";

$response = mysqli_query($dbc, $query);

//Fetch results into an associative array
$awards= array();
while($row = mysqli_fetch_assoc($response)){
  $awards[] = $row;
}

//Print query results as JSON
echo json_encode($awards);

//Close DB connection
mysqli_close($dbc);
?>
