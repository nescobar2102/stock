<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
 
	$brandName = $_POST['brandName'];
	$contacto = $_POST['contacto']; 
    $brandStatus = $_POST['brandStatus']; 

    $sql = "INSERT INTO brands_1 (brand_name, brand_active, brand_status,contacto) VALUES ('$brandName', '$brandStatus', 1,'$contacto')";
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