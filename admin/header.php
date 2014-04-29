<?php
require 'connections.php';
require $_SERVER['DOCUMENT_ROOT'].'final/functions.php';



?>
<!DOCKTYPE html>
<html lang="en"> 
<head>
    <title>Peace Love &amp; Beads Admin</title>
    <link rel="stylesheet" href="/final/css/bootstrap.css" media="screen" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="main.css" media="screen" />
    <script src="/final/js/jquery-1.10.2.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/final/js/grids.js"></script>
    <script type="text/javascript">
        // Keep all of our elements the same height, all the time.
        jQuery(function($) {
                $('.columns').responsiveEqualHeightGrid();        
        });
</script>
<script>
$(function() {
$( "#dialog" ).dialog();
});
</script>
</head>
<body>
    <div class="row">
        <div id="adminHeader" class="row">
            <h1>
                Peace Love &amp; Beads - Shopping Cart Admin
            </h1>
           <a href="/final/">Click here to go to the front end of the shop.</a>
        </div>
        <div  class="row">
           
            <div id="adminNav" class="col-md-2 columns">
                  
                <?php require 'nav.php'; ?>
            </div>
            <div id="adminMain" class="col-md-10 columns">