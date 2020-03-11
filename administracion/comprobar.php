<?php
	session_start();
	require('../config/conexion.php');
	require('fecha.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');

	$sql1 = "SELECT * FROM prestamos";
	$res1 = $mysqli->query($sql1);

	$ii = 1;

	while($row1 = mysqli_fetch_row($res1)){
		$id_prestamo = $row1[0];
		$fecha_inicial = $row1[6];
		$cuota = $row1[10];

		$Fecha_Final = FechaPago($fecha_inicial, $cuota);
		$fecha1 = fecha('d-m-Y', $Fecha_Final);
		
		$sqlCP = "UPDATE prestamos SET fecha_final = '$Fecha_Final' WHERE id_prestamo = '$id_prestamo'";
		$resCP = $mysqli->query($sqlCP);
		
		if(fecha('d-m-Y', $row1[16]) == $fecha1){ $a = 'green'; }else{ $a = 'red'; }
		echo "<font color='$a'>" .$ii .' - '. $row1[0] .' - INICIAL: '. fecha('d-m-Y', $row1[6]) .' - FINAL: '. fecha('d-m-Y', $row1[16]) .' - '. $cuota .'</font><br><br>';
		
		$ii++;
	}

	/*$sql = "SELECT * FROM prestamos ORDER BY id_prestamo asc";
	//$resP = $mysqli->query($sqlP);

	$res = $mysqli->query($sql);
	$i=1;
	while( $row = mysqli_fetch_array($res) ){

		if(fecha("d-m-Y", $row[16]) == $fecha2){ $a = 'green'; }else{ $a = 'red'; }
		
		echo "<font color='$a'>" .$i .' - '. $row[0] .' - INICIAL: '. fecha("d-m-Y", $row[6]) .' - FINAL: '. fecha("d-m-Y", $row[16]) .' - '. $cuota .'</font><br><br>';
		
		$i++;
	}
	
	/*while($rowP = $resP->fetch_assoc()){
		if($rowP['mensualidades']==1){	$diario = 1;	$pagara = 'D';} // DIARIO
		if($rowP['mensualidades']==2){	$diario = 2;	$pagara = 'S';} // SEMANAL
		if($rowP['mensualidades']==3){	$diario = 3;	$pagara = 'Q';} // QUINCENAL
		if($rowP['mensualidades']==4){	$diario = 4;	$pagara = 'M';} // MENSUAL

		if($rowP['cuota']==23){			$mes	= 1;} // 1 MES
		if($rowP['cuota']==46){			$mes	= 2;} // 2 MESES
		if($rowP['cuota']==69){			$mes	= 3;} // 3 MESES
		if($rowP['cuota']==92){			$mes	= 4;} // 4 MESES
		if($rowP['cuota']==138){		$mes	= 6;} // 6 MESES

		$monto_prestado = $rowP['monto_prestado'];
		$interes		= $rowP['interes_pagar'];
		$total 			= ($monto_prestado + $interes);

		// PAGA DIARIO
		if($diario == 1 && $mes	== 1){ $monto1 = ($monto_prestado/23); $interes1 = ($interes/23); $total2 = ($monto1+$interes1);	$cuota = 23;}
		if($diario == 1 && $mes == 2){ $monto1 = ($monto_prestado/46); $interes1 = ($interes/46); $total2 = ($monto1+$interes1);	$cuota = 46;}
		if($diario == 1 && $mes == 3){ $monto1 = ($monto_prestado/69); $interes1 = ($interes/69); $total2 = ($monto1+$interes1);	$cuota = 69;}
		if($diario == 1 && $mes	== 4){ $monto1 = ($monto_prestado/92); $interes1 = ($interes/92); $total2 = ($monto1+$interes1);	$cuota = 92;}
		if($diario == 1 && $mes == 6){ $monto1 = ($monto_prestado/138); $interes1 = ($interes/138); $total2 = ($monto1+$interes1);	$cuota = 138;}

		// PAGA SEMANAL
		if($diario == 2 && $mes	== 1){ $monto1 = ($monto_prestado/5); $interes1 = ($interes/5); $total2 = ($monto1+$interes1);		$cuota = 5;}
		if($diario == 2 && $mes == 2){ $monto1 = ($monto_prestado/10); $interes1 = ($interes/10); $total2 = ($monto1+$interes1);	$cuota = 10;}
		if($diario == 2 && $mes == 3){ $monto1 = ($monto_prestado/15); $interes1 = ($interes/15); $total2 = ($monto1+$interes1);	$cuota = 15;}
		if($diario == 2 && $mes	== 4){ $monto1 = ($monto_prestado/20); $interes1 = ($interes/20); $total2 = ($monto1+$interes1);	$cuota = 20;}
		if($diario == 2 && $mes == 6){ $monto1 = ($monto_prestado/30); $interes1 = ($interes/30); $total2 = ($monto1+$interes1);	$cuota = 30;}

		// PAGA QUINCENAL
		if($diario == 3 && $mes	== 1){ $monto1 = ($monto_prestado/2); $interes1 = ($interes/2); $total2 = ($monto1+$interes1);		$cuota = 2;}
		if($diario == 3 && $mes == 2){ $monto1 = ($monto_prestado/4); $interes1 = ($interes/4); $total2 = ($monto1+$interes1);		$cuota = 4;}
		if($diario == 3 && $mes == 3){ $monto1 = ($monto_prestado/6); $interes1 = ($interes/6); $total2 = ($monto1+$interes1);		$cuota = 6;}
		if($diario == 3 && $mes	== 4){ $monto1 = ($monto_prestado/8); $interes1 = ($interes/8); $total2 = ($monto1+$interes1);		$cuota = 8;}
		if($diario == 3 && $mes == 6){ $monto1 = ($monto_prestado/12); $interes1 = ($interes/12); $total2 = ($monto1+$interes1);	$cuota = 12;}

		// PAGA QUINCENAL
		if($diario == 4 && $mes	== 1){ $monto1 = ($monto_prestado/1); $interes1 = ($interes/1); $total2 = ($monto1+$interes1);		$cuota = 1;}
		if($diario == 4 && $mes == 2){ $monto1 = ($monto_prestado/2); $interes1 = ($interes/2); $total2 = ($monto1+$interes1);		$cuota = 2;}
		if($diario == 4 && $mes == 3){ $monto1 = ($monto_prestado/3); $interes1 = ($interes/3); $total2 = ($monto1+$interes1);		$cuota = 3;}
		if($diario == 4 && $mes	== 4){ $monto1 = ($monto_prestado/4); $interes1 = ($interes/4); $total2 = ($monto1+$interes1);		$cuota = 4;}
		if($diario == 4 && $mes == 6){ $monto1 = ($monto_prestado/6); $interes1 = ($interes/6); $total2 = ($monto1+$interes1);		$cuota = 6;}
		
		$id_prestamo = $rowP['id_prestamo'];
		$id_clientes = $rowP['id_clientes'];
		$cobrador = $rowP['cobrador'];
		$mensualidades  = $pagara;
		$fecha_inicial = $rowP['fecha_inicial'];
		$prestamo_activo = $rowP['prestamo_activo'];
		
		$x = 1;
		$a = 6;
		$b = 15;
		$c = 30;
		
		while($x <= $cuota){
			if($rowP['mensualidades']==1){ 				 $fecha_pago = FechaPago($fecha_inicial, $x); } // DIARIO
			if($rowP['mensualidades']==2){ $d = $a + $d; $fecha_pago = FechaPago($fecha_inicial, $d); } // SEMANAL
			if($rowP['mensualidades']==3){ $d = $b + $d; $fecha_pago = FechaPago($fecha_inicial, $d); } // QUINCENAL
			if($rowP['mensualidades']==4){ $d = $c + $d; $fecha_pago = FechaPago($fecha_inicial, $d); } // MENSUAL
			
			$sqlCP = "INSERT INTO cobros_prestamos 
				(id_cobro, id_prestamo, id_cliente, cobrador, mensualidades, monto_prestado, interes_pagar, total, pago, interes, total2, fecha_inicial, fecha_pago, cuota, prestamo_activo)
				VALUES
				(NULL, '$id_prestamo', '$id_clientes', '$cobrador', '$mensualidades', '$monto_prestado', '$interes', '$total', '$monto1', '$interes1', '$total2', '$fecha_inicial', '$fecha_pago', '$x', '$prestamo_activo')";
			$resCP = $mysqli->query($sqlCP);
			
			$sqlCP = "UPDATE prestamos SET generar_cobro='S' WHERE id_prestamo = $id_prestamo";
			$resCP = $mysqli->query($sqlCP);

			$x++;
		}
	}
?>
										
<?php
	/*session_start();
	header("Location: ../index.php");

	$sql = "SELECT * FROM prestamos";
	$res = $mysqli->query($sql);

	$i = 1;

	while($row = mysqli_fetch_row($res)){
		$id_prestamo = $row[0];
		$cobrador 	 = $row[3];
		
		echo $i. ' - ' .$id_prestamo. ' - ' .$cobrador;
		echo '<br>';
		
		$sql1 = "UPDATE detalleprestamo SET id_usuario = '$cobrador' WHERE id_prestamo = '$id_prestamo'";
		$res1 = $mysqli->query($sql1);
		
		$i++;
	}*/
?>