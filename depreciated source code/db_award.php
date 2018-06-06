<?php

// SQL Components + Query
require_once('config.php');
$query = "SELECT * FROM award";
$response = mysqli_query($dbc, $query);

// Title of table
echo "<h1> award table</h1><br>";

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
        <td class='firstRow'>accolade_date/td>
        <td class='firstRow'>accolade_type</td>
        <td class='firstRow'>user_id</td>
        <td class='firstRow'>certificate</td>
        <td class='firstRow'>recipient_id</td>";

while($row = mysqli_fetch_assoc($response)){
    echo "<tr>
            <td> {$row['id']} </td>
            <td> {$row['accolade_date']} </td>            
            <td> {$row['accolade_type']} </td>            
            <td> {$row['user_id']} </td>            
            <td> {$row['certificate']} </td>
            <td> {$row['recipient_id']} </td>";
}
echo "</table>";

mysqli_close($dbc)

?>