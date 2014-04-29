<?php

/* 
 * This scrip for editing or deleting an existing product category
 */


/*
 * select the current category from the plb_prod_categories table
 */
$catQuery = 'select * from plb_prod_categories WHERE id="'.$_REQUEST['catID'].'"';
$catResults = $con->query($catQuery);
while($catData = $catResults->fetch_object()){
    $catID = $catData->id;
    $catName = $catData->cat_name;
    $active = $catData->active;
}

if($active == 1){
    $status = 'checked';
}
?>

<h2>Edit <?php echo $catName; ?></h2>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="editCat" />
    <input type="hidden" name="id" value="<?php echo $catID; ?>" />
    <div class="form-group">
      <label for="catName">Category Name</label>
      <input type="text" class="form-control" id="catName" placeholder="Enter Category Name" name="catName" value="<?php echo $catName; ?>">
    </div>
    <div class="checkbox">
      <label>
          <input type="checkbox" name="catStatus" value="1" <?php echo $status; ?>> Active
      </label>
    </div>
    <button type="submit" class="btn btn-default">Update</button>
</form>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="deleteCat" />
    <input type="hidden" name="id" value="<?php echo $catID; ?>" />
    <button type="submit" class="btn btn-default">Delete Category</button>
</form>
<?php if($_REQUEST['added']){ ?>
<div id="dialog" title="Category Added">
    <p>The <b><?php echo $catName; ?></b> category has been added to the catalog.</p>
</div>
<?php } ?>