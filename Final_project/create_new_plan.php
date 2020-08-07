<?php
//Making connection to database and starting the session.
require "Required/common.php";

//If not logged-in user then redirect to login page.
if(!isset($_SESSION['email']))
{
    header('location:login.php');
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
        <title>Create new plan</title>
        
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
            .style2:hover{
                background-color: rgb(0,150,150) !important;
                color: white !important;
            }
        </style>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!--Addition of navigation bar of our webpage-->
         <?php
         include 'Required/header.php';
         ?>
        
        <!--Formation of "create_new_plan" form in this page-->
        <div class="container" style="min-height: 650px">
            <div class="row row_style">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="text-align:center;background-color: rgb(0,150,150);color: whitesmoke;">
                        <h3>Create New Plan</h3>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="plan_details.php">
                                <div class="form-group">
                                    <label>Initial Budget</label>
                                    <input type="number" name="ini_budget" placeholder="Initial Budget(Ex.4000)" class="form-control" min="50" required>
                                    <?php if(isset($_GET['budget_error'])){$error=$_GET['budget_error'];echo "<script>alert('$error')</script>";}?>
                                </div>
                                <div class="form-group">
                                    <label>How many peoples you want to add in your group?</label>
                                    <input type="number" name="no_people" placeholder="No.of people" class="form-control" min="1" required>
                                   <?php if(isset($_GET['people_error'])){$error=$_GET['people_error'];echo "<script>alert('$error')</script>";}?>                                    
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-block style2" style="border-color: lightseagreen;background-color: white;color: lightseagreen;">Next</button>
                                </div>
                            </form>
                        </div>
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
        

