<?php 	

require_once 'core.php';

//$sql = "SELECT order_id, order_date, client_name, client_contact, payment_status FROM orders WHERE order_status = 1";

  $sql = "SELECT orders_sucursale.order_id ,orders_sucursale.order_date,brands_1.brand_name,brands.brand_name, orders_sucursale.client_contact
 FROM orders_sucursale 
 INNER JOIN brands_1 ON orders_sucursale.brandCorporation = brands_1.brand_id 
INNER JOIN brands ON orders_sucursale.brandSurcursale = brands.brand_id 
WHERE   order_status = 1";
$result = $connect->query($sql);  


$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $paymentStatus = ""; 
 $x = 1;

 while($row = $result->fetch_array()) {
 	$orderId = $row[0];
 	  $countOrderItemSql = "SELECT count(*) FROM order_item_sucursale WHERE order_id = $orderId";
 	//$countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId";
 	$itemCountResult = $connect->query($countOrderItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();
/*

 	// active 
 	if($row[4] == 1) { 		
 		$paymentStatus = "<label class='label label-success'>Pago completo</label>";
 	} else if($row[4] == 2) { 		
 		$paymentStatus = "<label class='label label-info'>Pago por adelantado</label>";
 	} else { 		
 		$paymentStatus = "<label class='label label-warning'>No pagado</label>";
 	} // /else
*/
 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Acción <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    
	    <li><a type="button" onclick="printOrder('.$orderId.')"> <i class="glyphicon glyphicon-print"></i> Imprimir </a></li>
	    
	    <li><a type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>       
	  </ul>
	</div>';		

 	$output['data'][] = array( 		
 		// image
 		$x,
 		// order date
 		$row[1],
 		// corporacion
 		$row[2], 
 		//sucursal
 		$row[3], 
		// client contact
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