<?php
  require('sessionValidator.php');
  $_SESSION['location'] = 0;

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }
?>

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

    <?php include("userComponents/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include("userComponents/sidebar.php"); ?>

            <div class ="col-sm-12 page-content">
                <div class="row">
                    <div class="col-lg">
                        <p class="h3">AwardHub User Home</p>
                    </div>
                </div>
                <div class="row" style="padding: 20px 0px;">
                    <div class="card-deck remove-body-on-resize">
                        <a href ="searchemail.php">
                            <div class="card border-light text-white bg-primary mb-3">
                                <div class="card-header">Create Award</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Create Employee of the Week</li>
                                            <li>Create Employee of the Month</li>
                                            <li>Create Employee of the Year</li>
                                        </ul>
                                        <br>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="edit-user.php">
                            <div class="card border-light text-white bg-primary mb-3">
                                <div class="card-header">My Account</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Edit Name</li>
                                            <li>Edit Password</li>
                                            <li>Edit Signature</li>
                                        </ul>
                                        <br>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="addRecipient.php">
                            <div class="card border-light text-white bg-primary mb-3">
                                <div class="card-header">Add Recipient</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Add New Recipient</li>
                                        </ul>
                                        <br>
                                        <br>
                                        <br>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <a href="edit-recipient.php">
                            <div class="card border-light text-white bg-primary mb-3">
                                <div class="card-header">Manage Recipients</div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <ul>
                                            <li>Edit Recipient</li>
                                            <li>Delete Recipient</li>
                                        </ul>
                                        <br>
                                        <br>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                   <!-- <div class="col-md-7"> -->
                    <div class="col-xl">
                            <p class="h3">Awards Given</p>
                    </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Award Type</th>
                                        <th scope="col">Award Date</th>
                                        <th scope="col">Recipient First Name</th>
                                        <th scope="col">Recipient Last Name</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    require_once('config.php');

                                    $sql = "SELECT * FROM award WHERE user_id = " .$_SESSION['user'];
                                    $awards = mysqli_query($dbc, $sql);

                                    while($award = mysqli_fetch_assoc($awards)){
                                        $sql2 = "SELECT f_name, l_name FROM recipient WHERE id =" .$award['recipient_id'];
                                        $recip = mysqli_query($dbc, $sql2);
                                        $row = mysqli_fetch_assoc($recip);
                                        ?>

                                    <tr id="<?php echo $award['id'] ?>">
                                        <td><?php echo $award['accolade_type']; ?></td>
                                        <td><?php echo $award['accolade_date']; ?></td>
                                        <td><?php echo $row['f_name']; ?></td>
                                        <td><?php echo $row['l_name']; ?></td>
                                        <td><button class="btn btn-danger btn-sm active" 
                                            data-toggle="modal"
                                            id="deleteButt" 
                                            data-id="<?php echo $award['id'] ?>"
                                            data-target="#deleteAward">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16"><path fill-rule="evenodd" d="M7.71 8.23l3.75 3.75-1.48 1.48-3.75-3.75-3.75 3.75L1 11.98l3.75-3.75L1 4.48 2.48 3l3.75 3.75L9.98 3l1.48 1.48-3.75 3.75z"></path></svg>
                                            <span class='btn-txt'>Delete</span>
                                        </button></td>
                                    </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <!--</div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAward"
        tabindex="-1" role="dialog"
        aria-labelledby="deleteAward"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                <p>Are you sure you want to permenently delete this award?</p>
                <input id="deleteID" 
                style="visibility: hidden;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"> Cancel </button>
                <button type="button" class="btn btn-primary btn-sm" id="submitDelete"> Delete Award</button>
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $("#userHomebtn").addClass("active");
    </script>
    <script>
        $(document).ready(function(){
            $('#deleteAward').on('show.bs.modal', function(event){
                var button = $(event.relatedTarget);
                var id = button.data('id');

                var modal = $(this);
                modal.find('.modal-body input').val(id).hide();

                $('#submitDelete').click(function(){
                    var id = $('#deleteID').val();

                    $.ajax({
                        url: 'deleteAward.php?id=' + id,
                        type: 'DELETE',
                        cache: false,
                        success: function(result){
                            //window.location.reload(true);
                            $('#deleteAward').modal('hide');
                            $("#"+id).remove();
                        }
                    });
                });
            });
        });
    </script>
    <?php mysqli_close($dbc); ?>
</body>
