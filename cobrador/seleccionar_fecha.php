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

		$title = 'Generar reporte de cobros';
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
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a class="btn btn-primary">Generar reporte de cobros</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> Generar reporte de cobros</h4>
			</div>
			<form id="registro" name="registro" action="cobros_hoy.php" method="get">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div class="row">
						<div class="col-md-12" style="padding-bottom: 10px;">
							<label for="fecha1">Fecha inicial:</label>
							<div class="has-success has-feedback">
								<input class="form-control" id="fecha1" name="fecha1" type="date" value="<?php echo fecha('Y-m-d', ''); ?>">
								<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							</div>
						</div>
						
						<div class="col-md-6" style="bottom:0; padding-bottom: 10px;"></div>
						<div class="col-md-12" style="bottom:0; padding-bottom: 10px;">
							<button type="submit" class="btn btn-success" style="outline: none; width: 100%; height: 55px; font-size: 22px; font-weight: bold; border: 1px solid #000; color: #000;">
								Continuar <span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
    </main>
	
	<?php include("footer.php"); ?>
</body>
</html>