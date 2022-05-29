<?php 	
ini_set('memory_limit', '-1');
set_time_limit(420);
require_once 'core.php';
 
require  '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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
			}else{
				$allowedFileType = [
					'application/vnd.ms-excel',
					'text/xls',
					'text/xlsx',
					'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
					];
					if (in_array($_FILES["file"]["type"], $allowedFileType)) {
						$targetPath = 'subidas/' . $_FILES['file']['name'];
						move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
						
						//$Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
						$Reader = new Xlsx();
										
						$spreadSheet = $Reader->load($targetPath);
						$excelSheet = $spreadSheet->getActiveSheet();
						$spreadSheetAry = $excelSheet->toArray();
						$sheetCount = count($spreadSheetAry);					 
						for ($i = 1; $i <  $sheetCount; $i ++) {
		
							$sku = "";
							if (isset($spreadSheetAry[$i][1])) {
									$sku = mysqli_real_escape_string($connect, $spreadSheetAry[$i][1]);
							}
							$stock = "";
							if (isset($spreadSheetAry[$i][2])) {
									$stock = mysqli_real_escape_string($connect, $spreadSheetAry[$i][2]);
							}
							$n_guia = "";
							if (isset($spreadSheetAry[$i][3]) ) {
								$n_guia = mysqli_real_escape_string($connect, $spreadSheetAry[$i][3]);
							}
								if (! empty($sku) || !empty($descripcion) ) {
								echo $sql = "SELECT sku,quantity from product_coorporation where sku = $sku and brand_id = $brandName";
									$result = $connect->query($sql);
	
								if($result->num_rows > 0) {  
									$row = $result->fetch_array();
									$cantidad_new =	$row[0] + $stock;
										
									$sql_update = "UPDATE product_coorporation SET quantity = $cantidad_new, fecha_ingreso = 'CURDATE()' WHERE sku = {$sku}";
									$flag =$connect->query($sql_update); 
	
								} 

								$sql_car = "INSERT INTO carga_productos (sku, fecha_carga,stock,brand_id) 
								VALUES ('$sku','CURDATE()','$stock','$brandName' )";
								$connect->query($sql_car);
								/* $sql = "INSERT INTO product_coorporation (brand_id, status,active,fecha_ingreso, product_name, sku, modelo,rate) 
										VALUES ('$brandName', 1, 1,
												 CURDATE() , 
												'$descripcion', 
												'$sku',
												'$unidad_medida',
												'$precio' 
												)";
									$flag = $connect->query($sql);    */
		
								}

							}
			 
					}  else {
						$type = "danger";
						$message = "Tipo de archivo invalido. Cargar archivo de Excel.";
						}
						
					}
		 
			 header('Location: ../product.php');
		//	echo json_encode($valid);
} 