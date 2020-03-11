<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "asistente";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		require('fecha.php');

		// OBTIENE DATOS PARA EL FORMULARIO	
		$cliente = $_REQUEST['c'];
		$prestamo = $_REQUEST['p'];
		$usuario = $_SESSION["id_usuario"];

		$sql_c = "SELECT * FROM clientes WHERE id_cliente = $cliente";
		$res_c = $mysqli->query($sql_c);
		$row_c = $res_c->fetch_assoc();
		
		$sql_p = "SELECT * FROM prestamos WHERE id_prestamo = $prestamo";
		$res_p = $mysqli->query($sql_p);
		$row_p = $res_p->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO
			
		if(!empty($_POST)){
			$forma_pago = mysqli_real_escape_string($mysqli,$_POST['forma_pago']);
			$mensualidad = mysqli_real_escape_string($mysqli,$_POST['mensualidad']);
			$monto = mysqli_real_escape_string($mysqli,$_POST['monto']);
			$fecha = mysqli_real_escape_string($mysqli,$_POST['fecha']);
			$cuotas = mysqli_real_escape_string($mysqli,$_POST['cuotas']);
			$interes = mysqli_real_escape_string($mysqli,$_POST['interes']);
			$interes_pagar = ($monto * $interes)/100;
			$saldo_restante = $monto + $interes_pagar;
			
			$cobrador = $row_c['cobrador'];
			$id_ruta = $row_c['id_ruta'];
			
			$fecha_hoy = fecha('Y-m-d');
			
			if ($mensualidad == '1'){ $FechaSig = FechaPago($fecha_hoy, "1"); }	// SUMA 1 DIA
			if ($mensualidad == '2'){ $FechaSig = FechaPago($fecha_hoy, "6"); }	// SUMA 6 DIAS
			if ($mensualidad == '3'){ $FechaSig = FechaPago($fecha_hoy, "15"); }	// SUMA 15 DIAS
			if ($mensualidad == '4'){ $FechaSig = FechaPago($fecha_hoy, "30"); }	// SUMA 30 DIAS
			
			$FechaSig = fecha('Y-m-d', $FechaSig);
			$Fecha_Final = FechaPago($fecha, $cuotas);
			
			if($monto < $row_p['saldo_restante']){
				// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
				$alert_bandera 	= true;
				$alert_titulo 	= "Error";
				$alert_mensaje 	= "El monto ingresado es menor al saldo restante";
				$alert_icono 	= "error";
				$alert_boton 	= "danger";
			}else{
			
				$sqlPrestamo = "INSERT INTO prestamos 
				(id_prestamo, id_clientes, cobrador, forma_pago, mensualidades, monto_prestado, fecha_inicial, fecha_siguiente, interes, interes_pagar, cuota, saldo_restante, prestamo_activo, id_ruta, renovacion, fecha_final)

				VALUES

				(NULL, '$cliente', '$cobrador', '$forma_pago', '$mensualidad', '$monto', '$fecha', '$FechaSig', '$interes', '$interes_pagar', '$cuotas', '$saldo_restante', '1', '$id_ruta', '$prestamo', '$Fecha_Final');";
				$resPrestamo = $mysqli->query($sqlPrestamo);

				$insertado = mysqli_insert_id($mysqli);

				$sqlClientePrestamo = "UPDATE clientes SET prestamoactivo = '1' WHERE id_cliente = $cliente";
				$resClientePrestamo = $mysqli->query($sqlClientePrestamo);

				if( $resPrestamo>0 && $resClientePrestamo>0){

					// ACTUALIZAMOS LOS PRESTAMOS COBROS Y COBORS
						$sql_Prestamo = "UPDATE prestamos SET fecha_siguiente='1000-01-01', saldo_restante='0.00', prestamo_activo='0' WHERE id_prestamo = $prestamo";
						$res_Prestamo = $mysqli->query($sql_Prestamo);

						$sqlPrestamo4 = "UPDATE detalleprestamo SET estado = '0' WHERE id_prestamo = $prestamo";
						$resPrestamo4 = $mysqli->query($sqlPrestamo4);
					// ACTUALIZAMOS LOS PRESTAMOS COBROS Y COBORS


					// BITACORA  --  BITACORA  --  BITACORA
					// BITACORA  --  BITACORA  --  BITACORA

					$usuario_bitacora 			= $_SESSION['nombre'];
					$id_bitacora_codigo			= "28";
					$id_cliente_bitacora		= "$cliente";
					$id_prestamo_bitacora		= "$insertado";
					$id_detalle_bitacora		= "";
					$id_ruta_bitacora			= "";
					$id_departamento_bitacora	= "";
					$id_usuario_bitacora		= "";

					$monto_bitacora = moneda($monto);
					$interes_pagar = moneda($interes_pagar);

					$prestamo_a = $row_p['monto_prestado'];
					$interes_a = $row_p['interes_pagar'];				

					$total_a = moneda($prestamo_a + $interes_a);

					$descripcion_bitacora	= "Se renovó préstamo de $total_a por $monto_bitacora con un interes de $interes_pagar al cliente $cobrador";

					include('../config/bitacora.php');

					// BITACORA  --  BITACORA  --  BITACORA
					// BITACORA  --  BITACORA  --  BITACORA


					// MENSAJE SI EL REGISTRO ES INGRESADO
					$alert_redireccionar 	= true;
					$alert_titulo 			= "Exito";
					$alert_mensaje 			= "Se renovó el préstamo por $monto_bitacora y se cobrarán $interes_pagar";
					$alert_icono 			= "success";
					$alert_boton 			= "success";
					$alert_link				= "detalle_prestamo.php?c=$cliente&id=$insertado";

				}else{
					// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
					$alert_bandera 	= true;
					$alert_titulo 	= "Error";
					$alert_mensaje 	= "Error al renovar el préstamo";
					$alert_icono 	= "error";
					$alert_boton 	= "danger";
				}
			}
			
			$res_p = $mysqli->query($sql_p);
			$row_p = $res_p->fetch_assoc();
		}
			
		$title = 'Dar prestamo';		
		include('head.php');
		$active_prestamos="active";
    ?>
    
    <script>
		function validarInteres()
		{
			valor = document.getElementById("interes").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo interes", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.interes.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validarMonto()
		{
			valor = document.getElementById("monto").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo monto", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.monto.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validarFecha()
		{
			valor = document.getElementById("fecha").value;
			if( valor == "0000-00-00" || valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo fecha", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.fecha.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validar()
		{
			if(validarMonto() && validarInteres() && validarFecha())
			{
				document.registro.submit();
			}
		}
		
		function selecOp()
		{
			var op=document.getElementById("cuotas");
			var tt=document.getElementById("interes");

			if (op.selectedIndex==0)tt.value="5";		// 01
			
			if (op.selectedIndex==1)tt.value="15";		// 02
			if (op.selectedIndex==2)tt.value="30";		// 03
			if (op.selectedIndex==3)tt.value="45";		// 04
			if (op.selectedIndex==4)tt.value="60";		// 05
			if (op.selectedIndex==5)tt.value="75";		// 06
			if (op.selectedIndex==6)tt.value="90";		// 07
			
			
			if (op.selectedIndex==7)tt.value="105";		// 08
			if (op.selectedIndex==8)tt.value="120";		// 09
			if (op.selectedIndex==9)tt.value="135";		// 10
			if (op.selectedIndex==10)tt.value="150";	// 11
			if (op.selectedIndex==11)tt.value="165";	// 12
			if (op.selectedIndex==12)tt.value="180";	// 13
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
                    <a href="lista_prestamos.php?a=4" class="btn btn-success">Prestamos atrasados</a>
                    <a class="btn btn-danger">Renovación de prestamo</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-briefcase'></i> Datos del cliente</h4>
			</div>	

			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tr>
						<td width="20%" align="right"><label for="nombre">Nombre:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo Convertir($row_c['nombre']); ?>" disabled>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="dpi">DPI:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="dpi" name="dpi" type="text" value="<?php echo dpi($row_c['dpi'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-file'></i> Datos del prestamo a renovar</h4>
			</div>

			<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
				<div class="panel-body">
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="20%" align="right"><label for="forma_pago">Forma de pago:</label></td>
							<td>
								<div class="has-success has-feedback">
									<select name="forma_pago" id="forma_pago" class="form-control">
										<option value="1">Efectivo</option>
										<option value="2">Cheque</option>
										<option value="3">Tarjeta de Credito</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="mensualidad">Mensualidad:</label></td>
							<td>
								<div class="has-success has-feedback">
									<select name="mensualidad" id="mensualidad" class="form-control">
										<option value="1">Diario</option>
										<option value="2">Semanal</option>
										<option value="3">Quincenal</option>
										<option value="4">Mensual</option>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="monto">Monto a renovar:</label></td>
							<td>
								<div class="has-success input-group">
									<span class="input-group-addon"><b>Q</b></span>
									<input class="form-control" id="monto" name="monto" type="text" value="<?php echo $row_p['saldo_restante']; ?>" onClick="this.select();">
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="cuotas">Cuotas:</label></td>
							<td>
								<div class="has-success has-feedback">
									<select name="cuotas" id="cuotas" class="form-control custom-select" onchange="selecOp()">
										<option value="5">Una semana (5 cuotas)</option>
										<option value="23">Un mes (23 cuotas)</option>
										<option value="46">Dos meses (46 cuotas)</option>
										<option value="69">Tres meses (69 cuotas)</option>
										<option value="92">Cuatro meses (92 cuotas)</option>
										<option value="115">Cinco meses (115 cuotas)</option>
										<option value="138">Seis meses (138 cuotas)</option>
										<option value="161">Siete meses (161 cuotas)</option>
										<option value="184">Ocho meses (184 cuotas)</option>
										<option value="207">Nueve meses (207 cuotas)</option>
										<option value="230">Diez meses (230 cuotas)</option>
										<option value="253">Once meses (253 cuotas)</option>
										<option value="276">Doce meses (276 cuotas)</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="interes">Interes:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="interes" name="interes" type="number" value="15" onClick="this.select();">
									<span class="glyphicon glyphicon-star-empty form-control-feedback"></span>
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="fecha">Fecha:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="fecha" name="fecha" type="date" value="<?php echo fecha('Y-m-d'); ?>">
									<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Renovar prestamo
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_prestamos.php?a=4'" style="outline: none;">
									<span class="glyphicon glyphicon-backward"></span> Regresar
								</button>								
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>