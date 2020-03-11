<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		require('../config/funciones.php');
		
		if($_SESSION['tipo_usuario']=='administracion'){ $l_verificar = "administracion"; }
		if($_SESSION['tipo_usuario']=='administrador'){ $l_verificar = "administrador"; }
		if($_SESSION['tipo_usuario']=='asistente'){ $l_verificar = "asistente"; }

		if($_SESSION['tipo_usuario'] <> "$l_verificar"){
			echo"<script language='javascript'>window.location='../index.php'</script>;";
			exit();
		}
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$ruta = $_REQUEST['ruta'];
		$cobrador = $_REQUEST['cobrador'];
		$fecha1 = $_REQUEST['fecha1'];
		$fecha2 = $_REQUEST['fecha2'];
		
		if($ruta == 0 AND $cobrador == 0){
			$sql = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.usuario			AS USUARIO,
						dp.abono			AS ABONO,
						dp.mora				AS MORA,
						dp.total			AS TOTAL,
						dp.fecha_sugerida	AS FECHA_SUGERIDA,
						dp.fechaPago		AS FECHA_PAGO,
						dp.estado			AS ESTADO,
						dp.id_clientes		AS ID_CLIENTE,
						dp.id_usuario		AS ID_USUARIO,
						c.id_ruta			AS ID_RUTA,
						p.saldo_restante	AS RESTANTE,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						uu.usuario			AS USUARIO_REGISTRO,
						dp.usuario			AS ID_USUARIO_REGISTRO
						
					FROM 
						detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') ORDER BY dp.id_detalle ASC";
			$res = $mysqli->query($sql);
			
			$titulo = 'Reporte de cobros de todas las rutas y cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
		}

		elseif($ruta <> 0 AND $cobrador <> 0){
			$sql = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.usuario			AS USUARIO,
						dp.abono			AS ABONO,
						dp.mora				AS MORA,
						dp.total			AS TOTAL,
						dp.fecha_sugerida	AS FECHA_SUGERIDA,
						dp.fechaPago		AS FECHA_PAGO,
						dp.estado			AS ESTADO,
						dp.id_clientes		AS ID_CLIENTE,
						dp.id_usuario		AS ID_USUARIO,
						c.id_ruta			AS ID_RUTA,
						p.saldo_restante	AS RESTANTE,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						uu.usuario			AS USUARIO_REGISTRO,
						dp.usuario			AS ID_USUARIO_REGISTRO
						
					FROM 
						detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						
						c.id_ruta = '$ruta' AND
						dp.id_usuario = '$cobrador' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') ORDER BY dp.id_detalle ASC";
			$res = $mysqli->query($sql);
			
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
				$titulo = 'Reporte de cobros del cobrador <b>"'.convertir($rowRR['COBRADOR']).'"</b> en la ruta <b>"'.$rowRR['RUTA'].'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
			}
		}

		elseif($ruta == 0 AND $cobrador <> 0){
			$sql = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.usuario			AS USUARIO,
						dp.abono			AS ABONO,
						dp.mora				AS MORA,
						dp.total			AS TOTAL,
						dp.fecha_sugerida	AS FECHA_SUGERIDA,
						dp.fechaPago		AS FECHA_PAGO,
						dp.estado			AS ESTADO,
						dp.id_clientes		AS ID_CLIENTE,
						dp.id_usuario		AS ID_USUARIO,
						c.id_ruta			AS ID_RUTA,
						p.saldo_restante	AS RESTANTE,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						uu.usuario			AS USUARIO_REGISTRO,
						dp.usuario			AS ID_USUARIO_REGISTRO
						
					FROM 
						detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						
						dp.id_usuario = '$cobrador' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') ORDER BY dp.id_detalle ASC";
			$res = $mysqli->query($sql);

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
				$titulo = 'Reporte de prestamos de todas las rutas del cobrador <b>"'.convertir($rowRR['COBRADOR']).'"</b> entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
			}
		}

		elseif($ruta <> 0 AND $cobrador == 0){
			$sql = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.usuario			AS USUARIO,
						dp.abono			AS ABONO,
						dp.mora				AS MORA,
						dp.total			AS TOTAL,
						dp.fecha_sugerida	AS FECHA_SUGERIDA,
						dp.fechaPago		AS FECHA_PAGO,
						dp.estado			AS ESTADO,
						dp.id_clientes		AS ID_CLIENTE,
						dp.id_usuario		AS ID_USUARIO,
						c.id_ruta			AS ID_RUTA,
						p.saldo_restante	AS RESTANTE,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						uu.usuario			AS USUARIO_REGISTRO,
						dp.usuario			AS ID_USUARIO_REGISTRO
						
					FROM 
						detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						
						c.id_ruta = '$ruta' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') ORDER BY dp.id_detalle ASC";
			$res = $mysqli->query($sql);

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

    ?>
    
	<style>
		table, tr, th, td{
			font-size: 11px;
			border: 1px solid #BDBDBD;
			font-family: tahoma;
		}
		
		th{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<center style="font-size: 16px; font-weight: bold;"><?php echo $titulo; ?><br><br></center>
	<table class="table table-striped table-bordered" cellspacing="0" width="100%" style="background-color: white;">
		<thead>
			<tr class="info">
				<th width="2">#</th>
				<th>Código</th>
				<th width="20%">Cliente</th>
				<th>Ruta</th>
				<th>Cobrador</th>
				<th>Registrado</th>
				<th>Fecha sugerida</th>
				<th>Fecha pago</th>
				<th>Abono</th>
				<th>Mora</th>
				<th>Total</th>
				<th>Restante</th>
				<th></th>
				<!--th width="2"></th-->
			</tr>
		</thead>
		<tbody>
			<?php
				$abono=0;
				$mora=0;
				$total=0;
				$restante=0;

				$i=1;

				//while($row = $resP->fetch_assoc()){
				while($row = mysqli_fetch_array($res)){
			?>

				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[10]); //id_cliente?></b></td>

					<td><?php echo Convertir($row['CLIENTE']); ?></td>
					<td><?php echo ruta($row['RUTA']); ?></td>
					<td><?php echo Convertir($row['USUARIO']); ?></td>
					<td><?php echo verificar($row['USUARIO_REGISTRO']); ?></td>
					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_SUGERIDA']); //Fecha sugerida ?></td>
					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_PAGO']); //Fecha inicial ?></td>

					<td><?php echo moneda($row['ABONO'], 'Q'); ?></td>
					<td><?php echo moneda($row['MORA'], 'Q'); ?></td>
					<td><?php echo moneda($row['TOTAL'], 'Q'); ?></td>
					<td><?php echo moneda($row['RESTANTE'], 'Q'); ?></td>
				
					<td>
						<?php
							if($row['ESTADO']==0){
								echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="Finalizado">Finalizado</spam>';
							}else{
								echo '<span class="label label-primary" data-toggle="tooltip" data-placement="top" title="Activo">Activo</spam>';
							} //Estado
						?>
					</td>
				</tr>
			<?php $i++; $abono=$abono+$row['ABONO']; $mora=$mora+$row['MORA']; $total=$total+$row['TOTAL']; $restante=$restante+$row['RESTANTE'];} ?>
		</tbody>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>

				<td></td>
				<td></td>
				<td align="right"><b>Totales:</b></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($abono, 'Q'); ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($mora, 'Q'); ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($total, 'Q'); //Monto ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($restante, 'Q'); //Monto ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
</body>
</html>