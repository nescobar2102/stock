<?php 

require_once 'core.php';
 
	$sql = "SELECT  `order_id`, `order_date`,   `client_contact`,   brands_1.brand_name AS corporation, brands.brand_name 
	FROM orders_sucursale 
	INNER JOIN brands_1 ON brands_1.brand_id = orders_sucursale.brandCorporation
	INNER JOIN brands ON brands.brand_id = orders_sucursale.brandSurcursale
	WHERE  order_status = 1";
	$query = $connect->query($sql);
 

$table = '
<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<th>Fecha</th>
		<th>Almacén </th>
		<th>Sucursal </th>
		<th>Teléfono</th>
	</tr>

	<tr>';
	$totalAmount = "";
	while ($result = $query->fetch_assoc()) {
		//$sql1 = "SELECT SUM(quantity)  as total FROM `order_item_sucursale` WHERE order_id= $result['order_id']";
		//$query1 = $connect->query($sql1);

		$table .= '<tr>
			<td><center>'.$result['order_date'].'</center></td>
			<td><center>'.$result['corporation'].'</center></td>
			<td><center>'.$result['brand_name'].'</center></td>
			<td><center>'.$result['client_contact'].'</center></td>
		</tr>';	
	//	$totalAmount += $result['grand_total'];
	}
	$table .= '
	</tr>


</table>
';	
  

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=order_salida_".time().".xls"); 
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
?>