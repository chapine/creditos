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
	
		
		$sql_cod_bitacora = "SELECT * FROM bitacora_codigo WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21";
		$res_cod_bitacora = $mysqli->query($sql_cod_bitacora);
			
		$sql_usuario = "SELECT * FROM bitacora WHERE usuario <> '' GROUP BY usuario";
		$res_usuario = $mysqli->query($sql_usuario);

		$title = "Generar logs";
		include('head.php');
		
		$active_bitacora = "active";
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
                    <a class="btn btn-primary">Generar logs</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> Generar reporte de cambios en el sistema</h4>
			</div>
			<form id="registro" name="registro" action="bitacora.php" method="get">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div class="row">
						<div class="col-md-3" style="padding-bottom: 10px;">
							<label for="registro">Tipo de registro:</label>
							<div class="has-success has-feedback">
							<select class="form-control" id="registro" name="registro">
								<option value="todo">Todos</option>
								<option disabled>---------------------------------------------</option>
								<?php while($row_cod_bitacora = mysqli_fetch_row($res_cod_bitacora)){ ?>
									<option value="<?php echo $row_cod_bitacora[0]; ?>"><?php echo $row_cod_bitacora[2]; ?></option>
								<?php } ?>
							</select>
							</div>
						</div>
						
						
						<div class="col-md-3" style="padding-bottom: 10px;">
							<label for="usuario">Seleccionar usuario:</label>
							<div class="has-success has-feedback">
							<select class="form-control" id="usuario" name="usuario">
								<option value="todo">Todos</option>
								<option disabled>---------------------------------------------</option>
								<?php while($row_usuario = mysqli_fetch_row($res_usuario)){ ?>
									<option value="<?php echo base64_encode($row_usuario[3]) ?>"><?php echo convertir($row_usuario[3]); ?></option>
								<?php } ?>
							</select>
							</div>
						</div>
						
						
						<div class="col-md-3" style="padding-bottom: 10px;">
							<?php
								$fecha = new DateTime();
								$fecha->modify('first day of this month');
								$fecha1 = $fecha->format('Y-m-d');
							?>
							<label for="fecha1">Fecha inicial:</label>
							<div class="has-success has-feedback">
								<input class="form-control" id="fecha1" name="fecha1" type="date" value="<?php echo $fecha1; ?>">
								<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
							</div>
						</div>

						<div class="col-md-3" style="padding-bottom: 10px;">
							<?php
								$fecha = new DateTime();
								$fecha->modify('last day of this month');
								$fecha2 = $fecha->format('Y-m-d');
							?>
							<label for="fecha2">Fecha final:</label>
							<div class="has-success has-feedback">
								<input class="form-control" id="fecha2" name="fecha2" type="date" value="<?php echo $fecha2; ?>">
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