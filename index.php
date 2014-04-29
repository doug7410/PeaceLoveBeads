<?php
session_start();//start the session array
require 'admin/connections.php';


if(!$_COOKIE['cart']){ // if the 'cart' cookie does not exist create it
	$time = time() + (365 * 24 * 60 * 60); //set the time for 1 year from today
	setcookie('cart',' ',$time);//create the empty 'cart' cookie
}

require('functions.php');//get all the required functions

$state_list = state_list();//get state list array for the account and checkout forms
$cart_array = unserialize($_COOKIE['cart']); //convert the 'cart' cookie to the $cart_array

if($_GET['action']){ //if the $_GET['action'] variable exist run the update cart function
update_cart($cart_array,$_GET['screen'],$_GET['prodID']);
}


if($cart_array){ //if the $cart_array exist run the sub_total function
	$st = sub_total($cart_array,$con); // make the variable $st equal the result of the subtotal function
}

if($_SESSION['logged_in'] == "yes"){//if the user is logged in convert the user cookie into the $user_array
	//$user = $_SESSION['user_login'];
	//$user_array = unserialize($_COOKIE[$user]);
}

if($_SESSION['logged_in'] == "yes"){
$logged_in = 1; //if the user is logged in 
}
require($_SERVER['DOCUMENT_ROOT']."/final/template_top.inc");//get the template_top file
 
		//start cart page**********************************************************************************
		if($_GET['screen'] == "cart"){//if the $_GET['screen'] is cart display the code below  
			if(!$cart_array){ //if the cart array is empty display cart is empty message
				echo "<h1>Your Shopping Cart</h1>";
				echo '<div id="cart_screen">';
				echo '<h3> Your cart is empty</h3>';
				echo '</div>';
                                
				
			}else{ //else display the cart
				echo "<h1>Your Shopping Cart</h1>";
				echo '<div id="cart_screen">';
				shopping_cart($st,$_GET['screen'],$cart_array,$con);//this function displays the shoping cart  
				echo '<div id="cart_login">'; 
					if($logged_in){//if the user is logged in display the checkout button
						echo '<a id="checkout_link" href="index.php?screen=checkout" >Proceed to checkout</a>';
					}else{//if they are not logged in display the login form
						echo '<h2>Please sign in or create an account before checking out.</h2>';
						login_form($logged_in);	//this function displays the login form
						echo '</div>';
					}
				}	
			
			echo '</div></div>';
		//end cart page**********************************************************************************
		
		//start log in form**********************************************************************************
		}elseif($_GET['screen'] == "login"){ 
			echo "<h1>Login</h1>"; // if the $_GET['screen'] is login 
		login_form($logged_in);	//display the login form
		//end login form****************************************************************
			
		}elseif($_GET['screen'] == "register"){ // if the screen is register display the create/edit account form
		//account form***********************************************************************************************
		if($_POST['update'] || $_POST['new_account']){ //if this is true
			set_user_cookie($_GET['screen']);  //run the set_user_cookie functino
		}
        if($logged_in){
			echo '<h1>Your Account</h1>'; //if they are logged in display this
		}else{
			echo "<h1>Create an account</h1>"; //if not logged in display this
		}
		?>
       <div id="cart_screen">
       <?php 
       if($_GET['update']){
			echo '<div class="note">Your account has been updated</div>';// if $_GET[update] show this message
		}elseif($_GET['new_account']){//if $_GET[new_account] show this message			
			echo '<div class="note">Thank you for registering an account with Peace Love & Beads!</div>';
		}
       ?>
        <form method="post" action="admin/process.php">
<input type="hidden" name="screen" value="<?php echo $_GET['screen']; ?>" />
<input type="hidden" name="page" value="<?php echo (!$logged_in ? 'createCustomer' : 'updateCustomer'); ?>" />
<input type="hidden" name="id" value="<?php echo $customerRow->id; ?>" />
<table id="cart_table" >
  <tr>
    <td width="113">First Name:</td>
    <td width="471">
        <input type="text" name="first_name" value="<?php echo $customerRow->first_name; ?>" />
    </td>
  </tr>
  <tr>
    <td width="113">Last Name:</td>
    <td width="471">
        <input type="text" name="last_name" value="<?php echo $customerRow->last_name; ?>" />
    </td>
  </tr>
  <tr>
    <td>Email:</td>
    <td>
        <input type="text" name="email" value="<?php echo $customerRow->email; ?>" />
    </td>
  </tr>
  <tr>
    <td>Address:</td>
    <td>
        <input type="text" name="address" value="<?php echo $customerRow->address; ?>" />
    </td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td>
        <input type="text" name="phone" value="<?php echo '('.substr($customerRow->phone, 0, 3).') '.substr($customerRow->phone, 3, 3).'-'.substr($customerRow->phone,6) ; ?>" />
    </td>
  </tr>
  <tr>
    <td>City:</td>
    <td>
        <input type="text" name="city" value="<?php echo $customerRow->city; ?>" />
    </td>
  </tr>
  <tr>
    <td>State:</td>
    <td><select name="state" > 
    <?php  
	foreach($state_list as $key => $value){
            $selected = ($customerRow->state == $key ? 'selected' : '' );
            echo '<option value="' . $key . '" '.$selected.' >' . $value . '</option>';
	}
	 ?>
     </select>
     </td>
  </tr>
  <tr>
    <td>Zip Code:</td>
    <td>
        <input type="text" name="zip" value="<?php echo $customerRow->zip; ?>" />
    </td>
  </tr>
   <tr>
    <td>Password:</td>
    <td>
        <input type="password" name="password" value="<?php echo $customerRow->password; ?>" />
    </td>
  </tr>
</table>
<input class="submit" type="submit" value="<?php if($logged_in){ echo 'Update Account'; }else{ echo 'Create Account'; } ?>" /> 
</form></div>
        <?php
        if($logged_in){ //if they are logged in display the checkout button
			echo '<a style="float:right;top:-46px;position:relative;right:29px;text-align:center;" id="checkout_link" href="/final/index.php?screen=checkout">Checkout</a>';
		}
	
 //end create an account form**************************************************************************

		}elseif($_GET['screen'] == "checkout"){
			
			//checkout form******************************************************************************************
if(!($logged_in)){
	header('Location: index.php?screen=cart');//if not logged in go to cart screen
	exit();
}else{
	if(!$cart_array){
		header('Location: index.php?screen=cart');// if cart is empty go to cart screen
		exit();
	}
if($_GET['orderID']){//after the order is complete run the code below
    /*
     * get order information
     */
    $orderCustomerQuery = 'SELECT cust.first_name, cust.last_name, cust.email,
                            cust.address,cust.phone,cust.city,cust.state,cust.zip,ord.id,ord.order_date FROM
                            plb_orders AS ord LEFT JOIN plb_customers AS cust ON cust.id = ord.customer_id 
                            WHERE ord.id ="' .$_REQUEST['orderID'].'"';
    $orderCustomerResult = $con->query($orderCustomerQuery);
    $orderCustomerRow = $orderCustomerResult->fetch_object();
    
	echo '<h1>Thank you for your order</h1>';
	echo '<div id="order_details">';
	echo '<h3>A copy of this order has been sent to your email.</h3>';
	echo "<strong>Order Number:</strong> " . $orderCustomerRow->id . "<br />";
	echo "<strong>Order Date:</strong> " . $orderCustomerRow->order_date . '<br /><br />';  
	echo '<h2>Ship to Address</h2>';
	echo $orderCustomerRow->first_name . ' ' .$orderCustomerRow->last_name. '<br />';
	echo $orderCustomerRow->email . '<br />';
	echo "(".substr($orderCustomerRow->phone, 0, 3).") ".substr($orderCustomerRow->phone, 3, 3)."-".substr($orderCustomerRow->phone,6) . '<br />';
	echo $orderCustomerRow->address . '<br />';
	echo $orderCustomerRow->city . ', ' . $orderCustomerRow->state . ' ' . $orderCustomerRow->zip ;
	echo '</div>';
        echo '<div id="cart_screen">';
        echo order_summery($cart_array,$con);
        echo '</div>';
        setcookie('cart',' ',$time);//empty the 'cart' cookie
}else{ //if the order is not complete run code for checkout page
	echo '<h1>Checkout</h1>';
}
echo '<div id="cart_screen">';

if(!$_GET['orderID']){
    echo order_summery($cart_array,$con);
?>

<form id="form" method="post" action="order.php">
<input type="hidden" name="screen" value="<?php echo $_GET['screen']; ?>" />
<input type="hidden" name="customerID" value="<?php echo $customerRow->id; ?>" />
<h2>Shipping and Billing Info</h2>
<span class="note">all fields are required</span>
<table id="cart_table" >
  <tr>
    <td width="113">First Name:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->first_name; ?>" />
    </td>
  </tr>
  <tr>
    <td width="113">Last Name:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->last_name; ?>" />
    </td>
  </tr>
  <tr>
    <td width="113">Email:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->email; ?>" />
    </td>
  </tr>
 <tr>
    <td width="113">Address:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->address; ?>" />
    </td>
  </tr>
  <tr>
    <td width="113">Phone:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->phone; ?>" />
    </td>
  </tr>
  <tr>
    <td width="113">City:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->city; ?>" />
    </td>
  </tr>
<tr>
    <td>State:</td>
    <td><select name="state" > 
    <?php  
	foreach($state_list as $key => $value){
            $selected = ($customerRow->state == $key ? 'selected' : '' );
            echo '<option value="' . $key . '" '.$selected.' >' . $value . '</option>';
	}
	 ?>
     </select>
     </td>
  </tr>
  <tr>
    <td width="113">Zip Code:</td>
    <td width="471">
        <input type="text" name="name" value="<?php echo $customerRow->zip; ?>" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Credit Card #:</td>
    <td><input type="text" disabled="disabled" name="cc_number" value="1111-2222-3333-4444" /> 
    <span class="note">The credit card fields are disabled for this demo.</span>
    </td>
  </tr>
  <tr>
    <td>Expiration Date:</td>
    <td><input type="text" disabled="disabled" name="cc_exp" value="01/2020" /></td>
  </tr>
</table>
<input type="submit" value="submit" /> 
</form>
<?php	
	}
	echo '</div>';
}
	//end checkout form**********************************************************************************
		
		//start product details**********************************************************************************
		}elseif($_GET['screen'] == 'product'){	//if the screen is product ?> 
                   
            <h1>Product Details</h1>
            <div id="product_details">
            <div id="product_details_img">
            	<img src="<?php echo $prodRow->prod_image; ?>" width="360px" />
            </div>
            <div id="product_details_form">
                <form method="get" action="index.php">
                <input type="hidden" name="screen" value="product" />
                <input name="prodID" type="hidden" value="<?php echo $prodRow->id; ?>" />
                <input name="category" type="hidden" value="<?php echo $_GET['category']; ?>" />
                <input type="hidden" name="action" value="add" />         
		<h2><?php echo $prodRow->prod_name; ?></h2>
                <p>Code: <?php echo $prodRow->prod_code; ?></p>
                <?php echo nl2br($prodRow->prod_desc); ?>
		<h3><?php echo money_format('$%i',$prodRow->prod_price); //format number as money ?></h3>
                
                    <?php 
                        if($_GET['add']){ //if $_GET[add] display message
				if($_GET['qty'] > 1){ 
					$has_have = 'have';
				}else{ 
					$has_have = 'has'; 
				}
				echo '<div class="note">' . $_GET['qty'] . ' of these ' . $has_have . ' been added to your cart.</div>';
			   }
                    ?>
			<strong>QTY:</strong> <input type="text" size="3" name="qty" value="1" />
			<input type="submit" value="Add to Cart" />
			</form>
            </div>
			
	   </div>
               <?php 
	     //end product details**********************************************************************************
		
		
		//start category page***********************************************************************************************
			}elseif($_GET['screen'] == 'category'){	//if category screen
                        ?>    
			<h1><?php echo ucfirst($catRow->cat_name); //display category name ?> </h1>
			<div id="category_grid" >
                            <?php 
                                while($prodData = $prodResults->fetch_object()){ 
                                $id = $prodData->id;    
                            ?>
                            <div class="category_grid_box">
                                <div class="category_grid_box_image">
                                    <a href="/final/index.php?screen=product&prodID=<?php echo $id; ?>">
                                        <img src="<?php echo $prodData->prod_thumb ; ?>" />
                                    </a>
                                </div>
                                <div class="category_grid_box_name">
                                    <a href="/final/index.php?screen=product&prodID=<?php echo $id; ?>">
                                        <?php echo $prodData->prod_name; ?>
                                    </a>
                                </div>
                                <div class="category_grid_box_price">
                                    <?php echo money_format('$%i',$prodData->prod_price); ?>
                                </div>
                            </div>
                            <?php }//end while ?>
                        </div>
                        <?php 
			//end category page***********************************************************************************************
		
        }else{
		//start home page***********************************************************************************************
				echo '<h1>Home Page</h1>';
				echo '<img id="home_image" src="/final/images/home_page.jpg" />';
			
		}//end home page***********************************************************************************************	
        ?>
          </div>
     
     
</div><div id="footer">&copy;Peace Love & Beads Inc. - <a href="#">Contact Us</a> - (954)555-4444</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41855574-1', 'userworld.com');
  ga('send', 'pageview');

</script>
<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=4725844; 
var sc_invisible=1; 
var sc_security="294b849f"; 
</script>
<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="free hit
counter" href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/4725844/0/294b849f/1/"
alt="free hit counter"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->
</body>
</html>
        
   
