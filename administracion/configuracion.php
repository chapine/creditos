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
	
		$id = $_REQUEST['id'];
		
		$sqlC = "SELECT * FROM configuracion";
		$resC = $mysqli->query($sqlC);
		$rowC = $resC->fetch_assoc();

		if(!empty($_POST)){
			$hora_inicial = mysqli_real_escape_string($mysqli,$_POST['hora_inicial']);
			$hora_final = mysqli_real_escape_string($mysqli,$_POST['hora_final']);
			$mensaje = mysqli_real_escape_string($mysqli,$_POST['mensaje']);
			$cerrar_sesion_hora = mysqli_real_escape_string($mysqli,$_POST['cerrar_sesion_hora']);

			$sql = "UPDATE configuracion SET hora_inicial = '$hora_inicial', hora_final = '$hora_final', mensaje = '$mensaje', cerrar_sesion_hora = '$cerrar_sesion_hora' WHERE id_config = 1";
			$res = $mysqli->query($sql);

			if($res > 0){
				// ALERTA DE MENSAJE
				$alert_bandera = true;
				$alert_titulo ="Exito";
				$alert_mensaje ="Registro actualizado exitosamente";
				$alert_icono ="success";
				$alert_boton = "success";
				
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "14";
				$id_cliente_bitacora		= "";
				$id_prestamo_bitacora		= "";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "$id";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "";

				$descripcion_bitacora	= "Modificó la hora de cierre y apertura del sistema";

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				$resC = $mysqli->query($sqlC);
				$rowC = $resC->fetch_assoc();
			}else{
				// ALERTA DE MENSAJE
				$alert_bandera = true;
				$alert_titulo ="Error";
				$alert_mensaje ="Imposible actualizar";
				$alert_icono ="error";
				$alert_boton = "danger";
			}
		}
			
		$title = 'Configuración';
		include('head.php');
		$active_mantenimiento="active";
    ?>
    
    <script>
		function hora_inicial()
		{
			valor = document.getElementById("hora_inicial").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo fecha inicial", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){
							swal.close(),
							registro.hora_inicial.focus();
						}
					}
				);
				registro.getElementById('registar').disabled=false;
				return false;
			} else { return true;}
		}
		
		function hora_final()
		{
			valor = document.getElementById("hora_final").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo fecha final", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){
							swal.close(),
							registro.hora_final.focus();
						}
					}
				);
				registro.getElementById('registar').disabled=false;
				return false;
			} else { return true;}
		}
		
		function mensaje()
		{
			valor = document.getElementById("mensaje").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo mensaje", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){
							swal.close(),
							registro.mensaje.focus();
						}
					}
				);
				registro.getElementById('registar').disabled=false;
				return false;
			} else { return true; }
		}
		
		function cerrar_sesion_hora()
		{
			valor = document.getElementById("cerrar_sesion_hora").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo cerrar sesión en", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){
							swal.close(),
							registro.cerrar_sesion_hora.focus();
						}
					}
				);
				registro.getElementById('registar').disabled=false;
				return false;
			} else { return true; }
		}

		function validar()
		{
			if(hora_inicial() && hora_final() && mensaje() && cerrar_sesion_hora())
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
                    <a class="btn btn-danger">Configuraciones</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-plus'></i> Configuración</h4>
			</div>	

			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tr>
						<td width="20%" align="right" style="vertical-align: middle;"><label>Hora para cerrar:</label></td>
						<td><?php echo fecha('d-m-Y / g:i:s A', $rowC['fecha_inicial'].' '.$rowC['hora_inicial']); ?></td>
					</tr>
					<tr>
						<td align="right" style="vertical-align: middle;"><label>Hora para abrir:</label></td>
						<td><?php echo fecha('d-m-Y / g:i:s A', $rowC['fecha_final'].' '.$rowC['hora_final']); ?></td>
					</tr>

					<tr>
						<td align="right" style="vertical-align: middle;"><label>Mensaje:</label></td>
						<td>
							<div class="has-success has-feedback">
								<div class="alert alert-danger" role="alert">
								  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								  <span class="sr-only">Error:</span>
								  <?php echo $rowC['mensaje'].' '.date("g:i A", strtotime($rowC['hora_final'])); ?>
								</div>
							</div>
						</td>
					</tr>
				</table>
					
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
					<b style="color: darkgray">Nota: las cuentas de cobradores serán las que se desconecten a la hora espeficiada.</b><br><br>
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="20%" align="right" style="vertical-align: middle;">
								<label for="hora_inicial">Hora para cerrar:</label>
							</td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="hora_inicial" name="hora_inicial" type="time" value="<?php echo $rowC['hora_inicial']; ?>"  min="17:00" max="23:59">
									<span class="glyphicon glyphicon-time form-control-feedback"></span>
								</div>
								<label style="font-size: 12px; color: darkgray; padding-top: 8px;">05:00pm - 11:59pm</label>
							</td>
						</tr>
						<tr>
							<td align="right" style="vertical-align: middle;">
								<label for="hora_final">Hora para abrir:</label>
							</td>
							<td>
								<div class="has-success has-feedback">
									<input  type="time" class="form-control" id="hora_final" name="hora_final" value="<?php echo $rowC['hora_final']; ?>" min="00:00" max="11:59">
									<span class="glyphicon glyphicon-time form-control-feedback"></span>
								</div>
								<label style="font-size: 12px; color: darkgray; padding-top: 8px;">12:00am - 11:59am</label>
							</td>
						</tr>
						
						<tr>
							<td align="right" style="vertical-align: middle;">
								<label for="mensaje">Mensaje:</label>
							</td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="mensaje" name="mensaje" type="text" value="<?php echo $rowC['mensaje']; ?>" maxlength="80" autocomplete="off">
								</div>
							</td>
						</tr>
						
						
						<tr>
							<td align="right" style="vertical-align: middle;">
								<label for="hora_final">Cerrar sesiones inactivas en:</label>
							</td>
							<td>
								<div class="has-success has-feedback">
									<input  type="number" class="form-control" id="cerrar_sesion_hora" name="cerrar_sesion_hora" value="<?php echo $rowC['cerrar_sesion_hora']; ?>" min="1">
									<span class="glyphicon glyphicon-time form-control-feedback"></span>
								</div>
								<label style="font-size: 12px; color: darkgray; padding-top: 8px;">Las sesiones inactivas se cerrarán al transcirrir la hora especificada.</label>
							</td>
						</tr>
						
						<tr>
							<td colspan="2" align="right">
								<button type="button" class="btn btn-primary" name="registar" id="registar" onClick="validar(); this.disabled=true;" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>							
							</td>
						</tr>
					</table>
					
					<?php if($rowC['hora_inicial']==$rowC['hora_final']){ echo '<b style="color: red">* Tenga en cuenta que si usa dos horas iguales el programa estará cerrado 24 horas.</b><br>'; } ?>
				</form>
			</div>
		</div>
    </main>
    
	<?php include("footer.php"); ?>
</body>
</html>