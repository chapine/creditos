<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
	
		$l_verificar = 'asistente';
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$ruta = $_REQUEST['ruta'];
		$cobrador = $_REQUEST['cobrador'];
		$fecha1 = $_REQUEST['fecha1'];
		$fecha2 = $_REQUEST['fecha2'];
		$reporte = $_REQUEST['reporte'];
	
		// PRESTAMOS -- PRESTAMOS -- PRESTAMOS -- PRESTAMOS -- PRESTAMOS
		// PRESTAMOS -- PRESTAMOS -- PRESTAMOS -- PRESTAMOS -- PRESTAMOS
		if($reporte==1){
			$nombre_link = 'Reporte de préstamos';
			$title = $nombre_link;
			$link = '../print/print_reporte_ruta.php?ruta='.$ruta.'&cobrador='.$cobrador.'&fecha1='.$fecha1.'&fecha2='.$fecha2;
			
			if($ruta == 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=6&estado=1&fecha1=$fecha1&fecha2=$fecha2";
				$titulo = 'Reporte de prestamos de todas las rutas y cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
			}

			elseif($ruta <> 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=6&estado=2&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR Y RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR, 
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d, usuarios u 

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND
							u.id_usuario = p.cobrador AND

							p.id_ruta = '$ruta' AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['COBRADOR']=='' OR $rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> en la ruta <b>"'.$rowRR['RUTA'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta == 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=6&estado=3&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR

						FROM 
							prestamos p, usuarios u 

						WHERE
							u.id_usuario = p.cobrador AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['id_prestamo']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos de todas las rutas del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta <> 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=6&estado=4&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta";

				// MOSTRAR DATOS DE LA RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND

							p.id_ruta = '$ruta'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos en la ruta <b>"'.$rowRR['RUTA'].'"</b> de todos los cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}
			
		// COBROS -- COBROS -- COBROS -- COBROS -- COBROS -- COBROS -- COBROS
		// COBROS -- COBROS -- COBROS -- COBROS -- COBROS -- COBROS -- COBROS
		// COBROS -- COBROS -- COBROS -- COBROS -- COBROS -- COBROS -- COBROS
		}elseif($reporte==2){
			$nombre_link = 'Reporte de cobros';
			$title = $title = $nombre_link;
			$link = '../print/print_reporte_ruta_cobros.php?ruta='.$ruta.'&cobrador='.$cobrador.'&fecha1='.$fecha1.'&fecha2='.$fecha2;
			
			if($ruta == 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=9&estado=1&fecha1=$fecha1&fecha2=$fecha2";
				$titulo = 'Reporte de cobros de todas las rutas y cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
			}

			elseif($ruta <> 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=9&estado=2&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR Y RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR, 
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d, usuarios u 

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND
							u.id_usuario = p.cobrador AND

							p.id_ruta = '$ruta' AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['COBRADOR']=='' OR $rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de cobros del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> en la ruta <b>"'.$rowRR['RUTA'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta == 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=9&estado=3&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR

						FROM 
							prestamos p, usuarios u 

						WHERE
							u.id_usuario = p.cobrador AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['id_prestamo']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos de todas las rutas del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta <> 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=9&estado=4&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta";

				// MOSTRAR DATOS DE LA RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND

							p.id_ruta = '$ruta'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de cobros en la ruta <b>"'.$rowRR['RUTA'].'"</b> de todos los cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}
		}
	
	
	
	
	
	
	
		// RENOVACIONES -- RENOVACIONES -- RENOVACIONES -- RENOVACIONES -- RENOVACIONES
		// RENOVACIONES -- RENOVACIONES -- RENOVACIONES -- RENOVACIONES -- RENOVACIONES
		if($reporte==3){
			$nombre_link = 'Reporte de renovaciones';
			$title = $nombre_link;
			//$link = '../print/print_reporte_ruta.php?ruta='.$ruta.'&cobrador='.$cobrador.'&fecha1='.$fecha1.'&fecha2='.$fecha2;
			
			if($ruta == 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=17&estado=1&fecha1=$fecha1&fecha2=$fecha2";
				$titulo = 'Reporte de prestamos renovados de todas las rutas y cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
			}

			elseif($ruta <> 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=17&estado=2&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR Y RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR, 
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d, usuarios u 

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND
							u.id_usuario = p.cobrador AND

							p.id_ruta = '$ruta' AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['COBRADOR']=='' OR $rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos renovados del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> en la ruta <b>"'.$rowRR['RUTA'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta == 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=17&estado=3&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR

						FROM 
							prestamos p, usuarios u 

						WHERE
							u.id_usuario = p.cobrador AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['id_prestamo']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos renovados de todas las rutas del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta <> 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=17&estado=4&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta";

				// MOSTRAR DATOS DE LA RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND

							p.id_ruta = '$ruta'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de prestamos renovados en la ruta <b>"'.$rowRR['RUTA'].'"</b> de todos los cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}
			
		// COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES
		// COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES
		// COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES -- COBROS DE RENOVACIONES
		}elseif($reporte==4){
			$nombre_link = 'Reporte de cobros de las renovaciones';
			$title = $title = $nombre_link;
			//$link = '../print/print_reporte_ruta_cobros.php?ruta='.$ruta.'&cobrador='.$cobrador.'&fecha1='.$fecha1.'&fecha2='.$fecha2;
			
			if($ruta == 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=18&estado=1&fecha1=$fecha1&fecha2=$fecha2";
				$titulo = 'Reporte de cobros de las renovaciones de todas las rutas y cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
			}

			elseif($ruta <> 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=18&estado=2&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR Y RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR, 
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d, usuarios u 

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND
							u.id_usuario = p.cobrador AND

							p.id_ruta = '$ruta' AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['COBRADOR']=='' OR $rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de cobros de las renovaciones del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> en la ruta <b>"'.$rowRR['RUTA'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta == 0 AND $cobrador <> 0){
				$pagina = "generar_tabla.php?opt=18&estado=3&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador";

				// MOSTRAR DATOS DEL COBRADOR PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							u.nombre AS COBRADOR

						FROM 
							prestamos p, usuarios u 

						WHERE
							u.id_usuario = p.cobrador AND
							p.cobrador = '$cobrador'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['id_prestamo']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de cobros de las renovaciones de todas las rutas del cobrador <b style="text-transform:lowercase;">"'.$rowRR['COBRADOR'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}

			elseif($ruta <> 0 AND $cobrador == 0){
				$pagina = "generar_tabla.php?opt=18&estado=4&fecha1=$fecha1&fecha2=$fecha2&ruta=$ruta";

				// MOSTRAR DATOS DE LA RUTA PARA EL TITULO
				$sqlRR = "SELECT
							p.*,
							concat_ws(', ', r.nombre, d.nombre) AS RUTA 

						FROM 
							prestamos p, rutas r, departamento d

						WHERE
							r.id_ruta = p.id_ruta AND
							d.id_departamento = r.id_departamento AND

							p.id_ruta = '$ruta'
						";

				$resRR = $mysqli->query($sqlRR);
				$rowRR = $resRR->fetch_assoc();

				if($rowRR['RUTA']==''){
					$titulo = 'No se encontrarón registros';
				}else{
					$titulo = 'Reporte de cobros de las renovaciones en la ruta <b>"'.$rowRR['RUTA'].'"</b> de todos los cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
				}
			}
		}
	

		include('head.php');
		require('fecha.php');
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
					<a href="seleccionar_fecha_ruta.php" class="btn btn-success">Ruta, cobrador y fechas</a>
                    <a class="btn btn-danger"><?php echo $nombre_link; ?></a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
       		<?php
				if($reporte==3 OR $reporte==4){
					
				}else{
			?>
					<div class="btn-group pull-right hidden-xs">
						<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal..'; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir reporte</a>
					</div>
			<?php
				}
			?>
				<h5><i class='glyphicon glyphicon-list-alt'></i> <?php echo $titulo; ?></h5>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>