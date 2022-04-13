<?php 

require_once 'core.php';
 
	$sql = "SELECT brand_name, product_name, product_id ,stock, fecha_carga,carga_productos.sku from carga_productos
	 inner join brands_1 on carga_productos.brand_id= brands_1.brand_id
	 inner join product_coorporation on product_coorporation.sku= carga_productos.sku";
	$query = $connect->query($sql);
 
 

$table = '
<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
	<tr> 
		<th>Almacén </th> 
		<th>Id producto </th> 
		<th>Producto </th> 
		<th>Stock Cargado</th>  
		<th>SKU </th>   
		<th>Fecha Ingreso </th>
		
	</tr>

	<tr>'; 
	while ($result = $query->fetch_assoc()) {
		 

		$table .= '<tr>
			<td><center>'.$result['brand_name'].'</center></td>
			<td><center>'.$result['product_id'].'</center></td>
			<td><center>'.$result['product_name'].'</center></td>
			<td><center>'.$result['stock'].'</center></td>	  
			<td><center>'.$result['sku'].'</center></td> 
			<td><center>'.$result['fecha_carga'].'</center></td>
		</tr>';	 
	}
	$table .= '
	</tr>
 
</table>
';	
  

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=historico_carga_masiva_".time().".xls"); 
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
?>