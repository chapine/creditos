<?php
	session_start();
	require('config/conexion.php');

	if( isset($_SESSION['id_usuario']) AND ($_SESSION['tipo_usuario']) AND ($_SESSION['nombre']) AND ($_SESSION['usuario']) ){

		if($_SESSION['tipo_usuario']=='administracion'){
			header("Location: administracion/principal.php");
		}
		
		if($_SESSION['tipo_usuario']=='administrador'){
			header("Location: administrador/principal.php");
		}

		if($_SESSION['tipo_usuario']=='cobrador'){
			header("Location: cobrador/principal.php");
		}

		if($_SESSION['tipo_usuario']=='asistente'){
			header("Location: asistente/principal.php");
		}
	}

	if(!empty($_POST)){
		##############################################################################################################################################################
		#		Recibe los datos del formulario
		#############################################################################################################################################################
		$usuario 	= mysqli_real_escape_string($mysqli,$_POST['usuario']);
		$password 	= mysqli_real_escape_string($mysqli,$_POST['password']);
		$error 		= '';
		$sha1_pass 	= sha1($password);
		
		// VERIFICVAR SI ES ADMIN O COBRADOR
		$sql_v 	= "SELECT tipo_usuario FROM usuarios WHERE usuario = '$usuario'";
		$res_v 	= $mysqli->query($sql_v);
		$row_v 	= $res_v->fetch_assoc();
		$tipo 	= $row_v['tipo_usuario'];
		
		$day = date('D');
		
		if( ($tipo == 'administrador' AND $day == 'Sun') OR ($tipo == 'cobrador' AND $day == 'Sun') OR ($tipo == 'asistente' AND $day == 'Sun') ){
			session_destroy();
			$error = "El sistema será abierto el día lunes.";
		}else{
			###################################################################
			# Comprueba la hora para ver si el sistema está abierto
			###################################################################
			$sql_h 		= "SELECT * FROM configuracion WHERE id_config = 1";
			$res_h 		= $mysqli->query($sql_h);
			$row_h 		= $res_h->fetch_assoc();

			$h_cerrar 	= date('His', strtotime( $row_h['hora_inicial'] ) );
			$h_cerrar 	= strtotime($h_cerrar);

			$h_abrir 	= date('His', strtotime( $row_h['hora_final'] ) );
			$h_abrir 	= strtotime($h_abrir);

			$h_actual 	= date('His');
			$h_actual 	= strtotime($h_actual);

			##############################################################################################################################################################
			#		Comprueba la hora para abrir el sistema
			##############################################################################################################################################################
			if( $h_actual >= $h_abrir AND $h_actual <= $h_cerrar ){

				$sql_x = "SELECT id_usuario, tipo_usuario, nombre, usuario, sesion FROM usuarios WHERE usuario = '$usuario' AND clave = '$sha1_pass'";
				$res_x = $mysqli->query($sql_x);
				$row_x = $res_x->num_rows;

				if($row_x > 0){
					// Actualizar SESION en la base de datoss
					$sesion_fecha 	= date("Y-m-d G:i:s");
					$sql_user 		= "UPDATE usuarios SET sesion = 1, sesion_fecha = '$sesion_fecha' WHERE usuario = '$usuario' AND clave = '$sha1_pass'";
					$res_user 		= $mysqli->query($sql_user);

					// Ejecutar Query para llenar las variables de la SESION
					$row = $res_x->fetch_assoc();

					$_SESSION['id_usuario'] 	= $row['id_usuario'];
					$_SESSION['tipo_usuario'] 	= $row['tipo_usuario'];
					$_SESSION['nombre'] 		= $row['nombre'];
					$_SESSION['usuario'] 		= $row['usuario'];

					if($_SESSION['tipo_usuario']=='administracion'){
						header("Location: administracion/principal.php");
					}

					if($_SESSION['tipo_usuario']=='administrador'){
						header("Location: administrador/principal.php");
					}

					if($_SESSION['tipo_usuario']=='cobrador'){
						header("Location: cobrador/principal.php");
					}

					if($_SESSION['tipo_usuario']=='asistente'){
						header("Location: asistente/principal.php");
					}

				}else{
					$error = "Datos incorrectos.";
				}

			}

			##############################################################################################################################################################
			#		sí la hora es incorrecta no deja entrar a los cobradores solo a los administradores
			##############################################################################################################################################################
			else{

				##################################################################################################################################################
				#	Sí es cobrador cierra sesión
				##################################################################################################################################################
				if( ($tipo == 'administrador') OR ($tipo == 'cobrador') OR ($tipo == 'asistente') ){
					session_destroy();
					$hora_final = date("g:i A", strtotime($row_h['hora_final']));
					$error 		= $row_h['mensaje'] . "<br> $hora_final";
				}
				
				##################################################################################################################################################
				#	Sí es administrador deja entrar al sistema
				##################################################################################################################################################
				else{

					$sql = "SELECT id_usuario, tipo_usuario, nombre, usuario, sesion FROM usuarios WHERE usuario = '$usuario' AND clave = '$sha1_pass'";
					$res = $mysqli->query($sql);
					$rows = $res->num_rows;

					if($rows > 0){
						// Actualizar SESION en la base de datoss
						$sesion_fecha 	= date("Y-m-d G:i:s");
						$sql_user 		= "UPDATE usuarios SET sesion = 1, sesion_fecha = '$sesion_fecha' WHERE usuario = '$usuario' AND clave = '$sha1_pass'";
						$res_user 		= $mysqli->query($sql_user);

						// Ejecutar Query para llenar las variables de la SESION
						$row = $res->fetch_assoc();

						$_SESSION['id_usuario'] 	= $row['id_usuario'];
						$_SESSION['tipo_usuario'] 	= $row['tipo_usuario'];
						$_SESSION['nombre'] 		= $row['nombre'];
						$_SESSION['usuario'] 		= $row['usuario'];

						if($_SESSION['tipo_usuario']=='administracion'){
							header("Location: administracion/principal.php");
						}

					}else{
						$error = "Datos incorrectos.";
					}
				}

			}
	##############################################################################################################################################################
	##############################################################################################################################################################
		}
	}

	if($_COOKIE['mensaje'] <> ''){
		$error = '';
		$error = $_COOKIE['mensaje'];

		setcookie("mensaje", "", time()-365*24*60*60, "/");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Iniciar sesión</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="temas/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="temas/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="temas/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="temas/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="temas/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="temas/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="temas/css/util.css">
	<link rel="stylesheet" type="text/css" href="temas/css/main.css">
<!--===============================================================================================-->
<style>
    #background{position:absolute; z-index:-1; width:100%; height:100%;}
</style>

<script data-ad-client="ca-pub-2213176429980614" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>
<body>
	<img id="background" src="bg.jpg" alt="" title="" />
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
				    <br><br>
					<img src="temas/images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST">
					<span class="login100-form-title">
						<?php						
							if(isset($error)) { ?>
								<div class="alert alert-danger" role="alert" style="font-size: 14px;">
								  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								  <span class="sr-only">Error:</span>
								  <?php echo $error . $_SESSION['tipo_usuario']; ?>
								</div>
						<?php } ?>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Falta el usuario">
						<input class="input100" type="text" id="usuario" name="usuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Falta la contraseña">
						<input class="input100" type="password" id="password" name="password" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Entrar
						</button>
					</div>

					<div class="text-center p-t-12">
						<br><br>
					</div>

					<!--div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div-->
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->	
	<script src="temas/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="temas/vendor/bootstrap/js/popper.js"></script>
	<script src="temas/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="temas/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="temas/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="temas/js/main.js"></script>

<style type="text/css">
    html, body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }
 
    #full-screen-background-image {
        z-index: -999;
        width: 100%;
        height: auto;
        position: fixed;
        top: 0;
        left: 0;
    }
</style>

<img src="clikpow1.jpg" id="full-screen-background-image">

</body>
</html>