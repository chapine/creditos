<?php
	// Comprobar la sesión
	$sql_sesion = "SELECT sesion, sesion_fecha FROM usuarios WHERE id_usuario = ".$_SESSION["id_usuario"];
	$res_sesion = $mysqli->query($sql_sesion);
	$row_sesion = mysqli_fetch_array($res_sesion);

	// Actualizar la ultima hora y fecha activa
	$sesion_fecha = date("Y-m-d G:i:s");
	$sql_sesion_fecha = "UPDATE usuarios SET sesion_fecha = '$sesion_fecha' WHERE id_usuario = ".$_SESSION["id_usuario"];
	$res_sesion_fecha = $mysqli->query($sql_sesion_fecha);

	if($_SESSION["id_usuario"]=='' OR $_SESSION['tipo_usuario']=='' OR $_SESSION['nombre']=='' OR $_SESSION['usuario']==''){
		//header("Location: ../index.php");
		echo"<script language='javascript'>window.location='../index.php'</script>;";
		exit();

	}elseif($row_sesion['sesion']==0){
		
		setcookie("mensaje", "Sesión finalizada por un administrador.", time() + 365 * 24 * 60 * 60, "/");
		//header("Location: ../cerrar_sesion.php");
		echo"<script language='javascript'>window.location='../cerrar_sesion.php'</script>;";
		exit();

	}elseif($row_sesion['sesion']==2){
		// Comprobar la sesión
		$sql_sesion1 = "SELECT id_usuario FROM usuarios";
		$res_sesion1 = $mysqli->query($sql_sesion1);

		while($row_sesion1 = mysqli_fetch_array($res_sesion1)){
			$id_user		= $row_sesion1['id_usuario'];

			$sql_user2 = "UPDATE usuarios SET sesion = 0, sesion_fecha = '1000-01-01 00:00:00' WHERE id_usuario = $id_user AND sesion = 2";
			$res_user2 = $mysqli->query($sql_user2);
		}
		
		$sql_config = "SELECT * FROM configuracion WHERE id_config = 1";
		$res_config = $mysqli->query($sql_config);
		$row_config = $res_config->fetch_assoc();
		$cerrar_sesion_hora = $row_config['cerrar_sesion_hora'];
		
		if($cerrar_sesion_hora == 1){ $sesion_hora = "$cerrar_sesion_hora hora"; }else{ $sesion_hora = "$cerrar_sesion_hora horas"; }
		
		//setcookie("mensaje", "Sesión finalizada por estar inactiva $sesion_hora.", time() + 365 * 24 * 60 * 60);
		setcookie("mensaje", "Sesión finalizada por estar inactiva $sesion_hora.", time() + 365 * 24 * 60 * 60, "/");
    
		//header("Location: ../cerrar_sesion.php");
		echo"<script language='javascript'>window.location='../cerrar_sesion.php'</script>;";
		exit();

	}else
		if($_SESSION['tipo_usuario'] <> "$l_verificar"){
			//header("Status: 301 Moved Permanently");
			//header("Location:../index.php");
			echo"<script language='javascript'>window.location='../index.php'</script>;";
			exit();
			//header("Location: ../index.php");
		}

		// FUNCIONES QUE SE USAN EN EL PROGRAMA
		require('funciones.php');

		//echo $_SESSION['tipo_usuario'];
?>