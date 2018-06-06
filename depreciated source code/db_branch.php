<?php

// SQL Components + Query
require_once('config.php');
$query = "SELECT * FROM branch";
$response = mysqli_query($dbc, $query);

// Title of table
echo "<h1> branch table</h1><br>";

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
        <td class='firstRow'>name/td>
        <td class='firstRow'>state_location</td>";

while($row = mysqli_fetch_assoc($response)){
    echo "<tr>
            <td> {$row['id']} </td>
            <td> {$row['name']} </td>            
            <td> {$row['state_location']} </td>";
}
echo "</table>";

mysqli_close($dbc)

?>