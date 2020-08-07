<?php
//For making connection to the database in the backend.
$con= mysqli_connect("localhost","root","","exp_manager",3308) or die(mysqli_error($con));

//Note:After successful connection to database only,session will be started.

//To start the session on the current webpage,where it is included.
session_start();


?>

