<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	

	$eliminar = $_REQUEST['eliminar'];
	$ruta = base64_decode($_REQUEST['ruta']);

	$sqlC = "SELECT count(id_ruta) AS ruta FROM clientes WHERE id_ruta = $eliminar";
	$resC = $mysqli->query($sqlC);
	$numC = $resC->fetch_assoc();

	if($numC['ruta']==0){
		$sqlR = "DELETE FROM rutas WHERE id_ruta = $eliminar";
		$resR = $mysqli->query($sqlR);

		// BITACORA  --  BITACORA  --  BITACORA
		// BITACORA  --  BITACORA  --  BITACORA

		$usuario_bitacora 			= $_SESSION['nombre'];
		$id_bitacora_codigo			= "15";
		$id_cliente_bitacora		= "";
		$id_prestamo_bitacora		= "";
		$id_detalle_bitacora		= "";
		$id_ruta_bitacora			= "";
		$id_departamento_bitacora	= "";
		$id_usuario_bitacora		= "";

		$descripcion_bitacora	= "Eliminó la ruta $ruta";

		include('../config/bitacora.php');

		// BITACORA  --  BITACORA  --  BITACORA
		// BITACORA  --  BITACORA  --  BITACORA

		header('Location: lista_rutas.php');
	}else{
		$_SESSION['ruta'] = "La ruta esta asiganada a ".$numC['ruta']." clientes.";
		header('Location: lista_rutas.php');
	}
?>