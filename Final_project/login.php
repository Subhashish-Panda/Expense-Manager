<?php
//Making connection to the database and starting the session.
require "Required/common.php";

//Unless "logged-out" the logged-in user cannot go to login page again.
if (isset($_SESSION['email'])){
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
        <title>Login page</title>
        
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
        <!--Addition of navigation bar of our webpage-->
         <?php
         include 'Required/header.php';
         ?>
        <!--Creation of login form using bootstrap panels-->
        <div class="container" style="min-height:650px;">
            <div class="row row_style">
                <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                       <div class="panel-heading" style="text-align: center;background-color:white;">
                       <h3>Login</h3>
                       </div>
                       <div class="panel-body">
                       <form method="POST" action="login_script.php">
                       <div class="form-group">
                           <label>Email:</label>
                           <input type="email" name="email" placeholder="Email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                           <?php if(isset($_GET['email_error'])){$error=$_GET['email_error'];echo "<script>alert('$error')</script>";}?>
                       </div>
                       <div class="form-group">
                           <label>Password:</label>
                           <input type="password" name="password" placeholder="Password" class="form-control" pattern=".{6,}" required>
                           <?php if(isset($_GET['password_error'])){$error=$_GET['password_error'];echo "<script>alert('$error')</script>";}?>
                       </div>
                       <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-success btn-block" style="background-color: rgb(0,150,150);border-color: rgb(0,150,150);">Login</button>
                       </div>
                       </form>
                       <div class="panel-footer">
                       <p>Don't have an account?<a href="signup.php">Click here to Sign Up</a></p>
                       </div>
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

