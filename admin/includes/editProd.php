<?php

/* 
 * This scrip for editing or deleting a single product
 */


$prodTable = 'plb_prods'; //product table
$catTable = 'plb_prod_categories';//categories table
$prodID = $_REQUEST['prodID'];//product id

/*
 * get a list of all the categories
 */
$catQuery = 'select * from plb_prod_categories';
$catResult = $con->query($catQuery);

if(single_result($con,$prodTable,$prodID,'active') == 1){
    $status = 'checked';
}

?>

<h2>Edit Product: <?php echo single_result($con,$prodTable,$prodID,'prod_name'); ?></h2>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="editProd" />
    <input type="hidden" name="id" value="<?php echo single_result($con,$prodTable,$prodID,'id'); ?>" />
    <div class="form-group">
      <label for="prodCode">Product Code</label>
      <input type="text" class="form-control" id="prodCode" placeholder="Enter Product Code" name="prodCode" 
             value="<?php echo single_result($con,$prodTable,$prodID,'prod_code'); ?>">
    </div>
    <div class="form-group">
      <label for="prodName">Product Name</label>
      <input type="text" class="form-control" id="prodName" placeholder="Enter Product Name" name="prodName" 
             value="<?php echo single_result($con,$prodTable,$prodID,'prod_name'); ?>">
    </div>
    
    <div class="form-group " >
      <label for="cat_code">Category Name</label>
      <select type="text" class="form-control" id="cat_code" name="cat_code">
          <option value="">(Please choose a category)</option>
          <?php 
            while($catData = $catResult->fetch_object()){ 
            $catID = $catData->id;
            if($catID == single_result($con,$prodTable,$prodID,'cat_code')){
                $selected = 'selected';
            }else{
                $selected = '';
            }  
           ?>
          <option value="<?php echo $catData->id; ?>" <?php echo $selected; ?>><?php echo $catData->cat_name; ?></option>
          <?php } ?>
      </select>
    </div>
    
    <div class="form-group">
      <label for="prodPrice">Product Price</label>
      <input type="text" class="form-control" id="prodPrice" placeholder="Enter Category Name" name="prodPrice" 
             value="<?php echo single_result($con,$prodTable,$prodID,'prod_price'); ?>">
    </div>
    
    <div class="form-group">
      <label for="prodThumb">Product Thumbnail Image</label>
      <input type="text" class="form-control" id="prodThumb" placeholder="Enter Product Thumbnail" name="prodThumb"
             value="<?php echo single_result($con,$prodTable,$prodID,'prod_thumb'); ?>">
    </div>
    
    <div class="form-group">
      <label for="prodImage">Product Large Image</label>
      <input type="text" class="form-control" id="prodImage" placeholder="Enter Product Image" name="prodImage"
             value="<?php echo single_result($con,$prodTable,$prodID,'prod_image'); ?>">
    </div>
    
    <div class="form-group">
      <label for="prodDesc">Product Description</label>
      <textarea rows="5" type="text" class="form-control" id="prodDesc" placeholder="Enter Product Description" name="prodDesc"><?php echo single_result($con,$prodTable,$prodID,'prod_desc'); ?>
      </textarea>
    </div>
    
    <div class="checkbox">
      <label>
          <input type="checkbox" name="status" value="1" <?php echo $status; ?>> Active
      </label>
    </div>
    <button type="submit" class="btn btn-default">Update</button>
</form>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="deleteProd" />
    <input type="hidden" name="id" value="<?php echo single_result($con,$prodTable,$prodID,'id'); ?>" />
    <button type="submit" class="btn btn-default">Delete Product</button>
</form>
<?php if($_REQUEST['updated']){ ?>
<div id="dialog" title="Product Updated">
    <p><b><?php echo single_result($con,$prodTable,$prodID,'prod_name'); ?></b>  - has been updated.</p>
</div>
<?php } ?>
<?php if($_REQUEST['added']){ ?>
<div id="dialog" title="Product Added">
    <p><b><?php echo single_result($con,$prodTable,$prodID,'prod_name'); ?></b>  - has been added to the catalog.</p>
</div>
<?php } ?>