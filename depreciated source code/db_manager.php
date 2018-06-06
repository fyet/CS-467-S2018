<?php

// SQL Components + Query
require_once('config.php');
$query = "SELECT * FROM manager";
$response = mysqli_query($dbc, $query);

// Title of table
echo "<h1> manager table</h1><br>";

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
        <td class='firstRow'>f_name</td>
        <td class='firstRow'>l_name</td>
        <td class='firstRow'>department_name</td>";

while($row = mysqli_fetch_assoc($response)){
    echo "<tr>
            <td> {$row['id']} </td>
            <td> {$row['f_name']} </td>            
            <td> {$row['l_name']} </td>            
            <td> {$row['department_name']} </td>";
}
echo "</table>";

mysqli_close($dbc)

?>