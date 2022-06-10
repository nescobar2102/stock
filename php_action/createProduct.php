<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
 
if($_POST) {	

 
  $stock 			= $_POST['quantity']; 
  $brandName 			= $_POST['brandName']; 
  $productStatus 	= $_POST['productStatus'];
  $sku 	= $_POST['sku'];
  $tipo_doc 	= $_POST['tipo_doc'];
  $nro_doc 	= $_POST['nro_doc']; 
  $responsable 	= $_POST['responsable']; 
  $fecha_ingreso 	= $_POST['orderDate']; 
  $fecha_venc	= $_POST['orderDateven']; 
  $lote = $_POST['lote'];  
  $observacion 	= $_POST['observacion']; 

  			$cantidad_old =0;
			 $sql = "SELECT  quantity, product_name,lote,product_id from product_coorporation where sku = '$sku' and brand_id = $brandName and lote= '$lote' ";										
			$result = $connect->query($sql);

			if($result->num_rows > 0) {  			 
				$row = $result->fetch_array();
				if($row[0]!=''){									 
					$cantidad_old = $row[0];
				}
			
		 		if($row[2] == $lote ) { //si el lote ya existe se actualiza la cantidad
				$cantidad_new =	intval($cantidad_old) + $stock;
				   
			 	 $sql_update = "UPDATE product_coorporation SET quantity = $cantidad_new, fecha_ingreso = '$fecha_ingreso',  tipo_doc= '$tipo_doc',nro_doc = '$nro_doc',
				  responsable = '$responsable', fecha_venc = '$fecha_venc', observacion = '$observacion', lote ='$lote',active ='$productStatus'
				   WHERE product_id = {$row[3]} ";

				    if($connect->query($sql_update) === TRUE) {
						$valid['success'] = true;
						$valid['messages'] = "Creado exitosamente";	
					} else {
						$valid['success'] = false;
						$valid['messages'] = "Error no se ha podido guardar";
					}
				 
			   } else { 

			    $sql = "INSERT INTO product_coorporation (brand_id, status,active,fecha_ingreso, product_name, quantity, sku,tipo_doc,nro_doc,responsable,lote,fecha_venc,observacion) 
					   VALUES ('$brandName', '$productStatus', '$productStatus',
							   '$fecha_ingreso', 
							   '$row[1]',
							   '$stock',
							   '$sku', 
							   '$tipo_doc', 
							   '$nro_doc', 
							   '$responsable', 
							   '$lote',
							   '$fecha_venc',
							   '$observacion'
							   )"; 
			
			   if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Datos actualizados exitosamente";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error no se ha podido guardar";
				}
			}
			 
		}
			   
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST