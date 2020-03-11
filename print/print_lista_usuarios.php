<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		
		if($_SESSION['tipo_usuario']=='administracion'){ $l_verificar = "administracion"; }
		if($_SESSION['tipo_usuario']=='administrador'){ $l_verificar = "administrador"; }
		if($_SESSION['tipo_usuario']=='asistente'){ $l_verificar = "asistente"; }

		if($_SESSION['tipo_usuario'] <> "$l_verificar"){
			echo"<script language='javascript'>window.location='../index.php'</script>;";
			exit();
		}
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$sql = "SELECT id_usuario, tipo_usuario, usuario, nombre, cel FROM usuarios WHERE id_usuario >= 1";
		$result=$mysqli->query($sql);

		$title = 'Listado de usuarios';
		$link = '../print/print_lista_usuarios.php';
    ?>
	<style>
		table, tr, th, td{
			font-size: 15px;
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
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th>#</th>
				<th>Nombre</th>
				<th>Celular</th>
				<th>Usuario</th>
				<th>Tipo</th>
			</tr>
		</thead>
		<tbody>               
			<?php $i=1; while($row = mysqli_fetch_row($result)){  ?>
				<tr>
					<td><?php echo $i; ?></td>


					<td><?php echo $row[3]; //nombre?></td>

					<?php if ($row[4]==''){echo '<td style="color: darkgrey">Ninguno</td>';}else{echo '<td>'.$row[4].'</td>';}//Celular ?>
					<td><?php echo $row[2]; //Usuario ?></td>
					<?php if ($row[1]=='a'){echo '<td class="success hidden-xs"><b>Administrador</b></td>';}else{echo '<td>Cobrador</td>';}//Tipo ?>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
</body>
</html>