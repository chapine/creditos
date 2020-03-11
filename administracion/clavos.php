<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "administracion";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$id_cliente 	= $_REQUEST['cliente'];
		$id_prestamo 	= $_REQUEST['prestamo'];

		// DATOS DEL DETALLE DEL PRESTAMO
		$sql = "SELECT p.*, c.nombre FROM prestamos p, clientes c WHERE c.id_cliente = p.id_clientes AND p.id_prestamo = $id_prestamo";
		$res = $mysqli->query($sql);
		$row = mysqli_fetch_array($res);
		
		if(!empty($_POST)){
			$cliente			= $id_cliente;
			$prestamo			= $id_prestamo;
			$usuario			= mysqli_real_escape_string($mysqli, $_POST['id_usuario']);
			$abono				= mysqli_real_escape_string($mysqli, $_POST['abono']);
			$mora				= mysqli_real_escape_string($mysqli, $_POST['mora']);
			$total				= ($abono + $mora);
			$fecha_pago			= mysqli_real_escape_string($mysqli, $_POST['fecha_pago']);
			
			
			$sqlPago = "
			INSERT INTO detalleprestamo
			
			(id_clientes, id_prestamo, id_usuario, abono, mora, total, fecha_sugerida, fechaPago, estado, observaciones, usuario)
			
			VALUES
			
			('$cliente', '$prestamo', '$usuario', '$abono', '$mora', '$total', '1000-01-01', '$fecha_pago', '1', '', '-1')";
			$resPago = $mysqli->query($sqlPago);
			
		}
			
		$title = 'Editar pago';
		include('head.php');
		$active_rutas="active";
    ?>
    
    <script>
		function validar()
		{
			document.registro.submit();
		}
	</script>
