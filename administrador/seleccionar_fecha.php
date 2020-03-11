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
	
		$a = $_REQUEST['a'];
		
		if($a==1){
			$title = 'Generar reporte de cobros, seleccione una fecha inicial y una final';
			$link = 'cobros_realizados.php?a='.$a;
			
			include('head.php');
			$active_cobradores = "active";
		}
		
		elseif($a==2){
			$title = 'Cobros para hoy';
			$link = 'cobros_hoy.php';
			
			include('head.php');
			$active_cobradores = "active";
		}
		
		elseif($a==3){
			$title = 'Generar rendimiento por cobrador y fechas';
			$link = 'rendimiento_fecha.php';
			
			include('head.php');
			$active_cobros = "active";
		}
	
		else{
			header("location: principal.php");
		}
	
		$sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador' AND id_usuario >= 1";
		$res = $mysqli->query($sql);
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
                    <a class="btn btn-primary">Generar reporte de cobros</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $title; ?></h4>
			</div>
			<form id="registro" name="registro" action="<?php echo $link; ?>" method="get">
				<input type="text" name="a" id="a" hidden value="<?php echo $a; ?>">
				
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div class="row">
						<div class="col-md-<?php if($a==1 OR $a==3){ echo '4'; }else{ echo '6'; } ?>" style="padding-bottom: 10px;">
							<label for="cobradores">Cobradores:</label>
							<div class="has-success has-feedback">
								<select class="form-control" id="t" name="t">
									<?php if($a<>3){ ?>
										<option value="0">Todos</option>
										<option disabled>---------------------------------------------</option>

									<?php } while($row = mysqli_fetch_row($res)){ ?>
										<option value="<?php echo $row[0]; ?>"><?php echo Convertir($row[4]); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						
						<?php if($a==1 OR $a==3){ ?>
							<div class="col-md-<?php if($a==1 OR $a==3){ echo '4'; }else{ echo '6'; } ?>" style="padding-bottom: 10px;">
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

							<div class="col-md-4" style="padding-bottom: 10px;">
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
						<?php }elseif($a==2){ ?>
							<div class="col-md-<?php if($a==1 OR $a==3){ echo '4'; }else{ echo '6'; } ?>" style="padding-bottom: 10px;">
								<label for="fecha1">Fecha inicial:</label>
								<div class="has-success has-feedback">
									<input class="form-control" id="fecha1" name="fecha1" type="date" value="<?php echo fecha('Y-m-d', ''); ?>">
									<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
								</div>
							</div>
						<?php } ?>
						
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