<?php 	

require_once 'core.php';

$orderId = $_GET['orderId'];

//$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

$sql = "SELECT order_date, brands_1.brand_name AS corporation, client_contact, brands.brand_name 
FROM orders_sucursale 
INNER JOIN brands_1 ON brands_1.brand_id = orders_sucursale.brandCorporation
 INNER JOIN brands ON brands.brand_id = orders_sucursale.brandSurcursale
  WHERE order_id= $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2]; 
$Sucursale = $orderData[3];
/*
$vat = $orderData[4];
$totalAmount = $orderData[5]; 
$discount = $orderData[6];
$grandTotal = $orderData[7];
$paid = $orderData[8];
$due = $orderData[9];*/


$orderItemSql = "SELECT order_item_sucursale.product_id, order_item_sucursale.rate, order_item_sucursale.quantity,
 order_item_sucursale.total, product_coorporation.product_name 
FROM order_item_sucursale
 INNER JOIN product_coorporation ON order_item_sucursale.product_id = product_coorporation.product_id
  WHERE order_item_sucursale.order_id= $orderId";
$orderItemResult = $connect->query($orderItemSql);

 echo $table = '
 <table border="1" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		<tr >
			<th colspan="5">

			<center>
				Fecha : '.$orderDate.'
				<center>Corporation : '.$clientName.'</center>
				<center>Surcursal : '.$Sucursale.'</center>
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