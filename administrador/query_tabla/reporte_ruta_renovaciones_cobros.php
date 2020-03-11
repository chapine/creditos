<?php
	if($estado == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d
					WHERE
						p.id_prestamo = dp.id_prestamo AND c.id_cliente = dp.id_clientes AND u.id_usuario = dp.id_usuario AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND p.renovacion <> '' AND
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND uu.id_usuario = dp.usuario AND
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.nombre			AS USUARIO,
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
						
						uu.nombre			AS USUARIO_REGISTRO,
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
						
						p.renovacion <> '' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC
					";
	}

	if($estado == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d
				WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						p.renovacion <> '' AND
						
						c.id_ruta = '$ruta' AND
						dp.id_usuario = '$cobrador' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC";
		
		$sql_query = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.nombre			AS USUARIO,
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
						
						uu.nombre			AS USUARIO_REGISTRO,
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
						p.renovacion <> '' AND
						
						c.id_ruta = '$ruta' AND
						dp.id_usuario = '$cobrador' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC
					";
	}

	if($estado == 3){
		$sql_contar = "SELECT count(*) AS numrows FROM detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d
				WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						p.renovacion <> '' AND
						
						dp.id_usuario = '$cobrador' AND
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC";
		
		$sql_query = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.nombre			AS USUARIO,
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
						
						uu.nombre			AS USUARIO_REGISTRO,
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
						p.renovacion <> '' AND

						dp.id_usuario = '$cobrador' AND
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC
					";
	}

	if($estado == 4){
		$sql_contar = "SELECT count(*) AS numrows FROM detalleprestamo dp, prestamos p, clientes c, usuarios u, usuarios uu, rutas r, departamento d
				WHERE
						p.id_prestamo = dp.id_prestamo AND
						c.id_cliente = dp.id_clientes AND
                        u.id_usuario = dp.id_usuario AND
						uu.id_usuario = dp.usuario AND
						
						r.id_ruta = c.id_ruta AND
                        d.id_departamento = r.id_departamento AND
						
						p.renovacion <> '' AND
						
						c.id_ruta = '$ruta' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC";
		
		$sql_query = "SELECT
						dp.id_detalle 		AS ID_DETALLE,
						c.nombre 			AS CLIENTE,
						dp.id_prestamo 		AS ID_PRESTAMO,
						u.nombre			AS USUARIO,
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
						
						uu.nombre			AS USUARIO_REGISTRO,
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
						
						p.renovacion <> '' AND
						
						c.id_ruta = '$ruta' AND
						
						(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.id_detalle ASC
					";
	}



	if($a == 1){
?>

	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="2">#</th>
				<th>Código</th>
				<th>Cliente</th>
				<th width="180">Ruta</th>
				<th width="180">Cobrador</th>
				<th width="180">Registrado</th>
				<th width="110">Fecha sugerida</th>
				<th width="110">Fecha pago</th>
				<th width="120">Abono</th>
				<th width="120">Mora</th>
				<th width="120">Total</th>
				<th width="120">Restante</th>
				<th width="2"></th>
				<!--th width="2"></th-->
			</tr>
		</thead>
		<tbody>
			<?php
				$abono=0;
				$mora=0;
				$total=0;
				$restante=0;

				$i = $in;
				$finales = 0;

				//while($row = $resP->fetch_assoc()){
				while($row = mysqli_fetch_array($res_mostrar_registros)){
			?>

				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[10]); //id_cliente?></b></td>

					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row['ID_CLIENTE']); ?>'" style=text-decoration: none;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['CLIENTE']); //Cliente?>
						</a>
					</td>

					<td><?php echo ruta($row['RUTA']); ?></td>

					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php print($row['ID_USUARIO']); ?>'" style=text-decoration: none;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['USUARIO']); //Cobrador?>
						</a>
					</td>

					<td>
						<?php if($row['ID_USUARIO_REGISTRO']<=0){ ?>
							<div style="color:#BBBBBB;">
								<i class="glyphicon glyphicon-link"></i> Ninguno
							</div>
						<?php }else{ ?>

							<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php print($row['ID_USUARIO_REGISTRO']); ?>'" style="text-decoration: none;">
								<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['USUARIO_REGISTRO']); //Usuario que registro?>
							</a>

						<?php } ?>
					</td>

					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_SUGERIDA']); //Fecha sugerida ?></td>
					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_PAGO']); //Fecha inicial ?></td>

					<td><?php echo moneda($row['ABONO'], 'Q'); ?></td>
					<td><?php echo moneda($row['MORA'], 'Q'); ?></td>
					<td><?php echo moneda($row['TOTAL'], 'Q'); ?></td>
					<td><?php echo moneda($row['RESTANTE'], 'Q'); ?></td>

					<td align="center" style="cursor:pointer;">
						<?php
							if($row['ESTADO']==0){
								echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="Finalizado">F</spam>';
							}else{
								echo '<span class="label label-primary" data-toggle="tooltip" data-placement="top" title="Activo">A</spam>';
							} //Estado
						?>
					</td>

					<!--td width="120" align="center">
						<div class="btn-group" role="group">
							<div class="btn-group">
								<button type="button" class="btn btn-xs btn-primary" onclick="location.href='detalle_prestamo.php?c=<?php echo $row['ID_CLIENTE']; ?>&id=<?php echo $row['ID_PRESTAMO']; ?>'">
									<i class="glyphicon glyphicon-file"></i> ver ptmo
								</button>
							</div>
						</div>
					</td-->
				</tr>
			<?php $i++; $finales++; $abono=$abono+$row['ABONO']; $mora=$mora+$row['MORA']; $total=$total+$row['TOTAL']; $restante=$restante+$row['RESTANTE'];} ?>
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
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($total, 'Q'); ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($restante, 'Q'); ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
<?php		
	}
?>