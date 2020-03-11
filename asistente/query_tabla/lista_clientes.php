<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM clientes where (id_cliente LIKE '%".$query."%' OR  nombre LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
		
		$sql_query = "SELECT 
						id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta
					FROM 
						clientes
					WHERE
						(id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
	}

	if($a == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM clientes where cobrador = $usuario AND (id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
		
		$sql_query = "SELECT 
						id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta
					FROM 
						clientes
					WHERE
						 cobrador = $usuario AND (id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
	}
	

	if($a == 3){
?>

	<table class="table table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="1%">#</th>
				<!--th>Código</th-->
				<th width="98%">Nombre</th>
				<!--th>Celular</th>
				<th>DPI</th>
				<th width="30%">Ruta</th>
				<th width="2"></th-->
				<th width="1%"></th>
			</tr>
		</thead>
		<tbody>               
			<?php
				$i = $in;
				$finales = 0;

				while($row = mysqli_fetch_array($res_mostrar_registros)){

					if($row[7]==''){
						// Nada
					}else{
						$sqlR = "SELECT * FROM rutas WHERE id_ruta = ".$row[7];
						$resR = $mysqli->query($sqlR);
						$rowR = $resR->fetch_assoc();

						$sqlD = "SELECT * FROM departamento WHERE id_departamento = ".$rowR['id_departamento'];
						$resD = $mysqli->query($sqlD);
						$rowD = $resD->fetch_assoc();
					}
			?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<!--td align="center"><?php echo formato($row[0]); //id_cliente ?></td-->
					
					<script>
						$("#cursor_<?php echo $row[0]; ?>").hover(function(){
							//$(this).css("background-color", "yellow");
							$('#icon_<?php echo $row[0]; ?>').attr('style', 'color:#BBBBBB; visibility: visible;');
						}, function(){
							$('#icon_<?php echo $row[0]; ?>').attr('style', 'color:#BBBBBB; visibility: hidden;');
						});
					</script>
					
					<td id="cursor_<?php echo $row[0]; ?>" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="cursor: pointer">
						<a href="JavaScript:Void(0)" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="text-decoration: none;">
							<?php echo formato($row[0]); //id_cliente ?> - <?php echo Convertir($row[1]); //nombre?> <i class="glyphicon glyphicon-link" style="color:#BBBBBB; visibility: hidden;" id="icon_<?php echo $row[0]; ?>"></i>
						</a>
						<div style="color: #999999; font-size: 11px;">
							<?php echo celular($row[2], ''); ?>&nbsp;|&nbsp;
							<?php echo dpi($row[3], ''); ?>&nbsp;|&nbsp;
							<?php echo ruta($rowR['nombre'].', '.$rowD['nombre']); ?>|&nbsp;
							<?php
								if($row[6]==1){
									echo '<span class="label label-primary">Con prestamo</span>';
								}else{
									echo '<span class="label label-danger">Sin prestamo</span>';
								}//prestamo 
							?>
						</div>
					</td>

					<!--td><?php echo celular($row[2], ''); ?></td>
					<td><?php echo dpi($row[3], ''); ?></td>
					<td><?php echo ruta($rowR['nombre'].', '.$rowD['nombre']); ?></td-->

					

					<td width="120" align="center">
						<div class="btn-group" role="group">
							<?php
								$sqlU = "SELECT * FROM usuarios WHERE id_usuario=" . $row[5];
								$resU = $mysqli->query($sqlU);
								$rowU = $resU->fetch_assoc();

								if($row[5]<>0){
									$color = 'green';
									$texto = 'Cambiar cobrador <b>( ' . Convertir($rowU['nombre']) . ' )</b>';
									$icono = 'briefcase';
								}else{
									$color = 'black';
									$texto = 'Asignar cobrador';
									$icono = 'briefcase';
								}

								if($row[6]<>0){
									$color1 = '#337ab7';
									$texto1 = 'Ver prestamo(s) activo(s)';
									$icono1 = 'file';
									$link1 = "location.href='ver_prestamos.php?id=".$row[0]."'";
									$cursor = 'pointer';
								}else{
									$color1 = 'grey';
									$texto1 = 'El cliente no tiene prestamo';
									$icono1 = 'file';
									$link1 = "";
									$cursor = 'no-drop';
								}
							?>


						<div class="btn-group">
						  <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Opciones <span class="caret"></span>
						  </button>

						  <ul class="dropdown-menu dropdown-menu-right" style="z-index: 5;">
							<li> <!-- Perfil del cliente -->
								<a href="#" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="color: black; font-weight: bold;">
									<i class="glyphicon glyphicon-user"></i> Perfil
								</a>
							</li>

							<li> <!-- Conceder prestamo -->
								<a href="#" onclick="location.href='conceder_prestamo.php?id=<?php print($row[0]); ?>'" style="color: #A37427; font-weight: bold;">
									<i class="glyphicon glyphicon-ok"></i> Conceder prestamo
								</a>
							</li>

							<li role="separator" class="divider"></li>

							<li> <!-- Prestamos activos -->
								<a href="#" onclick="<?php echo $link1; ?>" style="color: <?php echo $color1; ?>; cursor: <?php echo $cursor; ?>;">
									<i class="glyphicon glyphicon-<?php echo $icono1; ?>"></i> <?php echo $texto1; ?>
								</a>
							</li>
						  </ul>
						</div>

					</td>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php		
	}
?>