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
	
		
		$opcion = $_REQUEST['a'];
			
		if($opcion==0){
			$a = 0;
			$texto = 'sin prestamos';
		}
		elseif($opcion==1){
			$a = 1;
			$texto = 'con prestamos';
		}
		
		$usuario = $_SESSION["id_usuario"];
		$pagina = "generar_tabla.php?opt=2&estado=$a&usuario=$usuario";
		
		include('head.php');
		$active_clientes = "active";
    ?>
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
                    <a href="lista_clientes.php?numero=1"  class="btn btn-success">Clientes</a>
                    <a class="btn btn-primary">Lista de clientes <?php echo $texto; ?></a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
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