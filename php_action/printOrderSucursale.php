<?php 	

require_once 'core.php';

$orderId = $_POST['orderId'];

//$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

$sql = "SELECT order_date, brands.brand_name AS sucursal, client_contact,client_name 
FROM orders INNER JOIN brands ON brands.brand_id = orders.brandSurcursale_id
 WHERE order_id= $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[3];
$clientContact = $orderData[2]; 
$Sucursale = $orderData[1];
 


 $orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity,
order_item.total, product_coorporation.product_name 
FROM order_item INNER JOIN product_coorporation ON order_item.product_id = product_coorporation.product_id 
WHERE order_item.order_id=  $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '
 <table border="1" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		<tr >
			<th colspan="5">

			<center>
				Fecha : '.$orderDate.'
				<center>Sucursal : '.$Sucursale.'</center>
				<center>Cliente : '.$clientName.'</center>			
				Teléfono : '.$clientContact.'
			</center>		
			</th>
				
		</tr>		
	</thead>
</table>
<table border="0" width="100%;" cellpadding="5" style="border:1px solid black;border-top-style:1px solid black;border-bottom-style:1px solid black;">

	<tbody>
		<tr>
			<th>#</th>
			<th>Producto</th>		
			<th>Cantidad</th>
		 
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<th>'.$x.'</th>
				<th>'.$row[4].'</th>				
				<th>'.$row[2].'</th>
				<th>0</th>
			</tr>
			';
		$x++;
		} // /while

		$table .= ' 
	</tbody>
</table>

<input type="button" name="imprimir" value="Imprimir" onclick="window.print();"> '
;
 


$connect->close();

echo $table;