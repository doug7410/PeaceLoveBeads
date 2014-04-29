<?php

/* 
 * edit a customer
 */


/*
 * get the customer data
 */
$custQuery = 'select * from plb_customers where id="'.$_REQUEST['id'].'"';
$custResult = $con->query($custQuery);
$custRow = $custResult->fetch_object();



?>

<h2>Edit Customer</h2>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="updateCustomer" />
    <input type="hidden" name="admin" value="1" />
    <input type="hidden" name="id" value="<?php echo $custRow->id; ?>" />
    <div class="form-group">
      <label for="first_name">First Name</label>
      <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name" 
             value="<?php echo $custRow->first_name; ?>">
    </div>
    <div class="form-group">
      <label for="last_name">Last Name</label>
      <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name" 
             value="<?php echo $custRow->last_name; ?>">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" class="form-control"  name="email" value="<?php echo $custRow->email; ?>">
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" class="form-control"  name="address" value="<?php echo $custRow->address; ?>">
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" class="form-control"  name="phone" value="<?php echo $custRow->phone; ?>">
    </div>
    <div class="form-group">
      <label for="city">City</label>
      <input type="text" class="form-control"  name="city" value="<?php echo $custRow->city; ?>">
    </div>
    <div class="form-group">
      <label for="state">State</label>
      <input type="text" class="form-control"  name="state" value="<?php echo $custRow->state; ?>">
    </div>
    <div class="form-group">
      <label for="zip">Zip</label>
      <input type="text" class="form-control"  name="zip" value="<?php echo $custRow->zip; ?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control"  name="password" value="<?php echo $custRow->password; ?>">
    </div>
    
    
    
    <button type="submit" class="btn btn-default">Update</button>
</form>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="deleteCust" />
    <input type="hidden" name="id" value="<?php echo $custRow->id; ?>" />
    <button type="submit" class="btn btn-default">Delete Customer</button>
</form>
<?php if($_REQUEST['updated']){ ?>
<div id="dialog" title="Customer Updated">
    <p>Customer <b><?php echo $custRow->first_name . ' ' . $custRow->last_name; ?></b>  - has been updated.</p>
</div>
<?php } ?>
