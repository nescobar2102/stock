<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'modal/productModal.php'; ?>
<?php require_once 'modal/productModalmasiva.php'; 

$id = $_GET['id'];
?>
 
<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Inicio</a></li>		  
		  <li class="active">Produtos Maestros </li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Produtos Maestros</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">
			<input id="brand_id_ver" type="text" value="<?=$id;?>">
				<div class="remove-messages"></div>

				<!--div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Ingresar Stock </button>
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtnMasiva" data-target="#addProductModalMasiva"> <i class="glyphicon glyphicon-plus-sign"></i> Carga masiva Stock </button>
				</div--> <!-- /div-action -->				
				
				<table class="table" id="manageProductTable">
					<thead>
						<tr> 						
							<th>Nombre del producto</th>
							<th>Fecha Ingreso</th>	 
							<th>Almacén</th>
							<th>SKU</th> 
							<th>Unidad Medida</th> 
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






<script src="custom/js/product_maestro.js"></script>

<?php require_once 'includes/footer.php'; ?>