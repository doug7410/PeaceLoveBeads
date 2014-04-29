<? 

$exp = time() + 100000;

$var = "varcookie";

setcookie('test','stuff in test',$exp);

setcookie($var,'stuff in var test',$exp);

$login = $_GET['login'];

if($_COOKIE[$login]){
	echo "yes";
}

?>