<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM usuarios WHERE id_usuario <> 0 AND tipo_usuario = 'cobrador'";
		
		$sql_query = "SELECT * FROM usuarios WHERE id_usuario <> 0 AND tipo_usuario = 'cobrador' AND (nombre LIKE '%".$query."%' OR usuario LIKE '%".$query."%' OR cel LIKE '%".$query."%') order by id_usuario";
	}

	if($a == 2){
?>
	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="4%">#</th>
				<th width="30%">Nombre</th>
				<th width="10%">Usuario</th>
				<th width="8%">Celular</th>
				<th width="8%">Teléfono</th>
				<th width="10%">Fecha de nac.</th>
				<th width="20%">Dirección</th>
				<th width="5%">Tipo</th>
				<th width="5%"></th>
			</tr>
		</thead>
		<tbody>               
			<?php $i=$in; $finales=0; while($row = mysqli_fetch_row($res_mostrar_registros)){  ?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<td><?php echo Convertir($row[4]); //nombre ?></td>
					<td><?php echo $row[2]; //Usuario ?></td>
					<td><?php echo celular($row[6]); //Celular ?></td>
					<td><?php echo telefono($row[7]); //Telefono ?></td>
					<td><?php echo fecha('d-m-Y', $row[5]); //Fecha de nacimiento ?></td>
					<td><?php echo verificar($row[8]); //Dirección ?></td>
					
					<td>Cobrador</td>

					<td align="center">
						<div class="btn-group">
						  <button type="button" class="btn btn-xs btn-primary" onclick="location.href='perfil_usuario.php?id=<?php print($row[0]); ?>'">
							<i class="glyphicon glyphicon-user"></i> ver Perfil
						  </button>
						</div>
						</div>
					</td>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php } ?>