<?php
//Making connection to database and starting the session.
require "Required/common.php";

$count=0;//flag for checking wheather all field are properly validated.

//Defining required input variables and set to empty values.
$email=$password="";

//Retreiving values from form input fields.
//Note:Before retreiving values,any kind of form-injection is also checked by test_input function.
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=test_input($con,$_POST["email"]);
    $password=test_input($con,$_POST["password"]);
}

//Performing all possible security measures in test_input function to prevent form injection in backend.
function test_input($con,$data){
$data=trim($data);
$data= stripslashes($data);
$data= mysqli_real_escape_string($con, $data);
$data= htmlspecialchars($data);
return $data;
}

//performing backend form validation.
$pat_email="/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/";//pattern for email of user.

if(!preg_match($pat_email, $email))
{
echo ("<script>location.href='login.php?email_error=Email entered is invalid'</script>");
$count=1;    
}

else if(strlen($password)<6)
{
echo ("<script>location.href='login.php?password_error=Password(Min. 6 characters)'</script>");
$count=1;
}

//Implies that all input fields are properly verified.
if($count==0)
{
//Fetching wheather email id is a registered one(or)not.
$query="Select id,email from users where email='$email'";
$select_query= mysqli_query($con, $query);
$no_of_rows= mysqli_num_rows($select_query);

//If no such registered email id in database.
if($no_of_rows==0)
{
echo ("<script>location.href='login.php?email_error=Enter correct email'</script>");
}

//Else there exits a registered email id in the database.
else
{
//Since passwords are stored in the database in encrypted format.
$password= md5($password);

//Fetching wheather password-entered is correct or not.
$query1="Select id,password from users where email='$email' and password='$password'";
$select_query1= mysqli_query($con, $query1);
$no_of_rows1= mysqli_num_rows($select_query1);

if($no_of_rows1==0)
{
echo ("<script>location.href='login.php?password_error=Password entered is incorrect'</script>");  
}

else
{
//Entered credentials are fully-correct.
$row= mysqli_fetch_array($select_query);
//Set the session variables.
$_SESSION['email']=$row['email'];
$_SESSION['user_id']=$row['id'];
//Once logged-in redirect to home page.
header('location:home.php');
}
}
}
?>

