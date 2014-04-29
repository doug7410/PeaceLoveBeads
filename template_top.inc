<?php


/*
 * Get all the categories
 */
$catQuery = 'select * from plb_prod_categories where active="1"';
$catResult = $con->query($catQuery);

/*
 * get the current category
 */
$currentCatQuery = 'select * from plb_prod_categories where id="'.$_REQUEST['category'].'"';
$currentCatResult = $con->query($currentCatQuery);
$catRow = mysqli_fetch_object($currentCatResult);

/*
 * get all the products in the current category
 */
$prodQuery = 'select * from plb_prods where cat_code="'.$_REQUEST['category'].'" and active="1"';
$prodResults = $con->query($prodQuery);

/*
 * get the current product
 */
$currentProdQuery = 'select * from plb_prods where id="'.$_REQUEST['prodID'].'"';
$currentProdResult = $con->query($currentProdQuery);
$prodRow = mysqli_fetch_object($currentProdResult);

/*
 * get the current customer if logged in
 */
if($_SESSION['logged_in'] == 'yes'){
$customerQuery = 'select * from plb_customers where email = "'.$_SESSION['user_login'].'" AND password="'.$_SESSION['user_password'].'"';
$customerResult = $con->query($customerQuery);
//echo $customerQuery;
//exit();
$customerRow = $customerResult->fetch_object();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="main.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Peace Love and Beads</title>

</head>

<body>
<div id="wrapper">
	<!--start header-->
	<div id="header"> 
    	<img src="images/PLBbanner.jpg" width="980" height="128" />    
    </div>
    
    <!--start top nav------------------------------------------------------------------------------------------------->
    <div id="top_nav" ><a href="/final/index.php">Home</a> | 
   	  <?php if($_SESSION['logged_in'] == 'yes'){ ?>
           Hello <?php echo $customerRow->first_name ?>, welcome back! | 
           <a href="index.php?screen=register">Account</a> | 
           <a href="login.php?logout=1">Logout</a>
           <?php }else{ ?>
           <a href="<?php echo $_SERVER['PHP_SELF'] . '?screen=login'; ?>">Login</a>
           <?php } ?> |  
       
      <a href="index.php?screen=cart">View Cart</a> (<?php 
	  if(empty($cart_array)){
	  	echo '0';
	  }else{	
	   echo array_sum($cart_array); //add all item quantities together
	  }
	   ?> items) <?php echo money_format('$%i',$st); //show cart sub-total ?>  |  
        <a href="index.php?screen=checkout">Checkout</a> 
    </div>
     
    
     
     <!--start side nav for categories------------------------------------------------------------------------------------->
     <div id="side_nav" >
     <h2>Categories</h2>
     	<?php 
                while($catData = $catResult->fetch_object()){
		//foreach ($catelog_array['categories'] as $value){ //list all the categories?>
		<a href="index.php?screen=category&category=<?php echo $catData->id; ?>"><?php echo ucfirst($catData->cat_name); ?></a> 
		<?php } ?>
   	  </div>
     
     <!--start main content section--------------------------------------------------------------------------------------------->
     <div id="main_content" >