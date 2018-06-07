<?php
require_once '../../database-resources/config.php';

$query = "SELECT 	recipient.f_name AS 'First Name',
		recipient.l_name AS 'Last Name',
		COUNT(award.id) AS 'Award Count',
        recipient.hire_date AS 'Hire Date',
        recipient.salary AS 'Salary',
        recipient.job_title AS 'Job Title',
        CONCAT(manager.l_name, ', ', manager.f_name) AS 'Manager',
        branch.name AS 'Branch',
        branch.state_location AS 'State'
FROM award
INNER JOIN recipient ON award.recipient_id = recipient.id
INNER JOIN manager ON recipient.manager_id = manager.id
INNER JOIN branch ON recipient.branch_id = branch.id
GROUP BY award.id";

$response = mysqli_query($dbc, $query);

while($row = mysqli_fetch_assoc($response)){
  //Add records as rows to HTML table
  echo "<tr>
  <td> {$row['First Name']} </td>
  <td> {$row['Last Name']} </td>
  <td> {$row['Award Count']} </td>
  <td> {$row['Hire Date']} </td>
  <td> {$row['Salary']} </td>
  <td> {$row['Job Title']} </td>
  <td> {$row['Manager']} </td>
  <td> {$row['Branch']} </td>
  <td> {$row['State']} </td>
  </tr>";
}

mysqli_close($dbc);
?>
