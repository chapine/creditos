<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "administrador";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_REQUEST['id']; // OBTIENE EL ID A EDITAR

		$sqlC = "SELECT * FROM clientes WHERE id_cliente = ".$id;
		$resC = $mysqli->query($sqlC);
		$row1 = $resC->fetch_assoc();

		if($row1['id_ruta']==''){
			$IdRuta = '0';
			$NombreRuta = 'Ninguno';
			$depto = 'Ninguno';
		}else{
			$sqlRR = "SELECT * FROM rutas WHERE id_ruta = ".$row1['id_ruta'];
			$resRR = $mysqli->query($sqlRR);
			$rowRR = mysqli_fetch_row($resRR);


			$sqlDD = "SELECT * FROM departamento WHERE id_departamento = ".$rowRR[1];
			$resDD = $mysqli->query($sqlDD);
			$rowDD = $resDD->fetch_assoc();

			$IdRuta = $rowRR[0];
			$NombreRuta = $rowRR[2];
			$depto = $rowDD['nombre'];
		}
		// OBTIENE DATOS PARA EL FORMULARIO

		if(!empty($_POST)){
			if(isset($_FILES['image']) AND isset($_FILES['image_1'])){
		
				$errors = array();
				$file_name 	= $_FILES['image']['name'];
				$file_size 	= $_FILES['image']['size'];
				$file_tmp 	= $_FILES['image']['tmp_name'];
				$file_type	= $_FILES['image']['type'];

				$file_ext = explode('.', $file_name);
				$expensions = array("jpeg","jpg","png");

				if(in_array($file_ext[1], $expensions)=== false){
					$errors[]="";
					//$errors[]="Extensión no permitida, seleccione un archivo JPEG, JPG o PNG.";
				}

				/*if($file_size > 2097152){
					$errors[]='';
					//$errors[]='El tamaño del archivo debe ser de 2mb';
				}*/
				
				
				$file_name_1 	= $_FILES['image_1']['name'];
				$file_size_1 	= $_FILES['image_1']['size'];
				$file_tmp_1 	= $_FILES['image_1']['tmp_name'];
				$file_type_1	= $_FILES['image_1']['type'];
				
				$file_ext_1		= explode('.', $file_name_1);
				$expensions_1 	= array("jpeg","jpg","png");

				if(in_array($file_ext_1[1], $expensions_1)=== false){
					$errors[]="";
					//$errors[]="Extensión no permitida, seleccione un archivo JPEG, JPG o PNG.";
				}

				/*if($file_size > 2097152){
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
					//$fecha = mysqli_real_escape_string($mysqli,$_POST['fecha']);
					$cobrador = mysqli_real_escape_string($mysqli,$_POST['cobrador']);
					
					if($file_name == ''){
						$dpi_frontal = $row1['dpi_frontal'];
					}else{
						$dpi_frontal = $new_name;
					}
					
					if($file_name_1 == ''){
						$dpi_posterior = $row1['dpi_posterior'];
					}else{
						$dpi_posterior = $new_name;
					}
					
					echo $dpi_frontal;
					echo '<br>';
					echo $dpi_posterior;

					$sqlUsuario = "UPDATE clientes SET dpi='$dpi', nit='$nit', direccion='$direccion', nombre='$nombre', profesion='$profesion', tel='$telefono', cel='$celular', estado='1', id_ruta='$id_ruta', ocultar='0', dpi_frontal='$dpi_frontal', dpi_posterior='$dpi_posterior' WHERE id_cliente=$id";
					$resultUsuario = $mysqli->query($sqlUsuario);

					if($resultUsuario>0){
						$sqlPRESTAMO = "UPDATE prestamos SET id_ruta = '$id_ruta' WHERE id_cliente = $id";
						$resPRESTAMO = $mysqli->query($sqlPRESTAMO);

						$sqlC = "SELECT * FROM clientes WHERE id_cliente = ".$id;
						$resC = $mysqli->query($sqlC);
						$row1 = $resC->fetch_assoc();


						if($row1['id_ruta']==''){
							$IdRuta = '0';
							$NombreRuta = 'Ninguno';
							$depto = 'Ninguno';
						}else{
							$sqlRR = "SELECT * FROM rutas WHERE id_ruta = ".$row1['id_ruta'];
							$resRR = $mysqli->query($sqlRR);
							$rowRR = mysqli_fetch_row($resRR);


							$sqlDD = "SELECT * FROM departamento WHERE id_departamento = ".$rowRR[1];
							$resDD = $mysqli->query($sqlDD);
							$rowDD = $resDD->fetch_assoc();

							$IdRuta = $rowRR[0];
							$NombreRuta = $rowRR[2];
							$depto = $rowDD['nombre'];
						}

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$usuario_bitacora 			= $_SESSION['nombre'];
						$id_bitacora_codigo			= "4";
						$id_cliente_bitacora		= "$id";
						$id_prestamo_bitacora		= "";
						$id_detalle_bitacora		= "";
						$id_ruta_bitacora			= "";
						$id_departamento_bitacora	= "";
						$id_usuario_bitacora		= "";

						$descripcion_bitacora	= "Modificó al cliente ".$row1['nombre'];

						include('../config/bitacora.php');

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$alert_bandera 	= true;
						$alert_titulo 	= "Exito";
						$alert_mensaje 	= "Registro actualizado exitosamente";
						$alert_icono 	= "success";
						$alert_boton 	= "success";

					}
					else{
						// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
						$alert_bandera 	= true;
						$alert_titulo 	= "Error";
						$alert_mensaje 	= "Error al actualizar el registro";
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
					
					$sqlUsuario = "UPDATE clientes SET dpi='$dpi', nit='$nit', direccion='$direccion', nombre='$nombre', profesion='$profesion', tel='$telefono', cel='$celular', estado='1', id_ruta='$id_ruta', ocultar='0' WHERE id_cliente=$id";
					$resultUsuario = $mysqli->query($sqlUsuario);

					if($resultUsuario>0){
						$sqlPRESTAMO = "UPDATE prestamos SET id_ruta = '$id_ruta' WHERE id_cliente = $id";
						$resPRESTAMO = $mysqli->query($sqlPRESTAMO);

						$sqlC = "SELECT * FROM clientes WHERE id_cliente = ".$id;
						$resC = $mysqli->query($sqlC);
						$row1 = $resC->fetch_assoc();


						if($row1['id_ruta']==''){
							$IdRuta = '0';
							$NombreRuta = 'Ninguno';
							$depto = 'Ninguno';
						}else{
							$sqlRR = "SELECT * FROM rutas WHERE id_ruta = ".$row1['id_ruta'];
							$resRR = $mysqli->query($sqlRR);
							$rowRR = mysqli_fetch_row($resRR);


							$sqlDD = "SELECT * FROM departamento WHERE id_departamento = ".$rowRR[1];
							$resDD = $mysqli->query($sqlDD);
							$rowDD = $resDD->fetch_assoc();

							$IdRuta = $rowRR[0];
							$NombreRuta = $rowRR[2];
							$depto = $rowDD['nombre'];
						}

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$usuario_bitacora 			= $_SESSION['nombre'];
						$id_bitacora_codigo			= "4";
						$id_cliente_bitacora		= "$id";
						$id_prestamo_bitacora		= "";
						$id_detalle_bitacora		= "";
						$id_ruta_bitacora			= "";
						$id_departamento_bitacora	= "";
						$id_usuario_bitacora		= "";

						$descripcion_bitacora	= "Modificó al cliente ".$row1['nombre'];

						include('../config/bitacora.php');

						// BITACORA  --  BITACORA  --  BITACORA
						// BITACORA  --  BITACORA  --  BITACORA

						$alert_bandera 	= true;
						$alert_titulo 	= "Exito";
						$alert_mensaje 	= "Registro actualizado exitosamente";
						$alert_icono 	= "success";
						$alert_boton 	= "success";

					}
					else{
						// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
						$alert_bandera 	= true;
						$alert_titulo 	= "Error";
						$alert_mensaje 	= "Error al actualizar el registro";
						$alert_icono 	= "error";
						$alert_boton 	= "danger";
					}
					//print_r($errors);
				}
			}
		}

		$title = 'Editar cliente';		
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

		/*function validarFecha()
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
		}*/

		function validar()
		{
			if(validarNombre() /*&& validarFecha()*/)
			{
				previa();
				
				document.registro.submit();
			}
		}
	</script>
</head>
<body onload="Reloj();">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">

        <!-- Navegador -->
        <div class="hidden-xs" style="padding-bottom:20px;">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    <a class="btn btn-danger" >Editar cliente</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->

        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-pencil'></i> <?php echo $title; ?></h4>
			</div>
			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="nombre">Nombre:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-success has-feedback">
									<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $row1['nombre']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="dpi">DPI:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="dpi" name="dpi" type="text" value="<?php echo $row1['dpi']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="dpi">Imagen frontal del DPI:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input type="file" name="image" class="form-control" />
									<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="dpi">Imagen posterior del DPI:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input type="file" name="image_1" class="form-control" />
									<span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1" style="height: 196px;">
								<label for="dpi">Vista previa:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<?php
										if($row1['dpi_frontal']==''){
											echo '<img src="../images/dpi_frontal.png" width="300" height="180">';
										}else{
											echo '<img src="../uploads/'.$row1['dpi_frontal'].'_frontal.jpg" width="300" height="180">';
										}
									
										if($row1['dpi_posterior']==''){
											echo '<img src="../images/dpi_posterior.png" width="300" height="180">';
										}else{
											echo '<img src="../uploads/'.$row1['dpi_posterior'].'_posterior.jpg" width="300" height="180">';
										}
									?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="nit">NIT:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="nit" name="nit" type="text" value="<?php echo $row1['nit']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-sound-dolby form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="profesion">Profesión:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="profesion" name="profesion" type="text" value="<?php echo $row1['profesion']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-erase form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="telefono">Teléfono:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="telefono" name="telefono" type="text" maxlength="9" value="<?php echo $row1['tel']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="celular">Celular:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="celular" name="celular" type="text" maxlength="9" value="<?php echo $row1['cel']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="direccion">Dirección:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-feedback">
									<input class="form-control" id="direccion" name="direccion" type="text" value="<?php echo $row1['direccion']; ?>" autocomplete="off">
									<span class="glyphicon glyphicon-road form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="id_ruta">Seleccionar ruta:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-success has-feedback">
									<select class="form-control" id="id_ruta" name="id_ruta">
										<option value="<?php echo $IdRuta; ?>"><?php echo $NombreRuta.', '.$depto; ?></option>
										<option disabled>----------------------------------------------</option>
										<?php
											$i=1;

											$sqlR = "SELECT * FROM rutas";
											$resR = $mysqli->query($sqlR);

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

						<!--div class="row">
							<div class="col-6 col-md-2 ajustar1">
								<label for="fecha">Fecha de nacimiento:</label>
							</div>
							<div class="col col-md-10 ajustar2">
								<div class="has-success has-feedback">
									<input class="form-control" id="fecha" name="fecha" type="date" value="<?php echo $row1['fechanacimiento']; ?>">
									<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
								</div>
							</div>
						</div-->

						<div class="row">
							<div class="col-6 col-md-2"></div>
							<div class="col col-md-10 ajustar3" align="right">
								<button type="button" class="btn btn-primary" name="registar" id="guardar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" id="guardar" onclick="location.href='lista_clientes.php?numero=1'" style="outline: none;">
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