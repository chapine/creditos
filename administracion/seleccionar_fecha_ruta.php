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
		$u = $_REQUEST['u'];
		
		$texto = 'Seleccione una ruta, cobrador, fecha inicial y una final';
		$title = $texto;
		
		$sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador' AND id_usuario >= 1";
		$res = $mysqli->query($sql);
		
		$sqlR = "SELECT r.id_ruta, r.id_departamento, r.nombre, d.nombre FROM rutas r, departamento d WHERE d.id_departamento = r.id_departamento AND r.id_ruta <> 1";
		$resR = $mysqli->query($sqlR);
		
		include('head.php');
		
		$active_prestamos = "active";
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
                    <a class="btn btn-primary"><?php echo $texto; ?></a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $texto; ?></h4>
			</div>
			<form id="registro" name="registro" action="reporte_ruta.php" method="get">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div class="row">
					
						<div class="col-md-4" style="padding-bottom: 10px;">
							<label for="ruta">Seleccione una ruta:</label>
							<div class="has-success has-feedback">
								<select class="form-control" id="ruta" name="ruta">
									<option value="0">Todas las rutas</option>
									<option disabled>-------------------------------------------------------</option>
									<?php while($rowR = mysqli_fetch_row($resR)){ ?>
									<option value="<?php echo $rowR[0]; ?>"><?php echo Convertir($rowR[2].', '.$rowR[3]); ?></option>
									<?php } ?>
								</select>
							
							</div>
						</div>
						
						<div class="col-md-4" style="padding-bottom: 10px;">
							<label for="cobrador">Seleccione un cobradores:</label>
							<div class="has-success has-feedback">
							<select class="form-control" id="cobrador" name="cobrador">
								<option value="0">Todos los cobradores</option>
								<option disabled>-------------------------------------------------------</option>
								<?php while($row = mysqli_fetch_row($res)){ ?>
									<option value="<?php echo $row[0]; ?>"><?php echo Convertir($row[4]); ?></option>
								<?php } ?>
							</select>
							
							<script>
								$(document).ready(function() {
									$('#cobrador option[value="<?php echo $u; ?>"]').attr('selected', 'selected');
								});
							</script>
								
							</div>
						</div>
						
						<div class="col-md-4" style="padding-bottom: 10px;">
							<label for="reporte">Generar reporte:</label>
							<div class="has-success has-feedback">
								<select class="form-control" id="reporte" name="reporte">
									<optgroup label="Prestamos">
										<option value="1">Prestamos</option>
										<option value="2">Cobros de los prestamos</option>
									</optgroup>
									
									<optgroup label="Renovaciones">
										<option value="3">Renovaciones</option>
										<option value="4">Cobros de las renovaciones</option>
									</optgroup>
								</select>
								
								<script>
									$(document).ready(function() {
										<?php if($a==1){ ?>
											$('#reporte option[value="1"]').attr('selected', 'selected');
										
										<?php }elseif($a==2){ ?>
											$('#reporte option[value="2"]').attr('selected', 'selected');
										
										<?php }elseif($a==3){ ?>
											$('#reporte option[value="3"]').attr('selected', 'selected');
										
										<?php }elseif($a==4){ ?>
											$('#reporte option[value="4"]').attr('selected', 'selected');
										
										<?php } ?>
									});
								</script>
							</div>
						</div>
						
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
						
						<div class="col-md-6" style="bottom:0; padding-bottom: 10px;">
							
						</div>
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