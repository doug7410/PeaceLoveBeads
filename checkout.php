<?




session_start(); ?>


<?

if($_SESSION['logged_in'] == "yes"){
	$user = $_SESSION['user_login'];
	$user_array = unserialize($_COOKIE[$user]);
}

if($_SESSION['logged_in'] == "yes" && $user_array['user_login'] == $_SESSION['user_login']){
$logged_in = 1;
 
}

require('functions.php');

if(!$_SESSION['subtotal']){
$_SESSION['subtotal'] = 0;
}


$shipping = 3.50;

update_cart();
$st = sub_total();


?>
<table border="1" cellpadding="3">
<tr>
<td>QTY</td><td>CODE</td><td>NAME</td><td>PRICE</td><td>PRICE EXTENDED</td><td>UPDATE</td><td>REMOVE</td>
</tr>
<? shopping_cart(); ?>
<tr>
<td colspan="6">Subtotal</td>
<td><? echo $st; ?></td>
</tr>
<tr>
<td colspan="6">Shipping</td>
<td><? echo $shipping; ?></td>
</tr>
<tr>
<td colspan="6">TOTAL</td>
<td><? echo $shipping + $st; ?></td>
</tr>
</table>
<br />
<?
 //checkout form******************************************************************************************
 if($logged_in){
?>
<form method="post" action="order.php">
<div>Proceed with checkout</div>
<table width="600" border="1">
  <tr>
    <td width="113">Name:</td>
    <td width="471"><input type="text" name="name" value="<? echo $user_array['user_name']; ?>" /></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><input type="text" name="email" value="<? echo $user_array['user_email']; ?>" /></td>
  </tr>
  <tr>
    <td>Address:</td>
    <td><input type="text" name="address" value="<? echo $user_array['address']; ?>" /></td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td><input type="text" name="phone" value="<? echo $user_array['phone']; ?>" /></td>
  </tr>
  <tr>
    <td>City:</td>
    <td><input type="text" name="city" value="<? echo $user_array['city']; ?>" /></td>
  </tr>
  <tr>
    <td>State:</td>
    <td><input type="text" name="state" value="<? echo $user_array['state']; ?>" /></td>
  </tr>
  <tr>
    <td>Zip:</td>
    <td><input type="text" name="zip" value="<? echo $user_array['zip']; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Credit Card #:</td>
    <td><input type="text" name="cc_number" value="" /></td>
  </tr>
  <tr>
    <td>Expiration Date:</td>
    <td><input type="text" name="cc_exp" value="" /></td>
  </tr>
  <tr>
    <td>Security Code:</td>
    <td><input type="text" name="cc_security" value="" /></td>
  </tr>
</table>
<input type="submit" value="submit" /> 
</form>
<?	
	}
	//end checkout form**********************************************************************************
	
	
	//start log in form**********************************************************************************
	
	if(!$logged_in && !$_GET['register']){
	
	if($_SESSION['logged_in'] == "no" && $_GET['login'] == "error"){//error for incorect login
		echo "<div style='color:red;'>Incorrect email or password</div>";
	}
?>
	<div>please sign in</div>
	<form method="post" action="login.php">
    <input type="hidden" name="url" value="<? echo $_SERVER['PHP_SELF']; ?>" />
    <input type="hidden" name="login" value="login" />
    Email: <input name="user_login" type="text" /><br />
	Password: <input name="user_password" type="password" /><br />
	<input type="submit" value="login" />
    </form>
    <br />
	<br />
	<a href="<? echo $_SESSION[PHP_SELF]; ?>?register=1">Create an account</a>
    
<? 
	}//end login form****************************************************************
	
	
	//create an account form*********************************************************
	if($_GET['register']){
		?>
        Create an account below.
        <form method="post" action="<? echo "set_cookie.php"; ?>">
<input type="hidden" name="login" value="yes" />

<table width="600" border="1">
  <tr>
    <td width="113">Name:</td>
    <td width="471"><input type="text" name="user_name" value="" /></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><input type="text" name="user_email" value="" /></td>
  </tr>
  <tr>
    <td>Address:</td>
    <td><input type="text" name="address" value="" /></td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td><input type="text" name="phone" value="" /></td>
  </tr>
  <tr>
    <td>City:</td>
    <td><input type="text" name="city" value="" /></td>
  </tr>
  <tr>
    <td>State:</td>
    <td><input type="text" name="state" value="" /></td>
  </tr>
  <tr>
    <td>Zip:</td>
    <td><input type="text" name="zip" value="" /></td>
  </tr>
  <tr>
    <td>User name:</td>
    <td><input type="text" name="user_login" value="" /></td>
  </tr>
   <tr>
    <td>Password:</td>
    <td><input type="text" name="user_password" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="submit" value="submit" /> 
</form>
        <?
	}
 //end create an account form**************************************************************************
?>

<br />
<br />

<a href="catalog.php">back to catalog</a>
<a href="login.php?url=<? echo $_SERVER['PHP_SELF']; ?>">Logout</a>
