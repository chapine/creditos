<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM clientes where prestamoactivo = $estado AND (nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
		
		$sql_query = "SELECT 
						id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta
					FROM 
						clientes
					WHERE
						 prestamoactivo = $estado AND (nombre LIKE '%".$query."%' OR cel LIKE '%".$query."%' OR dpi LIKE '%".$query."%') order by id_cliente";
	}	

	if($a == 2){
?>

	<table class="table table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="1%">#</th>
				<!--th>Código</th-->
				<th width="99%">Nombre</th>
				<!--th>Celular</th>
				<th>DPI</th>
				<th width="30%">Ruta</th-->
				<!--th width="2"></th>
				<th width="2"></th-->
			</tr>
		</thead>
		<tbody>
			<?php
				$i = $in;
				$finales = 0;

				while($row = mysqli_fetch_row($res_mostrar_registros)){

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
						<a href="JavaScript:Void(0)" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row[0]); ?>'" style="text-decoration: none;">
							<?php echo formato($row[0]); //id_cliente ?> - <?php echo Convertir($row[1]); //nombre?> <i class="glyphicon glyphicon-link" style="color:#BBBBBB; visibility: hidden;" id="icon_<?php echo $row[0]; ?>"></i>
						</a>
						<div style="color: #999999; font-size: 11px;">
							<?php echo celular($row[2], ''); ?>&nbsp;|&nbsp;
							<?php echo dpi($row[3], ''); ?>&nbsp;|&nbsp;
							<?php echo ruta($rowR['nombre'].', '.$rowD['nombre']); ?>&nbsp;|&nbsp;
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

					<!--?php
						if($row[6]==1){
							echo '<td><span class="label label-primary">Con prestamo</span></td>';
						}else{
							echo '<td><span class="label label-info">Sin prestamo</span></td>';
						}//prestamo 
					?-->
					
					<!--td>
						<button type="button" onclick="location.href='conceder_prestamo.php?id=<?php print($row[0]); ?>'" class="btn btn-xs btn-primary">Dar prestamo <i class="glyphicon glyphicon-chevron-right"></i></button>
					</td-->
				</tr>				

			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php } ?>