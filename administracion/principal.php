<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "administracion";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	
		$title = 'Página principal';
		include('head.php');
    ?>
</head>
<body onload="Reloj()">
    <?php include('menu.php'); ?>
  
    <!-- Contenido -->
    <main id="page-wrapper6" ng-hide="ocultar">
        <!-- Navegador -->
        
        <div align="right" class="navegar_secciones">
           <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-primary"><i class="glyphicon glyphicon-home"></i> Inicio</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> Opciones básicas</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<div id="feedback-bg-info"></div>
				<div class="row rotate" ng-click="animar_boton=true">
					<div class="col-md-4 espacio">
						<div class="ListaCliente" onclick="javascript:location.href='lista_clientes.php?numero=1'">Clientes</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaUsuario" onclick="javascript:location.href='lista_usuarios.php'">Usuarios</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaPrestamo" onclick="javascript:location.href='lista_cobradores.php'">Cobradores</div>
					</div>
				</div>
			</div>
		</div>
			
		<div class="panel panel-success">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-briefcase'></i> Opciones de clientes</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<div class="row">
					<div class="col-md-4 espacio">
						<div class="ClientesConPrestamos" onclick="javascript:location.href='lista_clientes_prestamos.php?a=1'">Clientes con prestamos</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ClientesSinPrestamos" onclick="javascript:location.href='lista_clientes_prestamos.php?a=0'">Clientes sin prestamos</div>
					</div>
				</div> 
			</div>
		</div>
		
		<div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-stats'></i> Préstamos</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				
				<div class="row">
					<div class="col-md-4 espacio">
						<div class="ListaPrestamo" onclick="javascript:location.href='lista_prestamos.php?a=1'">Préstamos</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaPrestamoActivo" onclick="javascript:location.href='lista_prestamos.php?a=2'">Préstamos activos</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaPrestamoFinalizado" onclick="javascript:location.href='lista_prestamos.php?a=3'">Préstamos finalizados</div>
					</div>
				</div>
			</div>
		</div>
    </main>
    <?php
		if($_SESSION['alert_mensaje'] <> ""){

			$alert_bandera 	= true;
			$alert_titulo 	= $_SESSION['alert_titulo'];
			$alert_mensaje	= $_SESSION['alert_mensaje'];
			$alert_boton 	= $_SESSION['alert_boton'];
			$alert_icono 	= $_SESSION['alert_icono'];
			
			unset($_SESSION['alert_titulo']);
			unset($_SESSION['alert_mensaje']);
			unset($_SESSION['alert_boton']);
			unset($_SESSION['alert_icono']);
		}
	?>
	
	<?php include("footer.php"); ?>
</body>
</html>