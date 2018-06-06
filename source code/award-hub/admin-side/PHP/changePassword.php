<?php
require '../../login-system/sessionValidator.php';
require '../../database-resources/config.php';
require '../../email-handler/emailHandler.php';

$_SESSION['location'] = 0;
$id = $_SESSION['user'];
//Get password from POST request body
$bodyData = file_get_contents('php://input');
$POST_body = json_decode($bodyData, true);
$psword = $POST_body['psword'];

//Encrypt password before submitting to DB
$hashed_psword = password_hash($psword, PASSWORD_DEFAULT);

$query = "UPDATE user SET psword = ? WHERE id = ?";
$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_bind_param($stmt, 'si', $hashed_psword, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);


$sql = "SELECT email FROM user WHERE id = " .$id;
$result = mysqli_query($dbc, $sql);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];

$subject = "AwardHub Password Changed";
$msgBody =
        "<p>Your password has been changed.</p>
        <p>If you do not recognize this activity, please contact your system administrator.</p>
        <p>-AwardHub Team</p>";

emailHandler($email, $subject, $msgBody);

?>
