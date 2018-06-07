<?php

// SQL Components + Query
require_once('config.php');
$query = "SELECT * FROM user";
$response = mysqli_query($dbc, $query);

// Title of table
echo "<h1> user table</h1><br>";

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
        <td class='firstRow'>f_name/td>
        <td class='firstRow'>l_name</td>
        <td class='firstRow'>email</td>
        <td class='firstRow'>psword</td>
        <td class='firstRow'>creation_date</td>
        <td class='firstRow'>signature</td>
        <td class='firstRow'>account_type</td>
        <td class='firstRow'>last_change</td> ";

while($row = mysqli_fetch_assoc($response)){
    echo "<tr>
            <td> {$row['id']} </td>
            <td> {$row['f_name']} </td>            
            <td> {$row['l_name']} </td>            
            <td> {$row['email']} </td>            
            <td> {$row['psword']} </td>
            <td> {$row['creation_date']} </td>
            <td> {$row['signature']} </td>  
            <td> {$row['account_type']} </td>   
            <td> {$row['last_change']} </td>";
}
echo "</table>";

mysqli_close($dbc)

?>