<?php
require_once 'outputCSV.php';
require_once '../../config.php';

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

outputCSV($response, "managerAwardDate.csv");
?>
