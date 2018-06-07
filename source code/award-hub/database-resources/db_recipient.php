<?php

// SQL Components + Query
require_once('config.php');
$query = "SELECT * FROM recipient";
$response = mysqli_query($dbc, $query);

// Title of table
echo "<h1> recipient table</h1><br>";

// Style table
echo "<style>
            td, th {
                border: 1px solid black;
            }

            table {
                border-collapse: collapse;
            }      

            .firstRow{
                background-color: #cbced3;
                font-weight: bold;   
            }
      </style>";

// Create table and titles
echo "<table>";
echo "<tr>
        <td class='firstRow'>id</td>
        <td class='firstRow'>email/td>
        <td class='firstRow'>f_name</td>
        <td class='firstRow'>l_name</td>
        <td class='firstRow'>branch_id</td>
        <td class='firstRow'>manager_id</td>
        <td class='firstRow'>job_title</td>
        <td class='firstRow'>salary</td>
        <td class='firstRow'>hire_date</td> ";

while($row = mysqli_fetch_assoc($response)){
    echo "<tr>
            <td> {$row['id']} </td>
            <td> {$row['email']} </td>            
            <td> {$row['f_name']} </td>            
            <td> {$row['l_name']} </td>            
            <td> {$row['branch_id']} </td>
            <td> {$row['manager_id']} </td>
            <td> {$row['job_title']} </td>  
            <td> {$row['salary']} </td>   
            <td> {$row['hire_date']} </td>";
}
echo "</table>";

mysqli_close($dbc)

?>