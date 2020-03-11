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
		
		$a = $_REQUEST['a'];
	
		if($a == 1){

			$title = 'Rutas por usuarios';
			include('head.php');
			$active_cobradores = "active";
		}
    ?>
    
	<script>
		$(document).ready(function(){
			load(1);
		});

		function load(page){
			//var year = document.getElementById("year").value;
			var parametros = {"action":"ajax", "page":page};
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'cambiar_rutas_lista.php',
				data: parametros,
				beforeSend: function(objeto){
					$(".outer_div").html('<div style="background: url(../images/cargando.gif) no-repeat center; min-height: 300px; width: 100%;"></div>');
				},
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$("#loader").html("");
				}
			})
		}
	</script>

	<style>
		.marco_3{ border: 1px solid #cccccc; padding: 0; border-radius: 4px; }
	</style>
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
                    <a class="btn btn-primary"><?php echo $title; ?></a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
        	<div class="panel-heading">
				<h4>
					<i class='glyphicon glyphicon-list-alt'></i> <?php echo $title; ?>
				</h4>
			</div>
		
			<div class="panel-body">
				<div style="padding: 0 10px 10px 10px;">Nota: al cambiar una ruta de un usuario a otro estás se unificarán.</div>
				
				<?php //Historial  --  Historial  --  Historial  --  Historial  --  Historial  --  Historial  --  Historial ?>
				<div class="marco_3">
					<div class='clearfix'></div>
					<samp id="loader"></samp>
					<div class='outer_div'></div>
				</div>
				
				

			</div>
		</div>
    </main>
									
    <?php
		$alert_cliente = $_SESSION["ruta_true"];
		$mensaje = $_SESSION["mensaje"];
			
		if($alert_cliente<>""){
			$alert_bandera 	= true;
			$alert_titulo 	= "Exito";
			$alert_mensaje 	= "$mensaje";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["ruta_true"]); // Vaciar variable
			unset($_SESSION["mensaje"]); // Vaciar variable
		}
	?>
    
	<?php include("footer.php"); ?>
</body>
</html>