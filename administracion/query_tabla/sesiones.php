<?php
	if($a == 1){
		$id_usuario_sesion = $_SESSION['id_usuario'];
		
		$sql_contar = "SELECT count(*) AS numrows FROM usuarios WHERE id_usuario >= '1' order by id_usuario";
		
		$sql_query = "SELECT id_usuario, tipo_usuario, usuario, nombre, cel, sesion, sesion_fecha FROM usuarios WHERE id_usuario >= '1' AND (nombre LIKE '%".$query."%' OR usuario LIKE '%".$query."%' OR cel LIKE '%".$query."%') order by id_usuario";
	}

	if($a == 2){
?>
	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th>#</th>
				<th width="20%">Nombre</th>
				<th>Celular</th>
				<th>Usuario</th>
				<th>Tipo</th>
				<th width="100">Inactivo hace</th>
				<th width="2"></th>
			</tr>
		</thead>
		<tbody>               
			<?php $i=$in; $finales=0; while($row = mysqli_fetch_array($res_mostrar_registros)){
					if($row['tipo_usuario']=='a'){ $color='danger'; }
					if($row['tipo_usuario']=='c'){ $color='warning';}
					if($row['tipo_usuario']=='s'){ $color='success';}
			?>
				<tr class="<?php echo $color; ?>">
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>


					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil" onclick="location.href='perfil_usuario.php?id=<?php print($row['id_usuario']); ?>'" style="color: black;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['nombre']); //nombre?>
						</a>
					</td>

					<td><?php echo celular($row['cel'], ''); //Celular ?></td>
					<td><?php echo $row['usuario']; //Usuario ?></td>
					
					
					
					<td>
						<b>
							<?php
								if($row[1]=='a'){ echo 'Administrador '; }
								if($row[1]=='c'){ echo 'Cobrador'; }
								if($row[1]=='s'){ echo 'Super administrador'; }
							?>
						</b>
					</td>

					<td align="center">
						<?php
							// Comprobar la sesión
																							   
							$sql_config = "SELECT * FROM configuracion WHERE id_config = 1";
							$res_config = $mysqli->query($sql_config);
							$row_config = $res_config->fetch_assoc();
							$cerrar_sesion_hora = $row_config['cerrar_sesion_hora'];

							$hora_actual_1 = date("Y-m-d H:i:s");
							$hora_sesion_1 = $row['sesion_fecha'];
							$cerrar_sesion_hora = $row_h['cerrar_sesion_hora'];

							$hora_actual_2 = new DateTime($hora_actual_1);
							$hora_sesion_2 = new DateTime($hora_sesion_1);

							$hora_diferencia = $hora_sesion_2->diff($hora_actual_2);

							if($hora_sesion_1 == '1000-01-01 00:00:00'){
								echo "<font color='#cccccc'>HH:mm:ss</font>";
							}else{
								echo $hora_diferencia->format("%H:%i:%s");
							}
						?>
					</td>
				
					<td width="90" align="center">
						<?php if($row['id_usuario'] <> $id_usuario_sesion AND $row['sesion']==1){ ?>
							<button type="button" class="btn btn-xs btn-danger" onclick="location.href='sesion_usuario.php?id=<?php print($row['id_usuario']); ?>&c=<?php echo base64_encode($row['nombre']); ?>'; return confirmar_eliminar();">
								<i class="glyphicon glyphicon-off"></i> Cerrar sesión
							</button>
							</div>
						<?php }elseif($row['id_usuario'] == $id_usuario_sesion){ ?>
							<button type="button" class="btn btn-xs btn-warning" disabled>
								<i class="glyphicon glyphicon-off"></i> Sesión actual
							</button>
						<?php }elseif($row['sesion']==0){ ?>
							<button type="button" class="btn btn-xs btn-warning" disabled>
								<i class="glyphicon glyphicon-off"></i> Cerrar sesión
							</button>
						<?php }elseif($row['sesion']==2){ ?>
							<button type="button" class="btn btn-xs btn-warning" disabled>
								<i class="glyphicon glyphicon-off"></i> Cerrar sesión
							</button>
						<?php } ?>
					</td>
				</tr>
			<?php $i++; $finales++; } ?>
		</tbody>
	</table>
<?php } ?>