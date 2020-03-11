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
		
		$sql = "SELECT r.id_ruta, r.nombre AS RUTA, d.nombre as DEPTO FROM rutas r, departamento d WHERE d.id_departamento = r.id_departamento AND r.id_ruta <> 1";
		$res = $mysqli->query($sql);
		
		$title = 'Listado de rutas';
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
	<table cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="5%">#</th>
				<th width="45%">Ruta</th>
				<th width="45%">Departamento</th>
			</tr>
		</thead>
		<tbody>               
			<?php $i = 1; while($row = mysqli_fetch_row($res)){ ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo Convertir($row[1]); ?></td>
					<td><?php echo Convertir($row[2]); ?></td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>

</body>
</html>