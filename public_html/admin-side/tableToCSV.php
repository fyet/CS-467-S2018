<?php
//Source: https://stackoverflow.com/questions/217424/create-a-csv-file-for-a-user-in-php
function outputCSV($data) {
  $output = fopen("php://output", "w");
  //Write columns names to file
  $fieldNames = [];
  while ($field = mysqli_fetch_field($data)) {
    $fieldNames[] = $field->name;
  }
  error_log(print_r($fieldNames,true));
  fputcsv($output, $fieldNames);
  //Write column data to file
  foreach ($data as $row)
    fputcsv($output, $row); // here you can change delimiter/enclosure
  fclose($output);
}

require_once('../config.php');
$query = "SELECT  recipient.f_name AS 'fname',
                  recipient.l_name AS 'lname',
                  COUNT(award.id) AS 'awardsReceived' FROM award
                  INNER JOIN recipient ON award.recipient_id = recipient.id
                  GROUP BY recipient.id
                  HAVING COUNT(award.id) > 0";
$response = mysqli_query($dbc, $query);
mysqli_close($dbc);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=recipientAwardData.csv");

outputCSV($response);
?>
