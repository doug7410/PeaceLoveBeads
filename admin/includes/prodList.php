<?php

/* 
 * this scrip will list all the products
 */



/*
 * list all entries in plb_prods table
 */
$prodQuery = 'select * from plb_prods';
$prodResults = $con->query($prodQuery);

?>
<h2>Product List</h2>
<?php if(mysqli_num_rows($prodResults) > 0){ ?>
<table class="table table-condensed table-bordered table-hover">
    <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Active</th>
        <th>Edit</th>
    </tr>
    <?php while($prodData = $prodResults->fetch_object()){ //loop tdrough all tde rows in tde category table?>    
    <tr>
        <td><?php echo $prodData->prod_code; ?></td>
        <td><?php echo $prodData->prod_name; ?></td>
        <td><?php echo single_result($con,'plb_prod_categories',$prodData->cat_code,'cat_name'); ?></td>
        <td><?php echo $prodData->active; ?></td>
        <td><a href="/final/admin/index.php?page=editProd&prodID=<?php echo $prodData->id; ?>">Edit Product</a></td>
    </tr>
    <?php } ?>
</table>
<?php }else{//end if ?>
<div class="highlight">
    There are no product categories. Please add some.
</div>

<?php } 
$prodResults->free();
?>
