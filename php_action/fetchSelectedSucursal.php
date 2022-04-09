<?php 	

require_once 'core.php';

 $almacen = $_POST['almacenid'];


 //$sql = "SELECT product_id, product_name, product_image, brand_id, categories_id, quantity, rate, active, status FROM product WHERE product_id = $productId";
 $sql = "SELECT brand_name FROM  brands_1 WHERE brand_id = $almacen";

$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();

 
$brand = $row[0];
 //$sql = "SELECT product_id, product_name, product_image, brand_id, categories_id, quantity, rate, active, status FROM product WHERE product_id = $productId";
$sql1 = "SELECT brand_id, brand_name FROM  brands WHERE brand_name_corporation = '$brand'";
$result1 = $connect->query($sql1);
} // 

if($result1->num_rows > 0) { 
 $row1 = $result1->fetch_all();
} // if num_rows

$connect->close();

echo json_encode($row1);