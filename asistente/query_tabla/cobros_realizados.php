<?php
	if($estado == 1){
		$sql_contar = "
			SELECT
				count(*) AS numrows 
			FROM
				detalleprestamo dp, clientes c, usuarios u, rutas r, departamento d
			WHERE
				c.id_cliente = dp.id_clientes AND
				u.id_usuario = dp.id_usuario AND
				u.id_usuario = $usuario AND
				(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
				r.id_ruta = c.id_ruta AND
				d.id_departamento = r.id_departamento AND
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
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA
						
					FROM 
						detalleprestamo dp, clientes c, usuarios u, rutas r, departamento d
						
					WHERE
						c.id_cliente = dp.id_clientes AND u.id_usuario = dp.id_usuario AND u.id_usuario = $usuario AND (dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.estado DESC";
	}

	if($estado == 2){
		$sql_contar = "
			SELECT
				count(*) AS numrows 
			FROM
				detalleprestamo dp, clientes c, usuarios u, rutas r, departamento d
			WHERE
				c.id_cliente = dp.id_clientes AND
				u.id_usuario = dp.id_usuario AND 
				(dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
				r.id_ruta = c.id_ruta AND
				d.id_departamento = r.id_departamento AND
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
						
						concat_ws(', ', r.nombre, d.nombre) AS RUTA,
						c.dpi				AS DPI,
						c.cel				AS CEL
						
					FROM 
						detalleprestamo dp, clientes c, usuarios u, rutas r, departamento d
						
					WHERE
						c.id_cliente = dp.id_clientes AND u.id_usuario = dp.id_usuario AND (dp.fechaPago BETWEEN '$fecha1' AND '$fecha2') AND
						
						r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento AND
						
						(dp.id_clientes LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY dp.estado DESC";
	}
	

	if($a == 1){
?>

	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="2">#</th>
				<th>Cliente</th>
				<th width="120">Monto</th>
				<th width="110">Fecha sugerida</th>
				<th width="110">Fecha inicial</th>
				<th width="2"></th>
				<th width="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$total=0;
				$i = $in;
				$finales = 0;

				while($row = mysqli_fetch_array($res_mostrar_registros)){
			?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					
					<td id="cursor_<?php echo $row[0]; ?>" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="cursor: pointer">
						<a href="JavaScript:Void(0)" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="text-decoration: none;">
							<?php echo formato($row['ID_CLIENTE']); //id_cliente ?> - <?php echo Convertir($row[1]); //nombre?> <i class="glyphicon glyphicon-link" style="color:#BBBBBB; visibility: hidden;" id="icon_<?php echo $row[0]; ?>"></i>
						</a>
						<div style="color: #999999; font-size: 11px;">
							<?php echo celular($row['CEL'], ''); ?>&nbsp;|&nbsp;
							<?php echo dpi($row['DPI'], ''); ?>&nbsp;|&nbsp;
							<?php echo ruta($row['RUTA']); ?>&nbsp;|&nbsp;
							<?php echo Convertir($row['USUARIO']); ?>&nbsp;|&nbsp;
							<?php
								if($row[6]==1){
									echo '<span class="label label-primary">Con prestamo</span>';
								}else{
									echo '<span class="label label-danger">Sin prestamo</span>';
								}//prestamo 
							?>
						</div>
					</td>

					<td><?php echo moneda($row['TOTAL'], 'Q'); //Monto ?></td>

					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_SUGERIDA']); //Fecha sugerida ?></td>
					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_PAGO']); //Fecha inicial ?></td>

					<td align="center" style="cursor:pointer;">
						<?php
							if($row['ESTADO']==0){
								echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="Finalizado">F</spam>';
							}else{
								echo '<span class="label label-primary" data-toggle="tooltip" data-placement="top" title="Activo">A</spam>';
							} //Estado
						?>
					</td>




					<td width="120" align="center">
						<div class="btn-group" role="group">

<div class="btn-group">
<button type="button" class="btn btn-xs btn-primary" onclick="location.href='detalle_prestamo.php?c=<?php echo $row['ID_CLIENTE']; ?>&id=<?php echo $row['ID_PRESTAMO']; ?>'">
<i class="glyphicon glyphicon-file"></i> ver ptmo
</button>
</div>

					</td>
				</tr>
			<?php $i++; $finales++; $total=$total+$row[6]; } ?>
		</tbody>
		<tbody>
			<tr>
				<td></td>
				<td align="right"><b>Totales:</b></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($total, 'Q'); //Monto ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
<?php		
	}
?>