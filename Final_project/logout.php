<?php
session_start();

//If user is not logged-in then redirect to login page.
if (!isset($_SESSION['email'])){
header('location: login.php');
}
else
{   //Destroy all sessions and redirect to index page.
    session_unset();
    session_destroy();
    header('location: index.php');
}
?>

