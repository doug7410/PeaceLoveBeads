<?
require('functions.php');//get all the required functions
$screen = $_POST['screen'];
validate_form($screen);

session_start(); 
$expires = time() + (25 * 365 * 24 * 60 * 60);
$user_info = serialize($_POST);
$cookie_name = $_POST['user_login'];

setcookie($cookie_name,$user_info,$expires);

$_SESSION['logged_in'] = "yes";
$_SESSION['user_login'] = $_POST['user_login'];
$_SESSION['user_password'] = $_POST['user_password'];

if($_POST['update']){
	//if the account is being updated add flag so "account has been updated" message is displayed on the account screen 
	$url = $_POST['url'] . '&update=1';
}elseif($_POST['new_account']){
	//if the account is being created add flag so "new account" message is displayed on the account screen 
	$url = $_POST['url'] . '&new_account=1';
}else{
	$url = $_POST['url'];
}
header('Location: ' . $url);

?>