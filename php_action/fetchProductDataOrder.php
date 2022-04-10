<?php 	

require_once 'core.php';

$brandId = $_POST['brandId'];

$sql = "SELECT product_id, product_name FROM product_coorporation WHERE status = 1 AND active = 1 AND brand_id = $brandId";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);