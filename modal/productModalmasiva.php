<!-- add product -->
<div class="modal fade" id="addProductModalMasiva" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Carga Masiva DarkStore</h4>
	      </div>
    <div class="modal-body" style="max-height:450px; overflow:auto;">

	     <div id="add-product-messages"></div>
		 <form enctype="multipart/form-data" method="post" action="php_action/createProductmasiva.php">
			 <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label">Coorporacion: </label>	         
				    <div class="col-sm-8">
				      <select class="form-control" id="brandName" name="brandName">
				      	<option value="">-- Selecciona --</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands_1 WHERE brand_status = 1 AND brand_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
	        </div> 
							<br> 
							<hr> 
			<div class="form-group">
				<label for="brandName" class="col-sm-3 control-label">CSV File: </label>
				<div class="col-sm-8">	
					<input  class="form-control" type="file" name="file" id="file">
					</div> 
			</div> 
			<div class="form-group">
				<div class="col-sm-8">	
					<input type="submit" class="btn btn-primary" value="Importar" name="enviar" >
				</div> 
			</div> 
		</form>
	</div> 
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
								

 