<?php
//Making connection to database and starting the session.
require "Required/common.php";

//If user is not logged-in then redirect to login page.
if(!isset($_SESSION['email']))
{
header('location:login.php');
}

//Extracting user id through session.
$user_id=$_SESSION['user_id'];

//Fetching all the plan details through plan id(of current user) obtained from "home.php".
$plan_id=$_GET["pl_id"];

//Running required sql query on the database.
$query="Select * from plan_details where id='$plan_id'";
$sel_query= mysqli_query($con, $query);
$result= mysqli_fetch_array($sel_query);

//Extracting all the information about this plan.
$_title=$result["title"];//title of plan.
$_from=$result["from_date"];//starting date of plan.
$_to=$result["to_date"];//ending date of plan.
$_budget=$result["ini_budget"];//Initial budget of plan.
$_persons=$result["tot_persons"];//No.of people in the plan.

//Extracting the person names through particular user_id and plan_id(from persons table) and storing it in an array.
$_person_names= array();
$q="Select pname from persons where uid='$user_id' and plid='$plan_id'";
$sel_q=mysqli_query($con, $q);
while($rows= mysqli_fetch_array($sel_q))
{
 $_person_names[]=$rows["pname"]; 
}

//Performing all possible security measures in test_input function to prevent form injection in backend.
function test_input($con,$data){
$data=trim($data);
$data= stripslashes($data);
$data= mysqli_real_escape_string($con, $data);
$data= htmlspecialchars($data);
return $data;
}

//Function to get image extension.
function GetImageExtension($imagetype){
if(empty($imagetype)){return false;}
switch($imagetype){
case 'image/bmp': return '.bmp';
case 'image/gif': return '.gif';
case 'image/jpeg': return '.jpg';
case 'image/png': return '.png';
case 'image/jpg': return '.jpg';
default: return false; } }

//Function to find month in "month-name" format.
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

//For finding day in "th,nd,rd" format
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

