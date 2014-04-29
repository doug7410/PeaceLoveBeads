<? 

session_start();
if(!$_SESSION['cart']){ // if the 'cart' session array does not exist create it
	$_SESSION['cart'] = array();
}

require('functions.php');
require('products.php');
update_cart();
$st = sub_total();






?>
<form method="get" action="catalog.php">
<select name="category">
<option value="all">all</option>
<? 
foreach ($categories as $value){ ?>
	<option value="<? echo $value; ?>" <? if($_GET['category'] == $value) echo 'selected'; ?>><? echo $value; ?></option>

<? } ?>
</select>
<input type="submit" value="go">
</form>
<br />
<br />



<? foreach($catelog as $key => $value){ 
if($_GET['category'] == $catelog[$key]['ctgy'] || $_GET['category'] == 'all' ){?>
<form method="get" action="catalog.php">
<input name="prod_code" type="hidden" value="<? echo $catelog[$key]['code']; ?>" />
<input name="prod_name" type="hidden" value="<? echo $catelog[$key]['name']; ?>" />
<input name="prod_price" type="hidden" value="<? echo $catelog[$key]['price']; ?>" />
<input name="category" type="hidden" value="<? echo $_GET['category']; ?>" />
<input type="hidden" name="action" value="add" />
Name: <? echo $catelog[$key]['name']; ?><br />
Description: <? echo $catelog[$key]['description']; ?><br />
Price: <? echo $catelog[$key]['price']; ?><br />
QTY: <input type="text" size="3" name="qty" value="1" />
<input type="submit" value="submit" />
</form>

<? } 
} ?>


<table border="1" cellpadding="3">
<tr>
<td>QTY</td><td>CODE</td><td>NAME</td><td>PRICE</td><td>PRICE EXTENDED</td><td>UPDATE</td><td>REMOVE</td>
</tr>

<?    
shopping_cart();//this is the shoping cart   
?>
<tr>
<td colspan="6">Subtotal</td>
<td><? echo $st; ?></td>
</tr>
</table>
<a href="basket.php">checkout</a>