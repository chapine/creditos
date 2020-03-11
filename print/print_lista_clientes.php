<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
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
		
		$numero = $_REQUEST['numero'];
		$usuario = $_SESSION['id_usuario'];
			
		if($numero == 1){
			$sql = "SELECT id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta FROM clientes";
			$res = $mysqli->query($sql);
			$title = 'Listado de clientes';
			$cobrador = '';
			
		}elseif($numero == 2){
			$sql = "SELECT id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta FROM clientes WHERE cobrador = $usuario";
			$res = $mysqli->query($sql);
			
			$sqlUU = "SELECT * FROM usuarios WHERE id_usuario = $usuario";
			$resUU = $mysqli->query($sqlUU);
			$rowUU = $resUU->fetch_assoc();
			
			$title = 'Listado de clientes del cobrador <br><b>' . $rowUU['nombre'].'</b>';
		}
    ?>
	<style>
		table, tr, th, td{
			font-size: 11px;
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
				<th>#</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Celular</th>
				<th>DPI</th>
				<th>Ruta</th>
				<th>Prestamo</th>
			</tr>
		</thead>
		<tbody>               
			<?php
				$i=1;

				while($row = mysqli_fetch_row($res)){

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
					<td><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[0]); //id_cliente?></b></td>
					<td><?php echo Convertir($row[1]); //nombre?></td>
					<td><?php echo celular($row[2]); //celular ?></td>
					<td><?php echo dpi($row[3]); //dpi ?></td>
					<td><?php echo ruta($rowR['nombre'].', '.$rowD['nombre']); //RUTA ?></td>

					<?php
						if($row[6]==1){
							echo '<td><span class="label label-primary">Con prestamo</span></td>';
						}else{
							echo '<td><span class="label label-warning">Sin prestamo</span></td>';
						}//prestamo 
					?>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
</body>
</html>