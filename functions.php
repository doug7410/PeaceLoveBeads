
<?php


	

function update_cart($cart_array,$screen,$prodID){//updates the cart 
			
			
	switch($_GET['action']){
		case "update": //if action  = update replace the cart array value with the new quantity
			$cart_array[$prodID] = $_GET['qty_update'];
			break;
		case "remove": //remove the id from the cart array
			unset($cart_array[$prodID]);
			break;
		case "add"://add the id and qty to the cart array
				$cart_array[$prodID] += $_GET['qty'];
				$query = 'add=1&qty='.$_GET['qty'] . '&';//this is for the 'added to cart' message on the product screen
			break;
		default:
			// 
	}
		$expires = time() + (365 * 24 * 60 * 60);
		$cart = serialize($cart_array);//serialize the cart array so it can be saved to a cookie
		setcookie('cart',$cart,$expires);//turn the newly updated cart array into the 'cart' cookie 
		if(!$prodID){
			$url = '/final/index.php?screen=' . $screen;
		}else{//if this function was run from the product screen run code below
			$url = '/final/index.php?' . $query  . 'screen=' . $screen . '&prodID=' . $prodID;
		}
		header('Location: ' . $url);
}

function sub_total($cart_array,$con){//gets sub-total of all items in cart
        
        foreach ($cart_array as $key => $value) {
                /*
                 * query plb_prods 
                 */
                 $prodQuery = 'select prod_price from plb_prods where id="'.$key.'"';
                 $prodResult = $con->query($prodQuery);
                 $prodRow = $prodResult->fetch_object();
                 
		$price_extended = $prodRow->prod_price * $cart_array[$key];//run through the cart array and multiply the price by qty
		$st += $price_extended;	// add it to the subtotal
	}   
		return $st;
}

function shopping_cart($st,$screen,$cart_array,$con){//creates shoping cart table
			
		echo '<table id="cart_table">';
		echo '<tr class="heading_row" >';
		echo '<td>&nbsp;</td><td>Item</td><td>Description</td><td>Quantity</td><td>Price/Ea.</td><td>Total</td>';
		echo '</tr>';
			
	foreach ($cart_array as $key => $value) {//for each id in the cart array run this
	
                /*
                 * get product data
                 */
                 $prodQuery = 'select * from plb_prods where id="'.$key.'"';
                 //echo $prodQuery;
                 //exit();
                 $prodResult = $con->query($prodQuery);
                 $prodRow = $prodResult->fetch_object();
                
		echo '<tr>';
		echo '<form method="get" action="' . $_SERVER['SCRIPT_NAME'] . '" >';
		echo '<input type="hidden" name="prodID" value="' . $key . '" />';
		echo '<input type="hidden" name="screen" value="' . $screen . '" />';
		echo '<input type="hidden" name="category" value="' . $_GET['category'] . '" />';
		echo '<input type="hidden" name="action" value="update" />';
		
		 
		
                $price_extended = $prodRow->prod_price * $cart_array[$key];
		
		echo '<td><a href="' . $_SERVER['SCRIPT_NAME'] . '?screen=' . $screen . '&action=remove&prodID=' . $key . '&category=' . $_GET['category'] . '">remove</a></td>';
		echo '<td><img src="'.$prodRow->prod_thumb.'" height="80px" /></td>';   
		echo '<td><a href="/final/index.php?screen=product&prodID='.$prodRow->id.'" >'.$prodRow->prod_name.'</a></td>'; 
		echo '<td><input type="text" size="3" name="qty_update" value="' . $cart_array[$key] . '" /><input id="update_button" type="submit"  value="" /></td>';
		echo '<td>' . money_format('$%i',$prodRow->prod_price) . '</td>'; 
		echo '<td>' . money_format('$%i',$price_extended) . '</td>';
		echo '</form>'; 
		echo '</tr>'; 
	}
	echo '<tr class="heading_row" >';
	echo '<td colspan="5">Subtotal</td>';
	echo '<td>' . money_format('$%i',$st) . '</td>';
	echo '</tr>';
	echo '</table>';
}

