<?php
require_once '../../database-resources/config.php';

//Recipient data
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

//Fetch results into an associative array
$branches = array();
while($row = mysqli_fetch_assoc($response)){
  $branches[] = $row;
}

//return query results as JSON
echo json_encode($branches);

//Close DB connection
mysqli_close($dbc);
?>
