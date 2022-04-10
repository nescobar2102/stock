<?php 	

require_once 'core.php';

$brandId = $_POST['brandId'];

//echo $sql = "SELECT product_id, product_name FROM product_coorporation WHERE status = 1 AND active = 1 AND 	brand_id = $brandId";
  $sql = " SELECT product_coorporation.product_id, product_coorporation.product_name ,product.brand_id,product.quantity
   FROM product_coorporation INNER JOIN product on product.product_id= product_coorporation.product_id WHERE   product.brand_id = $brandId";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);