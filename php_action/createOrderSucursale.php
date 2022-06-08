<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
 
if($_POST) {	

  $orderDate 						= date('Y-m-d', strtotime($_POST['orderDate']));
  $brandSurcursale 					= $_POST['brandSurcursale'];
  $clientContact 				= $_POST['clientContact'];
  $clientName 					= $_POST['clientName'];
  //si inserta

  $sql = "INSERT INTO orders (order_date, client_name, brandSurcursale_id,  client_contact, order_status) 
  		  		VALUES ('$orderDate', '$clientName',  '$brandSurcursale', '$clientContact', 1)";
 
	 
	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;	
		$orderStatus = true;
	}
 
	$orderItemStatus = false;

	for($x = 0; $x < count($_POST['productName1']); $x++) {			  
		$updateProductQuantitySql = "SELECT product.quantity FROM product_coorporation as product WHERE product.product_id = ".$_POST['productName1'][$x]."";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);
		
		
		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
			$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
				// update product table
				if($updateQuantity[$x] >= 0){
						
				$updateProductTable = "UPDATE product_coorporation SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName1'][$x]."";
				$connect->query($updateProductTable);

				// add into order_item
		     	$orderItemSql = "INSERT INTO  order_item (order_id, product_id, quantity, order_item_status) 
					VALUES ('$order_id', '".$_POST['productName1'][$x]."', '".$_POST['quantity'][$x]."',  1)";

				$connect->query($orderItemSql);		
			}

				if($x == count($_POST['productName1'])) {
					$orderItemStatus = true;
				}		
		} // while	
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Agregado exitosamente";		
	
	$connect->close();

	echo json_encode($valid);
	sleep(2);
	header('Location: ../orders_sucursale.php?o=add');
 
} // /if $_POST
// echo json_encode($valid);