<?php 	

require_once 'core.php';

//$sql = "SELECT order_id, order_date, client_name, client_contact, payment_status FROM orders WHERE order_status = 1";

 $sql = "SELECT orders.order_id ,orders.n_guia,orders.order_date,brands.brand_name, orders.client_contact,client_name 
 FROM orders INNER JOIN brands ON orders.brandSurcursale_id = brands.brand_id WHERE order_status = 1
 ";
$result = $connect->query($sql);  


$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $paymentStatus = ""; 
 $x = 1;

 while($row = $result->fetch_array()) {
 	$orderId = $row[0];
 	  $countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId"; 
 	$itemCountResult = $connect->query($countOrderItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();
 
 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Acción <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">  
	    <li><a type="button" onclick="printOrder('.$orderId.')"> <i class="glyphicon glyphicon-print"></i> Imprimir </a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>       
	  </ul>
	</div>';		

 	$output['data'][] = array( 	
		$orderId,
 		$row[1],
		$row[2], 
		$row[5], 	 
 		$row[3],  
		$row[4], 		 	
 		$itemCountRow, 		 
 		// button
 		$button 		
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);