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

		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_GET['id']; // OBTIENE EL ID A EDITAR
		$c = $_GET['c'];

		$sqlC = "SELECT * FROM clientes WHERE id_cliente = ".$c;
		$resC = $mysqli->query($sqlC);
		$rowC = $resC->fetch_assoc();
		
		$sqlP = "SELECT * FROM prestamos WHERE id_prestamo = ".$id;
		$resP = $mysqli->query($sqlP);
		$rowP = $resP->fetch_assoc();

			
		$title = 'Detalles del prestamo';
		include('../a/head.php');
		$active_prestamos="active";
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
	<div class="panel-body">
		<div class="row">
			<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
				<div style="border:1px solid #ccc;"></div>
				<b>Datos del cliente</b> <div style="border:1px solid #ccc;"></div>
			</div>
			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<br><b>Nombre: </b><?php echo Convertir($rowC['nombre']); ?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Código: </b><?php echo formato($rowC['id_cliente']); ?>
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>DPI: </b><?php echo dpi($rowC['dpi']); ?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>NIT: </b><?php echo nit($rowC['nit']); ?>
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>Télefono: </b><?php echo telefono($rowC['tel']); ?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Celular: </b><?php echo celular($rowC['cel']); ?>
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>Prestamo activo: </b><?php if($rowC['prestamoactivo']==0){echo'No';}else{echo 'Si';} ?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">

			</div>

			<!-- Información del prestamo -->

			<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
				<br><div style="border:1px solid #ccc;"></div>
				<b>Información del prestamo</b>
				<div style="border:1px solid #ccc;"></div><br>
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>Forma de pago: </b>
				<?php
					if($rowP['forma_pago']==1){echo 'Efectivo';}
					if($rowP['forma_pago']==2){echo 'Cheque';}
					if($rowP['forma_pago']==3){echo 'Tarjeta de crédito';}
				?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Total del prestamo: </b><?php echo moneda($rowP['monto_prestado'], 'Q') ?>
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>Tiempo de pago: </b>
				<?php
					if($rowP['mensualidades']==1){echo 'Diario';}
					if($rowP['mensualidades']==2){echo 'Semanal';}
					if($rowP['mensualidades']==3){echo 'Quincenal';}
					if($rowP['mensualidades']==4){echo 'Mensual';}
				?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Interes: </b><?php echo $rowP['interes']; ?> %
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>Cuotas: </b><?php echo $rowP['cuota']; ?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Total del interes: </b><?php echo moneda($rowP['interes_pagar'], 'Q') ?>
			</div>

			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
				<b>Fecha inicial: </b><?php echo fecha('d-m-Y', $rowP['fecha_inicial']); ?>
			</div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Total a pagar: </b><?php echo moneda(($rowP['monto_prestado']+$rowP['interes_pagar']), 'Q') ?>
			</div>
			<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;"></div>
			<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
				<b>Saldo restante: </b><?php echo moneda(($rowP['saldo_restante']), 'Q') ?>
			</div>
		</div>


		<!-- Detalle de pagos -->

		<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
			<br><div style="border:1px solid #ccc;"></div>
			<b>Detalle de los pagos</b>
			<div style="border:1px solid #ccc;"></div><br>
		</div>

		<div class="col col-md-12">
			<table class="table table-striped table-bordered table-hover" width="100%">
				<tbody>
					<tr>
						<td width="3%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">#</td>
						<td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Cantidad</td>
						<td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Mora</td>
						<td width="20%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Fecha sugerida de pago</td>
						<td width="20%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Fecha de pago</td>
						<td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Total</td>
					</tr>
					<?php
						$sqlDetalle = "SELECT * FROM detalleprestamo WHERE id_prestamo = '$id'";
						$resDetalle = $mysqli->query($sqlDetalle);

						$i=1;
						$total = 0;
						$mora = 0;

						while($rowD = mysqli_fetch_row($resDetalle)){

					?>
					<tr>
						<td align="center"><?php echo $i; ?></td>
						<td align="center"><?php echo moneda($rowD[4], 'Q'); ?></td>
						<td align="center"><?php echo moneda($rowD[5], 'Q'); ?></td>
						<td align="center"><?php echo fecha('d-m-Y', $rowD[7]); ?></td>
						<td align="center"><?php echo fecha('d-m-Y', $rowD[8]); ?></td>
						<td align="center"><?php echo moneda(($rowD[4]+$rowD[5]), 'Q'); ?></td>
					</tr>
					<?php $mora = $mora + $rowD[5]; $total = $total + $rowD[4]; $i++;} ?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right"><b>Sub total:</b></td>
						<td align="center" style="color: #660000; border-top: 3px solid red;"><?php echo moneda($total, 'Q'); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right"><b>[+] Mora:</b></td>
						<td align="center" style="color: #660000; border-bottom: 3px solid red;"><?php echo moneda($mora, 'Q'); ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right"><b>Gran total:</b></td>
						<td align="center" style="color: #660000; border-bottom: 3px double red;"><?php echo moneda($total+$mora, 'Q'); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>