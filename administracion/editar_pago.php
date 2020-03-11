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
		
		$c = $_REQUEST['c'];
		$id = $_REQUEST['id'];
		$detalle = $_REQUEST['detalle'];
		$estado = $_REQUEST['estado'];
		
	
		$cliente = base64_decode($_REQUEST['cliente']);
		//$prestamo = moneda(base64_decode($_REQUEST['prestamo']), ',');
	
		$abono_actual = base64_decode($_REQUEST['abono_actual']);
		$mora_actual = base64_decode($_REQUEST['mora_actual']);
		$ob_actual = base64_decode($_REQUEST['ob']);

		// DATOS DEL DETALLE DEL PRESTAMO
		$sqlD = "SELECT * FROM detalleprestamo WHERE id_detalle = $detalle";
		$resD = $mysqli->query($sqlD);
		$rowD = $resD->fetch_assoc();
		
		if(!empty($_POST)){
			// OBTENEMOS LOS DATOS AL ENVIAR EL FORMULARIO
			$abono = mysqli_real_escape_string($mysqli,$_POST['abono']);
			$mora = mysqli_real_escape_string($mysqli,$_POST['mora']);
			$observaciones = mysqli_real_escape_string($mysqli,$_POST['observaciones']);
			
			// SUMA EL ABONO Y LA MORA
			$total = $abono + $mora;

			
			// Obtenemos el total de abonos
			$sql_sum = "SELECT monto_prestado, interes_pagar, saldo_restante FROM prestamos WHERE id_prestamo = $id";
			$res_sum = $mysqli->query($sql_sum);
			$row_sum = $res_sum->fetch_assoc();
			
			$total_prestamo = $row_sum['monto_prestado'] + $row_sum['interes_pagar'];
			
			// DATOS DEL DETALLE DEL PRESTAMO
			$sqlDetalle = "SELECT * FROM detalleprestamo WHERE id_detalle = $detalle";
			$resDetalle = $mysqli->query($sqlDetalle);
			$rowDetalle = $resDetalle->fetch_assoc();		
			
			// Nuevo saldo restante
			$nuevo_saldo_restante = $row_sum['saldo_restante'] + $rowDetalle['abono'];
			
			

			if($abono > $nuevo_saldo_restante ){
				$bandera = true;
				$msj = "No se puede actualizar el pago con una cantidad mayor al saldo restante de: ".moneda($nuevo_saldo_restante, '');
				$ico = "error";
				$boton = "danger";
				
			}elseif($abono == $abono_actual AND $mora == $mora_actual AND $ob_actual == $observaciones ){	
				$bandera = true;
				$msj = "No realizó ningún cambio, imposible actualizar";
				$ico = "info";
				$boton = "warning";
				
			}elseif(
				($abono < $nuevo_saldo_restante AND $mora == $mora_actual AND $ob_actual == $observaciones) OR
				($abono < $nuevo_saldo_restante AND $mora <> $mora_actual AND $ob_actual <> $observaciones) OR
				
				($abono < $nuevo_saldo_restante AND $mora <> $mora_actual AND $ob_actual == $observaciones) OR
				($abono < $nuevo_saldo_restante AND $mora == $mora_actual AND $ob_actual <> $observaciones)
			){
				$sql_update_DT = "UPDATE detalleprestamo SET abono = '$abono', mora = '$mora', total = '$total', observaciones = '$observaciones' WHERE id_detalle = $detalle";
				$res_update_DT = $mysqli->query($sql_update_DT);
				
				if(mysqli_affected_rows($mysqli) > 0){
					
					// Obtenemos el total de abonos
					$sql_sumar = "SELECT SUM(abono) AS ABONO FROM detalleprestamo WHERE id_prestamo = $id";
					$res_sumar = $mysqli->query($sql_sumar);
					$row_sumar = $res_sumar->fetch_assoc();
					$sumar_abonos = $row_sumar['ABONO'];

					// Nuevo saldo restante
					$saldo_restante_nuevo = ($total_prestamo - $sumar_abonos);


					$sql_update_P = "UPDATE prestamos SET saldo_restante = $saldo_restante_nuevo WHERE id_prestamo = $id";
					$res_update_P = $mysqli->query($sql_update_P);

					// BITACORA  --  BITACORA  --  BITACORA
					// BITACORA  --  BITACORA  --  BITACORA

					$usuario_bitacora = $_SESSION['nombre'];
					$id_bitacora_codigo		= "25";

					$id_cliente_bitacora		= "$c";
					$id_prestamo_bitacora		= "$id";
					$id_detalle_bitacora		= "$detalle";
					$id_ruta_bitacora			= "";
					$id_departamento_bitacora	= "";
					$id_usuario_bitacora		= "";

					$abono = moneda($abono);
					$mora = moneda($mora);

					$descripcion_bitacora	= "Modificó un pago de $abono con una mora de $mora del prestamo de $prestamo del cliente $cliente";

					include('../config/bitacora.php');

					// BITACORA  --  BITACORA  --  BITACORA
					// BITACORA  --  BITACORA  --  BITACORA

					$mensaje = base64_encode("El pago fue actualizado con éxito, con un nuevo abono de $abono y una mora de $mora");
					$color_mensaje = base64_encode("success");
					$icono_mensaje = base64_encode("success");
					header("Location: detalle_prestamo.php?c=$c&id=$id&mensaje=$mensaje&color_mensaje=$color_mensaje&icono_mensaje=$icono_mensaje");
				}else{
					$alert_bandera = true;
					$alert_titulo ="Error";
					$alert_mensaje ="Error al actualizar el registro";
					$alert_icono ="error";
					$alert_boton = "danger";
				}
			}elseif(
				($abono == $nuevo_saldo_restante AND $mora == $mora_actual AND $ob_actual == $observaciones) OR
				($abono == $nuevo_saldo_restante AND $mora <> $mora_actual AND $ob_actual <> $observaciones) OR
				
				($abono == $nuevo_saldo_restante AND $mora <> $mora_actual AND $ob_actual == $observaciones) OR
				($abono == $nuevo_saldo_restante AND $mora == $mora_actual AND $ob_actual <> $observaciones)
			){
				$sql_update_DT = "UPDATE detalleprestamo SET abono = '$abono', mora = '$mora', total = '$total', observaciones = '$observaciones' WHERE id_detalle = $detalle";
				$res_update_DT = $mysqli->query($sql_update_DT);
				
				if(mysqli_affected_rows($mysqli) > 0){
					$sql_update_P = "UPDATE prestamos SET saldo_restante = '0.00', prestamo_activo = '0' WHERE id_prestamo = $id";
					$res_update_P = $mysqli->query($sql_update_P);
					
					$sql_update_detalle = "UPDATE detalleprestamo SET estado WHERE id_prestamo = $id";
					$res_update_detalle = $mysqli->query($sql_update_detalle);

					// BITACORA  --  BITACORA  --  BITACORA
					// BITACORA  --  BITACORA  --  BITACORA

					$usuario_bitacora = $_SESSION['nombre'];
					$id_bitacora_codigo		= "25";

					$id_cliente_bitacora		= "$c";
					$id_prestamo_bitacora		= "$id";
					$id_detalle_bitacora		= "$detalle";
					$id_ruta_bitacora			= "";
					$id_departamento_bitacora	= "";
					$id_usuario_bitacora		= "";

					$abono = moneda($abono);
					$mora = moneda($mora);


					$descripcion_bitacora	= "Modificó un pago de $abono con una mora de $mora del prestamo de $prestamo del cliente $cliente";

					include('../config/bitacora.php');

					// BITACORA  --  BITACORA  --  BITACORA
					// BITACORA  --  BITACORA  --  BITACORA

					$mensaje = base64_encode("El pago fue actualizado con éxito, con un nuevo abono de $abono , una mora de $mora y se ha finalizado el préstamo");
					$color_mensaje = base64_encode("success");
					$icono_mensaje = base64_encode("success");
					header("Location: detalle_prestamo.php?c=$c&id=$id&mensaje=$mensaje&color_mensaje=$color_mensaje&icono_mensaje=$icono_mensaje");

					$resD = $mysqli->query($sqlD);
					$rowD = $resD->fetch_assoc();
				}else{
					$alert_bandera = true;
					$alert_titulo ="Error";
					$alert_mensaje ="Error al actualizar el registro";
					$alert_icono ="error";
					$alert_boton = "danger";
				}
			}
		}
			
		$title = 'Editar pago';
		include('head.php');
		$active_rutas="active";
    ?>
    
    <script>
		function Abono()
		{
			valor = document.getElementById("abono").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo abono", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.abono.focus(); }
					}
				);

				return false;
			} else { return true;}
		}
		
		function Mora()
		{
			valor = document.getElementById("mora").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo mora", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.mora.focus(); }
					}
				);
				
				return false;
			} else { return true;}
		}

		function validar()
		{
			if(Abono() && Mora())
			{
				document.registro.submit();
			}
		}
	</script>
