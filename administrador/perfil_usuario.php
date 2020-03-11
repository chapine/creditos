<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
	
		$l_verificar = 'administrador';
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	

		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_REQUEST['id']; // OBTIENE EL ID

		$sql1 = "SELECT * FROM usuarios WHERE id_usuario = $id";
		$res1 = $mysqli->query($sql1);
		$row1 = $res1->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO
		
		$sql_contar = "SELECT count(1) AS contar FROM usuarios WHERE id_usuario = $id";
		$res_contar = $mysqli->query($sql_contar);
		$row_contar = $res_contar->fetch_assoc();
		
		if($row_contar['contar'] == 0 OR $id <= 0){
			header("Location: ../index.php");
		}
		
		$bandera = false;
		$title = 'Pefil de usuario';		
		include('head.php');
		$active_usuarios = "active";
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
                    <a href="lista_usuarios.php" class="btn btn-success">Usuarios</a>
                    <a class="btn btn-danger">Pefil del usuario</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<a href="lista_usuarios.php" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar</a>
				</div>
				<h4><i class='glyphicon glyphicon-user'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">			
				<div style="padding: 10px;">
					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Nombre:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<?php echo Convertir($row1['nombre']); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Usuario:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo $row1['usuario']; ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Tipo:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php if($row1['tipo_usuario']==c){ echo 'Cobrador'; }else{ echo 'Administrador'; } ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Teléfono:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo telefono($row1['tel']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Celular:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo celular($row1['cel']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Dirección:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo verificar($row1['direccion']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Observaciones:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo verificar($row1['observaciones']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Fecha de nacimiento:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-success has-feedback">
								<?php echo fecha('d-m-Y', $row1['fechanacimiento']); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col col-md-12 ajustar1">
							<div class="btn-group pull-left">
							<div class="btn-group pull-left">
								<a href="seleccionar_fecha_ruta.php?a=1&u=<?php echo $id; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-chevron-up"></i> &nbsp;  Préstamos por fecha y
 ruta</a>
								<a href="seleccionar_fecha_ruta.php?a=2&u=<?php echo $id; ?>" class="btn btn-success"><i class="glyphicon glyphicon-chevron-down"></i> &nbsp; Cobros por fecha y
 ruta</a>
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