<?php
	if($estado == 1){
		$sql_contar = "
			SELECT
				count(*) AS numrows
				
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
				
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
				
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
		
		$sql_query = "
			SELECT
				p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.prestamo_activo = 0";
	}

	if($estado == 2){
		$sql_contar = "
			SELECT
				count(*) AS numrows
				
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
				
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 1 AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
				
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
		
		
		$sql_query = "
			SELECT
				p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes,
				p.fecha_siguiente, p.cobrador, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 1 AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}

	if($estado == 3){
		$sql_contar = "
			SELECT
				count(*) AS numrows
				
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 0 AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
		
		
		$sql_query = "
			SELECT
				p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 0 AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}

	if($estado == 4){
		$sql_contar = "
			SELECT
				count(*) AS numrows
				
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.fecha_siguiente < '$date' AND prestamo_activo = 1 AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
		
		
		$sql_query = "
			SELECT
				p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.fecha_siguiente < '$date' AND prestamo_activo = 1 AND p.cobrador = $usuario AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
				(c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}
	if($a == 1){
?>
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="3%">#</th>
				<th width="25%">Cliente</th>
				<th>Ruta</th>
				<th>Cobrador</th>
				<th>Prestado</th>
				<th>Restante</th>
				<th>Fecha inicial</th>
				<th>Fecha sugerida</th>
				<th width="2"></th>
				<th width="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$tPrestado=0;
				$tRestante=0;
				
				$i = $in;
				$finales = 0;
				
				while($row = mysqli_fetch_array($res_mostrar_registros)){

					/*$id_ruta = $row[13];

					$sqlR = "SELECT
								r.id_ruta, r.id_departamento, r.nombre AS RUTA, d.nombre AS DEPARTAMENTO
							FROM rutas r, departamento d

							WHERE d.id_departamento = r.id_departamento AND r.id_ruta = $id_ruta";

					$resR = $mysqli->query($sqlR);
					$rowR = $resR->fetch_assoc();*/
			?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>

					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[10]); ?>'" style="color: black;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row[1]); //nombre?>
						</a>
					</td>

					<td><?php echo ruta($row['RUTA']); ?></td>
					<td><?php echo Convertir($row[2]); //Cobrador?></td>
					<td><?php echo moneda(($row[4]+$row[6]), 'Q'); //Monto prestado + interes ?></td>
					<td><?php echo moneda($row[8], 'Q'); // Saldo restante ?></td>
					<td><?php echo fecha('d-m-Y', $row[5]); //Fecha inicial ?></td>
					<td><?php echo fecha('d-m-Y', $row[11]); //Fecha siguiente ?></b>
					</td>

					<td>
						<?php if($row[9]==0){echo '<span class="label label-success">Finalizado</spam>';}else{echo '<span class="label label-primary">Activo</spam>';} ?>
					</td>

					<td width="120" align="center">
						  <button type="button" class="btn btn-xs btn-primary" onclick="location.href='detalle_prestamo.php?c=<?php echo $row[10]; ?>&id=<?php echo $row[0]; ?>'">
							<i class="glyphicon glyphicon-file"></i> Ver ptmo
						  </button>
					</td>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>	
<?php } ?>