</head>
<body onload="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">

        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="detalle_prestamo.php?c=<?php echo $c; ?>&id=<?php echo $id; ?>" class="btn btn-success">Detalle de prestamo</a>
                    <a class="btn btn-danger">Editar pago</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-pencil'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']."?a=b"; ?>" method="POST">
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="10%" align="right"><label>Abono:</label></td>
							<td width="90%"><?php echo moneda($rowD['abono'], 'Q'); ?></td>
						</tr>
						<tr>
							<td align="right"><label for="nombre">Mora:</label></td>
							<td><?php echo moneda($rowD['mora'], 'Q'); ?></td>
						</tr>
						<tr>
							<td align="right"><label for="nombre">Observaciones:</label></td>
							<td><?php echo $rowD['observaciones']; ?></td>
						</tr>

						<tr>
							<td align="right"><label for="abono">Nuevo abono:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="abono" name="abono" type="number" value="<?php echo $rowD['abono']; ?>" onclick="select()">
									<span class="glyphicon glyphicon-certificate form-control-feedback"></span>
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="mora">Nueva mora:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="mora" name="mora" type="number" value="<?php echo $rowD['mora']; ?>" onclick="select()">
									<span class="glyphicon glyphicon-certificate form-control-feedback"></span>
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="observaciones">Observaciones:</label></td>
							<td>
								<div class="has-success has-feedback">
									<textarea class="form-control textoarea" id="observaciones" name="observaciones" maxlength="200"><?php echo $rowD['observaciones']; ?></textarea>
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
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>