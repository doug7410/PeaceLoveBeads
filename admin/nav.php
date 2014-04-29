<?php

/* 
 * main nav for admin
 */

?>
<ul>
    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=catList">Category List</a><br>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=addCat">[add category]</a></li>
    
    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=prodList">Product List</a><br>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=addProd">[add product]</a></li>
    
    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=custList">Customer List</a></li>
    
    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=orderList">Order List</a></li>
    
</ul>


