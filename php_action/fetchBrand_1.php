<?php 	

require_once 'core.php';

$sql = "SELECT brand_id, brand_name, contacto, brand_active, brand_status FROM brands_1 WHERE brand_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$brandId = $row[0];
 	// active 
 	if($row[3] == 1) {
 		// activate member
 		$activeBrands = "<label class='label label-success'>Disponible</label>";
 	} else {
 		// deactivate member
 		$activeBrands = "<label class='label label-danger'>No disponible</label>";
 	}

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Acción <span class="caret"></span>
	  </button>
	
	  <ul class="dropdown-menu">
	  <li><a type="button" onclick="addStockBrand('.$brandId.')"> <i class="glyphicon glyphicon-edit"></i> Stock</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands('.$brandId.')"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands('.$brandId.')"> <i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>       
	  </ul> 
  </button>
 
	 
	
  </div>';

 	$output['data'][] = array( 		
 		$row[1], 	
		$row[2], 		
 		$activeBrands,
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);