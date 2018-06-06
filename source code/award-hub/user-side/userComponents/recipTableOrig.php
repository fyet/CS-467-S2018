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

?>

    <tr id="<?php echo $row['id']; ?>">
    <td><?php echo $row['f_name']; ?></td>
    <td><?php echo $row['l_name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $branch['name']; ?></td>
    <td><?php echo $manager['f_name'] ." " .$manager['l_name']; ?></td>
    <td><?php echo $row['job_title']; ?></td>
    <td><?php echo $row['salary']; ?></td>
    <td><button class="btn btn-secondary btn-sm active" 
                data-toggle="modal"
                id="editButt" 
                data-id="<?php echo $row['id'] ?>"
                data-email="<?php echo $row['email']; ?>"
                data-f_name="<?php echo $row['f_name']; ?>"
                data-l_name="<?php echo $row['l_name']; ?>"
                data-job_title="<?php echo $row['job_title']; ?>"
                data-salary="<?php echo $row['salary']; ?>"
                data-target="#editRecipient">
                Edit</button></td>
    <td><button class="btn btn-danger btn-sm active" 
                data-toggle="modal"
                id="deleteButt" 
                data-id="<?php echo $row['id'] ?>"                    
                data-target="#deleteRecipient">Delete</button></td>
    <?php } 

    mysqli_close($dbc); ?>

