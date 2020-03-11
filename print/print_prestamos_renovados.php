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
		
		require('fecha.php');
			
		$a = $_REQUEST['a'];
			
		if($a == 1){
			$sql = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente
			
			FROM prestamos p, clientes c, usuarios u
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.prestamo_activo = 1 AND p.renovacion <> '' order by p.id_prestamo";

			$title = 'Préstamos refinanciados activos';
			$result = $mysqli->query($sql);
		}

		if($a == 2){
			$sql = "SELECT p.id_prestamo, c.nombre, u.nombre, p.mensualidades, p.monto_prestado, p.fecha_inicial, p.interes_pagar, p.cuota, p.saldo_restante, p.prestamo_activo, p.id_clientes, p.fecha_siguiente, p.cobrador, p.id_ruta, p.fecha_final, c.id_cliente
			
			FROM prestamos p, clientes c, usuarios u
			
			WHERE c.id_cliente = p.id_clientes AND u.id_usuario = p.cobrador AND p.prestamo_activo = 0 AND p.renovacion <> '' order by p.id_prestamo";

			$title = 'Préstamos refinanciados finalizados';
			$result = $mysqli->query($sql);
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
    <!-- Contenido -->
	<center style="font-size: 32px; font-weight: bold;"><?php echo $title; ?><br><br></center>
	<table class="table table-striped table-bordered" cellspacing="0" width="100%" style="background-color: white;">
		<thead>
			<tr class="info">
				<th width="3%">#</th>
				<th>Código</th>
				<th width="20%">Cliente</th>
				<th>Ruta</th>
				<th>Cobrador</th>
				<th>Prestado</th>
				<th>Interes</th>
				<th>Restante</th>
				<th>Inicial</th>
				<th>Final</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;

				while($row = mysqli_fetch_row($result)){

					$id_ruta = $row[13];

					$sqlR = "SELECT
								r.id_ruta, r.id_departamento, r.nombre AS RUTA, d.nombre AS DEPARTAMENTO
							FROM rutas r, departamento d

							WHERE d.id_departamento = r.id_departamento AND r.id_ruta = $id_ruta";

					$resR = $mysqli->query($sqlR);
					$rowR = $resR->fetch_assoc();
			?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[15]); //id_cliente?></b></td>
					<td><?php echo Convertir($row[1]); //Cliente?></td>

					<td><?php echo ruta($rowR['RUTA'].', '.$rowR['DEPARTAMENTO']); ?></td>
					<td><?php echo Convertir($row[2]); //Cobrador?></td>
					<td><?php echo moneda($row[4], 'Q'); //Monto prestado ?></td>
					<td><?php echo moneda($row[6], 'Q'); //interes ?></td>
					<td><?php echo moneda($row[8], 'Q'); //RESTANTE ?></td>
					<td><?php echo fecha('d-m-Y', $row[5]); //Fecha inicial ?></td>
					<td><?php echo fecha('d-m-Y', $row[14]); ?></td>
				</tr>
			<?php $i++; $tPrestado=($tPrestado+$row[4]); $tInteres=($tInteres+$row[6]); $tRestante=($tRestante+$row[8]);} ?>
		</tbody>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="right"><b>Totales:</b></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><b>Q</b> <?php echo moneda($tPrestado, 'Q'); //Monto prestado ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><b>Q</b> <?php echo moneda($tInteres, 'Q'); //interes ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><b>Q</b> <?php echo moneda($tRestante, 'Q'); //Monto restante ?></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
</body>
</html>