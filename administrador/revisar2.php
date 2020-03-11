<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');
	
	$l_verificar = 'administrador';
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	$saldo_restante_vale = $_REQUEST['saldo_restante_vale'];
	$id_prestamo = $_REQUEST['id_prestamo'];

	$sqlP = "UPDATE prestamos SET saldo_restante = $saldo_restante_vale WHERE id_prestamo = $id_prestamo";
	$resP = $mysqli->query($sqlP);

	header('Location: revisar.php');
?>