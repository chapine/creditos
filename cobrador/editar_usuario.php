<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		
		$l_verificar = "cobrador";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	
		   
		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_SESSION['id_usuario']; // OBTIENE EL ID A EDITAR

		$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
		$result1=$mysqli->query($sql);
		$row1 = $result1->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO

		if(!empty($_POST)){			
			$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
			$result1=$mysqli->query($sql);
			$row1 = $result1->fetch_assoc();

			$p = mysqli_real_escape_string($mysqli,$_POST['password']);
			$observaciones = mysqli_real_escape_string($mysqli,$_POST['observaciones']);

			if($p==''){
				//echo "<script>alert('hola');</script>";
				$sha1_pass = $row1['clave'];
			}else{
				$sha1_pass = sha1($p);
			}

			$fecha = mysqli_real_escape_string($mysqli, $_POST['fecha']);
			$tipo_usuario = mysqli_real_escape_string($mysqli, $_POST['tipo_usuario']);

			$error = '';

			$sqlUsuario = "UPDATE usuarios SET clave='$sha1_pass' WHERE id_usuario = $id";
			$resultUsuario = $mysqli->query($sqlUsuario);

			if($resultUsuario>0){
				$sql = "SELECT * FROM usuarios WHERE id_usuario=".$id;
				$result1=$mysqli->query($sql);
				$row1 = $result1->fetch_assoc();
				
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA

				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "10";
				$id_cliente_bitacora		= "";
				$id_prestamo_bitacora		= "";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "$id";

				$descripcion_bitacora	= "Modificó su contraseña";

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				
				// MENSAJE SI EL REGISTRO ES INGRESADO
				$alert_bandera 	= true;
				$alert_titulo 	= "Exito";
				$alert_mensaje 	= "Usuario actualizado correctamente";
				$alert_icono 	= "success";
				$alert_boton 	= "success";
			}else{
				// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
				$alert_bandera 	= true;
				$alert_titulo 	= "Error";
				$alert_mensaje 	= "Error al actualizar el usuario";
				$alert_icono 	= "error";
				$alert_boton 	= "danger";
			}
		}
			
		$title = 'Editar usuario';
		include('head.php');
		$active_usuarios="active";
    ?>
    
    <script>
		function validarPassword(){
			valor = document.getElementById("password").value;
			valor2 = document.getElementById("con_password").value;

			if(valor == valor2){
				return true;
			}else{
				
				swal({ title: "La contraseña no coinciden", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){
							swal.close(),
							registro.password.value='',
							registro.con_password.value='',
							registro.password.focus();
						}
					}
				);
				
				return false;
			}
		}

		function validar()
		{
			if(validarPassword())
			{
				document.registro.submit();
			}
		}
	</script>
</head>
<body onLoad="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">

        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="index.php" class="btn btn-default">Inicio</a>
                    <a href="perfil_usuario.php" class="btn btn-success">Perfil</a>
                    <a class="btn btn-danger">Editar usuario</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
			<div class="btn-group pull-right">
				<h4><b>Nota: solo se le permite cambiar su contraseña.</b></h4>
			</div>
				<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="30%" align="right"><label for="nombre">Nombre:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $row1['nombre']; ?>" disabled>
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="telefono">Teléfono:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="telefono" name="telefono" type="text" value="<?php echo $row1['tel']; ?>" disabled>
									<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="celular">Celular:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="celular" name="celular" type="text" value="<?php echo $row1['cel']; ?>" disabled>
									<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="usuario">Usuario:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $row1['usuario']; ?>" disabled>
									<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="password">contraseña:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="password" name="password" type="password">
									<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="con_password">Confirmar contraseña:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="con_password" name="con_password" type="password">
									<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="direccion">Dirección:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="direccion" name="direccion" type="text" value="<?php echo $row1['direccion']; ?>" disabled>
									<span class="glyphicon glyphicon-road form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="observaciones">Observaciones:</label></td>
							<td>
								<div class="has-success has-feedback">
									<textarea class="form-control textoarea" id="observaciones" name="observaciones" maxlength="200" disabled><?php echo $row1['observaciones']; ?></textarea>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="fecha">Fecha de nacimiento:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="fecha" name="fecha" type="date" value="<?php echo $row1['fechanacimiento']; ?>" disabled>
									<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="tipo_usuario">Tipo Usuario:</label></td>
							<td>
								<div class="has-feedback">
									<select class="form-control" id="tipo_usuario" name="tipo_usuario" disabled>
										<option value="0">Seleccione tipo de usuario...</option>
										<?php if($row1['tipo_usuario']=='a'){ ?>
											<option value="a" selected>Administrador</option>
											<option value="c">Cobrador</option>
										<?php }else{?>
											<option value="a">Administrador</option>
											<option value="c" selected>Cobrador</option>
										<?php }?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='perfil_usuario.php'" style="outline: none;">
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