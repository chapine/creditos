<?php
	if($estado == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
		
		$sql_query = "SELECT id_bitacora, usuario, descripcion, fecha FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
	}

	if($estado == 2){
		$sql_contar = "SELECT count(*) AS numrows FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND id_bitacora_codigo = $registro AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
		
		$sql_query = "SELECT id_bitacora, usuario, descripcion, fecha FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND id_bitacora_codigo = $registro AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
	}

	if($estado == 3){
		$sql_contar = "SELECT count(*) AS numrows FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND usuario = '$usuario' AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
		
		$sql_query = "SELECT id_bitacora, descripcion, fecha FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND usuario = '$usuario' AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
	}

	if($estado == 4){
		$sql_contar = "SELECT count(*) AS numrows FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND id_bitacora_codigo = $registro AND usuario = '$usuario' AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
		
		$sql_query = "SELECT id_bitacora, usuario, descripcion, fecha FROM bitacora WHERE id_bitacora_codigo <> 2 AND id_bitacora_codigo <> 6 AND id_bitacora_codigo <> 12 AND id_bitacora_codigo <> 16 AND id_bitacora_codigo <> 17 AND id_bitacora_codigo <> 18 AND id_bitacora_codigo <> 19 AND id_bitacora_codigo <> 20 AND id_bitacora_codigo <> 21 AND id_bitacora_codigo = $registro AND usuario = '$usuario' AND (fecha BETWEEN '$fecha1' AND '$fecha2') AND (descripcion LIKE '%".$query."%' OR usuario LIKE '%".$query."%') ORDER BY fecha ASC";
	}

	if($a == 1){

?>

	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
			    <th width="2%">#</th>
				<th width="2%">ID</th>
				<th width="80%">Descripción</th>
				<th width="18%">Fecha</th>
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
					<td><b><?php echo $row['id_bitacora']; ?></b></td>
					<td><?php echo '<b>'.$row['usuario'].'</b>, '.convertir($row['descripcion']); ?></td>
					<td align="center"><?php echo fecha('d-m-Y / g:i:s A', $row['fecha']); ?></td>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php } ?>