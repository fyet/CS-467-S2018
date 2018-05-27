<?php
require_once 'outputCSV.php';
require_once '../../config.php';
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

outputCSV($response, "userAwardData.csv");
?>
