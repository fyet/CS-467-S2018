<?php
require_once('../../config.php');

$start = $_GET['start'];
$end = $_GET['end'];

$query = "SELECT award.accolade_date,
                 user.f_name AS 'uf_name',
                 user.l_name AS 'ul_name',
                 award.accolade_type,
                 recipient.f_name AS 'rf_name',
                 recipient.l_name AS 'rl_name' FROM ((award
INNER JOIN recipient ON award.recipient_id = recipient.id)
INNER JOIN user ON award.user_id = user.id)
WHERE award.accolade_date BETWEEN ? AND ?
ORDER BY award.accolade_date DESC";

if ($stmt = mysqli_prepare($dbc, $query)){
    mysqli_stmt_bind_param($stmt, 'ss', $start, $end);
    mysqli_stmt_execute($stmt);
    $response = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($response)){
        echo "<tr>
        <td><i>{$row['accolade_date']}</i></td>
        <td>
          <p>{$row['uf_name']} {$row['ul_name']} awarded \"{$row['accolade_type']}\" to {$row['rf_name']} {$row['rl_name']}</p>
        </td>
        </tr>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($dbc);
