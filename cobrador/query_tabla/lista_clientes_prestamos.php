<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM clientes where prestamoactivo = $estado AND cobrador = $usuario AND (id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%')";
		
		$sql_query = "
		SELECT
			id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta 
			
		FROM
			clientes 
		
		WHERE
			prestamoactivo = $estado AND cobrador = $usuario AND
		
		(id_cliente LIKE '%".$query."%' OR nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
	}	

	if($a == 2){
?>
	<table class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="2%">#</th>
				<th width="5%">Código</th>
				<th width="28%">Nombre</th>
				<th width="15%">Celular</th>
				<th width="20%">DPI</th>
				<th width="20%">Ruta</th>
				<th width="5%"></th>
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
					<td><?php echo celular($row[2], ''); ?></td>
					<td><?php echo dpi($row[3], ''); ?></td>
					<td><?php echo ruta($rowR['nombre'].', '.$rowD['nombre']); //RUTA ?></td>

					<?php
						if($row[6]==1){
							echo '<td align="center"><span class="label label-primary">Con prestamo</span></td>';
						}else{
							echo '<td align="center"><span class="label label-warning">Sin prestamo</span></td>';
						}//prestamo 
					?>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php } ?>