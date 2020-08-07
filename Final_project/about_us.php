<?php
//Making connection to the database and starting the session.
require "Required/common.php";

//Note:Since this page is accessible by both logged-in and logged-out/new user(so no checking of session variables).
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Linking necessary bootstrap files-->
        <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        
        <!--Title of the webpage-->
        <title>About us page</title>
        
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
        
        <!--Addition of required content to about_us page-->
        <div class="container" style="min-height:650px;">
            <div class="row row_style">
              <div class="container">
                <div class="col-sm-6">
                    <h3>Who are we?</h3>
                    <p>We are a group of young technocrats who came up with an idea of solving
                    budget and time issues which we usually face in our daily lives.We are here to
                    provide a budget controller according to your aspects.<br><br>Budget control is
                    the biggest financial issue in the present world.One should look after their budget
                    control to get ride off from their financial crisis.<br>
                    <h3>Contact Us</h3>
                    <p><b>Email: </b>trainings@internshala.com<br><br><b>Mobile: </b>+91-8448444853</p>
                </div>
                <div class="col-sm-6">
                    <h3>Why choose us?</h3>
                    <p>We provide with a predominant way to control and manage your budget estimations
                    with ease of accessing for multiple users.</p>
                </div>
              </div>
            </div>
        </div>
        
        <!--Addition of footer to our webpage-->
        <?php
        include 'footer.php';
        ?>
    </body>
</html>
