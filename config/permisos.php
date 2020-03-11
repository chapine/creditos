<?php	
	// Comprobar la sesión
	$sql_permisos = "SELECT * FROM permisos WHERE id_usuario = ".$_SESSION["id_usuario"];
	$res_permisos = $mysqli->query($sql_permisos);
	$row_permisos = mysqli_fetch_array($res_permisos);

	//if($l_permiso == "configuracion"){ $query_nombre = $l_permiso; }
	if($row_permisos["$l_permiso"]==0){
		// Error si no tiene acceso
		$_SESSION['alert_titulo'] 	= "Error";
		$_SESSION['alert_mensaje']	= "No tiene acceso al área de $sesion_mensaje";
		$_SESSION['alert_icono'] 	= "error";
		$_SESSION['alert_boton'] 	= "danger";

		header("location: principal.php");
		
		echo '<meta http-equiv="Refresh" content="0;url=principal.php">';
		
		exit;
	}
?>