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
$query = "SELECT
          award.accolade_type AS 'award_type',
          award.accolade_date AS 'date_awarded',
          recipient.f_name AS 'recipient_fname',
          recipient.l_name AS 'recipient_lname',
          recipient.job_title AS 'recipient_job_title',
          recipient.salary AS 'recipient_yearly_salary',
          recipient.hire_date AS 'recipient_hire_date',
          user.f_name AS 'award_granter_fname',
          user.l_name AS 'award_granter_lname',
          user.creation_date AS 'award_granter_account_creation_date',
          manager.f_name AS 'recipient_manager_fname',
          manager.l_name AS 'recipient_manager_lname',
          manager.department_name AS 'manager_department',
          branch.name AS 'branch',
          branch.state_location AS 'state'
          FROM award
          INNER JOIN recipient ON award.recipient_id = recipient.id
          INNER JOIN manager ON recipient.manager_id = manager.id
          INNER JOIN user ON award.user_id = user.id AND user.account_type = 'standard'
          INNER JOIN branch ON recipient.branch_id = branch.id
          ORDER BY
          award.accolade_date ASC,
          award.accolade_type ASC,
          recipient.l_name ASC";
$response = mysqli_query($dbc, $query);
mysqli_close($dbc);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=managerAwardData.csv");

outputCSV($response);
?>
