<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones

	$f1 = $_REQUEST['f1'];
	$f2 = $_REQUEST['f2'];

	echo '<center><b>Comisiones para cobradores desde ' . date('d-m-Y', strtotime($f1)) .' a '. date('d-m-Y', strtotime($f2)) . '</b><center><hr>';

	$sql = "
		SELECT
			u.nombre AS cobrador,
			Format(SUM(abono),2) AS suma,
			Format(((SUM(abono)*0.5)/100),2) AS por

		FROM
			detalleprestamo dp,
			usuarios u

		WHERE
			dp.id_usuario > 0 AND
			u.id_usuario = dp.id_usuario AND
			(dp.fechaPago BETWEEN '$f1' AND '$f2')
			GROUP BY dp.id_usuario;
	";
	$res = $mysqli->query($sql);

	while( $row = mysqli_fetch_array($res) ){
?>	
		<table width="100%" border="0" class="table table-striped" style="font-size: 14px; font-family: tahoma; text-transform:uppercase;">
			<tbody>
				<tr>
					<td width="300" align="right"><b><?php echo $row['cobrador']; ?>:</b></td>
					<td width="150" align="right">Q <?php echo $row['suma']; ?></td>
					<td width="2" align="center"><b>x</b></td>
					<td width="8" align="center">0.5%</td>
					<td width="2" align="center"><b>=</b></td>
					<td><b>Q <?php echo $row['por']; ?></b> <samp style="font-size: 12px; color: #9C9C9C;">Bonificación recomendada</samp></td>
				</tr>
			</tbody>
		</table>
	
		
		<a class="btn btn-sm btn-outline-danger" href="<?php echo PAGE .'ordenes/visualizar/'.$row['id_orden']; ?>" target="_blank">
			<b><?php echo $name; ?></b>
		</a>
<?php
	}
?>