<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$brandName = $_POST['editBrandName'];
	$contacto = $_POST['editBrandName1'];
  $brandStatus = $_POST['editBrandStatus']; 
  $brandId = $_POST['brandId'];

	$sql = "UPDATE brands_1 SET brand_name = '$brandName',contacto = '$contacto',brand_active = '$brandStatus' WHERE brand_id = '$brandId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Actualizado exitosamente";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error no se ha podido actualizar";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST