<?php
	if($estado == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.prestamo_activo = 0";
	}


	if($estado == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 1 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 1 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}

	if($estado == 3){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 0 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND prestamo_activo = 0 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') order by p.id_prestamo";
	}

	if($estado == 4){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.fecha_siguiente < '$date' AND p.fecha_siguiente <> '1000-01-01' AND p.prestamo_activo = 1 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.fecha_siguiente < '$date' AND p.fecha_siguiente <> '1000-01-01' AND p.prestamo_activo = 1 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') ORDER BY p.fecha_inicial DESC";
	}

	if($estado == 5){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.cobrador = $usuario AND prestamo_activo = 1 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.cobrador = $usuario AND prestamo_activo = 1 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') ORDER BY p.prestamo_activo DESC";
	}

	if($estado == 6){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.fecha_siguiente < '$date' AND p.fecha_siguiente <> '1000-01-01' AND p.prestamo_activo = 1 AND p.cobrador = '$usuario' AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') ";
		
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.fecha_siguiente < '$date' AND p.fecha_siguiente <> '1000-01-01' AND p.prestamo_activo = 1 AND p.cobrador = '$usuario' AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') ORDER BY p.monto_prestado ASC";
	}

	if($estado == 7){
		$sql_contar = "SELECT count(*) AS numrows FROM prestamos p, clientes c, usuarios u, rutas r, departamento d WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.cobrador = $usuario AND p.prestamo_activo = 0 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND (c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente, p.id_ruta, concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.cobrador = $usuario AND p.prestamo_activo = 0 AND r.id_ruta = p.id_ruta AND d.id_departamento = r.id_departamento AND
			
			(c.id_cliente LIKE '%".$query."%' OR c.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%') ORDER BY p.prestamo_activo DESC";
	}



	if($a == 1){
?>

	<table class="table table-bordered" cellspacing="0" width="100%">
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


				<?php if($estado == 4 OR $estado == 6){ ?>
					<th width="2">Atrasado</th>
					<th width="2">Detalle</th>
				<?php }else{ ?>
					<th width="2"></th>
				<?php } ?>

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

					<?php if($estado == 4 OR $estado == 6){ ?>
					<td align="center">
						<b>
						<?php
							$fecha_inicial = fecha('d-m-Y', $row[11]);
							$fecha_final   = fecha('d-m-Y');
				
							$dias_atrasados = SumarDia($fecha_inicial, $fecha_final);
							$dd = $dias_atrasados;

							echo '<span class="label label-warning" data-toggle="tooltip" data-placement="left" title="Atrasado" style="font-size: 11px; cursor:pointer;"><font color="#000000">'.$dias_atrasados.' Dia(s)</font></spam>';
						?>
						</b>
					</td>
					
					<td>
						<button class="btn btn-info btn-xs" href="#detalle_de_atraso<?php echo $i; ?>" data-toggle="modal" style="outline: none;" data-placement="top" title="Ver detalle de los pagos atrasados">
							<i class="glyphicon glyphicon-eye-open"></i> Detalle
						</button>
						
						
						<!-- Modal -->
						<div class="modal fade" id="detalle_de_atraso<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header modal-header-warning">
										<h3><i class="glyphicon glyphicon-info-sign"></i> Detalles de la deuda</h3>
									</div>
									<div class="modal-body">
										
										<span style="font-size: 16px;"></span>
										<?php
											if($row['cuota']==23){		$mes	= 1;  } // 1 MES
											if($row['cuota']==46){		$mes	= 2;  } // 2 MESES
											if($row['cuota']==69){		$mes	= 3;  } // 3 MESES
											if($row['cuota']==92){		$mes	= 4;  } // 4 MESES
											if($row['cuota']==115){		$mes	= 5;  } // 5 MESES
											if($row['cuota']==138){		$mes	= 6;  } // 6 MESES
											if($row['cuota']==161){		$mes	= 7;  } // 7 MESES
											if($row['cuota']==184){		$mes	= 8;  } // 8 MESES
											if($row['cuota']==207){		$mes	= 9;  } // 9 MESES
											if($row['cuota']==230){		$mes	= 10; } // 10 MESES
											if($row['cuota']==253){		$mes	= 11; } // 11 MESES
											if($row['cuota']==276){		$mes	= 12; } // 12 MESES

											$monto_prestado = ($row['monto_prestado']+$row['interes_pagar']);

											// PAG= DIARIO
											if($mes	== 1 ){ $monto_diario = ($monto_prestado/23);  }
											if($mes == 2 ){ $monto_diario = ($monto_prestado/46);  }
											if($mes == 3 ){ $monto_diario = ($monto_prestado/69);  }
											if($mes	== 4 ){ $monto_diario = ($monto_prestado/92);  }
											if($mes == 5 ){ $monto_diario = ($monto_prestado/115); }
											if($mes == 6 ){ $monto_diario = ($monto_prestado/138); }
											if($mes == 7 ){ $monto_diario = ($monto_prestado/161); }
											if($mes == 8 ){ $monto_diario = ($monto_prestado/184); }
											if($mes == 9 ){ $monto_diario = ($monto_prestado/207); }
											if($mes == 10){ $monto_diario = ($monto_prestado/230); }
											if($mes == 11){ $monto_diario = ($monto_prestado/253); }
											if($mes == 12){ $monto_diario = ($monto_prestado/276); }

											// Monto Restante y Cuotas restantes
											$monto_restante = $row[8];
											$cuota_restante = ($monto_restante / $monto_diario);

											// Separamos el entero y decimales
											list($entero, $decimales) = explode(".", $cuota_restante);

											// Comprobamos si hay decimales o no
											if($decimales==''){
												$decimales = '0'; //Si no hay decimal
											}else{
												$decimales = '0.'.$decimales; //Si hay decimal agregamos 0 al inicio
											}


											//Si los dias atrasados es menor a los enteros
											if($dias_atrasados < $entero){
												if($decimales=='0'){ // SI NO TIENE DECIMALES
													$dias_atrasados = $dias_atrasados;
										?>
													<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="20%" align="right"><label>Saldo restante:</label></td>
																<td width="80%"><?php echo moneda($monto_restante, 'Q'); ?></td>
															</tr>
															<tr>
																<td width="20%" align="right"><label>Cuotas diarias sin pagar:</label></td>
																<td width="80%"><?php echo moneda(($dias_atrasados+$decimales), 'x'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Pago diario:</label></td>
																<td width="80%"><?php echo moneda($monto_diario, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%">&nbsp;</td>
																<td width="80%">&nbsp;</td>
															</tr>
															
															<tr>
																<td colspan="2"><h4>Los pagos retrasados corresponden a.</h4></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda(($dias_atrasados+$decimales), 'x'); ?> =</label></td>
																<td width="80%"><?php $p1=($monto_diario*$dias_atrasados); echo moneda($p1, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda($decimales, 'x'); ?> =</label></td>
																<td width="80%"><?php $p2=($monto_diario*$decimales); echo moneda($p2, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Total: (+)</label></td>
																<td width="80%" style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda(($p1+$p2), 'Q'); ?></td>
															</tr>

														</tbody>
													</table>

										<?php
												}else{ // SI TIENE DECIMALES
													$dias_atrasados = $dias_atrasados;
										?>
													<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="20%" align="right"><label>Saldo restante:</label></td>
																<td width="80%"><?php echo moneda($monto_restante, 'Q'); ?></td>
															</tr>
															
															<tr>
																<td width="20%" align="right"><label>Cuotas diarias sin pagar:</label></td>
																<td width="80%"><?php echo moneda(($dias_atrasados+$decimales), 'x'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Pago diario:</label></td>
																<td width="80%"><?php echo moneda($monto_diario, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%">&nbsp;</td>
																<td width="80%">&nbsp;</td>
															</tr>
															<tr>
																<td width="20%">&nbsp;</td>
																<td width="80%">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2"><h4>Los pagos retrasados corresponden a.</h4></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda(($dias_atrasados), 'x'); ?> =</label></td>
																<td width="80%"><?php $p1=($monto_diario*$dias_atrasados); echo moneda($p1, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda($decimales, 'x'); ?> =</label></td>
																<td width="80%"><?php $p2=($monto_diario*$decimales); echo moneda($p2, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Total: (+)</label></td>
																<td width="80%" style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda(($p1+$p2), 'Q'); ?></td>
															</tr>

														</tbody>
													</table>
										<?php
												}
												
												
												
											}else{
												if($decimales=='0'){
													$dias_atrasados = $entero;
										?>
													<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="20%" align="right"><label>Saldo restante:</label></td>
																<td width="80%"><?php echo moneda($monto_restante, 'Q'); ?></td>
															</tr>
															
															<tr>
																<td width="20%" align="right"><label>Cuotas diarias sin pagar:</label></td>
																<td width="80%"><?php echo moneda(($dias_atrasados+$decimales), 'x'); ?></td>
															</tr>

															<tr>
																<td width="20%"><label>Debería de haber finalizado hace:</label></td>
																<td width="80%"><?php echo moneda(($dd-($dias_atrasados+$decimales)), 'x'); ?> día(s)</td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Pago diario:</label></td>
																<td width="80%"><?php echo moneda($monto_diario, 'Q'); ?></td>
															</tr>
															
															<tr>
																<td width="20%">&nbsp;</td>
																<td width="80%">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2"><h4>Los pagos retrasados corresponden a.</h4></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda($dias_atrasados, 'x'); ?> =</label></td>
																<td width="80%"><?php $p1=($monto_diario*$dias_atrasados); echo moneda($p1, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda($decimales, 'x'); ?> =</label></td>
																<td width="80%"><?php $p2=0; echo moneda($p2, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Total: (+)</label></td>
																<td width="80%" style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda(($p1+$p2), 'Q'); ?></td>
															</tr>

														</tbody>
													</table>
										<?php
												}else{ // si tiene decimales
													$dias_atrasados = $entero;
										?>
													<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td width="20%" align="right"><label>Saldo restante:</label></td>
																<td width="80%"><?php echo moneda($monto_restante, 'Q'); ?></td>
															</tr>
															
															<tr>
																<td width="20%" align="right"><label>Cuotas diarias sin pagar:</label></td>
																<td width="80%"><?php echo moneda(($dias_atrasados+$decimales), 'x'); ?></td>
															</tr>

															<tr>
																<td width="20%"><label>Debería de haber finalizado hace:</label></td>
																<td width="80%"><?php echo moneda(($dd-($dias_atrasados+$decimales)), 'x'); ?> día(s)</td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Pago diario:</label></td>
																<td width="80%"><?php echo moneda($monto_diario, 'Q'); ?></td>
															</tr>
															
															<tr>
																<td width="20%">&nbsp;</td>
																<td width="80%">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2"><h4>Los pagos retrasados corresponden a.</h4></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda($dias_atrasados, 'x'); ?> =</label></td>
																<td width="80%"><?php $p1=($monto_diario*$dias_atrasados); echo moneda($p1, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label><?php echo moneda($decimales, 'x'); ?> =</label></td>
																<td width="80%"><?php $p2=($monto_diario*$decimales); echo moneda($p2, 'Q'); ?></td>
															</tr>

															<tr>
																<td width="20%" align="right"><label>Total: (+)</label></td>
																<td width="80%" style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda(($p1+$p2), 'Q'); ?></td>
															</tr>

														</tbody>
													</table>
										<?php
												}
											}
										?>
										
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-warning pull-rigth" data-dismiss="modal">Cerrar</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
						<!-- Modal -->
					</td>

					<?php }else{ ?>

					<td style="cursor:pointer;">
						<?php if($row[9]==0){echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="Finalizado">F</spam>';}else{echo '<span class="label label-primary" data-toggle="tooltip" data-placement="top" title="Activo">A</spam>';} ?>
					</td>
					<?php } ?>

					<td align="center">
						<div class="btn-group" role="group">
							<?php if($estado==1){ ?>
								<div class="btn-group">
								  <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Menú <span class="caret"></span>
								  </button>

								  <ul class="dropdown-menu dropdown-menu-right">
									<li> <!-- Editar -->
										<a href="#" onclick="location.href='detalle_prestamo.php?c=<?php echo $row[10]; ?>&id=<?php echo $row[0]; ?>'" style="color: dark; font-weight: bold;">
											<i class="glyphicon glyphicon-eye-open"></i> Ver préstamo
										</a>
									</li>
									
									<?php if($row[9]<>0){ ?>
										<li role="separator" class="divider"></li>

										<li> <!-- Renovar -->
											<a href="#" onclick="location.href='renovar.php?c=<?php echo $row[10]; ?>&p=<?php echo $row[0]; ?>'" style="color:teal; font-weight: bold;">
												<i class="glyphicon glyphicon-ok-sign"></i> Renovar
											</a>
										</li>
									<?php } ?>
									

								  </ul>
								</div>
							<?php }elseif($estado==2 OR $estado==4){ ?>
								<div class="btn-group">
								  <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Menú <span class="caret"></span>
								  </button>

								  <ul class="dropdown-menu dropdown-menu-right">
									<li> <!-- Editar -->
										<a href="#" onclick="location.href='detalle_prestamo.php?c=<?php echo $row[10]; ?>&id=<?php echo $row[0]; ?>'" style="color: dark; font-weight: bold;">
											<i class="glyphicon glyphicon-eye-open"></i> Ver préstamo
										</a>
									</li>
									  
									<li role="separator" class="divider"></li>

									<li> <!-- Renovar -->
										<a href="#" onclick="location.href='renovar.php?c=<?php echo $row[10]; ?>&p=<?php echo $row[0]; ?>'" style="color:teal; font-weight: bold;">
											<i class="glyphicon glyphicon-ok-sign"></i> Renovar
										</a>
									</li>

								  </ul>
								</div>
							<?php }else{ ?>
								<div class="btn-group">
								  <button type="button" class="btn btn-xs btn-xs btn-primary" onclick="location.href='detalle_prestamo.php?c=<?php echo $row[10]; ?>&id=<?php echo $row[0]; ?>'">
									<i class="glyphicon glyphicon-file"></i> Ver ptmo
								  </button>
								</div>
							<?php } ?>
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
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tPrestado, 'Q'); //prestado ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tInteres, 'Q'); //interes ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($tRestante, 'Q'); //restante ?></td>
				<td></td>
				<td></td>
				<td></td>
				<!--td></td>
				<td></td-->
			</tr>
		</tbody>
	</table>	
<?php		
	}
?>