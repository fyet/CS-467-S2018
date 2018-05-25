<?php
//Source: https://stackoverflow.com/questions/217424/create-a-csv-file-for-a-user-in-php
function outputCSV($data) {
  $output = fopen("php://output", "w");
  //Write columns names to file
  $fieldNames = [];
  while ($field = mysqli_fetch_field($data)) {
    $fieldNames[] = $field->name;
  }
  //error_log(print_r($fieldNames,true));
  fputcsv($output, $fieldNames);
  //Write column data to file
  foreach ($data as $row)
    fputcsv($output, $row); // here you can change delimiter/enclosure
  fclose($output);
}

require_once '../config.php';
$query = "SELECT  manager.f_name AS 'fname',
                  manager.l_name AS 'lname',
                  COUNT(award.id) AS 'awardCount',
                  FLOOR(AVG(recipient.salary)) AS 'avgSalary',
                  COUNT(recipient.id) AS 'awardedEmployeeCount'
          FROM award
          INNER JOIN recipient ON award.recipient_id = recipient.id
          INNER JOIN manager ON recipient.manager_id = manager.id
          GROUP BY manager.id
          ORDER BY manager.l_name ASC";
$response = mysqli_query($dbc, $query);
mysqli_close($dbc);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=managerAwardData.csv");

outputCSV($response);
?>