function login_form($logged_in){//login form for cart and login screens

if(!$logged_in && !$_GET['register']){
echo '<div id="login_box" >';
     if($_GET['error'] == 2){ //if the login or password don't match what is saved in the cookie
    echo '<div style="color:#FF0000;">Incorrect username or password</div>';
     } 
	 
	echo '<form id="loginForm" method="get" action="login.php">';//submit this form to the login.php file
    echo '<input type="hidden" name="screen" value="' .$_GET['screen'] . '" />';
    echo '<input type="hidden" name="login" value="login" />';
    echo 'Email: <input name="user_login" type="text" value="' . $_GET['user_login']. '" />';
    if(!($_GET['user_login']) && $_GET['error'] == 1){ //if user_login is missing
  		echo '<span class="error">Please enter your login name.</span>';
  	} 
	echo '<br />Password: <input name="user_password" type="password" value="" />';
    if(!($_GET['user_password']) && $_GET['error'] == 1){//if the password is missing
    	echo '<span class="error">Please enter password.</span>';
    }
	echo '<br /><input type="submit" value="login" /></form></div>';
	echo '<div  id="create_account_box" ><a id="checkout_link" href="' . $_SESSION[PHP_SELF] . '?screen=register">Create an account</a></div>';
	}
}

function order_summery($cart_array,$con){//order summery for checkout, after checkout, and email

                
$order = "<h2>Order Summery</h2>";
$order .=  '<table id="cart_table" border="1" cellpadding="6" style="border-collapse:collapse;" >
				  <tr class="heading_row" >
					<th scope="col">Item</th>
					<th scope="col">Description</th>
					<th scope="col">Quantity</th>
					<th scope="col">Price</th>
					<th scope="col">Totoal</th>
				  </tr>';

$subtotal = 0;
$shipping = 3.5;
foreach($cart_array as $key => $value){//for each item in the cart array
/*
 * get products
 */    
 $prodQuery = 'select * from plb_prods where id="'.$key.'"';
 $prodResult = $con->query($prodQuery);
 $prodRow = $prodResult->fetch_object();     
$item_total = $prodRow->prod_price * $cart_array[$key];
$order .= '<tr><td align="center"><img src="http://dsteinbe.userworld.com'.$prodRow->prod_thumb.'" height="65px" /></td>';
$order .= '<td><a href="http://dsteinbe.userworld.com/final/index.php?screen=product&prodID='.$prodRow->id.'" >' . $prodRow->prod_name . '</a></td>'; 
$order .= '<td>' . $cart_array[$key] . '</td>';
$order .= '<td>' . money_format('$%i',$prodRow->prod_price) . '</td>';
$order .= '<td>' . money_format('$%i',$item_total) . '</td></tr>';
$subtotal += $item_total;
			      }
$total = $shipping + $subtotal;
$order .= "<tr><td colspan='4'>Subtotal</td><td>" . money_format('$%i',$subtotal) . "</td></tr>";
$order .= "<tr><td colspan='4'>Shipping (flat rate)</td><td>" . money_format('$%i',$shipping) . "</td></tr>";	
$order .= '<tr class="heading_row" ><td colspan="4">Total</td><td>' . money_format('$%i',$total) . '</td></tr>';					  
$order .= "</table>";
return $order;
}

