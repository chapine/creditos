<?php
	if($a == 1){
		$sql_contar = "SELECT count(*) AS numrows FROM usuarios WHERE id_usuario >= 1 AND
						(nombre LIKE '%".$query."%' OR usuario LIKE '%".$query."%' OR cel LIKE '%".$query."%')";


		$sql_query = "SELECT id_usuario, tipo_usuario, usuario, nombre, cel FROM usuarios WHERE id_usuario >= 1 AND
						(nombre LIKE '%".$query."%' OR usuario LIKE '%".$query."%' OR cel LIKE '%".$query."%') order by tipo_usuario";
	}

	if($a == 2){
?>
	<table class="table ttable-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="2">#</th>
				<th width="60%">Nombre</th>
				<th width="60">Celular</th>
				<th width="60">Usuario</th>
				<th width="50">Tipo</th>
				<th width="90"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i=$in;
				$finales=0;
		
				while($row = mysqli_fetch_array($res_mostrar_registros)){
					
					if($row['tipo_usuario']=='administracion'){ $color='danger'; }
					if($row['tipo_usuario']=='administrador'){ $color='warning';}
					if($row['tipo_usuario']=='asistente'){ $color='success';}
					if($row['tipo_usuario']=='cobrador'){ $color='info';}
			?>
					<tr>
						<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>


						<td>
							<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil" onclick="location.href='perfil_usuario.php?id=<?php print($row['id_usuario']); ?>'">
								<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['nombre']); //nombre?>
							</a>
						</td>
						<td><?php echo celular($row['cel'], ''); //Celular ?></td>
						<td><?php echo $row[2]; //Usuario ?></td>

						<td class="<?php echo $color; ?>">
							<b>
								<?php
									if($row['tipo_usuario']=='administracion'){ echo 'Administracion'; }
									if($row['tipo_usuario']=='administrador'){ echo 'Administrador'; }
									if($row['tipo_usuario']=='asistente'){ echo 'Asistente'; }
									if($row['tipo_usuario']=='cobrador'){ echo 'Cobrador'; }
								?>
							</b>
						</td>

						<td align="center">
							<div class="btn-group">
							  <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Opciones <span class="caret"></span>
							  </button>

							  <ul class="dropdown-menu dropdown-menu-right">
								<li> <!-- Perfil -->
									<a href="#" onclick="location.href='perfil_usuario.php?id=<?php print($row['id_usuario']); ?>'" style="color: black; font-weight: bold;">
										<i class="glyphicon glyphicon-user"></i> Perfil
									</a>
								</li>

								<li role="separator" class="divider"></li>

								<li> <!-- Editar -->
									<a href="#" onclick="location.href='editar_usuario.php?id=<?php print($row['id_usuario']); ?>&tipo=<?php print($row['tipo_usuario']); ?>'" style="color: darkgreen; font-weight: bold;">
										<i class="glyphicon glyphicon-pencil"></i> Editar
									</a>
								</li>

								<?php if($row['tipo_usuario']=='s'){ }else{ ?>
								<li> <!-- Eliminar -->
									<a href="#" onclick="return confirmar('eliminar', '<?php print($row['id_usuario']); ?>', '<?php print($row[3]); ?>');" style="color: red; font-weight: bold;">
										<i class="glyphicon glyphicon-trash"></i> Eliminar
									</a>
								</li>
								<?php } ?>
							  </ul>
							</div>

						</td>
					</tr>
			<?php
					$i++;
					$finales++;
				}
			?>
		</tbody>
	</table>
<?php } ?>