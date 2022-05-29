<?php 	



require_once 'core.php';
$almacen = $_GET['id'];

   $sql = "SELECT product.product_id, product.product_name,product.sku, brands.brand_name,
 		product.fecha_ingreso,product.quantity, product.active, product.brand_id, product.status, product.ubicacion,product.modelo 
		FROM product_coorporation as product
			INNER JOIN brands as brands 
			ON product.brand_id = brands.brand_id
			WHERE product.status = 1 and brands.brand_id=$almacen";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];
 	// active 
 	if($row[6] == 1) {
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

						 
 	$output['data'][] = array( 		 	 
 		$row[1], 
		 $row[2], 
		 $row[3], 
		 $row[4], 
		 $row[5],  
 		// active
 		$active,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);