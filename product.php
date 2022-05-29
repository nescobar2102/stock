<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'modal/productModal.php'; ?>
<?php require_once 'modal/productModalmasiva.php'; ?>
<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Inicio</a></li>		  
		  <li class="active">Stock DarkStore</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>   Stock DarkStore</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">
			<div class="form-group">
	        	<label for="brandName" class="col-sm-2 control-label">Almacén: </label>	         
				    <div class="col-sm-3">
				      <select class="form-control" id="brandName" name="brandName"  onchange="listarProductos(this)" >
				      	<option value="">-- Selecciona --</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands  WHERE brand_status = 1 AND brand_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
	        </div> 
			<br>

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Ingresar Stock </button>
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtnMasiva" data-target="#addProductModalMasiva"> <i class="glyphicon glyphicon-plus-sign"></i> Carga masiva Stock </button>
				</div> <!-- /div-action -->				
				
				<table class="table" id="manageProductTable">
					<thead>
						<tr> 						
							<th>Nombre del producto</th>
							<th>SKU</th>
							<th>Almacén</th>
							<th>Fecha Ingreso</th>							
							<th>Stock</th>		 
							<th>Estado</th>
							<th style="width:15%;">Opciones</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row --> 


<script src="custom/js/product.js"></script>

<?php require_once 'includes/footer.php'; ?>