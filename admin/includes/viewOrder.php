<?php

/* 
 * get order and customer info
 */
$shipping = 3.5;

$orderQuery = "SELECT
orders.order_date,
orders.id,
plb_customers.first_name,
plb_customers.last_name,
plb_customers.email,
orders.customer_id,
plb_customers.address,
plb_customers.phone,
plb_customers.city,
plb_customers.state,
plb_customers.zip
FROM
plb_orders AS orders
INNER JOIN plb_customers ON plb_customers.id = orders.customer_id
WHERE orders.id='".$_REQUEST['orderID']."'";
$orderResult = $con->query($orderQuery);
$orderRow = $orderResult->fetch_object();

/*
 * order items
 */
$itemsQuery = 'select * from plb_order_items where order_id = "'.$_REQUEST['orderID'].'"';
$itemsResult = $con->query($itemsQuery);
?>
<h2>Order #<?php echo $orderRow->id; ?></h2>
<table class="table">
    <tr>
        <td>
            <h4>Customer Info</h4>
            <div>
                <?php echo $orderRow->first_name. ' ' .$orderRow->last_name ; ?>
                <br>
                <?php echo $orderRow->email ; ?>
                <br>
                <?php echo '('.substr($orderRow->phone, 0, 3).') '.substr($orderRow->phone, 3, 3).'-'.substr($orderRow->phone,6) ;; ?>
                <br><br>
                <?php echo $orderRow->address ; ?>
                <br>
                <?php echo $orderRow->city . ', ' . $orderRow->state . ' '. $orderRow->zip  ; ?>
                <br>
            </div>
        </td>
    </tr>
</table>
<table class="table">
    <tr>
        <td>
            <h4>Order Info</h4>
            <div>
                <b>Order Date:</b>
                <?php echo $orderRow->order_date; ?>
                <br>          
            </div>
            <table class="table table-striped">
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Totoal</th>
                </tr>
                <?php
                while($data = $itemsResult->fetch_object()){
                    $prodTotal = $data->prod_qty * $data->prod_price;
                    $subTotal += $prodTotal;
                ?>
                <tr>
                    <td><?php echo $data->prod_name; ?></td>
                    <td><?php echo $data->prod_qty; ?></td>
                    <td><?php echo  money_format('$%i',$data->prod_price); ?></td>
                    <td><b><?php echo  money_format('$%i',$prodTotal) ?></b></td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Sub-Total:</b> </td>
                    <td><?php echo  money_format('$%i',$subTotal) ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Shipping:</b> </td>
                    <td><?php echo  money_format('$%i',$shipping) ?></td>
                </tr>   
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Grand Total:</b> </td>
                    <td><?php echo  money_format('$%i',$subTotal+$shipping) ?></td>
                </tr>  
            </table>
        </td>
    </tr>
</table>

