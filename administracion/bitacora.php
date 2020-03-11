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
	
		$registro = $_REQUEST['registro'];
		$usuario = $_REQUEST['usuario'];
	
		$fecha1 = $_REQUEST['fecha1'];
		$fecha2 = $_REQUEST['fecha2'];
		
		if($registro == 'todo' AND $usuario == 'todo'){
			$pagina = "generar_tabla.php?opt=13&estado=1&fecha1=$fecha1&fecha2=$fecha2";
			
			$fecha_inicial = fecha('d-m-Y', $fecha1);
			$fecha_final = fecha('d-m-Y', $fecha2);
			
			$title = "Cambios en el sistema entre las fechas ($fecha_inicial a $fecha_final)";
		}
	
		if($registro <> 'todo' AND $usuario == 'todo'){
			$pagina = "generar_tabla.php?opt=13&estado=2&registro=$registro&fecha1=$fecha1&fecha2=$fecha2";
			
			$fecha_inicial = fecha('d-m-Y', $fecha1);
			$fecha_final = fecha('d-m-Y', $fecha2);
			$usuario_a = base64_decode($usuario);
			
			$title = "Cambios en el sistema entre las fechas ($fecha_inicial a $fecha_final)";
		}
	
		if($registro == 'todo' AND $usuario <> 'todo'){
			$pagina = "generar_tabla.php?opt=13&estado=3&usuario=$usuario&fecha1=$fecha1&fecha2=$fecha2";
			
			$fecha_inicial = fecha('d-m-Y', $fecha1);
			$fecha_final = fecha('d-m-Y', $fecha2);
			$usuario_a = base64_decode($usuario);
			
			$title = "Cambios en el sistema realizados por $usuario_a entre las fechas ($fecha_inicial a $fecha_final)";
		}
	
		if($registro <> 'todo' AND $usuario <> 'todo'){
			$pagina = "generar_tabla.php?opt=13&estado=4&registro=$registro&usuario=$usuario&fecha1=$fecha1&fecha2=$fecha2";
			
			$fecha_inicial = fecha('d-m-Y', $fecha1);
			$fecha_final = fecha('d-m-Y', $fecha2);
			$usuario_a = base64_decode($usuario);
			
			$title = "Cambios en el sistema realizados por $usuario_a entre las fechas ($fecha_inicial a $fecha_final)";
		}
		
		include('head.php');
		$active_bitacora = "active";
    ?>
    
    <script>
		
		function confirmar(a,b)
		{
			if(confirm('Esta seguro que desea eliminar la ruta?'))
			{
				location.href = "eliminar_ruta.php?eliminar="+a+"&ruta="+b;
			}
		}
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
                    <a class="btn btn-success">Cambios del sistema por usuarios</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<!--div class="btn-group pull-right hidden-xs">
					<a href="nueva_ruta.php" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir ruta</a>
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir rutas</a>
				</div-->
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $title; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>


    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>