<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM rutas r, departamento d WHERE d.id_departamento = r.id_departamento AND r.id_ruta <> 1 AND (r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
		
		$sql_query = "SELECT r.id_ruta, r.nombre AS RUTA, d.nombre as DEPTO FROM rutas r, departamento d WHERE d.id_departamento = r.id_departamento AND r.id_ruta <> 1 AND (r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%')";
	}

	if($a == 2){
?>

	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="5%">#</th>
				<th width="50%">Ruta</th>
				<th width="45%">Departamento</th>
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
					<td><?php echo Convertir($row[1]); ?></td>
					<td><?php echo Convertir($row[2]); ?></td>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php } ?>