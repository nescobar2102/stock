<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
 
if($_POST) {	

	$productName 		= $_POST['productName'];
  // $productImage 	= $_POST['productImage'];
  $quantity 			= $_POST['quantity'];
  $rate 					= $_POST['rate'];
  $brandName 			= $_POST['brandName'];
  //$categoryName 	= $_POST['categoryName'];
  $productStatus 	= $_POST['productStatus'];
  $sku 	= $_POST['sku'];
  $modelo 	= $_POST['modelo'];
  $ubicacion 	= $_POST['ubicacion']; 
  $fecha_ingreso 	= $_POST['orderDate']; 
					$sql = "INSERT INTO product_coorporation (product_name,  brand_id,   quantity, rate, active, sku,modelo,ubicacion,fecha_ingreso, status) 
			VALUES ('$productName',  '$brandName',   '$quantity', '$rate', '$productStatus', '$sku', '$modelo'  ,'$ubicacion' ,'$fecha_ingreso',1)";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Creado exitosamente";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error no se ha podido guardar";
				}
		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST