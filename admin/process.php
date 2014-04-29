<?php
session_start(); 
/* 
 * this scipt processes the various form request from the admin
 */

require 'connections.php'; //get connection to database
require $_SERVER['DOCUMENT_ROOT'].'final/functions.php';



//***** CATEGORY CRUD *************************************************************************************************************************//
/*
 * add to plb_prod_categories
 */
if($_REQUEST['page'] == 'addCat'){
    $catAddQuery = "insert into plb_prod_categories values ('','".$con->real_escape_string($_REQUEST['catName'])."', '".$_REQUEST['catStatus']."')";
    $con->query($catAddQuery);
    $url = '/final/admin/index.php?page=editCat&catID='.mysqli_insert_id($con).'&added=1';
    header('Location: ' . $url);
}

/*
 * edit row in plb_prod_categories
 */
if($_REQUEST['page'] == 'editCat'){
    $catEditQuery = "update plb_prod_categories set 
             cat_name='".$con->real_escape_string($_REQUEST['catName'])."',  
             active='".$_REQUEST['catStatus']."' where id='".$_REQUEST['id']."'";
    $con->query($catEditQuery);
    $url = '/final/admin/index.php?page=editCat&catID='.$_REQUEST['id'];
    header('Location: ' . $url);
}

/*
 * delete row in plb_prod_categories
 */
if($_REQUEST['page'] == 'deleteCat'){
    $catDeleteQuery = "delete from plb_prod_categories where id='".$_REQUEST['id']."'";
    $con->query($catDeleteQuery);
    $url = '/final/admin/index.php?page=catList';
    header('Location: ' . $url);
}

//***** PRODUCT CRUD *************************************************************************************************************************//

/*
 * add to plb_prods
 */
if($_REQUEST['page'] == 'addProd'){
    $prodAddQuery = "insert into plb_prods values ('','".$con->real_escape_string($_REQUEST['prodCode'])."','".$con->real_escape_string($_REQUEST['prodName'])."', '".$con->real_escape_string($_REQUEST['prodDesc'])."', '".$con->real_escape_string($_REQUEST['prodPrice'])."', '".$_REQUEST['prodStatus']."', '".$_REQUEST['catID']."', '".$_REQUEST['prodThumb']."', '".$_REQUEST['prodImage']."')";
    $con->query($prodAddQuery);
    $url = '/final/admin/index.php?page=editProd&prodID='.mysqli_insert_id($con).'&added=1';
    header('Location: ' . $url);
}

/*
 * edit row in plb_prods
 */
if($_REQUEST['page'] == 'editProd'){
    $prodEditQuery = "update plb_prods set 
             prod_code='".$con->real_escape_string($_REQUEST['prodCode'])."', 
             prod_name='".$con->real_escape_string($_REQUEST['prodName'])."', 
             prod_desc='".$con->real_escape_string($_REQUEST['prodDesc'])."', 
             prod_price='".$con->real_escape_string($_REQUEST['prodPrice'])."', 
             cat_code='".$_REQUEST['cat_code']."',prod_thumb='".$_REQUEST['prodThumb']."',prod_image='".$_REQUEST['prodImage']."',                  
             active='".$_REQUEST['status']."' where id='".$_REQUEST['id']."'";
    //echo $prodEditQuery;
    $con->query($prodEditQuery);
    $url = '/final/admin/index.php?page=editProd&prodID='.$_REQUEST['id'].'&updated=1';
    header('Location: ' . $url);
}
/*
 * delete row in plb_prod_categories
 */
if($_REQUEST['page'] == 'deleteProd'){
    $prodDeleteQuery = "delete from plb_prods where id='".$_REQUEST['id']."'";
    $con->query($prodDeleteQuery);
    $url = '/final/admin/index.php?page=prodList';
    header('Location: ' . $url);
}

/**ACCOUNT CRUD************************************************************************************************************************************/

/*
 * create a customer
 */
if($_REQUEST['page'] == 'createCustomer'){
    $createCustomerQuery = "insert into plb_customers values ('','".$con->real_escape_string($_REQUEST['first_name'])."','".$con->real_escape_string($_REQUEST['last_name'])."','".$con->real_escape_string($_REQUEST['email'])."','".preg_replace("/[^0-9,.]/", "",$_REQUEST['phone'])."','".$con->real_escape_string($_REQUEST['address'])."','".$con->real_escape_string($_REQUEST['city'])."','".$con->real_escape_string($_REQUEST['state'])."','".$con->real_escape_string($_REQUEST['zip'])."','".$con->real_escape_string($_REQUEST['password'])."')";
    //echo $createCustomerQuery;
    //exit();
    if(!$con->query($createCustomerQuery)){ printf(mysqli_error($con));}
    $_SESSION['user_login'] = $_REQUEST['email'];
    $_SESSION['user_password'] = $_REQUEST['password'];
    $url = '/final/login.php?updateAccount=1';
    header('Location: ' . $url);
}

/*
 * edit customer account
 */
if($_REQUEST['page'] == 'updateCustomer'){
    $custEditQuery = "update plb_customers set 
             first_name='".$con->real_escape_string($_REQUEST['first_name'])."', 
             last_name='".$con->real_escape_string($_REQUEST['last_name'])."', 
             email='".$con->real_escape_string($_REQUEST['email'])."', 
             address='".$con->real_escape_string($_REQUEST['address'])."', 
             phone='".preg_replace("/[^0-9,.]/", "", $_REQUEST['phone'])."',city='".$con->real_escape_string($_REQUEST['city'])."',state='".$con->real_escape_string($_REQUEST['state'])."',                  
             zip='".$con->real_escape_string($_REQUEST['zip'])."',password='".$con->real_escape_string($_REQUEST['password'])."' where id='".$_REQUEST['id']."'";
    //echo $custEditQuery;
    //exit();
    $con->query($custEditQuery);
    if($_REQUEST['admin']){
        $url = '/final/admin/index.php?page=editCust&id='.$_REQUEST['id'].'&updated=1';
        header('Location: ' . $url);
    }else{
        $_SESSION['user_login'] = $_REQUEST['email'];
        $_SESSION['user_password'] = $_REQUEST['password'];
        $url = '/final/login.php?updateAccount=1';
        header('Location: ' . $url);
    }
}

/*
 * delete a cutomer
 */
if($_REQUEST['page'] == 'deleteCust'){
    $custDeleteQuery = "delete from plb_customers where id='".$_REQUEST['id']."'";
    $con->query($custDeleteQuery);
    $url = '/final/admin/index.php?page=custList';
    header('Location: ' . $url);
}