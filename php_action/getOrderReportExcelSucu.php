<?php 

require_once 'core.php';
 
	$sql = "SELECT product.product_id,product_coorporation.product_name,product.quantity,product_coorporation.modelo, 
	product_coorporation.sku,product_coorporation.ubicacion,fecha_salida,brands.brand_name 
	FROM `product` 
	inner join brands on product.brand_id= brands.brand_id 
	inner join product_coorporation on product_coorporation.brand_id= brands.brand_id
	and  product_coorporation.product_id= product.product_id";
	$query = $connect->query($sql);
 

$table = '
<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
	<tr> 
		<th>Sucursal </th> 
		<th>Id producto </th> 
		<th>Producto </th> 
		<th>Total</th> 
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
			<td><center>'.$result['modelo'].'</center></td> 
			<td><center>'.$result['sku'].'</center></td>
			<td><center>'.$result['ubicacion'].'</center></td>
			<td><center>'.$result['fecha_salida'].'</center></td>
		</tr>';	
	//	$totalAmount += $result['grand_total'];
	}
	$table .= '
	</tr>
 
</table>
';	
  

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=inventario_sucursal_".time().".xls"); 
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
?>