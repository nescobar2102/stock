<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$orderId = $_POST['orderId'];

if($orderId) { 

 //$sql = "UPDATE orders SET order_status = 2 WHERE order_id = {$orderId}";
 $sql = "UPDATE orders_sucursale SET order_status = 2 WHERE order_id = {$orderId}";

 //$orderItem = "UPDATE order_item SET order_item_status = 2 WHERE  order_id = {$orderId}";
 $orderItem = "UPDATE order_item_sucursale SET order_item_status = 2 WHERE  order_id = {$orderId}";

 if($connect->query($sql) === TRUE && $connect->query($orderItem) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Eliminado exitosamente";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error al eliminar la orden de salida";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST