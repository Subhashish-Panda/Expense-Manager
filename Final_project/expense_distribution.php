<?php

//Making connection to database and starting the session.
require "Required/common.php";

//If not logged-in user then redirect to index page.
if (!isset($_SESSION['email']))
{
header('location: index.php');
}

//Obtaining the user-id and plan-id.
$user_id=$_SESSION['user_id'];
$plan_id=$_GET['planid'];

//Fetching initial budget,no.of people,title of plan from plan_details table.
$query="Select * from plan_details where id='$plan_id'";
$sel_query= mysqli_query($con, $query);
$result= mysqli_fetch_array($sel_query);
$title=$result["title"];
$no_of_people=$result["tot_persons"];
$budget=$result["ini_budget"];

//Query to fetch person names from persons table(to be used later in loop).
$query1="Select pname from persons where uid='$user_id' and plid='$plan_id'";
$sel_query1= mysqli_query($con, $query1);

//Function for finding colour of remaining amount.
function find_colour($amt)
{
 $str="";
 if($amt<0){$str='red';}
 else if($amt>0){$str='green';}
 else{$str='black';}
 return $str ;
}

//Function for finding state(i.e wheather "owes" or "gets back" or "all settled up") of individual shares.
function find_text($amt)
{
 $str="";
 if($amt<0){$str="Owes &#8377; ";}
 else if($amt>0){$str="Gets back &#8377; ";}
 else{$str="All Settled up";}
 return $str;
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
        <!--Addition of required content to expense_distribution page.-->
        <div class="container-fluid" style="min-height: 650px">
            <div class="row row_style">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="panel panel-default">
                       <div class="panel-heading" style="background-color: rgb(0,150,150);text-align: center;color: whitesmoke;">
                        <p><span><text style="font-size:16px;"><?php echo $title;?></text></span><span class="glyphicon glyphicon-user" style="color:white;float:right;"><text style="margin-left: 2px;"><?php echo $no_of_people;?></text></span></p>
                       </div>
                        <div class="panel-body">
                        <p><b>Initial Budget</b><text style="float: right;">&#8377;<?php echo $budget;?></text></p>
                        <?php
                        $total_amount=0;//for storing total expense-amount spent by all persons in the current plan.
                        while($tupple= mysqli_fetch_array($sel_query1)){
                         $str=$tupple["pname"];
                         $query2="Select SUM(expense_amount) from expenses where expense_person='$str' and planid='$plan_id'";
                         $sel_query2= mysqli_query($con, $query2);
                         $exp_sum= mysqli_fetch_array($sel_query2);//stores expense-amount spent by each person in the current plan.
                         $total_amount+=$exp_sum["SUM(expense_amount)"];
                         ?>
                        <p><b><?php echo $str;?></b><text style="float: right;">&#8377;<?php if(!$exp_sum["SUM(expense_amount)"]){echo "0";}else{echo $exp_sum["SUM(expense_amount)"];}?></text></p>
                        <?php }?>
                        <p><b>Total amount spent</b><text style="float: right;">&#8377;<?php echo $total_amount;?></text></p>
                        <p><b>Remaining amount</b><text style="float: right; color: <?php echo find_colour($budget-$total_amount);?>;">&#8377;<?php echo abs($budget-$total_amount);?></text></p>
                        <p><b>Individual shares</b><text style="float: right;">&#8377;<?php echo round(($total_amount/$no_of_people),2);?></text></p>
                        <?php
                        $query1="Select pname from persons where uid='$user_id' and plid='$plan_id'";
                        $sel_query1= mysqli_query($con, $query1);
                         while($rows= mysqli_fetch_array($sel_query1)){
                         $str=$rows["pname"];
                         $query2="Select SUM(expense_amount) from expenses where expense_person='$str' and planid='$plan_id'";
                         $sel_query2= mysqli_query($con, $query2);
                         $exp_sum= mysqli_fetch_array($sel_query2);//stores expense-amount spent by each person in the current plan.
                         $share=$exp_sum["SUM(expense_amount)"]- round(($total_amount/$no_of_people),2);//stores  individual-share of each person in the current plan.
                         ?>
                        <p><b><?php echo $str;?></b><text style="float: right;color: <?php echo find_colour($share);?>;"><?php if($share==0){echo find_text($share);}else{echo find_text($share).abs($share);}?></text></p>
                         <?php }?>
                        <center><a href="viewplan.php?pl_id=<?php echo $plan_id;?>" class="btn link" style="color:rgb(0,150,150);border-color: lightblue;"><span class="glyphicon glyphicon-arrow-left"></span>Go back</a></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Addition of footer to our page-->
        <?php
        include "footer.php";
        ?>
    </body>
</html>

