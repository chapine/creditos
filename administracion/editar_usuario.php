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
		   
		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_REQUEST['id']; // OBTIENE EL ID A EDITAR
		$tipo = $_REQUEST['tipo'];

		$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
		$res1 = $mysqli->query($sql);
		$row1 = $res1->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO

		if(!empty($_POST)){
			$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
			$res1 = $mysqli->query($sql);
			$row1 = $res1->fetch_assoc();

			$nombre = mysqli_real_escape_string($mysqli,$_POST['nombre']);
			$telefono = mysqli_real_escape_string($mysqli,$_POST['telefono']);
			$celular = mysqli_real_escape_string($mysqli,$_POST['celular']);
			$usuario = mysqli_real_escape_string($mysqli,$_POST['usuario']);
			$p = mysqli_real_escape_string($mysqli,$_POST['password']);
			$direccion = mysqli_real_escape_string($mysqli,$_POST['direccion']);
			$observaciones = mysqli_real_escape_string($mysqli,$_POST['observaciones']);

			if($p==''){
				$sha1_pass = $row1['clave'];
			}else{
				$sha1_pass = sha1($p);
			}

			$fecha = mysqli_real_escape_string($mysqli,$_POST['fecha']);
			$tipo_usuario = mysqli_real_escape_string($mysqli,$_POST['tipo_usuario']);

			$sqlUsuario = "UPDATE usuarios SET nombre = '$nombre', tel='$telefono', cel='$celular', usuario='$usuario', clave='$sha1_pass', direccion='$direccion', observaciones='$observaciones', tipo_usuario='$tipo_usuario'  WHERE id_usuario = $id";
			$resultUsuario = $mysqli->query($sqlUsuario);
			
			// Comprobar si es Cobrador eliminar el registro de permiso si lo encuentra
			if($tipo_usuario == 'c'){
				
				$sql_a = "SELECT * FROM permisos WHERE id_usuario = $id";
				$res_a = $mysqli->query($sql_a);
				$row_a = $res_a->fetch_assoc();

				if($row_a > 0){
					$sql_b = "DELETE FROM permisos WHERE id_usuario = $id";
					$res_b = $mysqli->query($sql_b);
				}
				
				
			}
			
			// Si es administrador verifica si existe el registro y lo deja tal cual
			if($tipo_usuario == 'a'){
				$sql_a = "SELECT * FROM permisos WHERE id_usuario = $id";
				$res_a = $mysqli->query($sql_a);
				$row_a = $res_a->fetch_assoc();
				
				if($row_a > 0){
					//
				}else{
					$sql = "INSERT INTO permisos (id_usuario) VALUES ('$id')";
					$res = $mysqli->query($sql);
				}
				
				
			}
			
			if($resultUsuario>0){
				$sql = "SELECT * FROM usuarios WHERE id_usuario=".$id;
				$res1=$mysqli->query($sql);
				$row1 = $res1->fetch_assoc();
			
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

				$descripcion_bitacora	= "Modificó al usuario $nombre";

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
		function enviar(){
			$('#registro').find('#guardar').attr('disabled','disabled');
			$('#registro').find('#guardar').html('<span class="glyphicon glyphicon-floppy-disk"></span> Procesando, espere...');
			$('#registro').find('#regresar').attr('disabled','disabled');
		}
		
		function no_enviar(){
			$('#registro').find('#guardar').removeAttr('disabled','disabled');
			$('#registro').find('#guardar').html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
			$('#registro').find('#regresar').removeAttr('disabled','disabled');
		}
		
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
			enviar();
			
			if(validarNombre() && validarUsuario() && validarPassword() && validarTipoUsuario())
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
                    <a class="btn btn-danger">Editar usuario</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="30%" align="right"><label for="nombre">Nombre:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $row1['nombre']; ?>" autocomplete="off" onClick="this.select();">
									<span class="glyphicon glyphicon-user form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="telefono">Teléfono:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="telefono" name="telefono" type="text" value="<?php echo $row1['tel']; ?>" autocomplete="off" onClick="this.select();">
									<span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="celular">Celular:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="celular" name="celular" type="text" value="<?php echo $row1['cel']; ?>" autocomplete="off" onClick="this.select();">
									<span class="glyphicon glyphicon-phone form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="usuario">Usuario:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $row1['usuario']; ?>" autocomplete="off" onClick="this.select();">
									<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="password">Password:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="password" name="password" type="password" autocomplete="off">
									<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="con_password">Confirmar Password:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="con_password" name="con_password" type="password" autocomplete="off">
									<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="direccion">Dirección:</label></td>
							<td>
								<div class="has-feedback">
									<input class="form-control" id="direccion" name="direccion" type="text" value="<?php echo $row1['direccion']; ?>" autocomplete="off" onClick="this.select();">
									<span class="glyphicon glyphicon-road form-control-feedback"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="observaciones">Observaciones:</label></td>
							<td>
								<div class="has-feedback">
									<textarea class="form-control textoarea" id="observaciones" name="observaciones" maxlength="200" onClick="this.select();"><?php echo $row1['observaciones']; ?></textarea>
								</div>
							</td>
						</tr>
						<tr>
							<td align="right"><label for="tipo_usuario">Tipo Usuario:</label></td>
							<td>
								<div class="has-success has-feedback">
									<?php
										if($row1['tipo_usuario']=='administracion'){
											$b = 'selected';
										}elseif($row1['tipo_usuario']=='administrador'){
											$c = 'selected';
										}elseif($row1['tipo_usuario']=='asistente'){
											$d = 'selected';
										}elseif($row1['tipo_usuario']=='cobrador'){
											$e = 'selected';
										}else{
											$a = 'selected';
										}
									?>
									<select class="form-control" id="tipo_usuario" name="tipo_usuario">
										<option <?php echo $a; ?> value="0">Seleccione tipo de usuario...</option>
										<option <?php echo $b; ?> value="administracion">administracion</option>
										<option <?php echo $c; ?> value="administrador">administrador</option>
										<option <?php echo $d; ?> value="asistente">asistente</option>
										<option <?php echo $e; ?> value="cobrador">cobrador</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" id="guardar" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
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