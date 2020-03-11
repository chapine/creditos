<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
	
		$l_verificar = 'administrador';
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

		$sql = "SELECT id_usuario, nombre FROM usuarios WHERE id_usuario <> 0 AND tipo_usuario = 'cobrador'";
		$result = $mysqli->query($sql);
		
		$sqlR = "SELECT * FROM rutas";
		$resR = $mysqli->query($sqlR);

		if(!empty($_POST)){
			if(isset($_FILES['image']) OR isset($_FILES['image_1'])){
		
				$errors= array();
				$file_name 	= $_FILES['image']['name'];
				$file_size 	= $_FILES['image']['size'];
				$file_tmp 	= $_FILES['image']['tmp_name'];
				$file_type	= $_FILES['image']['type'];

				$file_ext = explode('.', $file_name);
				$expensions = array("jpeg","jpg","png");

				/*if(in_array($file_ext[1], $expensions)=== false){
					$errors[]="";
					//$errors[]="Extensión no permitida, seleccione un archivo JPEG, JPG o PNG.";
				}

				if($file_size > 2097152){
					$errors[]='';
					//$errors[]='El tamaño del archivo debe ser de 2mb';
				}*/
				
				
				$file_name_1 	= $_FILES['image_1']['name'];
				$file_size_1 	= $_FILES['image_1']['size'];
				$file_tmp_1 	= $_FILES['image_1']['tmp_name'];
				$file_type_1	= $_FILES['image_1']['type'];
				
				$file_ext_1		= explode('.', $file_name_1);
				$expensions_1 	= array("jpeg","jpg","png");

				/*if(in_array($file_ext_1[1], $expensions_1)=== false){
					$errors[]="";
					//$errors[]="Extensión no permitida, seleccione un archivo JPEG, JPG o PNG.";
				}

				if($file_size > 2097152){
					$errors[]='';
					//$errors[]='El tamaño del archivo debe ser de 2mb';
				}*/
				

				if(empty($errors)==true){
					$new_name = date('dmyhis');
					
					move_uploaded_file($file_tmp, "../uploads/".$new_name.'_frontal.jpg');
					move_uploaded_file($file_tmp_1, "../uploads/".$new_name.'_posterior.jpg');
					
					
					
					
					
					
					
					$nombre = mysqli_real_escape_string($mysqli,$_POST['nombre']);
					$dpi = mysqli_real_escape_string($mysqli,$_POST['dpi']);
					$nit = mysqli_real_escape_string($mysqli,$_POST['nit']);
					$profesion = mysqli_real_escape_string($mysqli,$_POST['profesion']);
					$telefono = mysqli_real_escape_string($mysqli,$_POST['telefono']);
					$celular = mysqli_real_escape_string($mysqli,$_POST['celular']);
					$direccion = mysqli_real_escape_string($mysqli,$_POST['direccion']);
					$id_ruta = mysqli_real_escape_string($mysqli,$_POST['id_ruta']);
					$fecha = mysqli_real_escape_string($mysqli,$_POST['fecha']);
					$cobrador = mysqli_real_escape_string($mysqli,$_POST['cobrador']);
					
					
					if($file_name == ''){
						$dpi_frontal = '';
					}else{
						$dpi_frontal = $new_name;
					}
					
					if($file_name_1 == ''){
						$dpi_posterior = '';
					}else{
						$dpi_posterior = $new_name;
					}


					$sqlUsuario = "INSERT INTO clientes 
					(dpi, nit, direccion, nombre, profesion, tel, cel, estado, cobrador, prestamoactivo, id_ruta, ocultar, dpi_frontal, dpi_posterior)
					VALUES
					('$dpi', '$nit', '$direccion', '$nombre', '$profesion', '$telefono', '$celular', '1', '$cobrador', '0', '$id_ruta', '0', '$dpi_frontal', '$dpi_posterior')";
					$resultUsuario = $mysqli->query($sqlUsuario);

					$insertado = mysqli_insert_id($mysqli);

					if($resultUsuario>0){
						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$usuario_bitacora 			= $_SESSION['nombre'];
						$id_bitacora_codigo			= "3";
						$id_cliente_bitacora		= "$insertado";
						$id_prestamo_bitacora		= "";
						$id_detalle_bitacora		= "";
						$id_ruta_bitacora			= "";
						$id_departamento_bitacora	= "";
						$id_usuario_bitacora		= "";

						$descripcion_bitacora	= "Agrego al cliente $nombre";

						include('../config/bitacora.php');

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						// MENSAJE SI EL REGISTRO ES INGRESADO
						$alert_bandera 	= true;
						$alert_titulo 	= "Exito";
						$alert_mensaje 	= "Cliente ingresado correctamente";
						$alert_icono 	= "success";
						$alert_boton 	= "success";

					}else{
						// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
						$alert_bandera 	= true;
						$alert_titulo 	= "Error";
						$alert_mensaje 	= "Error al ingresar el cliente";
						$alert_icono 	= "error";
						$alert_boton 	= "danger";
					}
					
					
					
					
					
					
					
					
					
				}else{
					$nombre = mysqli_real_escape_string($mysqli,$_POST['nombre']);
					$dpi = mysqli_real_escape_string($mysqli,$_POST['dpi']);
					$nit = mysqli_real_escape_string($mysqli,$_POST['nit']);
					$profesion = mysqli_real_escape_string($mysqli,$_POST['profesion']);
					$telefono = mysqli_real_escape_string($mysqli,$_POST['telefono']);
					$celular = mysqli_real_escape_string($mysqli,$_POST['celular']);
					$direccion = mysqli_real_escape_string($mysqli,$_POST['direccion']);
					$id_ruta = mysqli_real_escape_string($mysqli,$_POST['id_ruta']);
					//$fecha = mysqli_real_escape_string($mysqli,$_POST['fecha']);
					$cobrador = mysqli_real_escape_string($mysqli,$_POST['cobrador']);
					
					$sqlUsuario = "INSERT INTO clientes 
					(dpi, nit, direccion, nombre, profesion, tel, cel, estado, cobrador, prestamoactivo, id_ruta, ocultar, dpi_frontal, dpi_posterior)
					VALUES
					('$dpi', '$nit', '$direccion', '$nombre', '$profesion', '$telefono', '$celular', '1', '$cobrador', '0', '$id_ruta', '0', '$dpi_frontal', '$dpi_posterior')";
					$resultUsuario = $mysqli->query($sqlUsuario);

					$insertado = mysqli_insert_id($mysqli);

					if($resultUsuario>0){
						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$usuario_bitacora 			= $_SESSION['nombre'];
						$id_bitacora_codigo			= "3";
						$id_cliente_bitacora		= "$insertado";
						$id_prestamo_bitacora		= "";
						$id_detalle_bitacora		= "";
						$id_ruta_bitacora			= "";
						$id_departamento_bitacora	= "";
						$id_usuario_bitacora		= "";

						$descripcion_bitacora	= "Agrego al cliente $nombre";

						include('../config/bitacora.php');

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						// MENSAJE SI EL REGISTRO ES INGRESADO
						$alert_bandera 	= true;
						$alert_titulo 	= "Exito";
						$alert_mensaje 	= "Cliente ingresado correctamente";
						$alert_icono 	= "success";
						$alert_boton 	= "success";

					}else{
						// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
						$alert_bandera 	= true;
						$alert_titulo 	= "Error";
						$alert_mensaje 	= "Error al ingresar el cliente";
						$alert_icono 	= "error";
						$alert_boton 	= "danger";
					}
				}
			}
		}
			
		$title = 'Nuevo cliente';
		include('head.php');
		$active_clientes="active";
    ?>

    <script>

		function previa(){
			$('#registro').find('#guardar').attr('disabled','disabled');
			$('#registro').find('#guardar').html('<i class="glyphicon glyphicon-cloud-upload"></i> Procesando espere porfavor...');
		}

		function enviar(){
			$('#registro').find('#guardar').removeAttr('disabled','disabled');
			$('#registro').find('#guardar').html('<span class="glyphicon glyphicon-plus"></span> Guardar');
		}
		
		// this.disabled=true;
		
		function validarNombre()
		{
			previa();
			
			valor = document.getElementById("nombre").value;
			
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				
				swal({ title: "Necesita llenar el campo nombre", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.nombre.focus(), enviar(); }
					}
				);
				
				return false;
			} else { return true;}
		}

		function validar()
		{
			if(validarNombre())
			{
				previa();
				
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
                    <a class="btn btn-danger">Añadir cliente</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-plus'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="nombre">Nombre:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-success has-feedback">
									<input class="form-control" id="nombre" name="nombre" type="text" autocomplete="off">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="dpi">DPI:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="dpi" name="dpi" type="text" autocomplete="off">
									<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-6 col-md-3 ajustar1">
								<label for="dpi">Imagen frontal del DPI:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input type="file" name="image" class="form-control" />
									<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-3 ajustar1">
								<label for="dpi">Imagen posterior del DPI:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input type="file" name="image_1" class="form-control" />
									<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="nit">NIT:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="nit" name="nit" type="text" autocomplete="off">
									<span class="glyphicon glyphicon-sound-dolby form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="profesion">Profesión:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="profesion" name="profesion" type="text" autocomplete="off">
									<span class="glyphicon glyphicon-erase form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="telefono">Teléfono:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="telefono" name="telefono" type="number" maxlength="9" autocomplete="off">
									<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="celular">Celular:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="celular" name="celular" type="text" maxlength="9" autocomplete="off">
									<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="direccion">Dirección:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="direccion" name="direccion" type="text" autocomplete="off">
									<span class="glyphicon glyphicon-road form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="id_ruta">Seleccionar ruta:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<select class="form-control" id="id_ruta" name="id_ruta">
										<?php
											$i=1;
											while($rowR = mysqli_fetch_row($resR)){

												$sqlD = "SELECT * FROM departamento WHERE id_departamento = ".$rowR[1];
												$resD = $mysqli->query($sqlD);
												$rowD = $resD->fetch_assoc();
										?>
										<option value="<?php echo $rowR[0]; ?>"><?php echo $rowR[2].', '.$rowD['nombre']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 ajustar1">
								<label for="cobrador">Asignar cobrador:</label>
							</div>
							<div class="col col-md-9 ajustar2">
								<div class="has-feedback">
									<select class="form-control" id="cobrador" name="cobrador">
										<option value="-1">Seleccione un cobrador...</option>
										<?php $i=1; while($row = mysqli_fetch_row($result)){  ?>
										<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="row" align="right">
							<div class="col-md-3"></div>
							<div class="col col-md-9 ajustar3">
								<button type="button" class="btn btn-primary" name="registar" id="guardar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_clientes.php'" style="outline: none;">
									<span class="glyphicon glyphicon-backward"></span> Regresar
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>