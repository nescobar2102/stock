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
			 
				 if($i>0){
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