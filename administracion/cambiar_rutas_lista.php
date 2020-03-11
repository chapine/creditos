<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){
		
		$sql = "SELECT id_usuario, nombre FROM usuarios WHERE id_usuario > 0";
		$res_mostrar_registros = $mysqli->query("$sql"); // Query para mostrar los registros
	?>

		<table class="table table-striped" cellspacing="0" width="100%" style="background-color: white;">
			<thead>
				<tr class="info">
					<th width="2%">#</th>
					<th width="98%">Nombre</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; while($row = mysqli_fetch_array($res_mostrar_registros)){ ?>
				<tr>
					<td><b><?php echo $i; ?></b></td>
					<td><b><?php echo $row['nombre']; ?></b></td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<table class="table" cellspacing="0" width="100%" style="background-color: white; border: 1px solid #cccccc">
							<?php
								$ii=1;
								$id_usuario = $row['id_usuario'];

								$sql2 = "SELECT c.id_ruta AS ID, concat_ws(', ', r.nombre, d.nombre) AS RUTA FROM clientes c, rutas r, departamento d WHERE c.cobrador = $id_usuario AND r.id_ruta = c.id_ruta AND d.id_departamento = r.id_departamento GROUP BY c.id_ruta";
								$res2 = $mysqli->query("$sql2"); // Query para mostrar los registros
													
								$row_cnt = $res2->num_rows;

								if($row_cnt < 1){
									echo "<td width='100%' style='background-color: white; border: 1px solid #cccccc; color:#cccccc;'>No se encontrarón registros</td>";
								}

								while($row2 = mysqli_fetch_array($res2)){
							?>
									<tbody>
										<td width="2%" style="background-color: white; border: 1px solid #cccccc; color: darkgrey; font-weight: bold;"><?php echo $ii; ?></td>
										<td width="30%" style="background-color: white; border: 1px solid #cccccc"><?php echo $row2['RUTA']; ?></td>
										
										<?php
											$id_ruta = $row2['ID'];
											$sql3 = "SELECT 1 FROM clientes WHERE cobrador = $id_usuario AND id_ruta = $id_ruta";
											$res3 = $mysqli->query("$sql3"); // Query para mostrar los registros
									
											$row_cnt1 = $res3->num_rows;
										?>
										
										<td width="20%" style="background-color: white; border: 1px solid #cccccc;"><?php echo $row_cnt1; ?> cliente(s)</td>
										<td width="48%" style="background-color: white; border: 1px solid #cccccc;">
											<button type="button" class="btn btn-info btn-xs" onclick="location.href='cambiar_rutas_update.php?user=<?php echo $id_usuario; ?>&ruta=<?php echo $id_ruta; ?>'">Cambiar cobrador</button>
										</td>
									</tbody>
							<?php $ii++; } ?>
						</table>
					<td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>					
	<?php
	}	
?>