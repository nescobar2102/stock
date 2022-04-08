<?php 	

require_once 'core.php';

 $productId = $_POST['productId'];

//$sql = "SELECT product_id, product_name, product_image, brand_id, categories_id, quantity, rate, active, status FROM product WHERE product_id = $productId";
$sql = "SELECT product_id, product_name,  brand_id,  quantity, rate, active, status FROM product_coorporation WHERE product_id = $productId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);