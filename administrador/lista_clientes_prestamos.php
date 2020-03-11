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
	
		
		if($_REQUEST['a']==0){
			$a = 0;
			$texto = 'Sin préstamos';
		}
		elseif($_REQUEST['a']==1){
			$a = 1;
			$texto = 'Con préstamos';
		}

		$pagina = 'generar_tabla.php?opt=3&estado='.$a;
			
		$title = 'Listado de clientes';
		$link = '../print/print_lista_clientes_prestamos.php?a='.$a;
		
		include('head.php');
		$active_clientes = "active";
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
                    <a href="lista_clientes.php"  class="btn btn-success">Clientes</a>
                    <a class="btn btn-primary"><?php echo $texto; ?></a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right hidden-xs">
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir listado</a>
				</div>
				<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de clientes <?php echo $texto; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
	<?php include("footer.php"); ?>
</body>
</html>