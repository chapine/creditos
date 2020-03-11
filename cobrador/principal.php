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
		    
		$title = 'Página principal';
		include('head.php');
	
		/*if($_SESSION['info']==''){
			// Alerta para confirmar pago
			$alert_bandera = true;
			$alert_titulo ="Información";
			$alert_mensaje ="A partir de 20/07/2018 solo se podrá realizar un pago al día por préstamo, sí desea agregar más pagos con fecha anterior contacte a un administrador.";
			$alert_icono ="info";
			$alert_boton = "info";
			
			$_SESSION['info']='ya';
		}*/
    ?>
</head>
<body onLoad="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">

        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row">
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
				<div class="row">
					<div class="col-md-4 espacio">
						<div class="ListaPrestamo" onclick="javascript:location.href='cobros_hoy.php?fecha1=<?php echo date('Y-m-d'); ?>'">Ver cobros diarios [<?php echo date('d-m-Y'); ?>]</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaCliente" onclick="javascript:location.href='lista_clientes.php?numero=1'">Clientes</div>
					</div>
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
				<h4><i class='glyphicon glyphicon-stats'></i> Prestamos</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				
				<div class="row">
					<div class="col-md-4 espacio">
						<div class="ListaPrestamo" onclick="javascript:location.href='lista_prestamos.php?a=1'">Prestamos</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaPrestamoActivo" onclick="javascript:location.href='lista_prestamos.php?a=2'">Prestamos activos</div>
					</div>
					<div class="col-md-4 espacio">
						<div class="ListaPrestamoFinalizado" onclick="javascript:location.href='lista_prestamos.php?a=3'">Prestamos finalizados</div>
					</div>
				</div>
			</div>
		</div>
    </main>
	<?php include("footer.php"); ?>
</body>
</html>