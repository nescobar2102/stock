<?php 

require_once 'core.php';

if($_POST) {

	$startDate = $_POST['startDate'];
	$date = DateTime::createFromFormat('m/d/Y',$startDate);
	$start_date = $date->format("Y-m-d");


	$endDate = $_POST['endDate'];
	$format = DateTime::createFromFormat('m/d/Y',$endDate);
	$end_date = $format->format("Y-m-d");

//	echo $sql = "SELECT * FROM orders_sucursale  WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
	 $sql = "SELECT  `order_id`, `order_date`,   `client_contact`,   brands_1.brand_name AS corporation, brands.brand_name 
			FROM orders_sucursale 
			INNER JOIN brands_1 ON brands_1.brand_id = orders_sucursale.brandCorporation
			INNER JOIN brands ON brands.brand_id = orders_sucursale.brandSurcursale
		   WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
	$query = $connect->query($sql);

 
	 

	$table = '
	<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>Fecha</th>
			<th>Corporacion </th>
			<th>Sucursal </th>
			<th>Teléfono</th>
			<th>Total</th>
		</tr>

		<tr>';
		$totalAmount = "";
		while ($result = $query->fetch_assoc()) {
			$sql1 = "SELECT SUM(quantity)  as total FROM `order_item_sucursale` WHERE order_id= $result['order_id']";
			$query1 = $connect->query($sql1);

			$table .= '<tr>
				<td><center>'.$result['order_date'].'</center></td>
				<td><center>'.$result['corporation'].'</center></td>
				<td><center>'.$result['brand_name'].'</center></td>
				<td><center>'.$result['client_contact'].'</center></td>
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

	echo $table;

}

?>