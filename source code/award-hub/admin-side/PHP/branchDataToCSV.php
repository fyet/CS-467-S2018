<?php
require_once 'outputCSV.php';
require_once '../../database-resources/config.php';

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

outputCSV($response, "branchAwardData.csv");
?>
