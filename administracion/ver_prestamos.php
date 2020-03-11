<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "administracion";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	
		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_GET['id']; // OBTIENE EL ID A EDITAR

		$sql = "SELECT * FROM clientes WHERE id_cliente = ".$id;
		$result1=$mysqli->query($sql);
		$row1 = $result1->fetch_assoc();
		
		$title = 'Listado de prestamos';
		include('head.php');
		$active_clientes="active";
    ?>
</head>
<body onload="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">
        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    <a class="btn btn-danger">Listado de prestamos</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<a href="lista_clientes.php?numero=1" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar</a>
				</div>
				<h4><i class='glyphicon glyphicon-briefcase'></i> Datos del cliente</h4>
			</div>	

			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tr>
						<td width="20%" align="right"><label for="nombre">Nombre:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo Convertir($row1['nombre']); ?>" disabled>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="dpi">DPI:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="dpi" name="dpi" type="text" value="<?php echo dpi($row1['dpi'], 'input'); //DPI ?>" disabled>
								<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
							</div>
						</td>
					</tr>

					<tr>
						<td align="right"><label for="telefono">Teléfono:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="telefono" name="telefono" type="text" value="<?php echo telefono($row1['tel'], 'input'); //Teléfono ?>" disabled>
								<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="celular">Celular:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="celular" name="celular" type="text" value="<?php echo celular($row1['cel'], 'input'); //Teléfono ?>" disabled>
								<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
			
		<div class="panel panel-success">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-file'></i> Lista de prestamos</h4>
			</div>
			<br><div class="col col-md-12"><b style="font-size: 12px; color: #8F8F8F;">Nota: Los prestamos de color verde están finalizados.</b></div><br>
			<div class="panel-body">
				<?php 
				$sqlP = "SELECT * FROM prestamos WHERE id_clientes = '$id' ORDER BY prestamo_activo DESC";
				$resP = $mysqli->query($sqlP);
			
				$i=1;

				while($rowP = mysqli_fetch_row($resP)){

				$colores = array("info", "warning", "danger", "warning", "danger", "info");
				$color = $colores[array_rand($colores, 1)];
					
				$sqlU = "SELECT * FROM usuarios WHERE id_usuario = ".$rowP[2];
				$resU = $mysqli->query($sqlU);
				$rowU = mysqli_fetch_row($resU);

				?>
				
				<div class="alert alert-<?php if($rowP[12]==0){ echo 'success'; }else{ echo $color;}?>" role="alert">
					<div class="row">
						<div class="col col-md-12" style=" padding-bottom: 5px;"><b>Estado:</b> <?php if($rowP[12]==1){echo 'Activo';}else{echo 'Finalizado';} ?></div>
						<div class="col col-md-12" style=" padding-bottom: 5px;"><b>Cobrador:</b> <?php echo $rowU[4]; ?></div>
						<div class="col col-md-3"><?php echo '<b>'.$i . ' - Total de prestamo:</b> '.moneda(($rowP[5]+$rowP[9]), 'Q'); ?></div>
						<div class="col col-md-3"><b>Fecha de pago:</b> <?php echo fecha('d-m-Y', $rowP[7]); ?></div>
						<div class="col col-md-3"><b>Saldo restante:</b> <?php echo moneda($rowP[11], 'Q'); ?></div>
						<div class="col-6 col-md-3" align="right">
							<div class="visible-xs-block visible-sm-block"><br></div>
							<a onClick="location.href='detalle_prestamo.php?c=<?php echo $id; ?>&id=<?php echo $rowP[0]; ?>'" class="btn btn-<?php if($rowP[12]==0){ echo 'success'; }else{ echo $color;}?>">&nbsp; Detalles</a>
						</div>
					</div>
				</div>
				<?php $i++;} ?>
			</div>
		</div>
    </main>
	
	<?php include("footer.php"); ?>
</body>
</html>