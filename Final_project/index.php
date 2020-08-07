<?php if(isset($_GET['pswd_msg'])){$msg=$_GET['pswd_msg'];echo "<script>alert('$msg')</script>";}//Message to be displayed when password is updated?>

<?php
//Making connection to the database and starting the session.
require "Required/common.php";

//Checking wheather a "logged-in user/logged-out" user.
//If "logged-in user" then he/she should be in home-page of our webapp.
if (isset($_SESSION['email']))
{
header('location: home.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
         <!--Linking necessary files of bootstrap-->
         <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
         <script type="text/javascript" src="bootstrap/js/jquery-3.4.1.min.js"></script>
         <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
         
         <!--Title of the webpage-->
         <title>Expense Manager</title>
         
         <!--Required styling for this page.-->
         <!--Note:for different devices different background images is used to adjust footer properly w.r.t to device.-->
         <link rel="stylesheet" type="text/css" href="style.css">
         <style>
            footer{
            padding: 10px 0;
            background-color: #101010;
            color:#9d9d9d;
            bottom: 0;
            width: 100%;
            }
            @media(min-height: 740px) and (max-height:900px){
                footer{
                    position: fixed;
                }
                #banner_image{
                   background: url(pic/exp8.jpeg) no-repeat center;
                   min-height: 900px;
                }
                
            }
            @media(min-height: 901px) and (max-height:1366px){
                footer{
                    position: fixed;
                }
                #banner_image{
                   background: url(pic/exp8.jpeg) no-repeat center;
                   min-height: 1402px;
                }
                
            }
            @media(min-height: 1367px){
                #banner_image{
                   background: url(pic/exp5.jpg) no-repeat center;
                   min-height: 1600px;
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
        
        <!--Addition of required-content to index page-->
        <div id="banner_image">
            <div class="container">
                <center>
                <div id="banner_content">
                    <h2>We help you control your budget</h2>
                    <a href="login.php" class="btn btn-danger btn-lg active">Start Today</a>
                </div>
                </center>
            </div>
        </div>
        
        <!--Adding footer to the page-->
        <?php
        include 'footer.php';
        ?>
    </body>
</html>
