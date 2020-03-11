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
        $_SESSION["id_usuario"];

		$title = 'Porcentaje de cobros del mes';		
		include('head.php');
		$active_porcentaje="active";
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
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    <a class="btn btn-danger">Asignar cobrador</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-body">
			
				<form id='registro' name='registro' action='' method='POST'>
					<div class="col-md-6" style="padding-bottom: 10px;">
						<label for="fecha1">Especifique una fecha inicial:</label>
						<div class="has-success has-feedback">
							<?php
								$fecha = new DateTime();
								$fecha->modify('first day of this month');
								$fecha1 = $fecha->format('Y-m-d');
							?>
							<input class="form-control" id="fecha1" name="fecha1" type="date" value="<?php echo $fecha1; ?>">
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-6" style="padding-bottom: 10px;">
						<label for="fecha2">Especifique una fecha final:</label>
						<div class="has-success has-feedback">
							<?php
								$fecha = new DateTime();
								$fecha->modify('last day of this month');
								$fecha2 = $fecha->format('Y-m-d');
							?>
							<input class="form-control" id="fecha2" name="fecha2" type="date" value="<?php echo $fecha2; ?>">
							<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
						</div>
					</div>

					<div class="col-md-12" style="bottom:0; padding-bottom: 10px;">
						<button type="button" onClick="ajax_porcentaje();" class="btn btn-success" id="guardar" style="outline: none; width: 100%; height: 55px; font-size: 22px; font-weight: bold; border: 1px solid #000; color: #000;">
							Generar reporte <span class="glyphicon glyphicon-chevron-right"></span>
						</button>
					</div>

					<div class="col-md-12" style="bottom:0; padding-bottom: 10px;">
						<hr>
					</div>

					<script>
						function ajax_porcentaje(){
							var f1 = $('#registro').find('#fecha1').val();
							var f2 = $('#registro').find('#fecha2').val();

							$.ajax({
								url:'porcentaje_ajax.php?f1='+f1+'&f2='+f2,

								beforeSend: function(objeto){
									$('#registro').find('#guardar').attr('disabled','disabled');
									$('#registro').find('#guardar').html('Generando...');
								},
								success:function(data){
									//var resultado = data;

										$('#registro').find("#resultado").html(data);

										$('#registro').find('#guardar').removeAttr('disabled','disabled');
										$('#registro').find('#guardar').html('Generar reporte');
									
								}
							});
						}
					</script>
				
					<div id="resultado">

					</div>

				</form>
				<span style="font-size: 11px;">Nota: se muestra el total de cobros entre la fecha indicada el cuál se saca el el 0.5% dando un estimado de bonificación por cobros.</span>
			</div>
		</div>
    </main>
	<?php include("footer.php"); ?>

</body>
</html>