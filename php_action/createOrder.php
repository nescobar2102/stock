<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
// print_r($valid);
if($_POST) {	

  $orderDate 						= date('Y-m-d', strtotime($_POST['orderDate']));	
  $brandCorporation 					= $_POST['brandCorporation'];
  $brandSurcursale 					= $_POST['brandSurcursale'];
  $clientContact 				= $_POST['clientContact'];

  //si inserta
   $sql = "INSERT INTO orders_sucursale (order_date, brandCorporation, brandSurcursale,  client_contact, order_status) 
  		  		VALUES ('$orderDate', '$brandCorporation', '$brandSurcursale', '$clientContact', 1)";
	 
	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;	
		$orderStatus = true;
	}
 
	$orderItemStatus = false;

	for($x = 0; $x < count($_POST['productName']); $x++) {			 
		$updateProductQuantitySql = "SELECT product.quantity FROM product_coorporation as product WHERE product.product_id = ".$_POST['productName'][$x]."";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);
		
		
		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
			$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
				// update product table
			 	$updateProductTable = "UPDATE product_coorporation SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
				$connect->query($updateProductTable);

		 	  $orderItemSql = "INSERT INTO  order_item_sucursale (order_id, product_id, quantity, order_item_status) 
					VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."',  1)";

					$connect->query($orderItemSql);		

				 	 $productSucursale = "INSERT INTO  product ( product_id,brand_id, quantity, status, fecha_salida) 
					VALUES ('".$_POST['productName'][$x]."','$brandSurcursale', '".$_POST['quantity'][$x]."',  1,'$orderDate')";

				$connect->query($productSucursale);		

				if($x == count($_POST['productName'])) {
					$orderItemStatus = true;
				}		
		} // while	
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Agregado exitosamente";		
	
	$connect->close();

	echo json_encode($valid);
	sleep(10);
	header('Location: ../orders.php?o=add'); 
 
} // /if $_POST
// echo json_encode($valid);