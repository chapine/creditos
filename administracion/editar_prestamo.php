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

		require('fecha.php');
			
		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_REQUEST['id']; // OBTIENE EL ID A EDITAR
		$edit = $_REQUEST['edit'];

		$sql = "
			SELECT
				p.id_prestamo		AS id_prestamo,
				c.nombre			AS nombre_cliente,
                c.dpi				AS DPI,
                c.nit				AS NIT,
                c.tel				AS TELEFONO,
                c.cel				AS CELULAR,
				u.nombre			AS nombre_usuario,
				
				p.forma_pago		AS forma_pago,
				p.mensualidades		AS mensualidades,
				p.cuota				AS cuota,
				p.interes			AS interes,
				
				p.monto_prestado	AS monto_prestado,
				p.fecha_inicial		AS fecha_inicial,
				p.interes_pagar		AS interes_pagar,
				
				p.saldo_restante	AS saldo_restante,
				p.prestamo_activo	AS prestamo_activo,
				p.fecha_siguiente	AS fecha_siguiente,
                concat_ws(', ', r.nombre, d.nombre) AS RUTA
			
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			
			WHERE
				c.id_cliente = p.id_clientes AND
				u.id_usuario = p.cobrador AND
				r.id_ruta = p.id_ruta AND
				d.id_departamento = r.id_departamento AND
				p.id_prestamo = $id";
			
		$res = $mysqli->query($sql);
		$row = $res->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO

		if(!empty($_POST)){
			$forma_pago = mysqli_real_escape_string($mysqli,$_POST['forma_pago']);
			$mensualidad = mysqli_real_escape_string($mysqli,$_POST['mensualidad']);
			$monto = mysqli_real_escape_string($mysqli,$_POST['monto']);
			$fecha = mysqli_real_escape_string($mysqli,$_POST['fecha']);
			$cuotas = mysqli_real_escape_string($mysqli,$_POST['cuotas']);
			$interes = mysqli_real_escape_string($mysqli,$_POST['interes']);
			$interes_pagar = ($monto * $interes)/100;
			
			$sql_x = "SELECT SUM(abono) AS abono FROM detalleprestamo WHERE id_prestamo = $id";
			$res_x = $mysqli->query($sql_x);
			$row_x = $res_x->fetch_assoc();
			
			$saldo_restante = (($monto + $interes_pagar) - $row_x['abono']);
			
			$Fecha_Final = FechaPago($fecha, $cuotas);
			
			$sqlPrestamo = "UPDATE prestamos SET forma_pago='$forma_pago', mensualidades='$mensualidad', monto_prestado='$monto', saldo_restante='$saldo_restante', interes='$interes', interes_pagar='$interes_pagar', cuota='$cuotas', fecha_inicial='$fecha', fecha_final='$Fecha_Final' WHERE id_prestamo = '$id'";
			$resPrestamo = $mysqli->query($sqlPrestamo);
			
			if( $resPrestamo > 0 ){
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA

				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "22";
				$id_cliente_bitacora		= "";
				$id_prestamo_bitacora		= "$id";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "";
				
				$monto = moneda($monto, '');
				$cliente = $row['nombre_cliente'];
				$prestado = moneda($row['monto_prestado'], '');
				
				$descripcion_bitacora	= "Modificó el prestamo de $prestado por $monto del cliente $cliente";

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
		
				// Recargamos los datos de la consulta
				$res = $mysqli->query($sql);
				$row = $res->fetch_assoc();
				
				// MENSAJE SI EL REGISTRO ES INGRESADO
				$alert_bandera 	= true;
				$alert_titulo 	= "Exito";
				$alert_mensaje 	= "Se actualizó el préstamo correctamente";
				$alert_icono 	= "success";
				$alert_boton 	= "success";
				
			}else{
				// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
				$alert_bandera 	= true;
				$alert_titulo 	= "Error";
				$alert_mensaje 	= "Error al actualizar el prestamo";
				$alert_icono 	= "error";
				$alert_boton 	= "danger";
			}
		}
			
		$title = 'Editar prestamo';		
		include('head.php');
		$active_prestamos ="active";
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
		
		var PasarValor = function(x){
			if( x == "23" ){ document.getElementById('interes').value = "15"; }
			if( x == "46" ){ document.getElementById('interes').value = "30"; }
			if( x == "69" ){ document.getElementById('interes').value = "45"; }
			if( x == "92" ){ document.getElementById('interes').value = "60"; }
			if( x == "138" ){ document.getElementById('interes').value = "90"; }
		};
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
                    <a href="lista_prestamos.php?a=1" class="btn btn-success">prestamos</a>
                    <a class="btn btn-danger">Editar prestamo</a>
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
								<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo convertir($row['nombre_cliente']); ?>" disabled>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="dpi">NIT:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="dpi" name="dpi" type="text" value="<?php echo nit($row['NIT'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="dpi">DPI:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="dpi" name="dpi" type="text" value="<?php echo dpi($row['DPI'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
							</div>
						</td>
					</tr>

					<tr>
						<td align="right"><label for="telefono">Teléfono:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="telefono" name="telefono" type="text" value="<?php echo telefono($row['TELEFONO'], 'input'); ?>" disabled>
								<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
							</div>
						</td>
					</tr>
					<tr>
						<td align="right"><label for="celular">Celular:</label></td>
						<td>
							<div class="has-success has-feedback">
								<input class="form-control" id="celular" name="celular" type="text" value="<?php echo celular($row['CELULAR'], 'input'); ?>" disabled>
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
										<?php
											if($row['forma_pago']==1){ $forma_de_pago = 'Efectivo';}
											if($row['forma_pago']==2){ $forma_de_pago = 'Cheque';}
											if($row['forma_pago']==3){ $forma_de_pago = 'Tarjeta de Credito';}
										?>
										<option value="<?php echo $row['forma_pago']; ?>"><?php echo $forma_de_pago; ?></option>
										<option disabled>----------------------------</option>
										
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
										<?php
											if($row['mensualidades']==1){ $mensualidades = 'Diario';}
											if($row['mensualidades']==2){ $mensualidades = 'Semanal';}
											if($row['mensualidades']==3){ $mensualidades = 'Quincenal';}
											if($row['mensualidades']==4){ $mensualidades = 'Mensual';}
										?>
										<option value="<?php echo $row['mensualidades']; ?>"><?php echo $mensualidades; ?></option>
										<option disabled>----------------------------</option>
										
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
								<div class="has-success has-feedback">
									<select name="cuotas" id="cuotas" class="form-control custom-select" onchange="PasarValor(this.value)">
										<?php
											if($row['cuota']==23){ $cuota = 'Un mes (23 cuotas)';}
											if($row['cuota']==46){ $cuota = 'Dos meses (46 cuotas)';}
											if($row['cuota']==69){ $cuota = 'Tres meses (69 cuotas)';}
											if($row['cuota']==92){ $cuota = 'Cuatro meses (92 cuotas)';}
											if($row['cuota']==138){ $cuota = 'Seis meses (138 cuotas)';}
										?>
										<option value="<?php echo $row['cuota']; ?>"><?php echo $cuota; ?></option>
										<option disabled>----------------------------</option>
										
										<option value="23">Un mes (23 cuotas)</option>
										<option value="46">Dos meses (46 cuotas)</option>
										<option value="69">Tres meses (69 cuotas)</option>
										<option value="92">Cuatro meses (92 cuotas)</option>
										<option value="138">Seis meses (138 cuotas)</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="interes">Interes:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" type="number" value="<?php echo $row['interes']; ?>" name="interes" id="interes" onClick="this.select()">
									<span class="glyphicon glyphicon-star-empty form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="monto">Monto a prestar:</label></td>
							<td>
								<div class="has-success input-group">
									<span class="input-group-addon"><b>Q</b></span>
									<input class="form-control" id="monto" name="monto" type="number" autocomplete="off" value="<?php echo $row['monto_prestado']; ?>" onClick="this.select()">
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="fecha">Fecha:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="fecha" name="fecha" type="date" value="<?php echo fecha('Y-m-d', $row['fecha_inicial']); ?>">
									<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-pencil"></span> Editar prestamo
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_prestamos.php?a=1'" style="outline: none;">
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