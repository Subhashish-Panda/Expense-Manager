<?php
//Making connection to database and starting the session.
include 'Required/common.php';

$count=0;//flag for checking wheather all field are properly validated.

//Defining required input variables and set to empty values.
$name=$email=$password=$phn_no="";

//Retreiving values from form input fields.
//Note:Before retreiving values,any kind of form-injection is also checked by test_input function.
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=test_input($con,$_POST["name"]);
    $email=test_input($con,$_POST["email"]);
    $password=test_input($con,$_POST["password"]);
    $phn_no=test_input($con,$_POST["contact"]);
}

//Performing all possible security measures in test_input function to prevent form injection in backend.
function test_input($con,$data){
$data=trim($data);
$data= stripslashes($data);
$data= mysqli_real_escape_string($con, $data);
$data= htmlspecialchars($data);
return $data;
}

//Performing form validation in backend.
$pat_name="/^[a-zA-Z ]+$/";//pattern for name of user.
$pat_email="/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/";//pattern for email of user.
$pat_contact = "/^[6789][0-9]{9}$/";//pattern for phone_no of user.

if(!preg_match($pat_name, $name)){
    echo ("<script>location.href='signup.php?name_error=Enter valid name(Only letters and spaces)'</script>");
    $count=1;
}

else if (!preg_match($pat_email, $email)) {
    echo ("<script>location.href='signup.php?email_error=Email entered is invalid'</script>");
    $count=1;    
}

else if(strlen($password)<6){
    echo ("<script>location.href='signup.php?password_error=Password(Min. 6 characters)'</script>");
    $count=1;
}

else if(!preg_match($pat_contact, $phn_no)){
    echo ("<script>location.href='signup.php?contact_error=Contact number is invalid(Must start with 6,7,8,9)'</script>");
    $count=1;    
}

if($count==0)//Implies that all input fields are properly verified.
{
 $query="Select id from users where email='$email'";
 $select_query= mysqli_query($con, $query);
 $num_rows= mysqli_num_rows($select_query);
 
//Checking for duplicate emails.
if($num_rows>0)
 {
 echo ("<script>location.href='signup.php?email_error=This email address is already registered'</script>");
 }
 
else//If no duplicate emails found,register this user into database.
{
//Encrypting password before insertion into database.
$password= md5($password);

//Inserting details to database.
$query="Insert into users(name,email,password,phone_no) values('$name','$email','$password','$phn_no')";
$insert_query= mysqli_query($con, $query);

//Getting the primary key of the inserted row.
$id= mysqli_insert_id($con);

//Setting the session variables.
$_SESSION['email']=$email;
$_SESSION['user_id']=$id;

//After successful registration,go to home page.
echo ("<script>location.href='home.php?success_msg=User successfully registered'</script>");
}

}
?>


