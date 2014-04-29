<?php



/*
 * list all customers
 */
$catQuery = 'select * from plb_prod_categories';
$catResults = $con->query($catQuery);

?>
<h2>Category List</h2>
<?php if(mysqli_num_rows($catResults) > 0){ ?>
<table class="table table-condensed table-bordered table-hover">
    <tr>
        <th>Category Name</th>
        
        <th>Active</th>
        <th>Edit</th>
    </tr>
    <?php while($catData = $catResults->fetch_object()){ //loop tdrough all tde rows in tde category table?>    
    <tr>
        <td><?php echo $catData->cat_name; ?></td>
        
        <td><?php echo $catData->active; ?></td>
        <td><a href="/final/admin/index.php?page=editCat&catID=<?php echo $catData->id; ?>">Edit Category</a></td>
    </tr>
    <?php } ?>
</table>
<?php }else{//end if ?>
<div class="highlight">
    There are no categories. Please add some.
</div>

<?php } ?>
