<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM clientes WHERE cobrador = $usuario AND (id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%')";
		
		$sql_query = "SELECT id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta FROM clientes WHERE cobrador = $usuario AND
					
					(id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
	}

	if($a == 2){
?>
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th>#</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Celular</th>
				<th>DPI</th>
				<th>Ruta</th>
				<th width="2"></th>
				<th width="2"></th>
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
					<td align="center"><b><?php echo formato($row[0]); //id_cliente?></b></td>
					
					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="color: black;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row[1]); //nombre?>
						</a>
					</td>

					<td><? echo celular($row[2], ''); //CELULAR ?></td>
					<td><? echo dpi($row[3], ''); //DPI ?></td>
					<td><?php echo ruta($rowR['nombre'].', '.$rowD['nombre']); //RUTA ?></td>

					<?php
						if($row[6]==1){
							echo '<td><span class="label label-primary">Con prestamo</span></td>';
						}else{
							echo '<td><span class="label label-warning">Sin prestamo</span></td>';
						}//prestamo 
					?>

					<td width="120" align="center">
						<div class="btn-group" role="group">
							<?php
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

						  <ul class="dropdown-menu dropdown-menu-right">
							<li> <!-- Perfil del cliente -->
								<a href="#" onclick="location.href='perfil_cliente.php?id=<?php echo $row[0]; ?>'" style="color: black; font-weight: bold;">
									<i class="glyphicon glyphicon-user"></i> Perfil
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
<?php } ?>