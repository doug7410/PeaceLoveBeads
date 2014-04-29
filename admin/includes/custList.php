<?php

/*
 * list all the customers
 */
$custQuery = 'select * from plb_customers';
$custResults = $con->query($custQuery);

?>
<h2>Customer List</h2>
<?php if(mysqli_num_rows($custResults) > 0){ ?>
<table class="table table-condensed table-bordered table-hover">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
    </tr>
    <?php while($custData = $custResults->fetch_object()){ //loop tdrough all tde rows in tde category table?>    
    <tr>
        <td><?php echo $custData->first_name . ' ' .$custData->last_name; ?></td>
        <td><?php echo $custData->email; ?></td>
        <td><a href="/final/admin/index.php?page=editCust&id=<?php echo $custData->id; ?>">Edit Customer</a></td>
    </tr>
    <?php } ?>
</table>
<?php }else{//end if ?>
<div class="highlight">
    There are no product categories. Please add some.
</div>

<?php } 
$custResults->free();
?>
