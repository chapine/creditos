<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
		
		if($_REQUEST['a']==0){
			$a = 0;
			$texto = 'sin prestamos';
		}
		elseif($_REQUEST['a']==1){
			$a = 1;
			$texto = 'con prestamos';
		}
		
		$sql = "SELECT id_cliente, nombre, cel, dpi, direccion, cobrador, prestamoactivo, id_ruta FROM clientes WHERE prestamoactivo = $a";
		$result = $mysqli->query($sql);

		$title = 'Listado de clientes '.$texto;
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
			<tr class="info">
				<th width="2%">#</th>
				<th width="5%">Código</th>
				<th width="28%">Nombre</th>
				<th width="15%">Celular</th>
				<th width="20%">DPI</th>
				<th width="20%">Ruta</th>
				<th width="5%">Prestamo</th>
			</tr>
		</thead>
		<tbody>               
			<?php
				function formato($c){
					printf("%03d",  $c);
				}

				$i=1;

				while($row = mysqli_fetch_row($result)){

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
					<td><?php echo $row[1]; //nombre?></td>

					<?php if ($row[2]==''){echo '<td style="color: darkgrey">0000-0000</td>';}else{echo '<td>'.$row[2].'</td>';}//celular ?>

					<?php if ($row[3]==''){echo '<td style="color: darkgrey">0000-00000-0000</td>';}else{echo '<td>'.$row[3].'</td>';}//DPI ?>

					<td class="hidden-xs"><?php if($row[7] == 1){echo '<font color="#cccccc">Ninguno, Ninguno</font>';}else{echo $rowR['nombre'].', '.$rowD['nombre'];} ?></td>

					<?php
						if($row[6]==1){
							echo '<td align="center"><span class="label label-primary">Con prestamo</span></td>';
						}else{
							echo '<td align="center"><span class="label label-warning">Sin prestamo</span></td>';
						}//prestamo 
					?>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
</body>
</html>