</head>
<body onload="Reloj()">
    <?php //include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-pencil'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<table class="table table-bordered" width="100%">
						<tr>
							<td width="30%" align="right"><label>ID CLIENTE:</label></td>
							<td width="70%"><?php echo $id_cliente; ?></td>
						</tr>
						<tr>
							<td align="right"><label>CLIENTE:</label></td>
							<td><?php echo $row['nombre']; ?></td>
						</tr>
						<tr>
							<td align="right"><label>ID PRESTAMO:</label></td>
							<td><?php echo $id_prestamo; ?></td>
						</tr>
						<tr>
							<td align="right"><label>MONTO PRESTADO:</label></td>
							<td><?php echo number_format($row['monto_prestado'],2,".",","); ?></td>
						</tr>
						<tr>
							<td align="right"><label>INTERES A PAGAR:</label></td>
							<td><?php echo number_format($row['interes_pagar'],2,".",","); ?></td>
						</tr>
						
						<?php
							$total_a_pagar = ($row['monto_prestado']+$row['interes_pagar']);
						?>
						
						<tr>
							<td align="right"><label>TOTAL A PAGAR:</label></td>
							<td><?php echo number_format($total_a_pagar,2,".",","); ?></td>
						</tr>
						<tr>
							<td align="right"><label>SALDO RESTANTE:</label></td>
							<td><b><?php echo number_format(($row['saldo_restante']),2,".",","); ?></b></td>
						</tr>
						<tr>
							<td align="right"><label>SALDO ABONADO TABLA PRESTAMO:</label></td>
							<?php
								$sql_1 = "SELECT sum(abono) as suma FROM detalleprestamo WHERE id_prestamo = $id_prestamo";
								$res_1 = $mysqli->query($sql_1);
								$row_1 = mysqli_fetch_array($res_1);
								$suma = $row_1['suma'];
								$restante_detalle = $total_a_pagar-$suma;
							?>
							<td><?php echo number_format($suma,2,".",","); ?></td>
						</tr>
						<tr>
							<td align="right"><label>SALDO RESTANTE SUMA DETALLE:</label></td>
							<td><b><?php echo number_format(($restante_detalle),2,".",","); ?></b></td>
						</tr>
						<tr>
							<td align="right"><label>COMPARAR SALDOS RESTANTE:</label></td>
							<td>
								<?php
									if( $row['saldo_restante'] == $restante_detalle ){
										echo '<b style="color:green;">IGUALES</b>';
									}else{
										echo '<b style="color:red;">DIFERENTES</b>';
									}
								?>
							</td>
						</tr>
					</table>
					
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<table class="table table-bordered" width="100%">
						<tr>
							<td align="right"><label for="mora">id_usuario:</label></td>
							<td>
								<div class="has-success has-feedback">
	<select class="form-control" id="id_usuario" name="id_usuario">
		<option>Ninguno</option>
		<option disabled>------------------------------</option>
		<?php
			$sql_3 = "SELECT id_usuario, nombre, usuario FROM usuarios WHERE id_usuario > 0";
			$res_3 = $mysqli->query($sql_3);
		
			while($row_3 = mysqli_fetch_array($res_3)){
				if($row_3['id_usuario']==19){ $sel='selected'; }else{ $sel=''; }
		?>
			<option <?php echo $sel; ?> value="<?php echo $row_3['id_usuario']; ?>"><?php echo convertir($row_3['nombre'].'&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;- '.$row_3['usuario']); ?></option>
		<?php } ?>
	</select>
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="abono">Monto a cobrar:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="abono" name="abono" type="number" autocomplete="off" onclick="select()">
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="mora">Mora:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="mora" name="mora" type="number" autocomplete="off" value="0" onclick="select()">
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="fecha_pago">Fecha de pago:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="fecha_pago" name="fecha_pago" type="date" autocomplete="off" onclick="select()">
								</div>
							</td>
						</tr>

						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='detalle_prestamo.php?c=<?php echo $c; ?>&id=<?php echo $id; ?>'" style="outline: none;">
									<span class="glyphicon glyphicon-backward"></span> Regresar
								</button>								
							</td>
						</tr>
					</table>
				</form>
				
				
				<table class="table table-striped table-bordered table-hover" width="100%">
					<tbody>
						<tr>
							<td width="3%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">#</td>
							<td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Cantidad</td>
							<td width="10%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Mora</td>
							<!--td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Fecha sugerida</td-->
							<td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Fecha de pago</td>
							<td width="19%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Total</td>
						</tr>
						<?php
							$i=1;
							$total = 0;
							$mora = 0;
						 
							$sql_Detalle = "SELECT * FROM detalleprestamo WHERE id_prestamo = '$id_prestamo' ORDER BY fechapago";
							$res_Detalle = $mysqli->query($sql_Detalle);
							//$row_1 = mysqli_fetch_array($res_Detalle);

							while($rowD = mysqli_fetch_row($res_Detalle)){
						?>
						<tr>
							<td align="center"><?php echo $i; ?></td>
							<td align="center"><?php echo moneda($rowD[4], 'Q'); ?></td>
							<td align="center"><?php echo moneda($rowD[5], 'Q'); ?></td>

							<!--td align="center"><?php if($rowD[7]=='1000-01-01'){echo '<font style="color: #8B8B8B;">0000-00-00</font>';}else{ echo fecha('d-m-Y', $rowD[7]);} ?></td-->

							<td align="center"><?php echo fecha('d-m-Y', $rowD[8]); ?></td>
							<td align="center"><?php echo moneda(($rowD[4]+$rowD[5]), 'Q'); ?></td>
						</tr>

						<?php $mora = $mora + $rowD[5]; $total = $total + $rowD[4]; $i++;} ?>
						<tr>
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
							<td align="right"><b>[+] Mora:</b></td>
							<td align="center" style="color: #660000; border-bottom: 3px solid red;"><?php echo moneda($mora, 'Q'); ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="right"><b>Gran total:</b></td>
							<td align="center" style="color: #660000; border-bottom: 3px double red;"><?php echo moneda(($total+$mora), 'Q'); ?></td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>