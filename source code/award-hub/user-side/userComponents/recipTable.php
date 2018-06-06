<?php
require('../../database-resources/config.php'); // Instantiate a connection to our database

$sql = "SELECT * FROM recipient";
$recips = mysqli_query($dbc, $sql);

while($row = mysqli_fetch_assoc($recips)){
    $sql2 = "SELECT name FROM branch WHERE id=" .$row['branch_id'];
    $branchs = mysqli_query($dbc, $sql2);
    $branch = mysqli_fetch_assoc($branchs);
    $sql3 = "SELECT f_name, l_name FROM manager WHERE id=" .$row['manager_id'];
    $managers = mysqli_query($dbc, $sql3);
    $manager = mysqli_fetch_assoc($managers);
    $temp = $row['job_title'];
    $temp = str_replace(" ", "_", $temp);

    echo "<tr id={$row['id']}>
    <td> {$row['f_name']} </td>
    <td> {$row['l_name']} </td>
    <td> {$row['email']} </td>
    <td> {$branch['name']} </td>
    <td> {$manager['f_name']} {$manager['l_name']} </td>
    <td> {$row['job_title']} </td>
    <td> {$row['salary']} </td>
    <td>
        <button type='button'
                class='btn btn-secondary btn-sm active'
                data-toggle='modal'
                data-id={$row['id']}
                data-email={$row['email']}
                data-f_name={$row['f_name']}
                data-l_name={$row['l_name']}
                data-job_title={$temp}
                data-salary={$row['salary']}
                data-target='#editRecipient'>
                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"16\" viewBox=\"0 0 14 16\"><path fill-rule=\"evenodd\" d=\"M0 11.592v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3l-1.3 1.3-3-3 1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z\"></path></svg>
                <span class='btn-txt'>Edit</span>
        </button>
    </td>
    <td>
        <button type='button'
                class='btn btn-danger btn-sm active'
                data-toggle='modal'
                data-id={$row['id']}
                data-target='#deleteRecipModal'>
                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"16\" viewBox=\"0 0 12 16\"><path fill-rule=\"evenodd\" d=\"M7.71 8.23l3.75 3.75-1.48 1.48-3.75-3.75-3.75 3.75L1 11.98l3.75-3.75L1 4.48 2.48 3l3.75 3.75L9.98 3l1.48 1.48-3.75 3.75z\"></path></svg>
                <span class='btn-txt'>Delete</span>
        </button>
    </td>
    <tr>";

    }
    mysqli_close($dbc); ?>

