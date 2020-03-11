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
		
		$usuario = $_SESSION["id_usuario"];
		$opcion = $_REQUEST['a'];
			
		if($opcion==1){
			$pagina = "generar_tabla.php?opt=3&estado=1&usuario=$usuario";
			
			$texto = 'Todos los prestamos';
			$title = $texto;
			include('head.php');
			$active_prestamos = "active";
		}
		elseif($opcion==2){
			$pagina = "generar_tabla.php?opt=3&estado=2&usuario=$usuario";
			$texto = 'Prestamos activos';
			$title = $texto;
			include('head.php');
			$active_prestamos = "active";
		}
		elseif($opcion==3){
			$pagina = "generar_tabla.php?opt=3&estado=3&usuario=$usuario";
			$texto = 'Prestamos finalizados';
			$title = $texto;
			include('head.php');
			$active_prestamos = "active";
		}
		elseif($opcion==4){
			$date = fecha('Y-m-d', '');
			
			$pagina = "generar_tabla.php?opt=3&estado=4&date=$date&usuario=$usuario";
			$texto = 'Prestamos atrasados';
			$title = $texto;
			include('head.php');
			$active_prestamos = "active";
		}
    ?>
	</script>

</head>
<body onLoad="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">

        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="lista_prestamos.php?a=1" class="btn btn-success">Prestamos</a>
                    <a class="btn btn-primary"><?php echo $texto; ?></a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $texto; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
	
	<?php include("footer.php"); ?>
</body>
</html>