<?php

/* 
 * this is the main controller file for the admin. The contentes 
 * of this page will be determined by the $_REQEST variables
 */

require 'header.php'; 

/*
 * this section uses the $_REQUEST['page'] variable to determine which form is shown on the page
 */
switch($_REQUEST['page']){
    case 'addCat':
        require 'includes/addCat.php';
        break;
    case 'catList':
        require 'includes/catList.php';
        break;
    case 'editCat':
        require 'includes/editCat.php';
        break;
    case 'addProd':
        require 'includes/addProd.php';
        break;
    case 'prodList':
        require 'includes/prodList.php';
        break;
    case 'editProd':
        require 'includes/editProd.php';
        break;
    case 'orderList':
        require 'includes/orderList.php';
        break;
    case 'viewOrder':
        require 'includes/viewOrder.php';
        break;
    case 'custList':
        require 'includes/custList.php';
        break;
    case 'editCust':
        require 'includes/editCust.php';
        break;
    default :
        echo '<div class="highlight">choose a link from the left</div>';
}

require 'footer.php';
?>


