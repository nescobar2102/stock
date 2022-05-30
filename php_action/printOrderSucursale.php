<?php 	

require_once 'core.php';

//$orderId = $_POST['orderId'];
$orderId = $_GET['orderId'];
//$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

$sql = "SELECT order_date, brands.brand_name AS sucursal, client_contact,client_name ,n_guia
FROM orders INNER JOIN brands ON brands.brand_id = orders.brandSurcursale_id
 WHERE order_id= $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[3];
$clientContact = $orderData[2]; 
$Sucursale = $orderData[1];
$n_guia = $orderData[4];


 $orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity,
order_item.total, product_coorporation.product_name 
FROM order_item INNER JOIN product_coorporation ON order_item.product_id = product_coorporation.product_id 
WHERE order_item.order_id=  $orderId";
$orderItemResult = $connect->query($orderItemSql);
$count =  $orderItemResult->num_rows ;
 $table = '
 <div >
 <table border="1" cellspacing="5" cellpadding="5" width="30%">
	<thead>
		<tr >
			<th colspan="5">

			<center>
			<center>REMITENTE </center> 
				NOMBRE : '.$Sucursale.'<br>
				FECHA : '.$orderDate.'<br>
				<center> 
				Nº de Guía: : '.$n_guia.'</center>
				<center>DIRECCION : '.$clientName.'</center> 
			</center>		
			</th>
				
		</tr>		
	</thead>
</table>
<table border="1" cellspacing="05" cellpadding="5" width="30%">
<thead>
	<tr>
		<th colspan="5"> 
		<center>
		<center>DESTINATARIO </center> 
			NOMBRE : '.$clientName.' <br>
			TLEFONO : '.$clientContact.'<br>
			<center>  
			<center>DIRECCION : '.$clientName.'</center> 
		</center>		
		</th> 
	</tr>		
</thead>
</table>
<table border="1" cellspacing="0" cellpadding="5" width="30%">
<thead>
	<tr>
		<th colspan="5">  
		<center>NRO.PIEZAS: '.$count.' | PESO:0 KG  </center>  
		</th> 
	</tr>		
	
</thead>
</table>
<table border="1" width="30%;" cellpadding="5" >

	<tbody>
		<tr> 
			<th>Producto</th>		
			<th>Cantidad</th> 
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
			 
				<th>'.$row[4].'</th>				
				<th>'.$row[2].'</th> 
			</tr>
			';
		$x++;
		} // /while

		$table .= ' 
	</tbody>
</table>
<br>
<input type="button" name="imprimir" value="Imprimir" onclick="window.print();"> '
;
 


$connect->close();

echo $table;