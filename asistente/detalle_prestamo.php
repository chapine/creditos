<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
	
		$l_verificar = 'asistente';
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

		require('fecha.php');

		// OBTIENE DATOS PARA EL FORMULARIO	
		$id 		= $_REQUEST['id']; // OBTIENE EL ID A EDITAR
		$c 			= $_REQUEST['c'];
		$usuario 	= $_SESSION['id_usuario'];

		$sqlC 		= "SELECT * FROM clientes WHERE id_cliente = $c";
		$resC 		= $mysqli->query($sqlC);
		$rowC 		= $resC->fetch_assoc();
		$u 			= $rowC['cobrador'];
		
		$sqlP = "SELECT * FROM prestamos WHERE id_prestamo = $id";
		$resP = $mysqli->query($sqlP);
		$rowP = $resP->fetch_assoc();
		
		if(!empty($_POST)){
			$cantidad_recibida	= mysqli_real_escape_string($mysqli,$_POST['cantidad_recibida']);
			$mora_recibida		= mysqli_real_escape_string($mysqli,$_POST['mora_recibida']);
			$no_boleta			= mysqli_real_escape_string($mysqli,$_POST['no_boleta']);
			$total				= ($cantidad_recibida + $mora_recibida);
			$fecha_sugerida 	= $rowP['fecha_siguiente'];
			$fecha 				= fecha('Y-m-d', '');
			$observaciones 		= mysqli_real_escape_string($mysqli,$_POST['observaciones']);
			
			if( $no_boleta == '' ){
				$saldo_restante = $rowP['saldo_restante'];
			
				if($cantidad_recibida == '0' AND $mora_recibida=='0'){
					$alert_bandera = true;
					$alert_titulo ="Error";
					$alert_mensaje ="Tiene que ingresar una cantidad";
					$alert_icono ="error";
					$alert_boton = "danger";
				}

				elseif($saldo_restante=='0.00'){
					$alert_bandera = true;
					$alert_titulo ="Error";
					$alert_mensaje ="El prestamo no tiene deuda";
					$alert_icono ="error";
					$alert_boton = "danger";
				}

				elseif($cantidad_recibida > $saldo_restante){
					$alert_bandera = true;
					$alert_titulo ="Error";
					$alert_mensaje ="La cantidad recibida es mayor al saldo restante";
					$alert_icono ="error";
					$alert_boton = "danger";

				}else{
					$sqlPago = "INSERT INTO detalleprestamo (id_clientes, id_prestamo, id_usuario, abono, mora, total, fecha_sugerida, fechaPago, estado, observaciones, usuario)
					VALUES
					('$c', '$id', '$u', '$cantidad_recibida', '$mora_recibida', '$total', '$fecha_sugerida', '$fecha', '1', '$observaciones', '$usuario');";
					$resPago = $mysqli->query($sqlPago);

					$insertado = mysqli_insert_id($mysqli);

					// PARA ACTUALIZAR LA FECHA NUEVA PARA COBRAR
					$fecha_tmp 		= $rowP['fecha_siguiente'];
					$mensualidad 	= $rowP['mensualidades'];

					if ($mensualidad == 1){ $FechaSig = FechaPago($fecha_tmp, "1"); }
					if ($mensualidad == 2){ $FechaSig = FechaPago($fecha_tmp, "6"); }
					if ($mensualidad == 3){ $FechaSig = FechaPago($fecha_tmp, "15"); }
					if ($mensualidad == 4){ $FechaSig = FechaPago($fecha_tmp, "30"); }

					$FechaSig = fecha('Y-m-d', $FechaSig);
					// PARA ACTUALIZAR LA FECHA NUEVA PARA COBRAR

					// RESTAR SALDO RESTANTE CON LA CANTIDAD RECIBIDA
					$nuevo_saldo_restante = $saldo_restante - $cantidad_recibida;

					if($saldo_restante == $cantidad_recibida){ //TERMINO DE PAGAR

						$sqlPrestamo1 = "UPDATE prestamos SET fecha_siguiente='1000-01-01', saldo_restante='0.00', prestamo_activo='0' WHERE id_prestamo=$id";
						$resPrestamo1 = $mysqli->query($sqlPrestamo1);

						$sqlPrestamo4 = "UPDATE detalleprestamo SET fecha_sugerida = '$fecha_sugerida', estado = '0' WHERE id_prestamo = $id";
						$resPrestamo4 = $mysqli->query($sqlPrestamo4);

						$sqlPrestamo2 = "SELECT id_prestamo, id_clientes, prestamo_activo FROM prestamos WHERE id_clientes = $c AND prestamo_activo = 1";
						$resPrestamo2 = $mysqli->query($sqlPrestamo2);

						$row_cnt = $resPrestamo2->num_rows;

						if($row_cnt == 0){
							$sqlCliente1 = "UPDATE clientes SET prestamoactivo='0' WHERE id_cliente = '$c' AND prestamoactivo = '1'";
							$resCliente1 = $mysqli->query($sqlCliente1);

							$sqlPrestamo3 = "UPDATE prestamos SET fecha_siguiente='1000-01-01', saldo_restante='0.00', prestamo_activo='0' WHERE id_clientes=$c";
							$resPrestamo3 = $mysqli->query($sqlPrestamo3);


						}
					}

					if($cantidad_recibida < $saldo_restante){ //AUN NO TERMINA DE PAGAR
						$fecha_pago_diario = date("Y-m-d", strtotime("$fecha +1 day"));
						
						$sqlPrestamo1 = "UPDATE prestamos SET fecha_siguiente='$FechaSig', saldo_restante='$nuevo_saldo_restante', prestamo_activo='1', fecha_pago_diario='$fecha_pago_diario' WHERE id_prestamo=".$id;
						$resPrestamo1 = $mysqli->query($sqlPrestamo1);
					}

					if($resPago > 0 AND $resPrestamo1 > 0){
						/*$alert_bandera = true;*/

						$resP = $mysqli->query($sqlP);
						$rowP = $resP->fetch_assoc();


						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$usuario_bitacora 			= $_SESSION['nombre'];
						$id_bitacora_codigo			= "24";
						$id_cliente_bitacora		= "$c";
						$id_prestamo_bitacora		= "$id";
						$id_detalle_bitacora		= "$insertado";
						$id_ruta_bitacora			= "";
						$id_departamento_bitacora	= "";
						$id_usuario_bitacora		= "";

						$cantidad_recibida = moneda($cantidad_recibida, '');
						$mora_recibida = moneda($mora_recibida, '');
						$total_prestamo = moneda(($rowP['monto_prestado']+$rowP['interes_pagar']), '');

						$descripcion_bitacora	= "Cobró $cantidad_recibida con una mora de $mora_recibida del préstamo de $total_prestamo del cliente ".$rowC['nombre'];

						include('../config/bitacora.php');

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						// Alerta para confirmar pago
						$_SESSION['alert_titulo']	= 'Éxito';
						$_SESSION['alert_mensaje'] 	= 'Pago registrado correctamente';
						$_SESSION['alert_boton'] 	= 'success';
						$_SESSION['alert_icono'] 	= 'success';

					}else{
						// Alerta si hay error
						$alert_bandera = true;
						$alert_titulo ="Error";
						$alert_mensaje ="Error al Registrar";
						$alert_icono ="error";
						$alert_boton = "danger";
					}
				}
			}else{
				$sql_boleta = "SELECT COUNT(*) boleta FROM detalleprestamo WHERE boleta_deposito = '$no_boleta'";
				$res_boleta = $mysqli->query($sql_boleta);
				$row_boleta = $res_boleta->fetch_assoc();
				$boleta_ 	= $row_boleta['boleta'];
				
				if( $boleta_ > 0 ){
					// Alerta si hay error
					$alert_bandera = true;
					$alert_titulo ="Error";
					$alert_mensaje ="No se puede registrar el pago, el no de boleta ingresado ya existe.";
					$alert_icono ="error";
					$alert_boton = "danger";
				}else{
					$saldo_restante = $rowP['saldo_restante'];
			
					if($cantidad_recibida == '0' AND $mora_recibida=='0'){
						$alert_bandera = true;
						$alert_titulo ="Error";
						$alert_mensaje ="Tiene que ingresar una cantidad";
						$alert_icono ="error";
						$alert_boton = "danger";
					}

					elseif($saldo_restante=='0.00'){
						$alert_bandera = true;
						$alert_titulo ="Error";
						$alert_mensaje ="El prestamo no tiene deuda";
						$alert_icono ="error";
						$alert_boton = "danger";
					}

					elseif($cantidad_recibida > $saldo_restante){
						$alert_bandera = true;
						$alert_titulo ="Error";
						$alert_mensaje ="La cantidad recibida es mayor al saldo restante";
						$alert_icono ="error";
						$alert_boton = "danger";

					}else{
						$sqlPago = "INSERT INTO detalleprestamo (id_clientes, id_prestamo, id_usuario, abono, mora, total, fecha_sugerida, fechaPago, estado, observaciones, usuario, boleta_deposito)
						VALUES
						('$c', '$id', '$u', '$cantidad_recibida', '$mora_recibida', '$total', '$fecha_sugerida', '$fecha', '1', '$observaciones', '$usuario', '$no_boleta');";
						$resPago = $mysqli->query($sqlPago);

						$insertado = mysqli_insert_id($mysqli);

						// PARA ACTUALIZAR LA FECHA NUEVA PARA COBRAR
						$fecha_tmp 		= $rowP['fecha_siguiente'];
						$mensualidad 	= $rowP['mensualidades'];

						if ($mensualidad == 1){ $FechaSig = FechaPago($fecha_tmp, "1"); }
						if ($mensualidad == 2){ $FechaSig = FechaPago($fecha_tmp, "6"); }
						if ($mensualidad == 3){ $FechaSig = FechaPago($fecha_tmp, "15"); }
						if ($mensualidad == 4){ $FechaSig = FechaPago($fecha_tmp, "30"); }

						$FechaSig = fecha('Y-m-d', $FechaSig);
						// PARA ACTUALIZAR LA FECHA NUEVA PARA COBRAR

						// RESTAR SALDO RESTANTE CON LA CANTIDAD RECIBIDA
						$nuevo_saldo_restante = $saldo_restante - $cantidad_recibida;

						if($saldo_restante == $cantidad_recibida){ //TERMINO DE PAGAR

							$sqlPrestamo1 = "UPDATE prestamos SET fecha_siguiente='1000-01-01', saldo_restante='0.00', prestamo_activo='0' WHERE id_prestamo=$id";
							$resPrestamo1 = $mysqli->query($sqlPrestamo1);

							$sqlPrestamo4 = "UPDATE detalleprestamo SET fecha_sugerida = '$fecha_sugerida', estado = '0' WHERE id_prestamo = $id";
							$resPrestamo4 = $mysqli->query($sqlPrestamo4);

							$sqlPrestamo2 = "SELECT id_prestamo, id_clientes, prestamo_activo FROM prestamos WHERE id_clientes = $c AND prestamo_activo = 1";
							$resPrestamo2 = $mysqli->query($sqlPrestamo2);

							$row_cnt = $resPrestamo2->num_rows;

							if($row_cnt == 0){
								$sqlCliente1 = "UPDATE clientes SET prestamoactivo='0' WHERE id_cliente = '$c' AND prestamoactivo = '1'";
								$resCliente1 = $mysqli->query($sqlCliente1);

								$sqlPrestamo3 = "UPDATE prestamos SET fecha_siguiente='1000-01-01', saldo_restante='0.00', prestamo_activo='0' WHERE id_clientes=$c";
								$resPrestamo3 = $mysqli->query($sqlPrestamo3);


							}
						}

						if($cantidad_recibida < $saldo_restante){ //AUN NO TERMINA DE PAGAR
							$sqlPrestamo1 = "UPDATE prestamos SET fecha_siguiente='$FechaSig', saldo_restante='$nuevo_saldo_restante', prestamo_activo='1' WHERE id_prestamo=".$id;
							$resPrestamo1 = $mysqli->query($sqlPrestamo1);
						}

						if($resPago > 0 AND $resPrestamo1 > 0){
							/*$alert_bandera = true;*/

							$resP = $mysqli->query($sqlP);
							$rowP = $resP->fetch_assoc();


							// BITACORA  --  BITACORA  --  BITACORA
							// BITACORA  --  BITACORA  --  BITACORA

							$usuario_bitacora 			= $_SESSION['nombre'];
							$id_bitacora_codigo			= "24";
							$id_cliente_bitacora		= "$c";
							$id_prestamo_bitacora		= "$id";
							$id_detalle_bitacora		= "$insertado";
							$id_ruta_bitacora			= "";
							$id_departamento_bitacora	= "";
							$id_usuario_bitacora		= "";

							$cantidad_recibida = moneda($cantidad_recibida, '');
							$mora_recibida = moneda($mora_recibida, '');
							$total_prestamo = moneda(($rowP['monto_prestado']+$rowP['interes_pagar']), '');

							$descripcion_bitacora	= "Cobró $cantidad_recibida con una mora de $mora_recibida del préstamo de $total_prestamo del cliente ".$rowC['nombre'];

							include('../config/bitacora.php');

							// BITACORA  --  BITACORA  --  BITACORA
							// BITACORA  --  BITACORA  --  BITACORA

							// Alerta para confirmar pago
							$_SESSION['alert_titulo']	= 'Éxito';
							$_SESSION['alert_mensaje'] 	= 'Pago registrado correctamente';
							$_SESSION['alert_boton'] 	= 'success';
							$_SESSION['alert_icono'] 	= 'success';

						}else{
							// Alerta si hay error
							$alert_bandera = true;
							$alert_titulo ="Error";
							$alert_mensaje ="Error al Registrar";
							$alert_icono ="error";
							$alert_boton = "danger";
						}
					}
				}
			}
		}
			
		$title = 'Detalles del prestamo';
		$link = '../print/print_detalle_prestamo.php?c='.$c.'&id='.$id;
		include('head.php');
		$active_prestamos="active";
    ?>
    
    <script>
		function enviar(){
			$('#registro').find('#guardar').attr('disabled','disabled');
			$('#registro').find('#guardar').html('<span class="glyphicon glyphicon-floppy-disk"></span> Procesando, espere...');
		}
		
		function no_enviar(){
			$('#registro').find('#guardar').removeAttr('disabled','disabled');
			$('#registro').find('#guardar').html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
		}
		
		
		function validarCantidad()
		{
			valor = document.getElementById("cantidad_recibida").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Tienes que ingresar una cantidad", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.cantidad_recibida.focus(), no_enviar(); }
					}
				);
				return false;
			} else { return true;}
		}
		
		function validarInteres()
		{
			valor = document.getElementById("mora_recibidaa").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Si no desea cobrar mora ingrese el número cero (0)", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.mora_recibidaa.focus(), no_enviar(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validar()
		{
			enviar();
			
			if( validarCantidad() && validarInteres() )
			{
				document.registro.submit();
			}
		}
		
		function confirmar(a, b, c, d, e, f, g, h, i){
			// MENSAJE SI EL CLIENTE NO TIENE COBRADOR
			swal({
				title: "Esta seguro que desea eliminar el pago?",
				type: "error",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "si",
				cancelButtonText: "Cancelar",
				closeOnConfirm: false,
				closeOnCancel: false
			},

				function(isConfirm){
					if(isConfirm){
						//swal.close(),
						confirmar_eliminar(),
						window.location.href="eliminar_pago.php?c="+a+"&id="+b+"&detalle="+c+"&cantidad="+d+"&mora="+e+"&estado="+f+"&cliente="+g+"&prestamo="+h;
					}else{
						swal.close();
					}
				}
			);
		}
	</script>
	
	<style>
		a.disabled {
		  /* Make the disabled links grayish*/
		  color: gray;
		  /* And disable the pointer events */
		  pointer-events: none;
		}
		
		.modal-header-warning {
			color:#fff;
			padding:0 15px 7px;
			border-bottom:1px solid #eee;
			background-color: #f0ad4e;
			-webkit-border-top-left-radius: 5px;
			-webkit-border-top-right-radius: 5px;
			-moz-border-radius-topleft: 5px;
			-moz-border-radius-topright: 5px;
			 border-top-left-radius: 5px;
			 border-top-right-radius: 5px;
		}
	</style>
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
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    
                    <a href="ver_prestamos.php?id=<?php echo $c; ?>" class="btn btn-default">Prestamo</a>
                    <a class="btn btn-danger">Det. ptmo.</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->			
			
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right hidden-xs">
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir</a>
				</div>
				<h4><i class='glyphicon glyphicon-file'></i> Detalles del prestamo</h4>
			</div>

			<div class="panel-body">
				<div class="panel" style="border: 2px solid green;">
					<div class="panel-body">
						<?php $porcentaje = porcentaje( ($rowP['monto_prestado']+$rowP['interes_pagar']), $rowP['saldo_restante'] ); ?>
						<div class="row">
							<div class="col-md-12">

								<h3 class="progress-title">Progreso del préstamo</h3>
								<div class="progress green">
									<div class="progress-bar" style="width:<?php echo $porcentaje; ?>%; background:#53aa2c;">
										<div class="progress-value"><?php echo $porcentaje; ?>%</div>
									</div>
								</div>
								
								<script>
									$(document).ready(function(){
										width = <?php echo $porcentaje; ?>;
										if( width < 13 ){
											$('.progress-bar').css('width', '88px');
										}
									});
								</script>

							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col col-md-12" style="padding-bottom: 5px; text-align: center; font-size: 18px;">
						<div style="border-bottom: 2px solid #ccc; padding: 0 0 25px 0; margin:  10px 0 10px 0;">
							<b>Datos personales</b>
						</div>
					</div>
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>Nombre: </b><?php echo convertir($rowC['nombre']); ?>
					</div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>Código: </b><?php echo formato($rowC['id_cliente']); ?>
					</div>
					
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>DPI: </b><?php echo dpi($rowC['dpi'], ''); ?>
					</div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>NIT: </b><?php echo nit($rowC['nit'], ''); ?>
					</div>
					
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>Télefono: </b><?php echo telefono($rowC['tel'], ''); ?>
					</div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>Celular: </b><?php echo celular($rowC['cel'], ''); ?>
					</div>
					
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>Prestamo activo: </b><?php if($rowP['prestamo_activo']==0){echo'No';}else{echo 'Si';} ?>
					</div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						
					</div>
					
					<!-- Información del prestamo -->
					
					<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
						<br><div style="border:1px solid #ccc;"></div><br>
						<b>Información del prestamo</b>
						<br><br><div style="border:1px solid #ccc;"></div><br>
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
						<b>Interes: </b><?php echo $rowP['interes']; ?>%
					</div>
					
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>Tiempo de pago: </b>
						<?php
							if($rowP['mensualidades']==1){echo 'Diario';}
							if($rowP['mensualidades']==2 OR $rowP['mensualidades']==5){echo 'Semanal';}
							if($rowP['mensualidades']==3){echo 'Quincenal';}
							if($rowP['mensualidades']==4){echo 'Mensual';}
						?>
					</div>
					
					
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>Total del prestamo:</b> <?php echo moneda($rowP['monto_prestado'], 'Q'); ?>
					</div>
					
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>Cuotas: </b><?php echo $rowP['cuota']; ?>
					</div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>Total del interes:</b> <?php echo moneda($rowP['interes_pagar'], 'Q'); ?>
					</div>
					
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;">
						<b>Fecha inicial: </b><?php echo fecha('d-m-Y', $rowP['fecha_inicial']); ?>
					</div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>Total a pagar:</b> <?php echo moneda(($rowP['monto_prestado']+$rowP['interes_pagar']), 'Q'); ?>
					</div>
					<div class="col col-md-8" style="font-size: 13px; padding-bottom: 5px;"></div>
					<div class="col col-md-4" style="font-size: 13px; padding-bottom: 5px;">
						<b>Saldo restante:</b> <?php echo moneda($rowP['saldo_restante'], 'Q'); ?>
					</div>
				
				
					<!-- INFORMACION DEL PRESTAMO  --  INFORMACION DEL PRESTAMO  --  INFORMACION DEL PRESTAMO -->
					<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
						<br><div style="border:1px solid #ccc;"></div><br>
						<b>Préstamo principal y renovaciones</b>
						<br><br><div style="border:1px solid #ccc;"></div><br>
					</div>
					<div class="col col-md-12" style="padding-bottom: 5px; text-align: center;">
						<?php
							if( $rowP['renovacion'] == 0 ){
								$renovacion = '';
							}else{
								$renovacion = $rowP['renovacion'];
							}

							$sql_contar_a = "SELECT count(1) AS Contar FROM prestamos WHERE renovacion = '$id'";
							$res_contar_a = $mysqli->query($sql_contar_a);
							$row_contar_a = $res_contar_a->fetch_assoc();
							$contar_a = $row_contar_a['Contar'];
							
							$sql_contar_b = "SELECT count(1) AS Contar FROM prestamos WHERE renovacion = '$renovacion'";
							$res_contar_b = $mysqli->query($sql_contar_b);
							$row_contar_b = $res_contar_b->fetch_assoc();
							$contar_b = $row_contar_b['Contar'];
			
							if($contar_a == 0 AND $contar_b == 0){ // IF para comprobar si no hay registros
								echo '<br><div class="alert alert-info" role="alert" style="text-align: center;"><b>Este préstamo no tiene renovaciones</b></div>';
							}else{ //ELSE para comprobar si hay registros
			
								if($renovacion <> ''){
									$sql_prestamo_a = "SELECT * FROM prestamos WHERE renovacion = $renovacion ORDER BY id_prestamo DESC";
									$res_prestamo_a = $mysqli->query($sql_prestamo_a);

									$sql_prestamo_b = "SELECT * FROM prestamos WHERE id_prestamo = $renovacion";
									$res_prestamo_b = $mysqli->query($sql_prestamo_b);
									$row_prestamo_b = $res_prestamo_b->fetch_assoc();
						?>
									<div class="alert alert-danger">
										<div class="row">
											<div class="col col-md-5" align="left">
												<?php echo '<b>#1 - Total de prestamo:</b> '.moneda(($row_prestamo_b['monto_prestado']+$row_prestamo_b['interes_pagar']), 'Q'); ?>
											</div>
											<div class="col col-md-5" align="left"><b>Fecha de pago:</b> <?php echo fecha('d-m-Y', $row_prestamo_b['fecha_inicial']); ?></div>
											
											<div class="col-md-2" align="right">
												<a onClick="location.href='detalle_prestamo.php?c=<?php echo $row_prestamo_b['id_clientes']; ?>&id=<?php echo $row_prestamo_b['id_prestamo']; ?>'" class="btn btn-xs btn-danger">&nbsp; Detalles</a>
											</div>
										</div>
									</div>

								<?php
									$i=2;

									while($row_prestamo_a = $res_prestamo_a->fetch_assoc()){
						?>
										<div class="alert alert-warning">
											<div class="row">
												<div class="col col-md-5" align="left">
													<?php echo '<b>#'.$i.' - Total de prestamo:</b> '.moneda(($row_prestamo_a['monto_prestado']+$row_prestamo_a['interes_pagar']), 'Q'); ?>
												</div>
												<div class="col col-md-5" align="left"><b>Fecha de pago:</b> <?php echo fecha('d-m-Y', $row_prestamo_a['fecha_inicial']); ?></div>
												
												<div class="col-md-2" align="right">
													<?php if($row_prestamo_a['id_prestamo'] == $id){ ?>
														<a class="btn btn-xs btn-warning" disabled>&nbsp; Actual</a>
													<?php }else{ ?>
														<a onClick="location.href='detalle_prestamo.php?c=<?php echo $row_prestamo_a['id_clientes']; ?>&id=<?php echo $row_prestamo_a['id_prestamo']; ?>'" class="btn btn-xs btn-warning">&nbsp; Detalles</a>
													<?php } ?>
												</div>
											</div>
										</div>
						<?php
										$i++;
									}
								}

								elseif($renovacion == ''){
									$sql_prestamo_a = "SELECT * FROM prestamos WHERE renovacion = $id ORDER BY id_prestamo DESC";
									$res_prestamo_a = $mysqli->query($sql_prestamo_a);

									$sql_prestamo_b = "SELECT * FROM prestamos WHERE id_prestamo = $id";
									$res_prestamo_b = $mysqli->query($sql_prestamo_b);
									$row_prestamo_b = $res_prestamo_b->fetch_assoc();
						?>
							
									<div class="alert alert-danger">
										<div class="row">
											<div class="col col-md-5" align="left">
												<?php echo '<b>#1 - Total de prestamo:</b> '.moneda(($row_prestamo_b['monto_prestado']+$row_prestamo_b['interes_pagar']), 'Q'); ?>
											</div>
											<div class="col col-md-5" align="left"><b>Fecha de pago:</b> <?php echo fecha('d-m-Y', $row_prestamo_b['fecha_inicial']); ?></div>
											
											<div class="col-md-2" align="right">
												<a class="btn btn-xs btn-danger" disabled>&nbsp; Actual</a>
											</div>
										</div>
									</div>
								
							<?php
									$i=2;

									while($row_prestamo_a = $res_prestamo_a->fetch_assoc()){
							?>
										<div class="alert alert-warning">
											<div class="row">
												<div class="col col-md-5" align="left">
													<?php echo '<b>#'.$i.' - Total de prestamo:</b> '.moneda(($row_prestamo_a['monto_prestado']+$row_prestamo_a['interes_pagar']), 'Q'); ?>
												</div>
												<div class="col col-md-5" align="left"><b>Fecha de pago:</b> <?php echo fecha('d-m-Y', $row_prestamo_a['fecha_inicial']); ?></div>
												
												<div class="col-md-2" align="right">
													<a onClick="location.href='detalle_prestamo.php?c=<?php echo $row_prestamo_a['id_clientes']; ?>&id=<?php echo $row_prestamo_a['id_prestamo']; ?>'" class="btn btn-xs btn-warning">&nbsp; Detalles</a>
												</div>
											</div>
										</div>
						<?php
										$i++;
									}
								}
							} // ELSE para comprobar si hay registros
						?>
					</div><!-- INFORMACION DEL PRESTAMO  //  INFORMACION DEL PRESTAMO  //  INFORMACION DEL PRESTAMO -->
				
				
				
				
					<!-- Cobrar -->	
					<div class="col col-md-12">
						<?php
							if($rowP['prestamo_activo']<>0){ // <-- COMPROBAMOS SI EL PRESTAMO ESTA ACTIVO -->
						?>
							<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
								<br><div style="border:1px solid #ccc;"></div><br>
								<b>Cobrar</b>
								<br><br><div style="border:1px solid #ccc;"></div><br>
							</div>

							<div class="col col-md-6" style="font-size: 13px; padding-bottom: 5px;">
								<div class="col col-md-12" style=" padding: 5px; text-align: center; font-size: 18px; background-color: #99FF00;">
									<b>
										<?php
											if($rowP['mensualidades']==1){echo 'Paga diariamente';}
											if($rowP['mensualidades']==2){echo 'Paga semanalmente';}
											if($rowP['mensualidades']==3){echo 'Paga quincenalmente';}
											if($rowP['mensualidades']==4){echo 'Paga mensualmente';}
											if($rowP['mensualidades']==5){echo 'Pago semanal sugerido:';}
										?>
									</b>
								</div>

								<!-- INFORMACION SOBRE LA FECHA SUGERIDA DE PAGO Y LA CANTIDAD A PAGAR -->
								<div class="col col-md-12" style=" padding: 5px;">
									<table class="table table-striped table-bordered" width="100%">
										<tbody>
											<tr>
												<td align="right" width="50%"><b>Fecha sugerida de pago:</b></td>
												<td width="50%">
													<?php 
														if($rowP['fecha_siguiente']=='1000-01-01'){
															echo '<font color="#cccccc">Finalizo de pagar</font>';
															$color ='#cccccc';
														}else{
															echo fecha('d-m-Y', $rowP['fecha_siguiente']);
															$color ='#000000';
														}
													?>
												</td>
											</tr>
											<tr>
												<td align="right">
													<b>
														<?php
															if($rowP['mensualidades']==1){echo 'Pago diario sugerido:';}
															if($rowP['mensualidades']==2){echo 'Pago semanal sugerido:';}
															if($rowP['mensualidades']==3){echo 'Pago quincenal sugerido:';}
															if($rowP['mensualidades']==4){echo 'Pago mensual sugerido:';}
															if($rowP['mensualidades']==5){echo 'Pago semanal sugerido:';}
														?>
													</b>
												</td>
												<td style="color: <?php echo $color; ?>;">
													<?php
														if($rowP['mensualidades']==1){	$diario = 1;} // DIARIO
														if($rowP['mensualidades']==2){	$diario = 2;} // SEMANAL
														if($rowP['mensualidades']==3){	$diario = 3;} // QUINCENAL
														if($rowP['mensualidades']==4){	$diario = 4;} // MENSUAL
								
														if($rowP['mensualidades']==5){	$diario = 5;} // Semanal

														if($rowP['cuota']==5){			$mes	= 0;  } // 1 SEMANA
														if($rowP['cuota']==23){			$mes	= 1;  } // 1 MES
														if($rowP['cuota']==46){			$mes	= 2;  } // 2 MESES
														if($rowP['cuota']==69){			$mes	= 3;  } // 3 MESES
														if($rowP['cuota']==92){			$mes	= 4;  } // 4 MESES
														if($rowP['cuota']==115){		$mes	= 5;  } // 5 MESES
														if($rowP['cuota']==138){		$mes	= 6;  } // 6 MESES
														if($rowP['cuota']==161){		$mes	= 7;  } // 7 MESES
														if($rowP['cuota']==184){		$mes	= 8;  } // 8 MESES
														if($rowP['cuota']==207){		$mes	= 9;  } // 9 MESES

														if($rowP['cuota']==230){		$mes	= 10; } // 10 MESES
														if($rowP['cuota']==253){		$mes	= 11; } // 11 MESES
														if($rowP['cuota']==276){		$mes	= 12; } // 12 MESES
								


														$monto_prestado = ($rowP['monto_prestado']+$rowP['interes_pagar']);

														// PAGA DIARIO
														if($diario == 1 && $mes	== 0 ){ echo moneda(($monto_prestado/5),   'Q'); }
														if($diario == 1 && $mes	== 1 ){ echo moneda(($monto_prestado/23),  'Q'); }
														if($diario == 1 && $mes == 2 ){ echo moneda(($monto_prestado/46),  'Q'); }
														if($diario == 1 && $mes == 3 ){ echo moneda(($monto_prestado/69),  'Q'); }
														if($diario == 1 && $mes	== 4 ){ echo moneda(($monto_prestado/92),  'Q'); }
														if($diario == 1 && $mes == 5 ){ echo moneda(($monto_prestado/115), 'Q'); }
														if($diario == 1 && $mes == 6 ){ echo moneda(($monto_prestado/138), 'Q'); }
														if($diario == 1 && $mes == 7 ){ echo moneda(($monto_prestado/161), 'Q'); }
														if($diario == 1 && $mes == 8 ){ echo moneda(($monto_prestado/184), 'Q'); }
														if($diario == 1 && $mes == 9 ){ echo moneda(($monto_prestado/207), 'Q'); }
														if($diario == 1 && $mes == 10){ echo moneda(($monto_prestado/230), 'Q'); }
														if($diario == 1 && $mes == 11){ echo moneda(($monto_prestado/253), 'Q'); }
														if($diario == 1 && $mes == 12){ echo moneda(($monto_prestado/276), 'Q'); }

														// PAGA SEMANAL
														if($diario == 2 && $mes	== 0 ){ echo moneda(($monto_prestado/1),   'Q'); }
														if($diario == 2 && $mes	== 1 ){ echo moneda(($monto_prestado/5),   'Q'); }
														if($diario == 2 && $mes == 2 ){ echo moneda(($monto_prestado/10),  'Q'); }
														if($diario == 2 && $mes == 3 ){ echo moneda(($monto_prestado/15),  'Q'); }
														if($diario == 2 && $mes	== 4 ){ echo moneda(($monto_prestado/20),  'Q'); }
														if($diario == 2 && $mes == 5 ){ echo moneda(($monto_prestado/25),  'Q'); }
														if($diario == 2 && $mes == 6 ){ echo moneda(($monto_prestado/30),  'Q'); }
														if($diario == 2 && $mes == 7 ){ echo moneda(($monto_prestado/35),  'Q'); }
														if($diario == 2 && $mes == 8 ){ echo moneda(($monto_prestado/40),  'Q'); }
														if($diario == 2 && $mes == 9 ){ echo moneda(($monto_prestado/45),  'Q'); }
														if($diario == 2 && $mes == 10){ echo moneda(($monto_prestado/50),  'Q'); }
														if($diario == 2 && $mes == 11){ echo moneda(($monto_prestado/55),  'Q'); }
														if($diario == 2 && $mes == 12){ echo moneda(($monto_prestado/60),  'Q'); }

														// PAGA QUINCENAL
														if($diario == 3 && $mes	== 1 ){ echo moneda(($monto_prestado/2),   'Q'); }
														if($diario == 3 && $mes == 2 ){ echo moneda(($monto_prestado/4),   'Q'); }
														if($diario == 3 && $mes == 3 ){ echo moneda(($monto_prestado/6),   'Q'); }
														if($diario == 3 && $mes	== 4 ){ echo moneda(($monto_prestado/8),   'Q'); }
														if($diario == 3 && $mes == 5 ){ echo moneda(($monto_prestado/10),  'Q'); }
														if($diario == 3 && $mes == 6 ){ echo moneda(($monto_prestado/12),  'Q'); }
														if($diario == 3 && $mes == 7 ){ echo moneda(($monto_prestado/14),  'Q'); }
														if($diario == 3 && $mes == 8 ){ echo moneda(($monto_prestado/16),  'Q'); }
														if($diario == 3 && $mes == 9 ){ echo moneda(($monto_prestado/18),  'Q'); }
														if($diario == 3 && $mes == 10){ echo moneda(($monto_prestado/20),  'Q'); }
														if($diario == 3 && $mes == 11){ echo moneda(($monto_prestado/22),  'Q'); }
														if($diario == 3 && $mes == 12){ echo moneda(($monto_prestado/24),  'Q'); }

														// PAGA MENSUAL
														if($diario == 4 && $mes	== 1 ){ echo moneda(($monto_prestado/1),   'Q'); }
														if($diario == 4 && $mes == 2 ){ echo moneda(($monto_prestado/2),   'Q'); }
														if($diario == 4 && $mes == 3 ){ echo moneda(($monto_prestado/3),   'Q'); }
														if($diario == 4 && $mes	== 4 ){ echo moneda(($monto_prestado/4),   'Q'); }
														if($diario == 4 && $mes == 5 ){ echo moneda(($monto_prestado/5),   'Q'); }
														if($diario == 4 && $mes == 6 ){ echo moneda(($monto_prestado/6),   'Q'); }
														if($diario == 4 && $mes == 7 ){ echo moneda(($monto_prestado/7),   'Q'); }
														if($diario == 4 && $mes == 8 ){ echo moneda(($monto_prestado/8),   'Q'); }
														if($diario == 4 && $mes == 9 ){ echo moneda(($monto_prestado/9),   'Q'); }
														if($diario == 4 && $mes == 10){ echo moneda(($monto_prestado/10),  'Q'); }
														if($diario == 4 && $mes == 11){ echo moneda(($monto_prestado/11),  'Q'); }
														if($diario == 4 && $mes == 12){ echo moneda(($monto_prestado/12),  'Q'); }
								
														// PAGA SEMANAL - NUEVA FORMA
														if($diario == 5 && $rowP['cuota'] == 4  ){ echo moneda(($monto_prestado/4),   'Q'); }
														if($diario == 5 && $rowP['cuota'] == 8  ){ echo moneda(($monto_prestado/8),   'Q'); }
														if($diario == 5 && $rowP['cuota'] == 12 ){ echo moneda(($monto_prestado/12),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 16 ){ echo moneda(($monto_prestado/16),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 20 ){ echo moneda(($monto_prestado/20),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 24 ){ echo moneda(($monto_prestado/24),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 28 ){ echo moneda(($monto_prestado/28),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 32 ){ echo moneda(($monto_prestado/32),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 36 ){ echo moneda(($monto_prestado/36),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 40 ){ echo moneda(($monto_prestado/40),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 44 ){ echo moneda(($monto_prestado/44),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 48 ){ echo moneda(($monto_prestado/48),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 52 ){ echo moneda(($monto_prestado/52),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 56 ){ echo moneda(($monto_prestado/56),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 60 ){ echo moneda(($monto_prestado/60),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 64 ){ echo moneda(($monto_prestado/64),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 68 ){ echo moneda(($monto_prestado/68),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 72 ){ echo moneda(($monto_prestado/72),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 76 ){ echo moneda(($monto_prestado/76),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 80 ){ echo moneda(($monto_prestado/80),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 84 ){ echo moneda(($monto_prestado/84),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 88 ){ echo moneda(($monto_prestado/88),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 92 ){ echo moneda(($monto_prestado/92),  'Q'); }
														if($diario == 5 && $rowP['cuota'] == 96 ){ echo moneda(($monto_prestado/96),  'Q'); }
													?>
												</td>
											</tr>
											<tr>
												<td align="right" width="50%"><b>Saldo pendiente:</b></td>
												<td width="50%"><?php echo moneda(($rowP['saldo_restante']), 'Q'); ?></td>
											</tr>
										</tbody>
									</table>
								</div><!-- INFORMACION SOBRE LA FECHA SUGERIDA DE PAGO Y LA CANTIDAD A PAGAR -->
							</div>

							<!-- DATOS SI EL CLIENTE ESTA ATRASADO CON SUS PAGOS -->
							<div class="col col-md-6" style="font-size: 13px; padding-bottom: 5px;">
								<div class="col col-md-12" style=" padding: 5px; text-align: center; font-size: 18px; background-color: #99FF00;">
									<b>Esta atrasado con los pagos</b>
								</div>

								<div class="col col-md-12" style=" padding: 5px;">
									<table class="table table-striped table-bordered" width="100%">
										<tbody>
											<tr>
												<?php
													// Cuantos días, Meses y Años han pasado
													$fecha_nacimiento = fecha('d/m/Y', $rowP['fecha_siguiente']);
													$fecha_control = fecha('d/m/Y', '');
													$tiempo = tiempo_transcurrido($fecha_nacimiento, $fecha_control);

													if($rowP['fecha_siguiente']=='1000-01-01'){
														$txt1 = '<font color="#cccccc">0</font>';
														$txt2 = '<font color="#cccccc">0</font>';
														$txt3 = '<font color="#cccccc">0</font>';
														$color ='#cccccc';
													}else{
														$txt1 = $tiempo[0];
														$txt2 = $tiempo[1];
														$txt3 = $tiempo[2];
														$color ='#000000';
													}
												?>

												<td align="right" width="50%"><b>Año(s):</b></td>
												<td width="50%" style="color: <?php echo $color; ?>"><?php echo $txt1; ?></td>
											</tr>
											<tr>
												<td align="right" width="50%"><b>Mes(s):</b></td>
												<td width="50%" style="color: <?php echo $color; ?>"><?php echo $txt2; ?></td>
											</tr>
											<tr>
												<td align="right" width="50%"><b>Día(s):</b></td>
												<td width="50%" style="color: <?php echo $color; ?>"><?php echo $txt2; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div><!-- DATOS SI EL CLIENTE ESTA ATRASADO CON SUS PAGOS -->



							<?php if($rowP['fecha_pago_diario']<=fecha("Y-m-d")){ //COMPROBAR si el pogo diario ya se realizó ?>
							
								<!-- FORMULARIO PARA COBRAR  --  FORMULARIO PARA COBRAR  --  FORMULARIO PARA COBRAR -->
								<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
									<?php if($rowP['saldo_restante']=='0.00'){ $validar='onClick=""  disabled'; $disabled = 'disabled'; }else{ $validar='onClick="validar();"'; $disabled = ''; } ?>
									<div class="col col-md-12">
										<div class="col-6 col-md-3 ajustar1">
											<label for="cantidad_recibida">Monto a cobrar:</label>
										</div>
										<div class="col col-md-9 ajustar2">
											<div class="has-feedback">
												<input class="form-control" id="cantidad_recibida" name="cantidad_recibida" type="number" autocomplete="off" <?php echo $disabled; ?>/>
												<span class="glyphicon glyphicon-piggy-bank form-control-feedback"></span>
											</div>
										</div>
									</div>
									
									<div class="col col-md-12">
										<div class="col-6 col-md-3 ajustar1">
											<label for="mora_recibidaa">Mora:</label>
										</div>
										<div class="col col-md-9 ajustar2">
											<div class="has-feedback">
												<input class="form-control" id="mora_recibidaa" name="mora_recibidaa" type="number" autocomplete="off" value="0" <?php echo $disabled; ?>>
												<span class="glyphicon glyphicon-flash form-control-feedback"></span>
											</div>
										</div>
									</div>
									
									<div class="col col-md-12">
										<div class="col-6 col-md-3 ajustar1" style="height: 70px;">
											<label for="mora_recibida">Número de boleta de deposito:</label>
										</div>
										<div class="col col-md-9 ajustar2">
											<div class="has-feedback">
												<input class="form-control" id="no_boleta" name="no_boleta" type="text" autocomplete="off" <?php echo $disabled; ?>>
												<span class="glyphicon glyphicon-superscript form-control-feedback"></span>
												<b style="font-size: 10px;">Nota: Si no hay número de boleta de deposito dejar vacia la casilla.</b>
											</div>
										</div>
									</div>
									<div class="col col-md-12">
										<div class="col-6 col-md-3 ajustar1" style="height: 96px;">
											<label for="observaciones">Observaciones:</label>
										</div>
										<div class="col col-md-9 ajustar2">
											<div class="has-feedback">
												<textarea class="form-control textoarea" id="observaciones" name="observaciones" maxlength="200" <?php echo $disabled; ?>></textarea>
											</div>
										</div>
									</div>
									<div class="col col-md-12" align="right">
										<div class="col-6 col-md-3"></div>
										<div class="col col-md-9 ajustar3">
											<button type="button" class="btn btn-primary" id="guardar" <?php echo $validar; ?> style="outline: none;">
												<span class="glyphicon glyphicon-plus"></span> Cobrar
											</button>
										</div>
									</div>
								</form>
								<div class="col col-md-12">
									<div class="col-6 col-md-12" style="color: #6B6B6B;"><b>Nota:</b> si no desea agregar la mora escriba el número cero (0).</div>
								</div>
								<!-- FORMULARIO PARA COBRAR  --  FORMULARIO PARA COBRAR  --  FORMULARIO PARA COBRAR -->
								
							<?php }else{ ?>
								<div class="col col-md-12">
									<div class="alert alert-success" role="alert">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tbody>
												<tr>
													<td width="50"><!--samp class="glyphicon glyphicon-info-sign" style="font-size: 36px;"></samp--></td>
													<td valign="middle">
														<b>

															El cobro del día ya fue realizado.<br>Sí desea ingresar un pago con fecha anterior contacte con administración.
														</b>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							<?php } ?>
							
						</div>
					<?php } // <-- COMPROBAMOS SI EL PRESTAMO ESTA ACTIVO --> ?>
					</div>
					

					<!-- DETALLE DE PAGOS PRESTAMOS  //  DETALLE DE PAGOS PRESTAMOS  //  DETALLE DE PAGOS PRESTAMOS -->
					<div class="col col-md-12">
						<?php
							$sqlDetalle = "SELECT * FROM detalleprestamo WHERE id_prestamo = '$id' ORDER BY fechapago";
							$resDetalle = $mysqli->query($sqlDetalle);

							if( $resDetalle->num_rows == 0 ){
								echo '<br><div class="alert alert-danger" role="alert" style="text-align:center;"><b>El préstamo no tiene cobros</b></div>';
							}else{
						?>
								<div class="col col-md-12" style=" padding-bottom: 5px; text-align: center; font-size: 18px;">
									<br><div style="border:1px solid #ccc;"></div><br>
									<b>Detalle del prestamo</b>
									<br><br><div style="border:1px solid #ccc;"></div><br>
								</div>

								<div class="col col-md-12">
									<table class="table table-striped table-bordered table-hover" width="100%">
										<tbody>
											<tr>
												<td class="hidden-xs" width="3%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">#</td>
												<td width="15%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Cantidad</td>
												<td width="10%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Mora</td>
												<td width="15%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">No de Boleta</td>
												<td class="hidden-xs" width="16%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Fecha sugerida</td>
												<td class="hidden-xs" width="16%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Fecha de pago</td>
												<td width="25%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">Total</td>
												<td class="hidden-xs" width="2%" align="center" style="font-weight: bold; color: #ffffff; background: #337ab7;">&nbsp;</td>
											</tr>
											<?php
												$i=1;
												$total = 0;
												$mora = 0;

												while($rowD = mysqli_fetch_row($resDetalle)){
											?>
											<tr>
												<td class="hidden-xs" align="center"><?php echo $i; ?></td>
												<td align="center"><?php echo moneda($rowD[4], 'Q'); ?></td>
												<td align="center"><?php echo moneda($rowD[5], 'Q'); ?></td>
												
												<td align="center">
													<?php
														if($rowD[12]==''){
															echo '<font style="color:#DADADA;">0000000</font>';
														}else{
															echo $rowD[12];
														}
													?>
												</td>

												<td class="hidden-xs" align="center"><?php if($rowD[7]=='1000-01-01'){echo '<font style="color: #8B8B8B;">1000-01-01</font>';}else{ echo fecha('d-m-Y', $rowD[7]);} ?></td>

												<td class="hidden-xs" align="center"><?php echo fecha('d-m-Y', $rowD[8]); ?></td>
												<td align="center"><?php echo moneda(($rowD[4]+$rowD[5]), 'Q'); ?></td>

												<td class="hidden-xs" align="center">
													<?php if($rowD[10]==''){ ?>
														<a href="" class="disabled"><i class="glyphicon glyphicon-info-sign" style="color: #8B8B8B;"></i></a>
													<?php }else{ $obs = $rowD[10]; ?>
														<a href="#obs-<?php echo $i; ?>" data-toggle="modal" style="outline: none;" data-togglee="tooltip" data-placement="top" title="Ver observaciones"><i class="glyphicon glyphicon-info-sign"></i></a>
													<?php } ?>
												</td>
											</tr>

											<?php if($rowD[10]==''){ /* NADA */ }else{ $obs = $rowD[10]; ?>
												<!-- Modal -->
												<div class="modal fade" id="obs-<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header modal-header-warning">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																<h3><i class="glyphicon glyphicon-info-sign"></i> Observaciones</h3>
															</div>
															<div class="modal-body">
																<h4><?php echo $obs; ?></h4>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-warning pull-rigth" data-dismiss="modal">Cerrar</button>
															</div>
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div><!-- /.modal -->
												<!-- Modal -->				
											<?php } ?>

											<?php $mora = $mora + $rowD[5]; $total = $total + $rowD[4]; $i++;} ?>
											<tr>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td>&nbsp;</td>
												<td align="right"><b>Sub total:</b></td>
												<td align="center" style="color: #660000; border-top: 3px solid red;"><?php echo moneda($total, 'Q'); ?></td>
												<td class="hidden-xs">&nbsp;</td>
											</tr>
											<tr>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td>&nbsp;</td>
												<td align="right"><b>[+] Mora:</b></td>
												<td align="center" style="color: #660000; border-bottom: 3px solid red;"><?php echo moneda($mora, 'Q'); ?></td>
												<td class="hidden-xs">&nbsp;</td>
											</tr>
											<tr>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td class="hidden-xs">&nbsp;</td>
												<td>&nbsp;</td>
												<td align="right"><b>Gran total:</b></td>
												<td align="center" style="color: #660000; border-bottom: 3px double red;"><?php echo moneda(($total+$mora), 'Q'); ?></td>
												<td class="hidden-xs">&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</div>
						<?php } ?>
					</div><!-- DETALLE DE PAGOS PRESTAMOS  //  DETALLE DE PAGOS PRESTAMOS  //  DETALLE DE PAGOS PRESTAMOS -->
				</div>
			</div>
		</div>
    </main>
    
    <?php
						
		if($_SESSION['alert_mensaje'] <> ""){
			$alert_titulo  = $_SESSION['alert_titulo'];
			$mensaje_error = $_SESSION['alert_mensaje'];
			$color_mensaje = $_SESSION['alert_boton'];
			$icono_mensaje = $_SESSION['alert_icono'];
			
			$alert_bandera 	= true;
			$alert_titulo 	= $alert_titulo;
			$alert_mensaje	= $mensaje_error;
			$alert_icono 	= $icono_mensaje;
			$alert_boton 	= $color_mensaje;
			
			unset($_SESSION['alert_titulo']);
			unset($_SESSION['alert_mensaje']);
			unset($_SESSION['alert_boton']);
			unset($_SESSION['alert_icono']);
		}
	
	?>
    
	<?php include("footer.php"); ?>
</body>
</html>