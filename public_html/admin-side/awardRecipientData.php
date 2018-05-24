<?php
require_once '../config.php';

//Recipient data
$query = "SELECT 	recipient.f_name AS 'fname',
              		recipient.l_name AS 'lname',
              		COUNT(award.id) AS 'awardsReceived',
                  recipient.salary AS 'salary',
                  recipient.hire_date AS 'hireDate',
                  recipient.job_title AS 'jobTitle',
                  CONCAT(manager.l_name, ', ', manager.f_name) AS 'manager',
                  branch.name AS 'branch',
                  branch.state_location AS 'state'
          FROM award
          INNER JOIN recipient ON award.recipient_id = recipient.id
          INNER JOIN manager ON recipient.manager_id = manager.id
          INNER JOIN branch ON recipient.branch_id = branch.id
          GROUP BY recipient.id
          HAVING COUNT(award.id) > 0
          ORDER BY recipient.l_name ASC";

$response = mysqli_query($dbc, $query);

//Fetch results into an associative array
$recipients = array();
while($row = mysqli_fetch_assoc($response)){
  $recipients[] = $row;
}

//return query results as JSON
echo json_encode($recipients);

//Close DB connection
mysqli_close($dbc);
?>
