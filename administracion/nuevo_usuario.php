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

		if(!empty($_POST)){
			$nombre 		= mysqli_real_escape_string($mysqli,$_POST['nombre']);
			$telefono 		= mysqli_real_escape_string($mysqli,$_POST['telefono']);
			$celular 		= mysqli_real_escape_string($mysqli,$_POST['celular']);
			$usuario 		= mysqli_real_escape_string($mysqli,$_POST['usuario']);
			$p 				= mysqli_real_escape_string($mysqli,$_POST['password']);
			$direccion 		= mysqli_real_escape_string($mysqli,$_POST['direccion']);
			$observaciones 	= mysqli_real_escape_string($mysqli,$_POST['observaciones']);
			$sha1_pass 		= sha1($p);
			
			$tipo_usuario 	= mysqli_real_escape_string($mysqli,$_POST['tipo_usuario']);

			$sqlUsuario = "
				INSERT INTO usuarios 
					(tipo_usuario, usuario, clave, nombre, tel, cel, direccion, observaciones)
				VALUES
					('$tipo_usuario', '$usuario', '$sha1_pass', '$nombre', '$telefono', '$celular', '$direccion', '$observaciones')
			";
			$resultUsuario = $mysqli->query($sqlUsuario);

			$insertado = mysqli_insert_id($mysqli);
			
			if($tipo_usuario=='a'){
				$sql = "INSERT INTO permisos (id_usuario) VALUES ('$insertado')";
				$res = $mysqli->query($sql);
			}
			
			if($resultUsuario>0){
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA

				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "9";
				$id_cliente_bitacora		= "";
				$id_prestamo_bitacora		= "";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "$insertado";

				$descripcion_bitacora	= "Agrego al usuario $nombre";

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				// MENSAJE SI EL REGISTRO ES INGRESADO
				$alert_bandera 	= true;
				$alert_titulo 	= "Exito";
				$alert_mensaje 	= "Nuevo usuario registrado correctamente";
				$alert_icono 	= "success";
				$alert_boton 	= "success";
				
			}else{
				// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
				$alert_bandera 	= true;
				$alert_titulo 	= "Error";
				$alert_mensaje 	= "Error al registrar el nuevo usuario";
				$alert_icono 	= "error";
				$alert_boton 	= "danger";
			}
		}
			
		$title = 'Nuevo usuario';
		include('head.php');
		$active_usuarios="active";
    ?>
    
    <script>
		function validarNombre()
		{
			valor = document.getElementById("nombre").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo nombre", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.nombre.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validarUsuario()
		{
			valor = document.getElementById("usuario").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo usuario", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.usuario.focus(); }
					}
				);
				return false;
			} else { return true;}
		}
		
		function validarContraseña()
		{
			valor = document.getElementById("password").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo password", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.password.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validarPassword()
		{
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
		
		function validarTipoUsuario()
		{
			indice = document.getElementById("tipo_usuario").selectedIndex;
			if( indice == null || indice==0 ) {
				swal({ title: "Seleccione un tipo de usuario", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.tipo_usuario.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validar()
		{
			if(validarNombre() && validarUsuario() && validarContraseña() && validarPassword() && validarTipoUsuario())
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
                    <a href="lista_usuarios.php" class="btn btn-success">Usuarios</a>
                    <a class="btn btn-danger">Añadir usuario</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-plus'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="30%" align="right"><label for="nombre">Nombre:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="nombre" name="nombre" type="text">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="telefono">Teléfono:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="telefono" name="telefono" type="text">
									<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="celular">Celular:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="celular" name="celular" type="text">
									<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="usuario">Usuario:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="usuario" name="usuario" type="text">
									<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="password">Password:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="password" name="password" type="password">
									<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="con_password">Confirmar Password:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="con_password" name="con_password" type="password">
									<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="direccion">Dirección:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="direccion" name="direccion" type="text">
									<span class="glyphicon glyphicon-road form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="observaciones">Observaciones:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="observaciones" name="observaciones" type="text">
									<span class="glyphicon glyphicon-cloud form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="tipo_usuario">Tipo Usuario:</label></td>
							<td>
								<div class="has-success has-feedback">
									<select class="form-control" id="tipo_usuario" name="tipo_usuario">
										<option value="0" selected>Seleccione tipo de usuario...</option>
										<option value="administracion">administracion</option>
										<option value="administrador">administrador</option>
										<option value="asistente">asistente</option>
										<option value="cobrador">cobrador</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_usuarios.php'" style="outline: none;">
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