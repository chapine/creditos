<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		
		$l_verificar = 'asistente';
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$a = $_REQUEST['a'];

		if($a == 1){
			$pagina = "generar_tabla.php?opt=15&estado=1";
			$title = 'Préstamos refinanciados activos';
			$link = '../print/print_prestamos_renovados.php?a=1';
		}

		if($a == 2){
			$pagina = "generar_tabla.php?opt=15&estado=2";
			$title = 'Préstamos refinanciados finalizados';
			$link = '../print/print_prestamos_renovados.php?a=2';
		}

		include('head.php');
		$active_prestamos = "active";
    ?>
	</script>

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
                    <a class="btn btn-primary">Préstamos refinanciados</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
        	<div class="panel-heading">
        		<div class="btn-group pull-right hidden-xs">
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status=''; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir reporte</a>
				</div>
				<h4>
					<i class='glyphicon glyphicon-list-alt'></i> <?php echo $title; ?>
				</h4>
			</div>
		
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>