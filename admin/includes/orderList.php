<?php



/*
 * list all the orders
 */
$orderListQuery = 'SELECT
orders.order_date,
orders.id,
plb_customers.first_name,
plb_customers.last_name,
plb_customers.email,
orders.customer_id
FROM
plb_orders AS orders
INNER JOIN plb_customers ON plb_customers.id = orders.customer_id ORDER BY orders.id ASC';
$orderListResult = $con->query($orderListQuery);

?>
<h2>Order List</h2>
<?php if(mysqli_num_rows($orderListResult) > 0){ ?>
<table class="table table-condensed table-bordered table-hover">
    <tr>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Customer Name</th>
        <th>Customer Email</th>
        <th>Edit</th>
    </tr>
    <?php while($data = $orderListResult->fetch_object()){ //loop tdrough all tde rows in tde category table?>    
    <tr>
        <td><?php echo $data->id; ?></td>
        <td><?php echo $data->order_date; ?></td>
        <td><?php echo $data->first_name. ' ' . $data->last_name; ?></td>
        <td><?php echo $data->email; ?></td>
        <td><a href="/final/admin/index.php?page=viewOrder&orderID=<?php echo $data->id; ?>&customerID=<?php echo $data->customer_id; ?>">View Order</a></td>
    </tr>
    <?php } ?>
</table>
<?php }else{//end if ?>
<div class="highlight">
    There are no orders. Go get some!
</div>

<?php } ?>
