<?php if(isset($_GET['success_msg'])){$msg=$_GET['success_msg'];echo "<script>alert('$msg')</script>";}//After successful registration occurs from signup page.?>

<?php
//Making connection to database and starting the session.
require "Required/common.php";

//If not logged-in user then redirect to index page.
if (!isset($_SESSION['email']))
{
header('location: index.php');
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
        <title>Home page</title>
        
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
            @media(min-height:720px)
            {
                .content{
                    min-height: 1000px !important;
                }
            }
            @media(min-height:1050px)
            {
                .content{
                    min-height: 1450px !important;
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
        
        <!--Addition of required content to home page-->
        <?php
        //Initially,checking wheather the person has made any plan or not.
        $user_id=$_SESSION['user_id'];
        $query="Select * from persons where uid='$user_id'";
        $select_query= mysqli_query($con, $query);
        $num_rows= mysqli_num_rows($select_query);
        //If no rows in persons table means,current logged-in user has not made any plan yet.
        if($num_rows==0)
        {?>
        <div class="container content" style="min-height: 1300px;">
            <div class="row row_style">
                <div style="margin-left: 10px;">
                    <h2>You don't have any active plans</h2><br>
                </div>
                  <div class="col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-3">
                    <div class="panel panel-default" style="min-height: 150px;">
                        <div class="panel-body" style="text-align: center; margin-top: 40px;">
                          <span class="glyphicon glyphicon-plus-sign" style="color:rgb(0,150,150);"></span><a href="create_new_plan.php" style="text-decoration:none; color:blue;">Create a New plan</p>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
        <?php }
        //Else display all created plans made by this user(by fetching distinct plan_id from persons table).
        else{ ?>
        <div class="container content" style="min-height: 650px;">
          <div class="row row_style">
            <h1 style="margin-left:10px;">Your Plans</h1>
         <?php
            //Search for all plans(distinct values) made by the current user from the persons table.
            $query="Select DISTINCT plid from persons where uid='$user_id'";
            $select_query= mysqli_query($con, $query);
            while($rows= mysqli_fetch_array($select_query))
            {//Extracting each plan made by the user.
             $plan_id=$rows["plid"];
            //Fetching all the details related to particular plan.
            $query1="Select * from plan_details where id='$plan_id'";
            $select_query1= mysqli_query($con, $query1);
            $fetched= mysqli_fetch_array($select_query1);
            //Setting all the required variables from the fetched values.
            $ti=$fetched["title"];//"ti"-stands for title of plan.
            $f=$fetched["from_date"];//"f"-stands for from date of plan.
            $t=$fetched["to_date"];//"t"-stands for to date of plan.
            $in_budget=$fetched["ini_budget"];//"in_budget"-stands for initial budget of plan.
            $people=$fetched["tot_persons"];//"people"-stands for no.of.people in the plan.
            ?>                   
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: rgb(0,150,150);text-align: center;color: whitesmoke;">
                        <p><span><text style="font-size:16px;"><?php echo $ti;?></text></span><span class="glyphicon glyphicon-user" style="color:white;float:right;"><text style="margin-left: 2px;"><?php echo $people;?></text></span></p>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:13px;"><b>Budget</b><text style="float: right;">&#8377;<?php echo $in_budget;?></text></p>
                            <p style="font-size:13px;"><b>Date</b><text style="float:right;"><?php echo substr($f,8,2).find_day(substr($f,8,2))." ".find_month(substr($f,5,2))."-".substr($t,8,2).find_day(substr($t,8,2))." ".find_month(substr($t,5,2))." "."2020"?></text></p>
                            <a href="viewplan.php?pl_id=<?php echo $plan_id;?>" class="btn btn-default btn-block link" style="color: lightseagreen;border-color: lightseagreen;">View Plan</a>
                        </div>
                    </div>                         
                </div>
        
        <?php } ?>
           </div>
        </div>
        <!--Implementing Plus button for creating new plan in home page(if atleast one plan is made by user)-->
        <div class="container-fluid">
          <div class="row">
            <div  style="font-size: 40px; float: right; margin-right: 10px;">
             <a href="create_new_plan.php" class="glyphicon glyphicon-plus-sign" style="color:rgb(0,150,150);text-decoration: none;"></a>
            </div>
          </div>
        </div>

        <?php  } ?>

        <!--Adding footer to our page-->
        <?php
        include 'footer.php';
        ?>
    </body>
</html>
    
    
    
<?php
//For finding month in "month-name" format.
function find_month($str)
{
$mon="";
if($str=="01"){$mon="Jan";}
else if($str=="02"){$mon="Feb";}
else if($str=="03"){$mon="Mar";}
else if($str=="04"){$mon="Apr";}
else if($str=="05"){$mon="May";}
else if($str=="06"){$mon="Jun";}
else if($str=="07"){$mon="Jul";}
else if($str=="08"){$mon="Aug";}
else if($str=="09"){$mon="Sep";}
else if($str=="10"){$mon="Oct";}
else if($str=="11"){$mon="Nov";}
else if($str=="12"){$mon="Dec";}
return $mon;
}

//For finding day in "th,nd,rd" format.
function  find_day($temp)
{
$day="";
if($temp=="11"||$temp=="12"||$temp=="13"){$day="th";}
else{
if(substr($temp,1)=="1"){$day="st";}
else if(substr($temp,1)=="2"){$day="nd";}
else if(substr($temp,1)=="3"){$day="rd";}
else{$day="th";}
}
return $day;
}
?>
     