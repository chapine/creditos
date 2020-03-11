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
		$id = $_REQUEST['id']; // OBTIENE EL ID A EDITAR
		$usuario = $_SESSION["id_usuario"];

		$sql = "SELECT * FROM clientes WHERE id_cliente = $id";
		$result1 = $mysqli->query($sql);
		$row1 = $result1->fetch_assoc();
			
		if($row1['cobrador'] == '-1'){
			// MENSAJE SI EL CLIENTE NO TIENE COBRADOR
			$alert_redireccionar = true;
			$alert_titulo ="Error";
			$alert_mensaje ="Antes de dar un prestamo debe de asiganar un cobrador al cliente.";
			$alert_icono ="error";
			$alert_boton = "danger";
			$alert_link = "asignar_cobrador.php?id=$id";
		}
		// OBTIENE DATOS PARA EL FORMULARIO
			
		if(!empty($_POST)){
			$forma_pago 		= mysqli_real_escape_string($mysqli, $_POST['forma_pago']);
			$mensualidad 		= mysqli_real_escape_string($mysqli, $_POST['mensualidad']);
			$radio 				= mysqli_real_escape_string($mysqli, $_POST['asdasd']);
			
			$monto 				= mysqli_real_escape_string($mysqli, $_POST['monto']);
			$fecha 				= mysqli_real_escape_string($mysqli, $_POST['fecha']);
			$cuotas 			= mysqli_real_escape_string($mysqli, $_POST['cuotas']);
			$interes 			= mysqli_real_escape_string($mysqli, $_POST['interes']);
			$interes_pagar 		= ($monto * $interes)/100;
			$saldo_restante 	= $monto + $interes_pagar;
			
			$cobrador = $row1['cobrador'];
			$id_ruta = $row1['id_ruta'];
			
			$fecha_hoy = fecha('Y-m-d', '');
			
			if( $radio=='semana' ){
				$mensualidad = '5';
				$FechaSig = FechaPago($fecha_hoy, "6");
			}else{
				if ($mensualidad == '1'){ $FechaSig = FechaPago($fecha_hoy, "1"); }		// SUMA 1 DIA
				if ($mensualidad == '2'){ $FechaSig = FechaPago($fecha_hoy, "6"); }		// SUMA 6 DIAS
				if ($mensualidad == '3'){ $FechaSig = FechaPago($fecha_hoy, "15"); }	// SUMA 15 DIAS
				if ($mensualidad == '4'){ $FechaSig = FechaPago($fecha_hoy, "30"); }	// SUMA 30 DIAS
			}
			
			
			$FechaSig = fecha('Y-m-d', $FechaSig);			
			$Fecha_Final = FechaPago($fecha, $cuotas);
			
			$sqlPrestamo = "INSERT INTO prestamos 
			(id_prestamo, id_clientes, cobrador, forma_pago, mensualidades, monto_prestado, fecha_inicial, fecha_siguiente, interes, interes_pagar, cuota, saldo_restante, prestamo_activo, id_ruta, fecha_final, usuario)
			
			VALUES
			
			(NULL, '$id', '$cobrador', '$forma_pago', '$mensualidad', '$monto', '$fecha', '$FechaSig', '$interes', '$interes_pagar', '$cuotas', '$saldo_restante', '1', '$id_ruta', '$Fecha_Final', '$usuario');";
			$resPrestamo = $mysqli->query($sqlPrestamo);
			
			$insertado = mysqli_insert_id($mysqli);

			$sqlClientePrestamo = "UPDATE clientes SET prestamoactivo = '1' WHERE id_cliente = $id";
			$resClientePrestamo = $mysqli->query($sqlClientePrestamo);
			
			if( $resPrestamo>0 && $resClientePrestamo>0){
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA

				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "8";
				$id_cliente_bitacora		= "$id";
				$id_prestamo_bitacora		= "$insertado";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "";
							
				$monto_bitacora = moneda($monto, '');
				$interes_pagar = moneda($interes_pagar, '');
				
				$descripcion_bitacora	= "Dio un prestamo de $monto_bitacora con un interes de $interes_pagar al cliente ".$row1['nombre'];

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
		
				// MENSAJE SI EL REGISTRO ES INGRESADO
				$alert_bandera = true;
				$alert_titulo = "Éxito";
				$alert_mensaje ="Se prestaron $monto_bitacora y se cobrará un interes de $interes_pagar";
				$alert_icono = "success";
				$alert_boton = "success";
				
			}else{
				// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
				$alert_bandera = true;
				$alert_titulo ="Error";
				$alert_mensaje ="Error al ingresar el registro";
				$alert_icono ="error";
				$alert_boton = "danger";
			}
		}
			
		$title = 'Dar prestamo';		
		include('head.php');
		$active_clientes="active";
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
			if(validarInteres() && validarMonto() && validarFecha())
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
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    <a class="btn btn-danger">Dar prestamo</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<a href="lista_clientes.php?numero=1" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar</a>
				</div>
				<h4><i class='glyphicon glyphicon-briefcase'></i> Datos del cliente</h4>
			</div>	

			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tr>
						<td width="20%" align="right"><label for="nombre">Nombre:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo Convertir($row1['nombre']); ?>" disabled>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="dpi">DPI:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="dpi" name="dpi" type="text" value="<?php echo dpi($row1['dpi'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
							</div>
						</td>
					</tr>

					<tr>
						<td align="right"><label for="telefono">Teléfono:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="telefono" name="telefono" type="text" value="<?php echo telefono($row1['tel'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="celular">Celular:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="celular" name="celular" type="text" value="<?php echo celular($row1['cel'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-phone form-control-feedback"></span>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-file'></i> Datos del prestamo</h4>
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
							<td align="right"><label for="mensualidad"></label></td>
							<td>
								<div class="has-success has-feedback">
									<script>
										function semana(){
											$.ajax({
												url:'<?php echo "conceder_prestamo_ajax_semana.php"; ?>',

												beforeSend: function(objeto){
													$('div').find("#ajax").html('Cargando información...');
												},
												success:function(data){
													$('div').find("#ajax").html(data);
													$("#mensualidad").val("2");
													$("#mensualidad").attr('disabled', true);
												}
											});
										}
										function mes(){
											$.ajax({
												url:'<?php echo "conceder_prestamo_ajax_mes.php"; ?>',

												beforeSend: function(objeto){
													$('div').find("#ajax").html('Cargando información...');
												},
												success:function(data){
													$('div').find("#ajax").html(data);
													$("#mensualidad").val("4");
													$("#mensualidad").removeAttr('disabled', true);
												}
											});
										}
										
										mes();
									</script>
									<label><input type="radio" name="asdasd" value="semana" onClick="semana();"> Semanal</label><br>
									<label><input type="radio" name="asdasd" value="mes" onClick="mes();" checked> Mensual</label>
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
							<td align="right"><label for="cuotas">Cuotas:</label></td>
							<td>
								<div class="has-success has-feedback" id="ajax">
									
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="interes">Interes:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="interes" name="interes" type="number" value="15">
									<span class="glyphicon glyphicon-star-empty form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="monto">Monto a prestar:</label></td>
							<td>
								<div class="has-success input-group">
									<span class="input-group-addon"><b>Q</b></span>
									<input class="form-control" id="monto" name="monto" type="number" autocomplete="off">
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="fecha">Fecha:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="fecha" name="fecha" type="date" value="<?php echo fecha('Y-m-d', ''); ?>">
									<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Dar prestamo
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_clientes.php?numero=1'" style="outline: none;">
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