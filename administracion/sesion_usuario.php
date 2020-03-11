<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	
	$id = $_REQUEST['id'];
	$cliente = base64_decode($_REQUEST['c']);

	$sql_user = "UPDATE usuarios SET sesion = 0 WHERE id_usuario = $id";
	$res_user = $mysqli->query($sql_user);

	// BITACORA  --  BITACORA  --  BITACORA
	// BITACORA  --  BITACORA  --  BITACORA

	$usuario_bitacora 			= $_SESSION['nombre'];
	$id_bitacora_codigo			= "29";
	$id_cliente_bitacora		= "";
	$id_prestamo_bitacora		= "";
	$id_detalle_bitacora		= "";
	$id_ruta_bitacora			= "";
	$id_departamento_bitacora	= "";
	$id_usuario_bitacora		= "";

	$descripcion_bitacora	= "Cerro sesión a distancia de $cliente";

	include('../config/bitacora.php');

	// BITACORA  --  BITACORA  --  BITACORA
	// BITACORA  --  BITACORA  --  BITACORA

	header('Location: sesiones.php');
?>