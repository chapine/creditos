<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		require('../config/funciones.php');
		
		if($_SESSION['tipo_usuario']=='administracion'){ $l_verificar = "administracion"; }
		if($_SESSION['tipo_usuario']=='administrador'){ $l_verificar = "administrador"; }
		if($_SESSION['tipo_usuario']=='asistente'){ $l_verificar = "asistente"; }

		if($_SESSION['tipo_usuario'] <> "$l_verificar"){
			echo"<script language='javascript'>window.location='../index.php'</script>;";
			exit();
		}
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$sql = "SELECT * FROM usuarios WHERE id_usuario <> 0 AND tipo_usuario = 'cobrador'";
		$result=$mysqli->query($sql);

		$title = 'Listado de cobradores';
    ?>
	<style>
		table, tr, th, td{
			font-size: 12px;
			border: 1px solid #BDBDBD;
			font-family: tahoma;
		}
		
		th{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<center style="font-size: 32px; font-weight: bold;"><?php echo $title; ?><br><br></center>
	<table cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th width="4%">#</th>
				<th width="25%">Nombre</th>
				<th>Usuario</th>
				<th>Celular</th>
				<th>Teléfono</th>
				<th>Fecha de nac.</th>
				<th>Dirección</th>
				<th>Tipo</th>
			</tr>
		</thead>
		<tbody>               
			<?php $i=1; while($row = mysqli_fetch_row($result)){  ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row[4]; //nombre?></td>
					<td><?php echo $row[2]; //Usuario ?></td>
					<?php if ($row[6]==''){echo '<td style="color: darkgrey">Ninguno</td>';}else{echo '<td>'.$row[6].'</td>';}//Telefono ?>
					<?php if ($row[7]==''){echo '<td style="color: darkgrey">Ninguno</td>';}else{echo '<td>'.$row[7].'</td>';}//Celular ?>
					<td><?php echo fecha('d-m-Y', $row[5]); //Fecha de nacimiento ?></td>
					<?php if ($row[8]==''){echo '<td style="color: darkgrey">Ninguno</td>';}else{echo '<td>'.$row[8].'</td>';}//Dirección ?>
					<td>Cobrador</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
</body>
</html>