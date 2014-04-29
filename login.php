<?php
session_start(); 
require 'admin/connections.php'; //get connection to database
require 'functions.php';//get all the required functions

if($_GET['logout']){//if logged in, log out
	$_SESSION['logged_in'] = "no";
	$url = 'index.php?screen=login';
	header("Location: ".$url);
	exit();
	}
	




//get the user name (email) and password
if(!$_REQUEST['updateAccount']){ //if the account is being updated do not set these variables
$user = $con->real_escape_string($_GET['user_login']);
$password = $con->real_escape_string($_GET['user_password']);
//set the session user name and password
$_SESSION['user_login'] = $user;
$_SESSION['user_password'] = $password;
$user_array = unserialize($_COOKIE[$user]);
echo 'test';
}

/*
 * select customer forom the plb_customer table
 */
if($_REQUEST['updateAccount']){//if the account is being updated use the new session vars to query the database
    $user = $_SESSION['user_login'];
    $password = $_SESSION['user_password'];
    pre($_SESSION);
}
$customerQuery = 'select * from plb_customers where email = "'.$user.'" AND password="'.$password.'"';
$customerResult = $con->query($customerQuery);
pre($_SESSION);
        echo $customerQuery;
        //exit();

//if not logged in and the login_name and password matched what is saved in the database, log in	
if((mysqli_num_rows($customerResult) > 0)){
	$_SESSION['logged_in'] = "yes";
        //pre($_SESSION);
        //echo $customerQuery;
        //exit();
	$url = '/final/index.php?screen=register';
}else{//this is for incorrect login or password
	$url = 'http://' .$_SERVER['HTTP_HOST']. '/final/index.php?screen=login&error=2&user_login=' .$_GET['user_login'];
}

header('Location: ' . $url );	
exit();
?>
