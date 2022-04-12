<?php 

require_once 'core.php';
 
	$sql = "SELECT product_id, product_name,quantity,rate,modelo,sku,ubicacion,fecha_ingreso,brand_name 
	FROM `product_coorporation` inner join brands_1 on product_coorporation.brand_id= brands_1.brand_id";
	$query = $connect->query($sql);
 

$table = '
<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
	<tr> 
		<th>Almacén </th> 
		<th>Id producto </th> 
		<th>Producto </th> 
		<th>Total</th>
		<th>Precio </th> 
		<th>Modelo </th>
		<th>SKU </th>  
		<th>Ubicacion </th>
		<th>Fecha Ingreso </th>
		
	</tr>

	<tr>';
	$totalAmount = "";
	while ($result = $query->fetch_assoc()) {
		 

		$table .= '<tr>
			<td><center>'.$result['brand_name'].'</center></td>
			<td><center>'.$result['product_id'].'</center></td>
			<td><center>'.$result['product_name'].'</center></td>
			<td><center>'.$result['quantity'].'</center></td>			
			<td><center>'.$result['rate'].'</center></td>
			<td><center>'.$result['modelo'].'</center></td> 
			<td><center>'.$result['sku'].'</center></td>
			<td><center>'.$result['ubicacion'].'</center></td>
			<td><center>'.$result['fecha_ingreso'].'</center></td>
		</tr>';	
	//	$totalAmount += $result['grand_total'];
	}
	$table .= '
	</tr>
 
</table>
';	
  

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventario_principal_".time().".xls"); 
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
?>