function validate_form($screen){//this validates all the fields on the checkout and account forms
extract($_POST); //turns all $_POST['vars'] into $vars
//if any of the fields are missing or feild check functions return false
if(!($name && $email && $phone && $city && $address && $zip && email_check($email) && phone_check($phone) && zip_check($zip)) 
|| ($screen == 'register' && !($user_login && $user_password && password_check($user_password)))){


//create error url
$url = '/final/index.php?screen=' . $screen . '&error=1';

if(!email_check($email) && $email){//if the email_check function returns false and the emai feild is not blank add this error
	$url .= '&email_error=1';
}
if(!phone_check($phone) && $phone){//if the phone_check function returns false and the phone feild is not blank add this error
	$url .= '&phone_error=1';
}
if(!zip_check($zip) && $zip){//if the zip_check function returns false and the zip feild is not blank add this error
	$url .= '&zip_error=1';
}
if(!password_check($user_password) && $user_password){//if the password_check function returns false and the password feild is not blank add this error
	$url .= '&password_error=1';
}

$url .= '&name=' . $name; 
$url .= '&email=' . $email; 
$url .= '&phone=' . $phone; 
$url .= '&city=' . $city; 
$url .= '&state=' . $state; 
$url .= '&address=' . $address; 
$url .= '&zip=' . $zip; 
if($screen == 'register'){
	$url .= '&user_login=' . $user_login; 
	if(!$user_password){
		$url .= '&missing_password=1';
	}
}
$url .= '&#form'; //this jumps the page down to the form
header('Location: ' . $url);
exit();
}
}

function email_check($field)//checks if the email is valid
{
  //filter_var() sanitizes the e-mail
  //address using FILTER_SANITIZE_EMAIL
  $field=filter_var($field, FILTER_SANITIZE_EMAIL);

  //filter_var() validates the e-mail
  //address using FILTER_VALIDATE_EMAIL
  if(filter_var($field, FILTER_VALIDATE_EMAIL))
    {
    return TRUE;
    }
  else
    {
    return FALSE;
    }
  }
  
function phone_check($phone){//check if phone number is valid
$phone_digits =  preg_replace("/[^0-9]/", "", $phone);//remove all non-digits from the phone number
	if(strlen($phone_digits) == 10){//check to see if the number has 10 digits
		return TRUE;
	}else{
		return FALSE;
	}
}

function zip_check($zip){//check if zip code is valid
if(ctype_digit($zip) && strlen($zip) == 5){//make sure it's all numeric and 5 digits long
		return TRUE;
	}else{
		return FALSE;
	}
}

function password_check($password){//check if the password is less then 8 charicters long
if(strlen($password) > 7){//check if password is at least 8 charicters long
		return TRUE;
	}else{
		return FALSE;
	}
}

