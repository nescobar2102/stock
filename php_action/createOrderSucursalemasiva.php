<?php 	

ini_set('memory_limit', '-1');
set_time_limit(420);
require_once 'core.php';
 
require  '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
 
if (isset($_POST['enviar'])){
	
	$brandSurcursale = $_POST['brandName'];
		  
	$allowedFileType = [
		'application/vnd.ms-excel',
		'text/xls',
		'text/xlsx',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];
		if (in_array($_FILES["file"]["type"], $allowedFileType)) {
			$targetPath = 'subidas/' . $_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
			 
			$Reader = new Xlsx();
							
			$spreadSheet = $Reader->load($targetPath);
			$excelSheet = $spreadSheet->getActiveSheet();
			$spreadSheetAry = $excelSheet->toArray();
			$sheetCount = count($spreadSheetAry);					 
			for ($i = 1; $i <  $sheetCount; $i ++) { 
				$guia = "";
				if (isset($spreadSheetAry[$i][0])) {
						 $guia = mysqli_real_escape_string($connect, $spreadSheetAry[$i][0]);
				}
				$fecha = "";
				if (isset($spreadSheetAry[$i][1])) {
					  $fecha = mysqli_real_escape_string($connect, $spreadSheetAry[$i][1]);
				}
				$clientName = "";
				if (isset($spreadSheetAry[$i][2]) ) {
						 $clientName = mysqli_real_escape_string($connect, $spreadSheetAry[$i][2]);
				}
				$client_contact = "";
				if (isset($spreadSheetAry[$i][3]) ) {
						 $client_contact = mysqli_real_escape_string($connect, $spreadSheetAry[$i][3]);
				}
				$sku = "";
				if (isset($spreadSheetAry[$i][4]) ) {
						 $sku = mysqli_real_escape_string($connect, $spreadSheetAry[$i][4]);
				}
				$stock = "";
				if (isset($spreadSheetAry[$i][5]) ) {
						 $stock = mysqli_real_escape_string($connect, $spreadSheetAry[$i][5]);
				} 

				if (! empty($sku) &&!empty($stock) && !empty($clientName) && !empty($guia)  ) {

			echo	$sql = "SELECT  order_id from orders where n_guia ='$guia' and brandSurcursale_id = $brandSurcursale";
							
				$result = $connect->query($sql);
				$order_id; 	
				if($result->num_rows == 0) {  
					echo "no existe la guia".$guia;
				 
					$sql = "INSERT INTO orders (order_date, client_name, brandSurcursale_id,  client_contact, order_status,	n_guia) 
					VALUES ('$fecha', '$clientName',  '$brandSurcursale', '$client_contact', 1,'$guia')"; 
					
						if($connect->query($sql) === true) {
							$order_id = $connect->insert_id;
							$valid['order_id'] = $order_id;	 
						}
					} else {
						$row = $result->fetch_array();  
						$order_id = $row[0];
						echo "si existe la guia".$guia." con el id order".$order_id;
					 }
				}
				 
					
			    $updateProductQuantitySql = "SELECT product.quantity,  product.product_id FROM product_coorporation as product 
					WHERE product.sku = '$sku' and brand_id='$brandSurcursale'";
				$updateProductQuantityData = $connect->query($updateProductQuantitySql);				
						
						while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
							$updateQuantity = $updateProductQuantityResult[0] - $stock;	
							$product_id  = $updateProductQuantityResult[1];			
								// update product table
								if($$updateQuantity>=0){
								// 	$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName1'][$x]."";
									$updateProductTable = "UPDATE product_coorporation SET quantity = '".$updateQuantity."' WHERE sku =  '$sku'  and brand_id='$brandSurcursale'";
									$connect->query($updateProductTable);
					
									// add into order_item
									$orderItemSql = "INSERT INTO  order_item (order_id, product_id, quantity, order_item_status) 
										VALUES ('$order_id', '".$product_id."', '$stock',  1)";
				
									$connect->query($orderItemSql);
									}	
						 
								
						} // while	
				 

					/* $sql_car = "INSERT INTO carga_productos (sku, fecha_carga,stock,brand_id) 
						VALUES ('$sku', CURDATE() ,'$stock','$brandName' )";
						$connect->query($sql_car);*/
				 

					}
 
 
		}  else {
			$type = "danger";
			$message = "Tipo de archivo invalido. Cargar archivo de Excel.";
	   } 
	 
		$connect->close(); 
		sleep(2);
		header('Location: ../orders_sucursale.php?o=add');
 
}  
// echo json_encode($valid);