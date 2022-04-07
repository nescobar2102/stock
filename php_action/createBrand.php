<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$brandName = $_POST['brandName'];
  $brandStatus = $_POST['brandStatus']; 
  $brandCorporation = $_POST['brandCorporation']; 
 

	$sql = "INSERT INTO brands (brand_name, brand_active, brand_status,brand_name_corporation) VALUES ('$brandName', '$brandStatus', 1, '$brandCorporation')";
echo $sql;
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