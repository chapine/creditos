<?php
	error_reporting(0); // DESACTIVAR ERRORES

	$DBSERVER   = 'localhost';
	$DB_USER    = 'user';
	$DB_PASS    = 'pass';
	$DB_NAME    = 'data_base';

	$mysqli = new mysqli("$DBSERVER","$DB_USER","$DB_PASS","$DB_NAME"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	mysqli_set_charset($mysqli, "utf8");
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
    
	$connection = mysqli_connect("$DBSERVER", "$DB_USER", "$DB_PASS", "$DB_NAME");

	date_default_timezone_set('America/Guatemala');
?>