<!--?php
	if($estado == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.renovacion IS NULL AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante	AS RESTANTE,
						p.interes_pagar		AS INTERES,
						p.fecha_inicial		AS FECHAI,
						c.nombre			AS CLIENTE,
						p.prestamo_activo	AS ESTADO,
						p.id_ruta			AS ID_RUTA,
						u.nombre			AS NOMBRE_COBRADOR,
						p.mensualidades		AS MES,
						p.cuota				AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.renovacion IS NULL AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
						
					";
	}

	if($estado == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.renovacion IS NULL AND p.id_ruta = '$ruta' AND p.cobrador = '$cobrador' AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador 			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante 	AS RESTANTE,
						p.interes_pagar 	AS INTERES,
						p.fecha_inicial 	AS FECHAI,
						c.nombre 			AS CLIENTE,
						p.prestamo_activo 	AS ESTADO,
						p.id_ruta 			AS ID_RUTA,
						u.nombre 			AS NOMBRE_COBRADOR,
						p.mensualidades 	AS MES,
						p.cuota 			AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.renovacion IS NULL AND
						
						p.id_ruta = '$ruta' AND
						p.cobrador = '$cobrador' AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND 
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
						
					";
	}

	if($estado == 3){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.renovacion IS NULL AND p.cobrador = '$cobrador' AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador 			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante 	AS RESTANTE,
						p.interes_pagar 	AS INTERES,
						p.fecha_inicial 	AS FECHAI,
						c.nombre 			AS CLIENTE,
						p.prestamo_activo 	AS ESTADO,
						p.id_ruta 			AS ID_RUTA,
						u.nombre 			AS NOMBRE_COBRADOR,
						p.mensualidades 	AS MES,
						p.cuota 			AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.renovacion IS NULL AND
						
						p.cobrador = '$cobrador' AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND 
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
						
					";
	}

	if($estado == 4){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.renovacion IS NULL AND p.id_ruta = '$ruta' AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador 			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante 	AS RESTANTE,
						p.interes_pagar 	AS INTERES,
						p.fecha_inicial 	AS FECHAI,
						c.nombre 			AS CLIENTE,
						p.prestamo_activo 	AS ESTADO,
						p.id_ruta 			AS ID_RUTA,
						u.nombre 			AS NOMBRE_COBRADOR,
						p.mensualidades 	AS MES,
						p.cuota 			AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.renovacion IS NULL AND
						
						p.id_ruta = '$ruta' AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND 
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
					";
	}



	if($a == 1){
?-->


<?php
	if($estado == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante	AS RESTANTE,
						p.interes_pagar		AS INTERES,
						p.fecha_inicial		AS FECHAI,
						c.nombre			AS CLIENTE,
						p.prestamo_activo	AS ESTADO,
						p.id_ruta			AS ID_RUTA,
						u.nombre			AS NOMBRE_COBRADOR,
						p.mensualidades		AS MES,
						p.cuota				AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
						
					";
	}

	if($estado == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.id_ruta = '$ruta' AND p.cobrador = '$cobrador' AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador 			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante 	AS RESTANTE,
						p.interes_pagar 	AS INTERES,
						p.fecha_inicial 	AS FECHAI,
						c.nombre 			AS CLIENTE,
						p.prestamo_activo 	AS ESTADO,
						p.id_ruta 			AS ID_RUTA,
						u.nombre 			AS NOMBRE_COBRADOR,
						p.mensualidades 	AS MES,
						p.cuota 			AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.id_ruta = '$ruta' AND
						p.cobrador = '$cobrador' AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND 
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
						
					";
	}

	if($estado == 3){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.cobrador = '$cobrador' AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador 			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante 	AS RESTANTE,
						p.interes_pagar 	AS INTERES,
						p.fecha_inicial 	AS FECHAI,
						c.nombre 			AS CLIENTE,
						p.prestamo_activo 	AS ESTADO,
						p.id_ruta 			AS ID_RUTA,
						u.nombre 			AS NOMBRE_COBRADOR,
						p.mensualidades 	AS MES,
						p.cuota 			AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.cobrador = '$cobrador' AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND 
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
						
					";
	}

	if($estado == 4){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.id_ruta = '$ruta' AND (p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = p.usuario AND (p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						p.id_prestamo 		AS ID_PRESTAMO,
						p.id_clientes		AS ID_CLIENTE,
						p.cobrador 			AS COBRADOR,
						p.monto_prestado 	AS MONTO,
						p.saldo_restante 	AS RESTANTE,
						p.interes_pagar 	AS INTERES,
						p.fecha_inicial 	AS FECHAI,
						c.nombre 			AS CLIENTE,
						p.prestamo_activo 	AS ESTADO,
						p.id_ruta 			AS ID_RUTA,
						u.nombre 			AS NOMBRE_COBRADOR,
						p.mensualidades 	AS MES,
						p.cuota 			AS CUOTA,
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						
						p.fecha_final		AS FECHA_FINAL,
						uu.nombre			AS USUARIO_REGISTRO,
						p.usuario			AS USUARIO

					FROM prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d

					WHERE
						c.id_cliente = p.id_clientes AND
						u.id_usuario = p.cobrador AND
						uu.id_usuario = p.usuario AND
						
						r.id_ruta = c.id_ruta AND
						d.id_departamento = r.id_departamento AND
						
						p.id_ruta = '$ruta' AND
						
						(p.fecha_inicial BETWEEN '$fecha1' AND '$fecha2') AND 
						
						(p.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')
					";
	}



	if($a == 1){
?>

	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
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
				<!--th width="5%">Opciones</th-->
			</tr>
		</thead>
		<tbody>
			<?php
				$tPrestado=0;
				$tInteres=0;
				$tRestante=0;

				$i = $in;
				$finales = 0;

				//while($row = $resP->fetch_assoc()){
				while($row = mysqli_fetch_array($res_mostrar_registros)){
			?>

				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[1]); //id_cliente?></b></td>
					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row['ID_CLIENTE']); ?>'" style="text-decoration: none;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['CLIENTE']); //Cliente?>
						</a>
					</td>
					<td><?php echo ruta($row['RUTA']); ?></td>
					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php print($row['COBRADOR']); ?>'" style="text-decoration: none;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['NOMBRE_COBRADOR']); //Cobrador?>
						</a>
					</td>

					<td>
						<?php if($row['USUARIO']<1){ ?>
							<div style="color:#BBBBBB;">
								<i class="glyphicon glyphicon-link"></i> Ninguno
							</div>
						<?php }else{ ?>

							<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php print($row['USUARIO']); ?>'" style="color: black; text-decoration: none;">
								<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['USUARIO_REGISTRO']); //Cobrador?>
							</a>

						<?php } ?>
					</td>

					<td><?php echo fecha('d-m-Y', $row['FECHAI']); ?></td>
					<td><?php echo fecha('d-m-Y', $row['FECHA_FINAL']); ?></td>

					<td><?php echo moneda($row['MONTO'], 'Q'); //Monto prestado ?></td>
					<td><?php echo moneda($row['INTERES'], 'Q'); //interes ?></td>
					<td><?php echo moneda($row['RESTANTE'], 'Q'); //Saldo ?></td>
					<td><?php if($row['ESTADO']==0){echo '<span class="label label-success">Finalizado</spam>';}else{echo '<span class="label label-primary">Activo</spam>';} ?></td>

					<!--td width="120" align="center">
						<div class="btn-group" role="group">


	<div class="btn-group">
	<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	Opciones <span class="caret"></span>
	</button>

	<ul class="dropdown-menu dropdown-menu-right">

	<li> <!-- Editar - ->
	<a href="#" onclick="location.href='editar_ruta.php?id=<?php echo $row[0]; ?>'" style="color: darkgreen; font-weight: bold;">
	<i class="glyphicon glyphicon-pencil"></i> Editar
	</a>
	</li>

	<li> <!-- Eliminar - ->
	<a href="#" onclick="return confirmar('<?php print($row[0]); ?>');" style="color: red; font-weight: bold;">
	<i class="glyphicon glyphicon-trash"></i> Eliminar
	</a>
	</li>

	</ul>
	</div>

					</td-->
				</tr>
			<?php $i++; $finales++; $tPrestado=($tPrestado+$row['MONTO']); $tInteres=($tInteres+$row['INTERES']); $tRestante=($tRestante+$row['RESTANTE']);} ?>
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
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tPrestado, 'Q'); //Monto prestado ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tInteres, 'Q'); //interes ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tRestante, 'Q'); //Monto restante ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
<?php		
	}
?>