//For finding colour based on current amount(used for remaining amount).
function find_colour($amt)
{
 $str="";
 if($amt<0){$str='red';}
 else if($amt>0){$str='green';}
 else{$str='black';}
 return $str ;
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
        <title>View_Plan</title>
        
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
            .btn_style:hover{
                background-color: rgb(0,150,150) !important;
                color: white !important;
            }
            .link:hover{
                background-color: rgb(0,150,150) !important;
                color: white !important;   
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
        <!--Addition of required content to viewplan page-->
        <div class="container" style="min-height: 1800px;">
            <div class="row row_style">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: rgb(0,150,150);text-align: center;color: whitesmoke;">
                         <p><span><text style="font-size:16px;"><?php echo $_title;?></text></span><span class="glyphicon glyphicon-user" style="color:white;float:right;"><text style="margin-left: 2px;"><?php echo $_persons;?></text></span></p>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:13px;"><b>Budget</b><text style="float: right;">&#8377;<?php echo $_budget;?></text></p>
                            <?php
                              $sum_query="Select expense_amount from expenses where usid='$user_id' and planid='$plan_id'";
                              $res= mysqli_query($con, $sum_query) or die(mysqli_error($con));
                              $total_rows= mysqli_num_rows($res);
                              if($total_rows==0){
                               $rem_amount=$_budget;
                               }
                              else{
                                $sum=0;   
                                while($record=mysqli_fetch_array($res)){
                                $sum+=$record['expense_amount'];
                                }
                                $rem_amount=$_budget-$sum;
                                }?>
                               <p style="font-size:13px;"><b>Remaining Amount</b><text style="float: right; color: <?php echo find_colour($rem_amount);?>;">&#8377;<?php echo abs($rem_amount);?></text></p>
                               <p style="font-size:13px;"><b>Date</b><text style="float: right;"><?php echo substr($_from,8,2).find_day(substr($_from,8,2))." ".find_month(substr($_from,5,2))."-".substr($_to,8,2).find_day(substr($_to,8,2))." ".find_month(substr($_to,5,2))." "."2020"?></text></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-sm-offset-2">
                     <a href="expense_distribution.php?planid=<?php echo $plan_id;?>" class="btn btn-lg link" style="color:lightseagreen;border-color: lightblue;">Expense distribution</a>
                </div>
            </div><!--End of first row(contains expense_distribution button and plan-information panel-->
            <br>
              <div class="row">    
                   <div class="col-sm-8">
                   <?php
                   $query="Select id,expense_title,expense_date,expense_amount,expense_person,bill from expenses where usid='$user_id' and planid='$plan_id'";
                   $res_query= mysqli_query($con, $query);
                   while($rows= mysqli_fetch_array($res_query)){
                       $res_title=$rows["expense_title"];
                       $res_date=$rows["expense_date"];
                       $res_amount=$rows["expense_amount"];
                       $res_person=$rows["expense_person"];
                       $res_bill=$rows["bill"];?>
                  <div class="col-sm-6">
                    <div class="panel panel-default">
                      <div class="panel-heading" style="background-color: rgb(0,150,150);text-align: center;color: whitesmoke;">
                       <p><span><text style="font-size:16px;"><?php echo $res_title;?></text></span></p>
                      </div>
                      <div class="panel-body">
                       <p><b>Amount</b><text style="float: right;">&#8377;<?php echo $res_amount;?></text></p>
                       <p><b>Paid by</b><text style="float: right;"><?php echo $res_person;?></text></p>
                       <p><b>Paid on</b><text style="float: right;"><?php echo substr($res_date,8,2).find_day(substr($res_date,9,1))." ".find_month(substr($res_date,5,2))."-"."2020"; ?></text></p>
                       <?php if($res_bill){?>
                       <center><a href="showbill.php?id=<?php echo $rows["id"];?>" style="color: lightseagreen;text-decoration: none;padding: 0;"><?php echo "Show Bill";?></a></center>
                       <?php } else {?>
                       <center><text style="color: lightseagreen;">You dont have bill</text></center>
                       <?php }?>
                      </div>
                    </div>
                  </div>
                  <?php }?>
                  </div>
                  <div class=" col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: rgb(0,150,150);color: white;text-align: center;">
                        <text>Add New Expense</text>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="exp_name" value="Expense Name" class="form-control" pattern="[a-zA-Z ]+" required>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="exp_date" value="" class="form-control" min="<?php echo $_from;?>" max="<?php echo $_to;?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Amount Spent</label>
                                    <input type="number" name="exp_amt" value="Amount Spent" class="form-control" min="1" required>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="exp_given" required>
                                    <option>Choose</option>
                                    <?php
                                    $itr=0;
                                    while($itr<count($_person_names)){?>
                                    <option value="<?php echo $_person_names["$itr"];?>"><?php echo $_person_names["$itr"];?></option>
                                    <?php $itr+=1;}?>
                                 </select>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="exp_image" value="No file chosen" id="img">
                                </div>
                                <div class="form-group" style="color:lightseagreen;">
                                 <button type="submit" name="insert" id="insert" class="btn btn-block btn_style" style="border-color: lightblue;">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>                  
                  </div>
               </div><!--End of second row(contains all the expenses made in this plan and add_expenses form)-->
        </div>
        <!--Addition of footer to our page-->
        <?php
        include 'footer.php';
        ?>
    </body>
</html>

<?php

//Form validation and form injection for expense-form.
$exp_a=0;$count=0;
if(isset($_POST["insert"]))
{
    $exp_t=test_input($con,$_POST["exp_name"]);
    $exp_d=test_input($con,$_POST["exp_date"]);
    $exp_a=test_input($con,$_POST["exp_amt"]);
    $exp_p=test_input($con,$_POST["exp_given"]);
    $test_arr= explode('-', $exp_d);
    //form -validation.
    $pat_name="/^[a-zA-Z ]+$/";
    $pat_date="/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
    //For amount and persons.
    if($exp_a<=0){
     echo ("<script>alert('Invalid amount')</script>");
     $count=1;
    }
    else if(!is_numeric($exp_a)){
     echo ("<script>alert('Invalid amount')</script>");
     $count=1;
    }
    else if(!(in_array($exp_p, $_person_names))){
     echo ("<script>alert('Invalid person name')</script>");
     $count=1;
    }
    //For title and date.
    else if(!preg_match($pat_name, $exp_t)){
    echo ("<script>alert('Invalid title(only letters and spaces)')</script>"); 
    $count=1;
    }
    else if(!preg_match($pat_date, $exp_d)){
    echo ("<script>alert('Invalid date')</script>");
    $count=1;      
    }
    else if(count($test_arr)==3){
        if(!(checkdate($test_arr[1],$test_arr[2],$test_arr[0]))){
             echo ("<script>alert('Invalid date')</script>");
             $count=1;
        }
        else{
            if($exp_d<$_from||$exp_d>$_to){
             echo ("<script>alert('Invalid date')</script>");
             $count=1;   
            }
        }

    }
    else if (count($test_arr)!=3) {
     echo ("<script>alert('Invalid date')</script>");
     $count=1;
    }

    //If,All verifications are properly done(i.e both validation and injection).
    //Insert all the expense details into expense table.
    if($count==0){
    //Checking for image/bill.
    if (!empty($_FILES["exp_image"]["name"])) {
     $file= addslashes(file_get_contents($_FILES["exp_image"]["tmp_name"]));//contains the bill image.
     $file_name=$_FILES["exp_image"]["name"];
     $temp_name=$_FILES["exp_image"]["tmp_name"];
     $imgtype=$_FILES["exp_image"]["type"];
     $ext= GetImageExtension($imgtype);
     $imagename=date("d-m-Y")."-".time().$ext;
     $target_path = "pic/".$imagename;
     if(move_uploaded_file($temp_name, $target_path)){
    $query="Insert into expenses(usid,planid,expense_title,expense_date,expense_amount,expense_person,bill) values('$user_id','$plan_id','$exp_t','$exp_d','$exp_a','$exp_p','$file')";
    mysqli_query($con, $query) or die(mysqli_error($con)); 
    echo "<script>location.href=''</script>";
  
    }
    }
    else{
        $file='';//No bill then no value is inserted in bill column.
        $query="Insert into expenses(usid,planid,expense_title,expense_date,expense_amount,expense_person,bill) values('$user_id','$plan_id','$exp_t','$exp_d','$exp_a','$exp_p','$file')";
        mysqli_query($con, $query);
        echo "<script>location.href=''</script>";
    }
    
    }
}
?>
