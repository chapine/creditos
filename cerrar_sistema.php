<?php
	require('config/conexion.php');

    $sql_h = "SELECT * FROM configuracion WHERE id_config = 1";
	$res_h = $mysqli->query($sql_h);
	$row_h = $res_h->fetch_assoc();

	$hora_inicial = $row_h['hora_inicial'];
	$fecha_inicial = $row_h['fecha_inicial'];

	$hora_final = $row_h['hora_final'];
	$fecha_final = $row_h['fecha_final'];

	$hora_actual = strtotime(date("Y-m-d H:i:s")); // HORA ACTUAL
	$hora_cerrar = strtotime(date("$fecha_inicial $hora_inicial")); // HORA PARA CERRAR
	$hora_abrir  = strtotime(date("$fecha_final $hora_final")); // HORA PARA ABRIR

	// Si llega la hora de cerrar hasta la hora de abrir se actualiza la base de datos y cierra sesión de los cobradores
	if( $hora_actual >= $hora_cerrar AND $hora_actual <= $hora_abrir ){
		$sql_user = "UPDATE usuarios SET sesion = 0 WHERE tipo_usuario = 'cobrador'";
		$res_user = $mysqli->query($sql_user);
	}

	  //01:56:00 13/07/2018 > 08:00:00 14/07/2018
	if( $hora_actual >= $hora_abrir ){
		$fecha_inicial = date("Y-m-d", strtotime("$fecha_inicial +1 day")); // HORA PARA CERRAR
		$fecha_final =  date("Y-m-d", strtotime("$fecha_final +1 day")); // HORA PARA ABRIR
		
		$sql = "UPDATE configuracion SET fecha_inicial = '$fecha_inicial', fecha_final = '$fecha_final' WHERE id_config = 1";
		$res = $mysqli->query($sql);
	}




	// Comprobar la sesión
	$sql_sesion1 = "SELECT id_usuario, sesion, sesion_fecha FROM usuarios";
	$res_sesion1 = $mysqli->query($sql_sesion1);

	while($row_sesion1 = mysqli_fetch_array($res_sesion1)){
		$hora_actual_1 = date("Y-m-d H:i:s");
		$hora_sesion_1 = $row_sesion1['sesion_fecha'];
		$cerrar_sesion_hora = $row_h['cerrar_sesion_hora'];

		$hora_actual_2 = new DateTime($hora_actual_1);
		$hora_sesion_2 = new DateTime($hora_sesion_1);

		$hora_diferencia = $hora_sesion_2->diff($hora_actual_2);

		$hora_total = ($hora_diferencia->format("%d")*24)+($hora_diferencia->format("%h"));
		

		if($hora_total >= $cerrar_sesion_hora){
			$sql_user1 = "UPDATE usuarios SET sesion = 2, sesion_fecha = '1000-01-01 00:00:00' WHERE id_usuario = ".$row_sesion1['id_usuario'];
			$res_user1 = $mysqli->query($sql_user1);
		}

	}
?>