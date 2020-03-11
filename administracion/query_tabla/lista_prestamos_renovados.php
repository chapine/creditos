<?php
	if($estado == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.prestamo_activo = 1 AND p.renovacion <> '' AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%'  OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.prestamo_activo = 1 AND p.renovacion <> '' AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}

	if($estado == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.prestamo_activo = 0 AND p.renovacion <> '' AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%'  OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.prestamo_activo = 0 AND p.renovacion <> '' AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}

	if($a == 1){
?>

	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="3%">#</th>
				<!--th>Código</th-->
				<th width="20%">Cliente</th>
				<!--th>Ruta</th-->
				<!--th>Cobrador</th-->
				<th width="110">Prestado</th>
				<th width="110">Interes</th>
				<th width="110">Restante</th>
				<!--th width="90">Inicial</th-->
				<th width="90">Fecha</th>
				<th width="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$tPrestado=0;
				$tInteres=0;
				$tRestante=0;
				$i = $in;
				$finales = 0;

				while($row = mysqli_fetch_array($res_mostrar_registros)){
			?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<!--td align="center"><?php echo formato($row[15]); //id_cliente ?></td-->
					
					<script>
						$("#cursor_<?php echo $row[0]; ?>").hover(function(){
							//$(this).css("background-color", "yellow");
							$('#icon_<?php echo $row[0]; ?>').attr('style', 'color:#BBBBBB; visibility: visible;');
						}, function(){
							$('#icon_<?php echo $row[0]; ?>').attr('style', 'color:#BBBBBB; visibility: hidden;');
						});
					</script>
					
					<td id="cursor_<?php echo $row[0]; ?>" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="cursor: pointer">
						<a href="JavaScript:Void(0)" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="text-decoration: none;">
							<?php echo formato($row[15]); //id_cliente ?> - <?php echo Convertir($row[1]); //nombre?> <i class="glyphicon glyphicon-link" style="color:#BBBBBB; visibility: hidden;" id="icon_<?php echo $row[0]; ?>"></i>
						</a>
						<div style="color: #999999; font-size: 11px;">
							<?php echo ruta($row['RUTA']); ?>&nbsp;
							<i class="glyphicon glyphicon-shopping-cart"></i> <?php echo Convertir($row[2]); ?>&nbsp;
							
						</div>
					</td>
					
					<!--td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[10]); ?>'">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row[1]); //Cliente?>
						</a>
					</td>

					<td><?php echo ruta($row['RUTA']); ?></td>

					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php echo $row[12]; ?>'">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row[2]); //Cobrador?>
						</a>
					</td-->
					
					<td><?php echo moneda($row[4], 'Q'); //Monto prestado ?></td>
					<td><?php echo moneda($row[6], 'Q'); //interes ?></td>
					<td><?php echo moneda($row[8], 'Q'); // Restante ?></td>

					<td>
						<div>
							<b>Inicial: </b><?php echo fecha('d-m-Y', $row[5]); ?>
						</div>
						<div>
							<b>Final: </b><?php echo fecha('d-m-Y', $row[14]); //Fecha final ?>
						</div>
					</td>
					<!--td><?php echo fecha('d-m-Y', $row[5]); ?></td>
					<td><?php echo fecha('d-m-Y', $row[14]); //Fecha final ?></td-->

					<td align="center">
						<div class="btn-group">
							<button type="button" class="btn btn-xs btn-xs btn-primary" onclick="location.href='detalle_prestamo.php?c=<?php echo $row[10]; ?>&id=<?php echo $row[0]; ?>'">
								<i class="glyphicon glyphicon-file"></i> Ver ptmo
							</button>
						</div>
					</td>
				</tr>
			<?php $i++; $finales++; $tPrestado=($tPrestado+$row[4]); $tInteres=($tInteres+$row[6]); $tRestante=($tRestante+$row[8]);} ?>
		</tbody>
		<tbody>
			<tr>
				<!--td></td>
				<td></td>
				<td></td-->
				<td></td>
				<td align="right"><b>Totales:</b></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tPrestado, 'Q'); //Monto prestado ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tInteres, 'Q'); //interes ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tRestante, 'Q'); //Monto restante ?></td>
				<td></td>
				<!--td></td>
				<td></td-->
			</tr>
		</tbody>
	</table>
<?php		
	}
?>