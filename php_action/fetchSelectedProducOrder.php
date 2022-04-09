<?php 	

require_once 'core.php';
 
 $almacen = $_POST['almacenid'];
 
  
 //$sql = "SELECT product_id, product_name, product_image, brand_id, categories_id, quantity, rate, active, status FROM product WHERE product_id = $productId";
$sql1 = "SELECTproduct_id, product_name, quantity FROM  product_coorporation WHERE brand_id = $almacen";
$result1 = $connect->query($sql1);
 

if($result1->num_rows > 0) { 
 $row1 = $result1->fetch_all();
} // if num_rows

$connect->close();

echo json_encode($row1);