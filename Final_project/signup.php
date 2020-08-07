<?php
//Making connection to the database and starting the session.
require "Required/common.php";

//If session variable is set,that means current user is a "logged in user".
//Then,directly proceed to home page since no need of signup.
if (isset($_SESSION['email']))
{
header('location: home.php');
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
        <title>Signup page</title>
        
        <!--Required styling for this page.-->
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
        <!--Addition of navigation bar of our webpage-->
         <?php
         include 'Required/header.php';
         ?>
        
        <!--Creation of sign up form using bootstrap panels.-->
        <!--Front-end validation is also performed-->
        <div class="container" style="min-height:650px;">
            <div class="row row_style">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                      <div class="panel-heading" style="text-align: center;background-color:white;">
                      <h3>Sign Up</h3>
                      </div>
                      <div class="panel-body">
                       <form method="POST" action="signup_script.php">
                       <div class="form-group">
                           <label>Name:</label>
                           <input type="text" name="name" placeholder="Name" class="form-control" pattern="[a-zA-Z ]+" required>
                           <?php if(isset($_GET['name_error'])){$error=$_GET['name_error'];echo "<script>alert('$error')</script>";}?>
                       </div>
                       <div class="form-group">
                           <label>Email:</label>
                           <input type="email" name="email" placeholder="Enter Valid Email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                           <?php if(isset($_GET['email_error'])){$error=$_GET['email_error'];echo "<script>alert('$error')</script>";}?>
                       </div>
                       <div class="form-group">
                           <label>Password:</label>
                           <input type="password" name="password" placeholder="Password(Min. 6 characters)" class="form-control" pattern=".{6,}" required>
                           <?php if(isset($_GET['password_error'])){$error=$_GET['password_error'];echo "<script>alert('$error')</script>";}?>
                       </div>
                       <div class="form-group">
                           <label>Phone Number:</label>
                           <input type="tel" name="contact" placeholder="Enter Valid Phone Number(Ex: 8448444853)" class="form-control" pattern=".{10}" required>
                           <?php if(isset($_GET['contact_error'])){$error=$_GET['contact_error'];echo "<script>alert('$error')</script>";}?>
                       </div>
                       <div class="form-group">
                       <button type="submit" name="submit" class="btn btn-success btn-block" style="background-color: rgb(0,150,150);border-color: rgb(0,150,150);">Sign Up</button>
                       </div>
                       </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Adding footer to the page-->
        <?php
        include 'footer.php';
        ?>
   </body>
</html>


