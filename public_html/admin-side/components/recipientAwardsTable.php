<?php
require_once('../../config.php');
$query = "SELECT  recipient.f_name AS 'fname',
                  recipient.l_name AS 'lname',
                  COUNT(award.id) AS 'awardsReceived' FROM award
                  INNER JOIN recipient ON award.recipient_id = recipient.id
                  GROUP BY recipient.id
                  HAVING COUNT(award.id) > 0";
$response = mysqli_query($dbc, $query);

//Open or create new file for writing
//$CSV_file = 'awardsByRecipient.csv';
//$fileHandler = fopen($CSV_file, 'w') or die('Cannot open file: '.$CSV_file);

while($row = mysqli_fetch_assoc($response)){
  //Add records as rows to HTML table
  echo "<tr>
  <td> {$row['fname']} </td>
  <td> {$row['lname']} </td>
  <td> {$row['awardsReceived']} </td>
  </tr>";
}

mysqli_close($dbc);
?>
