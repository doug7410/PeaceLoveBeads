<?php

/* 
 * add a new product category with this form
 */
?>

<script>
$(function() {
$( "#dialog" ).dialog();
});
</script>  
<h2>Add a new category</h2>
<form role="form" action="process.php" method="POST">
    <input type="hidden" name="page" value="addCat" />
    <div class="form-group">
      <label for="catName">Category Name</label>
      <input type="text" class="form-control" id="catName" placeholder="Enter Category Name" name="catName">
    </div>
    
    <div class="checkbox">
      <label>
          <input type="checkbox" name="catStatus" value="1"> Active
      </label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
