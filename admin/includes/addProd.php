<?php

/* 
 * add a new product with this form
 */

/*
 * get list of categories
 */
$catQuery = 'select * from plb_prod_categories';
$catResult = $con->query($catQuery);
?>


  
<h2>Add a new product</h2>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="addProd" />
    
    <div class="form-group">
      <label for="prodCode">Product Code</label>
      <input type="text" class="form-control" id="prodCode" placeholder="Enter Product Code" name="prodCode">
    </div>
    
    <div class="form-group">
      <label for="prodName">Product Name</label>
      <input type="text" class="form-control" id="prodName" placeholder="Enter Product Name" name="prodName">
    </div>
    
    <div class="form-group " >
      <label for="catName">Category Name</label>
      <select type="text" class="form-control" id="catID" name="catID">
          <option value="">(Please choose a category)</option>
          <?php while($catData = $catResult->fetch_object()){ ?>
          <option value="<?php echo $catData->id; ?>"><?php echo $catData->cat_name; ?></option>
          <?php } ?>
      </select>
    </div>
    
    <div class="form-group">
      <label for="prodPrice">Product Price</label>
      <input type="text" class="form-control" id="prodPrice" placeholder="Enter Product Price" name="prodPrice">
    </div>
    
    <div class="form-group">
      <label for="prodThumb">Product Thumbnail Image</label>
      <input type="text" class="form-control" id="prodThumb" placeholder="Enter Product Thumbnail" name="prodThumb">
    </div>
    
    <div class="form-group">
      <label for="prodImage">Product Large Image</label>
      <input type="text" class="form-control" id="prodImage" placeholder="Enter Product Image" name="prodImage">
    </div>
    
    <div class="form-group">
      <label for="prodDesc">Product Description</label>
      <textarea rows="5" type="text" class="form-control" id="prodDesc" placeholder="Enter Product Description" name="prodDesc"></textarea>
    </div>
    
    <div class="checkbox">
      <label>
          <input type="checkbox" name="prodStatus" value="1"> Active
      </label>
    </div>
    
    <button type="submit" class="btn btn-default">Add Product</button>
</form>

<?php
$catResult->free();
?>