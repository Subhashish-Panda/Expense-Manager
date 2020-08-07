<?php
include "Required/common.php";

//If not logged-in user then no access to this page.
if (!isset($_SESSION['email']))
{
header('location: index.php');
}

//Fetching the bill-image and plan id using "id" coloumn of expense table.
$exp_id=$_GET["id"];
$query="Select planid,bill from expenses where id='$exp_id'";
$sel_query= mysqli_query($con, $query);
$record= mysqli_fetch_array($sel_query);
$plan_id=$record["planid"];
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Linking necessary bootstrap files-->
        <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!--Title of the webpage-->
        <title>Expense_Distribution</title>
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
            .link:hover{
                background-color: rgb(0,150,150) !important;
                color: white !important;   
            }
        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!--Addition of navigation bar to our webpage-->
        <?php
        include 'Required/header.php';
        ?>
        <!--Show required bill to user-->
        <div class="container" style="min-height: 600px;">
            <div class="row row_style">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading" style="text-align:center;">
                            <h3>Your Bill</h3>
                        </div>
                        <div class="panel-body">
                        <center><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($record['bill']).'" alt="Nothing" class="img-responsive"/>'?>;</center>
                        <center><a href="viewplan.php?pl_id=<?php echo $plan_id;?>" class="btn link" style="color:rgb(0,150,150);border-color: lightblue;"><span class="glyphicon glyphicon-arrow-left"></span>Go back</a></center>
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
