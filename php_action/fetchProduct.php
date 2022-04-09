<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image,
		product.brand_id, product.quantity, product.fecha_ingreso, product.active, product.status,
		brands.brand_name,product.sku,product.ubicacion,product.modelo
		FROM product_coorporation as product
			INNER JOIN brands_1 as brands 
			ON product.brand_id = brands.brand_id
			WHERE product.status = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];
 	// active 
 	if($row[7] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Disponible</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>No disponible</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Acción <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>       
	  </ul>
	</div>';
 
	$brand = $row[8]; 
	$sku = $row[9];
	$ubicacion = $row[10];
	$modelo = $row[11]; 

 	$output['data'][] = array( 		 	 
 		$row[1], 
 		// rate
 		$row[5],
 		// quantity 
 		$row[4], 		 	
 		// brand
 		$brand, 
		 //sku
		$sku,
		//ubicacion
		$ubicacion,
		 //modelo
		$modelo,
 		// active
 		$active,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);