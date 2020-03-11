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
		
		$a = $_REQUEST['a'];
		$t = $_REQUEST['t'];
		$fecha1 = $_REQUEST['fecha1'];
		$fecha2 = $_REQUEST['fecha2'];
		
		$sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador' AND id_usuario = $t";
		$res = $mysqli->query($sql);
		$row1 = mysqli_fetch_row($res);
		
		if($a==1 AND $t<>0){
			$sql = "SELECT dp.id_detalle, c.nombre, dp.id_prestamo, u.nombre, dp.abono, dp.mora, dp.total, dp.fecha_sugerida, dp.fechaPago, dp.estado, dp.id_clientes, dp.id_usuario, c.id_ruta
			
			FROM detalleprestamo dp, clientes c, usuarios u
			
			WHERE c.id_cliente = dp.id_clientes AND u.id_usuario = dp.id_usuario AND u.id_usuario = $t AND dp.fechaPago BETWEEN '$fecha1' AND '$fecha2' ORDER BY estado DESC";
			
			$title = 'Todos los cobros realizados entre la fecha '.fecha('d-m-Y', $fecha1).' a la '.fecha('d-m-Y', $fecha2).' <br>del cobrador '.$row1[4];
		}
		elseif($a==1 AND $t==0){
			$sql = "SELECT dp.id_detalle, c.nombre, dp.id_prestamo, u.nombre, dp.abono, dp.mora, dp.total, dp.fecha_sugerida, dp.fechaPago, dp.estado, dp.id_clientes, dp.id_usuario, c.id_ruta
			
			FROM detalleprestamo dp, clientes c, usuarios u
			
			WHERE c.id_cliente = dp.id_clientes AND u.id_usuario = dp.id_usuario AND dp.fechaPago BETWEEN '$fecha1' AND '$fecha2' ORDER BY estado DESC";
			
			$title = 'Todos los cobros realizados entre la fecha '.fecha('d-m-Y', $fecha1).' a la '.fecha('d-m-Y', $fecha2).' de todos los cobradores';
		}
		
		$result = $mysqli->query($sql);
		$res1 = $mysqli->query($sql);
    ?>
	<style>
		table, tr, th, td{
			font-size: 10px;
			border: 1px solid #BDBDBD;
			font-family: tahoma;
		}
		
		th{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<center style="font-size: 22px; font-weight: bold;"><?php echo $title; ?><br><br></center>
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr class="info">
				<th>#</th>
				<th>Código</th>
				<th width="25%">Cliente</th>
				<th>Ruta</th>
				<th>Cobrador</th>
				<th>Monto</th>
				<th>Fecha sugerida</th>
				<th>Fecha inicial</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$total=0;
				$i=1;

				while($row = mysqli_fetch_row($result)){

					$id_ruta = $row[12];

					$sqlR = "SELECT
								r.id_ruta, r.id_departamento, r.nombre AS RUTA, d.nombre AS DEPARTAMENTO
							FROM rutas r, departamento d

							WHERE d.id_departamento = r.id_departamento AND r.id_ruta = $id_ruta";

					$resR = $mysqli->query($sqlR);
					$rowR = $resR->fetch_assoc();
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[10]); //id_cliente?></b></td>
					<td><?php echo Convertir($row[1]); //Cliente ?></td>
					<td><?php echo ruta($rowR['RUTA'].', '.$rowR['DEPARTAMENTO']); ?></td>

					<td><?php echo Convertir($row[3]); //Cobrado ?></td>
					<td><?php echo moneda($row[6], 'Q'); //Monto ?></td>

					<td align="center"><?php echo fecha('d-m-Y', $row[8]); //Fecha sugerida ?></td>
					<td align="center"><?php echo fecha('d-m-Y', $row[5]); //Fecha inicial ?></td>

					<td align="center"><?php if($row[9]==0){echo 'Finalizado';}else{echo 'Activo';} //Estado ?></td>

				</tr>
			<?php $i++; $total=$total+$row[6]; } ?>
		</tbody>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="right"><b>Totale: </b></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($total, 'Q'); //Monto ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>

</body>
</html>