<!doctype html>
<html lang="en">
<head>
    <title>User Home</title>
    <!-- Required meta tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/custom.css">
</head>
<body>
    <?php
    session_start();
    $_SESSION['user'] = 1;
    ?>

    <?php include("userComponents/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include("userComponents/sidebar.php"); ?>

            <div class ="col-sm-14 page-content">
                <div class="row" style="padding: 20px 0px;">
                    <div class="card-deck">
                        <a href ="searchemail.php">
                            <div class="card border-light mb-3">
                                <div class="card-header">Create Award</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Create Employee of the Week</li>
                                            <li>Create Employee of the Month</li>
                                            <li>Create Employee of the Year</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="manage-user.php">
                            <div class="card border-light mb-3">
                                <div class="card-header">Manager User</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Edit Name</li>
                                            <li>Edit Password</li>
                                            <li>Edit Signature</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="addRecipient.php">
                            <div class="card border-light mb-3">
                                <div class="card-header">Add Recipient</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Add New Recipient</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="container">
                    <table class="table table-bordered">
                        <tr>
                            <th>Award Type</th>
                            <th>Recipient First Name</th>
                            <th>Recipient Last Name</th>
                            <th width="100px">Delete</th>
                        </tr>

                        <?php
                        require_once('config.php');

                        $sql = "SELECT * FROM award WHERE user_id = " .$_SESSION['user'];
                        $awards = mysqli_query($dbc, $sql);

                        while($award = mysqli_fetch_assoc($awards)){
                            $sql2 = "SELECT f_name, l_name FROM recipient WHERE id =" .$award['recipient_id'];
                            $recip = mysqli_query($dbc, $sql2);
                            $row = mysqli_fetch_assoc($recip);
                            ?>

                            <tr data-id="<?php echo $award['id'] ?>">
                                <td><?php echo $award['accolade_type']; ?></td>
                                <td><?php echo $row['f_name']; ?></td>
                                <td><?php echo $row['l_name']; ?></td>
                                <td><button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#deleteAward">Delete</button></td>
                            </tr>

                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAward"
        tabindex="-1" role="dialog"
        aria-labelledby="deleteAward"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAwardTitle"> Delete Award</h5>
                    <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this award?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal"> Cancel </button>
                <button type="button" class="btn btn-primary btn-sm"> Delete Award</button>
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- -<script>
        $(document).ready(function(){
            $('.remove').click(function(e){

                e.preventDefault();

                var id = $(this).parents("tr").attr("id");
                var parent = $(this).parent("td").parent("tr");


                bootbox.dialog({
                    message:"Are you use you want to delete this award?",
                    title:"Delete Award",
                    buttons:{
                        success:{
                            label:"No",
                            className: "btn-success",
                            callback: function(){
                                $('.bootbox').modal('hide');
                            }
                        },
                        danger:{
                            label:"Delete Award",
                            className:"btn-danger",
                            callback: function(){

                                /*using $.ajax();

                                $.ajax({
                                    type: 'POST',
                                    url: 'deleteAward.php',
                                    data:'delete='+id
                                })
                                .done(function(response){
                                    bootbox.alert(response);
                                    parent.fadeOut('slow');
                                })
                                .fail(function(){
                                    bootbox.alert("Something went wrong when deleting....")*/
                                })
                            }
                        }
                    }
                });

            });
        });
    </script> -->
</body>
