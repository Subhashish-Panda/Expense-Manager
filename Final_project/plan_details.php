<?php
//Making connection to database and starting the session.
include 'Required/common.php';

//If user is not logged-in then redirect to login page.
if(!isset($_SESSION['email']))
{
header('location:login.php');
}

//Defining required input variables and set to empty values.
$budget=$no_of_people=0;

//Retreiving values from form input fields.
//Note:Before retreiving values,any kind of form-injection is also checked by test_input function.
if($_SERVER["REQUEST_METHOD"]=="POST")
{
$budget= test_input($con, $_POST["ini_budget"]);//initial budget of plan.
$no_of_people= test_input($con, $_POST["no_people"]);//no_of_people in the plan.
}

//Performing all possible security measures in test_input function to prevent form injection in backend.
function test_input($con,$data)
{
$data=trim($data);
$data= stripslashes($data);
$data= mysqli_real_escape_string($con, $data);
$data= htmlspecialchars($data);
return $data;
}


//Form validation in backend for "create_new_plan.php"-page submitted form.
if(!is_numeric($budget))
{
echo ("<script>location.href='create_new_plan.php?budget_error=Initial Budget(value) must be a valid integer'</script>");       
}
else{
if($budget<50)
{
 
echo ("<script>location.href='create_new_plan.php?budget_error=Initial Budget(value) must be greater than or equal to 50'</script>");
}
else{
if(!is_numeric($no_of_people)||$no_of_people<=0)
{
echo ("<script>location.href='create_new_plan.php?people_error=No.of.people(value) must be greater than or equal to 1'</script>");   
}
else
{
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Linking necessary bootstrap files-->
        <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        
        <!--Title of the webpage-->
        <title>Plan Details</title>
        
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
            
            .style1:hover{
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
         <!--Addition of required content to this page(plan-details form)-->
         <div class="container" style="min-height: 680px">
             <div class="row row_style">
                 <div class="col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8">
                    <div class="panel panel-default">
                     <div class="panel-body">
                        <form method="POST" action="">
                             <div class="form-group">
                             <label>Title</label>
                             <input type="text" name="title" placeholder="Enter Title(Ex. Trip to Goa)" class="form-control" pattern="[a-zA-Z ]+" required>
                             </div>
                             <div class="form-group">
                             <div class="row">
                             <div class="col-sm-7">
                             <label>From</label>
                             <input type="date"  class="form-control"  name="from" min="2020-01-01" max="2020-12-31" required>                                
                             </div>
                             <div class="col-sm-5">
                             <label>To</label>
                             <input type="date" class="form-control"  name="to" min="2020-01-01" max="2020-12-31" required>
                             </div>
                             </div>
                             </div>
                             <div class="form-group">
                             <div class="row">
                             <div class="col-sm-7">
                             <label>Initial Budget</label>
                             <input type="number" class="form-control" value="<?php echo $budget;?>" name="ini_budget" readonly>
                             </div>
                             <div class="col-sm-5">
                             <label>No. of people</label>
                             <input type="number" class="form-control" value="<?php echo $no_of_people;?>" name="no_people" readonly>
                             </div>
                             </div>
                             </div>
                             <?php
                              $count=1;
                              while($count<=$no_of_people){ ?>
                              <div class="form-group">
                              <label>Person<?php echo " ".$count?></label>
                              <input type="text" class="form-control" value="<?php echo "Person".$count." Name"?>" name="person[<?php echo $count-1;?>]" pattern="[a-zA-Z ]+" required>          
                              </div>
                              <?php $count+=1; } ?>
                              <div class="form-group" style="color:blue;">
                                <button type="submit" name="submit1" class="btn btn-block style1" style="border-color: lightblue;background-color: white;color: lightseagreen;">Submit</button>
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
<?php
}}}

//Start verification as soon as plan details form is submitted.
if(isset($_POST["submit1"]))
{
//Defining input variables and set to empty values
$title=$from=$to=$budget=$no_of_people="";
$count=0;$temp=array();$person_names=array();$verify=0;


//Retreiving values from form input fields.
//Note:Before retreiving values,any kind of form-injection is also checked by test_input function.
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $title=test_input($con, $_POST["title"]);
    $from= test_input($con, $_POST["from"]);
    $to= test_input($con, $_POST["to"]);
    $budget= test_input($con, $_POST["ini_budget"] );
    $no_of_people= test_input($con,$_POST["no_people"] );
    //Copying all the entered person names in a "temporary array(temp)" first.
    $temp=new ArrayObject($_POST['person']);
    //Then storing all person names in "person_names array" from "temp array".
    while($count<$no_of_people)
    {
    $person_names["$count"]= test_input($con,$temp["$count"]);
    $string=$person_names["$count"];
    $name_regex="/^[a-zA-Z ]+$/";
    if(!preg_match($name_regex, $string))
    {
     echo ("<script>alert('Enter valid name(only letters and spaces)')</script>");
     $verify=1;
     }
     $count+=1;
    }
}

//Performing form validation(required patterns) in backend.
$pat_name="/^[a-zA-Z ]+$/";
$pat_date="/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
if(!preg_match($pat_name, $title))
{
echo ("<script>alert('Enter valid title(only letters and spaces)')</script>");
$verify=1;
}
else if($from<"2020-01-01" || $from>"2020-12-31")//from date shouldn't be beyond limits and shouldn't be null.
{
echo ("<script>alert('Enter from date within given limits')</script>");
$verify=1;   
}

else if($to<"2020-01-01" || $to>"2020-12-31")//to date shouldn't be beyond limits and shouldn't be null.
{
echo ("<script>alert('Enter to date within given limits')</script>");
$verify=1;   
}
else if(!preg_match($pat_date, $from))//from date should be in date format only.
{
echo ("<script>alert('Enter valid from date')</script>");
$verify=1;   
}
else if(!preg_match($pat_date, $to))//to date should be in date format only.
{
echo ("<script>alert('Enter valid to date')</script>");
$verify=1;   
}
else if($from>$to)
{
echo ("<script>alert('To date must be greater than From date')</script>");
$verify=1;
}

//All things verified correctly(both injection and validation).
if($verify==0)
{
//Insert the obtained data(title of plan,starting-date,ending-date,initial_budget of plan,no_of_people in the plan) into "plan_details" table.
$query="Insert into plan_details (title,from_date,to_date,ini_budget,tot_persons) values('$title','$from','$to','$budget','$no_of_people')";
$insert_query= mysqli_query($con, $query);
$plan_id= mysqli_insert_id($con);
//Inserting user_id,plan_id,along with person's name into "persons" table.
$user_id=$_SESSION['user_id'];
$itr=0;
while($itr<$no_of_people)
{
$string=$person_names["$itr"];    
$query="Insert into persons (uid,plid,pname) values ('$user_id','$plan_id','$string')";
$insert_query= mysqli_query($con, $query);
$itr+=1;
}
//Redirect to home page to show created plan with the required success message.
echo ("<script>location.href='home.php?success_msg=Your New Budget Planner Added Successfully'</script>");
}

}?>