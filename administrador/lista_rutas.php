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
		
		$pagina = "generar_tabla.php?opt=7";
		
		$title = 'Listado de rutas';
		$link = '../print/print_lista_rutas.php';
		
		include('head.php');
		$active_rutas = "active";
    ?>
    
    <script>
		function confirmar(a,b){
			swal({
				title: "Esta seguro que desea eliminar la ruta?",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-primary",
				confirmButtonText: "si",
				cancelButtonText: "No",
				closeOnConfirm: false,
				closeOnCancel: false
			},
				 
				function(isConfirm){
					if(isConfirm){
						//swal.close(),
						confirmar_eliminar(),
						location.href = "eliminar_ruta.php?eliminar="+a+"&ruta="+b;
					}else{
						swal.close();
					}
				}
			);
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
                    <a class="btn btn-success">Rutas</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right hidden-xs">
					<a href="nueva_ruta.php" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir ruta</a>
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir rutas</a>
				</div>
				<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de rutas</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
   	<?php
		$alert_ruta = $_SESSION["ruta"];
			
		if($alert_ruta<>""){
			$alert_bandera 	= true;
			$alert_titulo 	= "Error";
			$alert_mensaje 	= "$alert_ruta";
			$alert_icono 	= "warning";
			$alert_boton 	= "warning";
			
			unset($_SESSION["ruta"]); // Vaciar variable
		}
	?>
    
    <?php include("footer.php"); ?>
</body>
</html>