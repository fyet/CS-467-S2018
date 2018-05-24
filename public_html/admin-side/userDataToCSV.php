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
$query = "SELECT user.f_name AS 'fname',
          user.l_name AS 'lname',
          COUNT(award.id) AS 'awardsGiven',
          FLOOR(DATEDIFF(CURDATE(), user.creation_date)/365) AS 'yearsWithAwardPrivileges'
          FROM award
          INNER JOIN user ON award.user_id = user.id
          GROUP BY user.id
          ORDER BY user.l_name ASC";
$response = mysqli_query($dbc, $query);
mysqli_close($dbc);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=userAwardData.csv");

outputCSV($response);
?>
