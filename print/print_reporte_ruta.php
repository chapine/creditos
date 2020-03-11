<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
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
			$sqlP = "SELECT
						p.*,
						c.nombre AS CLIENTE,
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						u.nombre AS COBRADOR,
						
						uu.nombre			AS USUARIO_REGISTRO

					FROM prestamos p, clientes c, rutas r, departamento d, usuarios u, usuarios uu

					WHERE
						c.id_cliente = p.id_clientes AND
						r.id_ruta = p.id_ruta AND
						d.id_departamento = r.id_departamento AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2'
				";
			
			$resP = $mysqli->query($sqlP);
			$titulo = 'Reporte de prestamos de todas las rutas y cobradores entre las fechas <b>"'.fecha('d-m-Y', $fecha1).' - '.fecha('d-m-Y', $fecha2).'"</b>';
		}
	
		elseif($ruta <> 0 AND $cobrador <> 0){
			$sqlP = "SELECT
						p.*,
						c.nombre AS CLIENTE,
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						u.nombre AS COBRADOR,
						
						uu.nombre			AS USUARIO_REGISTRO

					FROM prestamos p, clientes c, rutas r, departamento d, usuarios u, usuarios uu

					WHERE
						c.id_cliente = p.id_clientes AND
						r.id_ruta = p.id_ruta AND
						d.id_departamento = r.id_departamento AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						p.id_ruta = '$ruta' AND
						p.cobrador = '$cobrador' AND
						p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2'
					";
			
			$resP = $mysqli->query($sqlP);
			
			
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
			$sqlP = "SELECT
						p.fecha_inicial,
						p.fecha_final,
						p.monto_prestado,
						p.interes_pagar,
						p.saldo_restante,
						p.prestamo_activo,
						
						
						c.nombre AS CLIENTE,
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						u.usuario AS COBRADOR,
						uu.usuario			AS USUARIO_REGISTRO

					FROM prestamos p, clientes c, rutas r, departamento d, usuarios u, usuarios uu

					WHERE
						c.id_cliente = p.id_clientes AND
						r.id_ruta = p.id_ruta AND
						d.id_departamento = r.id_departamento AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						p.cobrador = '$cobrador' AND
						p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2'
				";
	
			$resP = $mysqli->query($sqlP);
			

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
			$sqlP = "SELECT
						p.*,
						c.nombre AS CLIENTE,
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						u.nombre AS COBRADOR,
						
						uu.nombre			AS USUARIO_REGISTRO

					FROM prestamos p, clientes c, rutas r, departamento d, usuarios u, usuarios uu

					WHERE
						c.id_cliente = p.id_clientes AND
						r.id_ruta = p.id_ruta AND
						d.id_departamento = r.id_departamento AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						p.id_ruta = '$ruta' AND
						p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2'
				";
	
			$resP = $mysqli->query($sqlP);
			
			
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
	<table cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="3%">#</th>
				<th>Código</th>
				<th width="20%">Cliente</th>
				<th>Ruta</th>
				<th>Cobrador</th>
				<th>Registrado</th>
				<th>Fecha inicial</th>
				<th>Fecha final</th>
				<th>Prestado</th>
				<th>Interes</th>
				<th>Restante</th>
				<th width="2"></th>
				<!--th width="5%" class="hidden-xs">Opciones</th-->
			</tr>
		</thead>
		<tbody>               
			<?php
				$tPrestado=0;
				$tInteres=0;
				$tRestante=0;
				$i=1;
				while($rowP = $resP->fetch_assoc()){

					$id_ruta = $rowP['id_ruta'];
					
					
					
			?>
				<tr>
					<td><?php echo '<font color="#ACACAC"><b>'.$i.'</b></font>'; ?></td>
					<td align="center"><b><?php echo formato($rowP['id_clientes']); //id_cliente?></b></td>
				
					<td><?php echo Convertir($rowP['CLIENTE']); ?></td>
					<td><?php echo ruta($rowP['RUTA']); ?></td>
					<td><?php echo Convertir($rowP['COBRADOR']); ?></td>
					<td><?php echo verificar($rowP['USUARIO_REGISTRO']); ?></td>
					
					<td><?php echo fecha('d-m-Y', $rowP['fecha_inicial']); ?></td>
					<td><?php echo fecha('d-m-Y', $rowP['fecha_final']); ?></td>

					<td><?php echo moneda($rowP['monto_prestado'], 'Q'); //Monto prestado ?></td>
					<td><?php echo moneda($rowP['interes_pagar'], 'Q'); //Interes ?></td>
					<td><?php echo moneda($rowP['saldo_restante'], 'Q'); //saldo_restante ?></td>
					
					<td><?php if($rowP['prestamo_activo']==0){echo '<span class="label label-success">Finalizado</spam>';}else{echo '<span class="label label-primary">Activo</spam>';} ?></td>

				</tr>
			<?php $i++; $tPrestado=($tPrestado+$rowP['monto_prestado']); $tInteres=($tInteres+$rowP['interes_pagar']); $tRestante=($tRestante+$rowP['saldo_restante']);} ?>
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
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tPrestado, 'Q');//Monto prestado ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tInteres, 'Q'); //interes ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tRestante, 'Q');//Monto restante ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>

</body>
</html>