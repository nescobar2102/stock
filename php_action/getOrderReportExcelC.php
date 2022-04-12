<?php 

require_once 'core.php';
 
	$sql = "SELECT orders.order_id ,orders.order_date,brands.brand_name, orders.client_contact,client_name 
	FROM orders INNER JOIN brands ON orders.brandSurcursale_id = brands.brand_id WHERE order_status = 1";
	$query = $connect->query($sql);
 

$table = '
<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<th>Fecha</th> 
		<th>Sucursal </th>
		<th>Cliente </th>
		<th>Teléfono</th>
		<th>Total</th>
	</tr>

	<tr>';
	$totalAmount = "";
	while ($result = $query->fetch_assoc()) {
		//$sql1 = "SELECT SUM(quantity)  as total FROM `order_item_sucursale` WHERE order_id= $result['order_id']";
		//$query1 = $connect->query($sql1);

		$table .= '<tr>
			<td><center>'.$result['order_date'].'</center></td> 
			<td><center>'.$result['brand_name'].'</center></td>
			<td><center>'.$result['client_name'].'</center></td>
			<td><center>'.$result['client_contact'].'</center></td>
		</tr>';	
	//	$totalAmount += $result['grand_total'];
	}
	$table .= '
	</tr>

	<tr>
		<td colspan="3"><center>Total</center></td>
		<td><center>'.$totalAmount.'</center></td>
	</tr>
</table>
';	
  

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=order_salida_cliente".time().".xls"); 
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
?>