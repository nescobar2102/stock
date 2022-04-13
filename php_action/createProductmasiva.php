<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
 
if (isset($_POST['enviar']))
{
		 
		 	$brandName = $_POST['brandName'];
		 
	 	$filename=$_FILES["file"]["name"];
			$info = new SplFileInfo($filename);
			$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
 
		 	if($extension == 'csv')
			{
				
				$filename = $_FILES['file']['tmp_name'];
				$handle = fopen($filename, "r");
				$flag = true;
				$i=0;
			while( ($data = fgetcsv($handle, 1000, ",") ) !== FALSE )
				{
			 
			//	 if($i>0){
					$sql = "SELECT quantity FROM `product_coorporation` where sku = $data[4]";
							$result = $connect->query($sql);

							if($result->num_rows > 0) {  
								$row = $result->fetch_array();
								$cantidad_new =	$row[0] + $data[2];
									
								$sql_update = "UPDATE product_coorporation SET quantity = $cantidad_new, fecha_ingreso = '$data[0]' WHERE sku = {$data[4]}";
								$flag =$connect->query($sql_update); 

							}else{   
							$sql = "INSERT INTO product_coorporation (brand_id, status,active,fecha_ingreso, product_name, quantity, rate, sku, modelo,ubicacion) 
								VALUES ('$brandName', 1, 1,
										'$data[0]', 
										'$data[1]',
										'$data[2]',
										'$data[3]',
										'$data[4]',
										'$data[5]',
										'$data[6]'
										)";
							$flag = $connect->query($sql);


					} 
			// } 
			//registro de carga masiva
			$sql_car = "INSERT INTO carga_productos (sku, fecha_carga,stock,brand_id) 
				VALUES ('$data[4]','$data[0]','$data[2]','$brandName'	)";
				$connect->query($sql_car);
			
			$i++;
							
			} 
			if($flag === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Carga exitosamente";	
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error no se ha podido cargar el archivo, revise el formato";
			} 
				$connect->close();

				fclose($handle);
			}
			 header('Location: ../product.php');
		//	echo json_encode($valid);
} 