
<?
session_start();

if(!$_SESSION['subtotal']){
$_SESSION['subtotal'] = 0;
}

require('functions.php');


$shipping = 3.50;

update_cart();
$st = sub_total();

?>
<table border="1" cellpadding="3">
<tr>
<td>QTY</td><td>CODE</td><td>NAME</td><td>PRICE</td><td>PRICE EXTENDED</td><td>UPDATE</td><td>REMOVE</td>
</tr>
<?

shopping_cart();

?>
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
<a href="catalog.php">back to catalog</a><br />
<a href="checkout.php">checkout</a>