<?php
    session_start();

	require('config/conexion.php');

	/*/ BITACORA  --  BITACORA  --  BITACORA
	// BITACORA  --  BITACORA  --  BITACORA

	$usuario_bitacora 			= $_SESSION['nombre'];
	$id_bitacora_codigo			= "2";
	$id_cliente_bitacora		= "";
	$id_prestamo_bitacora		= "";
	$id_detalle_bitacora		= "";
	$id_ruta_bitacora			= "";
	$id_departamento_bitacora	= "";
	$id_usuario_bitacora		= "";

	$descripcion_bitacora	= "Cerror sesión";

	include('config/bitacora.php');

	// BITACORA  --  BITACORA  --  BITACORA
	// BITACORA  --  BITACORA  --  BITACORA*/

	// Actualizar SESION en la base de datoss
	$sql_user = "UPDATE usuarios SET sesion = 0 WHERE id_usuario = " .$_SESSION["id_usuario"];
	$res_user = $mysqli->query($sql_user);

    session_destroy(); 	
    header('location: index.php'); 
?>