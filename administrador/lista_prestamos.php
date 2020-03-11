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
		
		if($_REQUEST['a']==1){
			$pagina = 'generar_tabla.php?opt=4&estado=1';
			
			$title = 'Todos los prestamos';
			$title_link = $title;
			$title_panel = $title;
			
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=1';
			
			$active_prestamos = "active";
		}
		elseif($_REQUEST['a']==2){
			$pagina = 'generar_tabla.php?opt=4&estado=2';
			
			$title = 'Préstamos activos';
			$title_link = $title;
			$title_panel = $title;
			
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=2';
			
			$active_prestamos = "active";
		}
		elseif($_REQUEST['a']==3){
			$pagina = 'generar_tabla.php?opt=4&estado=3';
			
			$title = 'Préstamos finalizados';
			$title_link = $title;
			$title_panel = $title;
			
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=3';
			
			$active_prestamos = "active";
		}
		elseif($_REQUEST['a']==4){
			$u = $_REQUEST['u'];
			$date = fecha('Y-m-d');

			$pagina = 'generar_tabla.php?opt=4&estado=4&date='.$date;
			$title = 'Préstamos atrasados';
			$title_link = $title;
			$title_panel = $title;
			
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=4';
			
			$active_prestamos = "active";
		}
			
		elseif($_REQUEST['a']==5){
			$u = $_REQUEST['u'];
			
			$pagina = 'generar_tabla.php?opt=4&estado=5&usuario='.$u;
			
			$title = 'Préstamos activos por cobrador';
			$title_link = $title;
			$title_panel = $title;
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=5&u='.$u;
			
			$active_cobradores = "active";
			$numero = '?a=1';
			
		}
			
		elseif($_REQUEST['a']==6){
			$u = $_REQUEST['u'];
			$d = $_REQUEST['d'];

			$pagina = 'generar_tabla.php?opt=4&estado=6&usuario='.$u.'&date='.$d;
			
			$sqlU = "SELECT id_usuario, nombre FROM usuarios WHERE id_usuario=$u";
			$resU = $mysqli->query($sqlU);
			$rowU = mysqli_fetch_row($resU);
			
			
			
			$title_panel = '
				<a href="perfil_usuario.php?id='.$u.'" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" style="color: black; color:#fff; text-decoration: none;">
					<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i>
					<b>'.Convertir($rowU[1]).'</b>
				</a>';
			
			$title_panel = 'Préstamos atrasados de '.$title_panel;
			
			$title = 'Préstamos atrasados de '.Convertir($rowU[1]);
			$title_link = 'Préstamos atrasados';
			
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=6&u='.$u.'&d='.$d;
			
			$active_cobradores = "active";
			$numero = '?a=2';
		}
			
			
		elseif($_REQUEST['a']==7){
			$u = $_REQUEST['u'];
			
			$pagina = 'generar_tabla.php?opt=4&estado=7&usuario='.$u;
			
			$title = 'Préstamos finalizados por cobrador';
			$title_link = 'Finalizados por cobrador';
			
			$title_panel = $title;
			
			include('head.php');
			
			$link = '../print/print_prestamos.php?a=7&u='.$u;
			
			$active_cobradores = "active";
			$numero = '?a=1';
		}
	
		$a = $_REQUEST['a'];
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
                    <a href="lista_prestamos.php?a=1" class="btn btn-success">Prestamos</a>
                    <a class="btn btn-primary"><?php echo $title_link; ?></a>
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
					<i class='glyphicon glyphicon-list-alt'></i> <?php echo $title_panel; ?>
				</h4>
			</div>
		
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
    <?php
		$alert_cliente = $_SESSION["cliente"];
			
		if($alert_cliente<>""){
			$alert_bandera 	= true;
			$alert_titulo 	= "Exito";
			$alert_mensaje 	= "Se elimino al prestamo de ".Convertir($alert_cliente)." correctamente";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["cliente"]); // Vaciar variable
		}
	?>
    
	<?php include("footer.php"); ?>
</body>
</html>