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
	
		
		$fecha1 = $_REQUEST['fecha1'];
		$usuario = $_SESSION["id_usuario"];
		
		$sql = "SELECT * FROM usuarios WHERE id_usuario = $usuario";
		$res = $mysqli->query($sql);
		$row1 = mysqli_fetch_row($res);
		
		
		$title_link = '
			<a href="perfil_usuario.php" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" style="color: black; color:#fff; text-decoration: none;">
				<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i>
				<b>'.Convertir($row1[4]).'</b>
			</a>';

		$title_panel = 'Cobros para hoy <b>"'.fecha('d-m-Y', $fecha1).'"</b> de '.$title_link;
			
		$title = 'Cobros para hoy "'.fecha('d-m-Y', $fecha1).'" de '.Convertir($row1[4]);
		
		
		$link = '../print/print_cobros_hoy_cobrador.php?fecha1='.$fecha1;
		$pagina = 'generar_tabla.php?opt=4&usuario='.$usuario.'&fecha1='.$fecha1;
		include('head.php');
		$active_cobradores = "active";
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
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="seleccionar_fecha.php" class="btn btn-success">Fecha</a>
                    <a class="btn btn-primary">Cobros para hoy</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
        		<div class="btn-group pull-right hidden-xs">
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir reporte</a>
				</div>
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $title_panel; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
	
	<?php include("footer.php"); ?>
</body>
</html>