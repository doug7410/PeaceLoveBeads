

<?php 
require('functions.php');//get all the required functions
$screen = $_POST['screen']; //this gets used in the validate form functinon so the functnio knows what screen to go back to
$catelog_array = catelog();//get the product and categories from the $catelog array
$catelog = $catelog_array['products'];//get the product $catelog array
$cart_array = unserialize($_COOKIE['cart']);//turn the 'cart' cookie into an array

validate_form($screen);


extract($_POST);//turnr the post array into variables
$date = date("F j, Y, g:i a");//format the date
$order_number = rand(1000,9999); //make a random order number

//create the email message
$email_message = '<html>';
$email_message .= '<strong>Order Number:</strong> ' . $order_number . '<br />';
$email_message .= '<strong>Order Date:</strong> ' . $date . '<br /><br />';  
$email_message .= 'Hello ' . $_POST['name'] . ', <br /><br />Thank you for your order from Peace Love & Beads! Your order details are below.';

$email_message .= '<h2>Ship to Address</h2>';
$email_message .= $name . '<br />';
$email_message .= $email . '<br />';
$email_message .= '('.substr($phone, 0, 3).') '.substr($phone, 3, 3).'-'.substr($phone,6) . '<br />';
$email_message .= $address . '<br />';
$email_message .= $city . ', ' . $state . ' ' . $zip ;
		  
//this runs the order_summery functin to display the order contets in the email
//it just seems to work beter when I put (string) function in front of it, maybe because it's a very long string
$email_message .=  (string)order_summery($cart_array,$catelog); 

$email_message .= '</html>';

$to = $email;  
$from = "sales@peaceloveandbeads.com";  
$email_subject = "Peace Love & Beads - Order# " . $order_number;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";//this makes the email html
$headers .= 'From: Peace Love & Beads <sales@peaceloveandbeads.com>' . "\r\n";
$headers .= 'Cc: dstein-phins@hotmail.com' . "\r\n";

mail($to, $email_subject, $email_message, $headers);//send the order email

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/final/index.php?screen=checkout&order_number=' . $order_number . '&name=' . $name . '&email=' . $email . '&phone=' . $phone . '&address=' . $address . '&city=' . $city . '&state=' . $state . '&zip=' . $zip;
header('Location: ' . $url);//redirect to the order confirmation/ thank you screen
exit;
   
?>