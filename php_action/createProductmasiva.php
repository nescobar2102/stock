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
				 
						$targetPath = 'subidas/' . $_FILES['file']['name'];
						move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
						 
						$Reader = new Xlsx();
										
						$spreadSheet = $Reader->load($targetPath);
						$excelSheet = $spreadSheet->getActiveSheet();
						$spreadSheetAry = $excelSheet->toArray();
						$sheetCount = count($spreadSheetAry);					 
						for ($i = 1; $i <  $sheetCount; $i ++) {
		
							$sku = "";
							if (isset($spreadSheetAry[$i][0])) {
								 	$sku = mysqli_real_escape_string($connect, $spreadSheetAry[$i][0]);
							}
							$stock = "";
							if (isset($spreadSheetAry[$i][1])) {
								 	$stock = mysqli_real_escape_string($connect, $spreadSheetAry[$i][1]);
							}
							$tipo_doc = "";
							if (isset($spreadSheetAry[$i][2]) ) {
								 	$tipo_doc = mysqli_real_escape_string($connect, $spreadSheetAry[$i][2]);
							}
							$nro_doc = "";
							if (isset($spreadSheetAry[$i][3]) ) {
								 	$nro_doc = mysqli_real_escape_string($connect, $spreadSheetAry[$i][3]);
							}
							$fecha_ingreso = "";
							if (isset($spreadSheetAry[$i][4]) ) {
								 	$fecha_ingreso = mysqli_real_escape_string($connect, $spreadSheetAry[$i][4]);
							}
							$responsable = "";
							if (isset($spreadSheetAry[$i][5]) ) {
								 	$responsable = mysqli_real_escape_string($connect, $spreadSheetAry[$i][5]);
							}
							$lote = "";
							if (isset($spreadSheetAry[$i][6]) ) {
								 	$lote = mysqli_real_escape_string($connect, $spreadSheetAry[$i][6]);
							}
							$fecha_venc = "";
							if (isset($spreadSheetAry[$i][7]) ) {
								 	$fecha_venc = mysqli_real_escape_string($connect, $spreadSheetAry[$i][7]);
							}
							$observacion = "";
							if (isset($spreadSheetAry[$i][8]) ) {
								 	$observacion = mysqli_real_escape_string($connect, $spreadSheetAry[$i][8]);
							}
 
								if (! empty($sku) || !empty($stock) || !empty($lote)  ) {
						 	   $sql = "SELECT  quantity,product_name,lote from product_coorporation where sku = $sku and brand_id = $brandName ";
							
									$result = $connect->query($sql);
	
								if($result->num_rows > 0) {  
									$cantidad_old =0;
									$row = $result->fetch_array();
									  if($row[0]!=''){									 
										$cantidad_old = $row[0];
									}
								 
									if($row[2] == $lote ||  $row[2]=='') { //si el lote ya existe se actualiza la cantidad
								 	$cantidad_new =	intval($cantidad_old) + $stock;
										
								  	$sql_update = "UPDATE product_coorporation SET quantity = $cantidad_new, fecha_ingreso = '$fecha_ingreso',  tipo_doc= '$tipo_doc',nro_doc = '$nro_doc',
									   responsable = '$responsable', fecha_venc = '$fecha_venc', observacion = '$observacion', lote ='$lote'
									    WHERE sku = {$sku} and brand_id = {$brandName}  ";
										$flag =$connect->query($sql_update); 
									}else { 

								    $sql = "INSERT INTO product_coorporation (brand_id, status,active,fecha_ingreso, product_name, quantity,  sku,tipo_doc,nro_doc,responsable,lote,fecha_venc,observacion) 
											VALUES ('$brandName', 1, 1,
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
										$flag = $connect->query($sql);
									}
								} 

							 	$sql_car = "INSERT INTO carga_productos (sku, fecha_carga,stock,brand_id,lote) 
								VALUES ('$sku', CURDATE() ,'$stock','$brandName' ,$lote)";
								$connect->query($sql_car);
							 
		
								}
 
							}
			  
						
					}
		 
			 header('Location: ../product.php');
	 
} 