function state_list(){//array of US states used in account and checkout forms
$state_list = array('AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming");
			return $state_list;
}

function catelog(){//product and category arrays
$categories = array('bracelets','necklaces','earings');//dfine the categories


//define products
$products = array();

$products[1006] = array();
$products[1006]['ctgy'] = $categories[1];
$products[1006]['code'] = '1006';
$products[1006]['name'] = 'Filigree Orbs Necklace';
$products[1006]['description'] = '
A brass ring suspending a trio of charms consisting of brass filigree round beads, tiny fresh water pearls, Swarovski crystals and a large cubic zerconia hangs on an antiqued brass chain. Finished with a lobster clasp.<br /><br />Length: 20-1/4 inches';
$products[1006]['price'] = 28.00;
$products[1006]['image'] = "1006-1";

$products[1005] = array();
$products[1005]['ctgy'] = $categories[0];
$products[1005]['code'] = '1005';
$products[1005]['name'] = 'The Blues Czech Glass Bracelet';
$products[1005]['description'] = '
The kind of blues you want to have...<br /><br />Three strands of beautiful blues with just a touch of green vintage seed beads for contrast. Several shapes of Czech glass beads are showcased along with blue jade rounds with accents of fire polish crystals. Finished with an etched sterling silver toggle clasp.<br /><br />Length: 7 3/4 inches';
$products[1005]['price'] = 25.00;
$products[1005]['image'] = "1005-1";

$products[1002] = array();
$products[1002]['ctgy'] = $categories[2];
$products[1002]['code'] = '1002';
$products[1002]['name'] = 'Crystal Blue Earrings';
$products[1002]['description'] = '
Sterling silver ear wires suspend blue Swarovski crystals, followed by a cascade of sterling silver chain with Picasso Czech pinch beads on the ends<br /><br />All of my creations are handmade by myself with love. All designs are original and one-of-a-kind, I never duplicate a piece.<br /><br />I welcome requests for custom designs, so if you have a vision let me bring it to life for you.<br /><br />Please feel free to contact me with any questions you might have.';
$products[1002]['price'] = 20.00;
$products[1002]['image'] = "1002-1";

$products[1003] = array();
$products[1003]['ctgy'] = $categories[2];
$products[1003]['code'] = '1003';
$products[1003]['name'] = 'Sparkling Green Tea Earings';
$products[1003]['description'] = '
Hanging from sterling silver ear wires are beautifully faceted cubic zirconia?s linked together with sterling silver wire.  The pictures just don?t give justice to the sparkle these earrings possess.<br /><br />All of my creations are handmade by myself with love. All designs are original and one-of-a-kind, I never duplicate a piece.<br /><br />I welcome requests for custom designs, so if you have a vision let me bring it to life for you.<br /><br />Please feel free to contact me with any questions you might have.';
$products[1003]['price'] = 18.00;
$products[1003]['image'] = "1003-1";

$products[1001] = array();
$products[1001]['ctgy'] = $categories[2];
$products[1001]['code'] = '1001';
$products[1001]['name'] = 'Lava Bali Earrings';
$products[1001]['description'] = '
On sterling silver ear wires, hang faceted opaque cubic zerconias paired with Bali silver beads for a striking combination  
What makes Bali silver so special?  Bali sterling silver beads are hand crafted by highly skilled artisans in Bali, Indonesia in the traditional Balinese style<br /><br />All of my creations are handmade by myself with love. All designs are original and one-of-a-kind, I never duplicate a piece.<br /><br />I welcome requests for custom designs, so if you have a vision let me bring it to life for you.<br /><br />Please feel free to contact me with any questions you might have.';
$products[1001]['price'] = 45.00;
$products[1001]['image'] = "1001-1";


$products[1004] = array();
$products[1004]['ctgy'] = $categories[2];
$products[1004]['code'] = '1004';
$products[1004]['name'] = 'Wrapped Purple Earrings';
$products[1004]['description'] = '
A silver wire wrapped Czech glass bead  followed by a cathedral and a fire polish glass bead dangle presents an interesting and fun design. The ear wires are sterling silver. Great for every day wear!<br /><br />All of my creations are handmade by myself with love. All designs are original and one-of-a-kind, I never duplicate a piece.<br /><br />I welcome requests for custom designs, so if you have a vision let me bring it to life for you.<br /><br />Please feel free to contact me with any questions you might have.';
$products[1004]['price'] = 18.00;
$products[1004]['image'] = "1004-1";

//return catelog as array with product and category arrays inside
$catelog = array('products' => $products,'categories' => $categories); 

return $catelog;
}

function set_user_cookie($screen){//this sets the user account cookie
$screen = $_POST['screen'];
validate_form($screen);//validate the account form

$expires = time() + (25 * 365 * 24 * 60 * 60);
$user_info = serialize($_POST); //serialize the post array so it can be stored in a cookie
$cookie_name = $_POST['user_login'];//make the user_login the name of the cookie

setcookie($cookie_name,$user_info,$expires);//ser the user cookie

$_SESSION['logged_in'] = "yes";//log the user in
$_SESSION['user_login'] = $_POST['user_login']; //set the session user_login
$_SESSION['user_password'] = $_POST['user_password']; //set the session user_password

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
}

function pre($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

/*
 * this function gets a single value from a table
 * where id matches the $id of the row and $column 
 * matches the desired colum
 */
function single_result($con,$table,$id,$column){
    $query = $con->query('select * from '.$table.' where id ='.$id); 
    $result = mysqli_fetch_object($query); 
    return $result->$column;
    $query->free();
    
}
?>
