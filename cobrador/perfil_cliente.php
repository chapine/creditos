<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		
		$l_verificar = "cobrador";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	

		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_GET['id']; // OBTIENE EL ID A EDITAR

		$sql = "SELECT
		
		c.id_cliente, c.dpi, c.nit, c.direccion, c.nombre, c.profesion, c.fechanacimiento, c.tel, c.cel, c.estado, c.cobrador, c.prestamoactivo, c.id_ruta, c.ocultar, c.dpi_frontal, c.dpi_posterior
		
		FROM clientes c, rutas r WHERE id_cliente = ".$id;
		$result1=$mysqli->query($sql);
		$row1 = $result1->fetch_assoc();
		
		if($row1['id_ruta']==''){
			
		}else{
			$sqlR = "SELECT * FROM rutas WHERE id_ruta = ".$row1['id_ruta'];
			$resR = $mysqli->query($sqlR);
			$rowR = $resR->fetch_assoc();


			$sqlD = "SELECT * FROM departamento WHERE id_departamento = ".$rowR['id_departamento'];
			$resD = $mysqli->query($sqlD);
			$rowD = $resD->fetch_assoc();
		}
		
		$sqlU = "SELECT * FROM usuarios WHERE id_usuario = ".$row1['cobrador'];
		$resU = $mysqli->query($sqlU);
		$rowU = $resU->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO
			
		$bandera = false;
			
		$title = 'Pefil de cliente';		
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
                    <a class="btn btn-danger">Pefil de cliente</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<a href="lista_clientes.php?numero=1" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar</a>
				</div>
				<h4><i class='glyphicon glyphicon-user'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">			
				<div style="padding: 10px;">
					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Nombre:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<?php echo Convertir($row1['nombre']); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>DPI:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo dpi($row1['dpi'], ''); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1" style="height: 196px;">
							<label for="dpi">Vista previa:</label>
						</div>
						<div class="col col-md-9 ajustar2">
							<div class="has-feedback">
								<?php
									if($row1['dpi_frontal']==''){
										echo '<img src="../images/dpi_frontal.png" width="300" height="180">';
									}else{
										echo '<img src="../uploads/'.$row1['dpi_frontal'].'_frontal.jpg" width="300" height="180">';
									}

									if($row1['dpi_posterior']==''){
										echo '<img src="../images/dpi_posterior.png" width="300" height="180">';
									}else{
										echo '<img src="../uploads/'.$row1['dpi_posterior'].'_posterior.jpg" width="300" height="180">';
									}
								?>
							</div>
						</div>
					</div>
						
					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>NIT:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo nit($row1['nit'], ''); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Profesión:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo verificar($row1['profesion']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Teléfono:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo telefono($row1['tel'], ''); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Celular:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo celular($row1['tel'], ''); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Dirección:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo verificar($row1['direccion']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Ruta:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo ruta(($rowR['nombre'].', '.$rowD['nombre']), 'input'); ?>
							</div>
						</div>
					</div>

					<!--div class="row">
						<div class="col-md-3 ajustar1">
							<b>Fecha de nacimiento:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-success has-feedback">
								<?php echo fecha('Y-m-d', $row1['fechanacimiento']); ?>
							</div>
						</div>
					</div-->
					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Prestamo activo:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-success has-feedback">
								<?php if($row1['prestamoactivo']==1){echo 'Tiene prestamo activo';}else{echo 'No tiene prestamo activo';} ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 ajustar1">
							<b>Cobrador:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-success has-feedback">
								<?php
									if($rowU['nombre']=='edba'){
										echo 'Sin cobrador';
									}else{
										echo Convertir($rowU['nombre']);
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>