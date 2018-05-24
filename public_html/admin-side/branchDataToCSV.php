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
$query = "SELECT branch.name AS 'branch',
          branch.state_location AS 'state',
          COUNT(award.id) AS 'awardCount',
          FLOOR(AVG(recipient.salary)) AS 'avgSalary',
          FLOOR(AVG(DATEDIFF(CURDATE(), recipient.hire_date))) AS 'avgTimeWithCompany'
          FROM award
          INNER JOIN recipient ON award.recipient_id = recipient.id
          INNER JOIN branch ON recipient.branch_id = branch.id
          GROUP BY branch.id
          ORDER BY branch.name ASC";
$response = mysqli_query($dbc, $query);
mysqli_close($dbc);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=branchAwardData.csv");

outputCSV($response);
?>
