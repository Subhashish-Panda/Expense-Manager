<?php

//Making connection to database and starting the session.
require "Required/common.php";

//If not logged-in user then no access to this page.
if (!isset($_SESSION['email']))
{
header('location: index.php');
}

//Obtaining the current user_email.
$user_email=$_SESSION['email'];

//Performing all possible security measures in test_input function to prevent form injection in backend.
function test_input($con,$data){
$data=trim($data);
$data= stripslashes($data);
$data= mysqli_real_escape_string($con, $data);
$data= htmlspecialchars($data);
return $data;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Linking necessary bootstrap files-->
        <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!--Title of the webpage-->
        <title>Change_Password</title>
        <!--Required styling-->
        <style>
            .row_style{
                margin-top: 100px;
            }
            footer{
            margin-top: 10px;
            padding: 10px 0;
            background-color: #101010;
            color:#9d9d9d;
            bottom: 0;
            width: 100%;
            }
            @media(min-height: 720px){
                footer{
                    position: fixed;
                }
            }
        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!--Addition of navigation bar to our webpage-->
        <?php
        include 'Required/header.php';
        ?>
        <!--Addition of required content to our page-->
        <div class="container" style="min-height: 650px;">
            <div class="row row_style">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align: center;background-color:white;">
                            <h3>Change Password</h3>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" name="old_password" placeholder="Old Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" placeholder="New Password(Min. 6 characters)" class="form-control" pattern=".{6,}"required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="confirm_password" placeholder="Re-type New Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="change" class="btn btn-block" style="background-color: lightseagreen;text-align: center;color: whitesmoke;">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Addition of footer to our page-->
        <?php
        include 'footer.php';
        ?>
    </body>
</html>

<?php
//When change button is clicked.
if(isset($_POST["change"]))
{
 //Checking for any kind of injection.
 $old= md5(test_input($con, $_POST["old_password"]));
 $new= test_input($con, $_POST["new_password"]);
 $conf= test_input($con, $_POST["confirm_password"]);
 $ver=0;
 
 //Perfroming Form validation.
 $query="Select password from users where email='$user_email'";
 $select_query= mysqli_query($con, $query);
 $rows= mysqli_fetch_array($select_query);
 if($rows["password"]!=$old)
 {
  echo ("<script>alert('Wrong old password')</script>");
  $ver=1;
 }
 else if(strlen($new)<6)
 {
  echo ("<script>alert('New Password(Min. 6 characters)')</script>");
  $ver=1;
 }
 else if($conf!=$new)
 {
  echo ("<script>alert('Passwords dont match')</script>");
  $ver=1;
 }
 
 //All validation and injection prevention done.
 if($ver==0)
 {$new=md5($new);//Encryption scheme.
  //Make a query to update password into database.
  $query="Update users set password='$new' where email='$user_email'";
  mysqli_query($con, $query);
  //Delete all the session variables since,redirecting the "logged-in" user to index page.
  session_unset();
  session_destroy();
  echo ("<script>location.href='index.php?pswd_msg=Password updated'</script>");
 }
 
}
?>
