<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	$sql = "SELECT sesion FROM usuarios WHERE sesion <> 0";
	$res = $mysqli->query($sql);

	echo $row = mysqli_num_rows($res);
?>