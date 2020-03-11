<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');

	$l_verificar = "administracion";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	$id = $_REQUEST['prestamo'];

	$sqlP = "SELECT * FROM prestamos WHERE prestamo_activo = 1";
	$resP = $mysqli->query($sqlP);

	$i=1;
	$abono = 0;
	$mora = 0;

		//number_format(($rowP[6]+$rowP[9]),2,".",",");

?>
	<table border="1" cellspacing="0" cellpadding="5" align="center">
	  <tbody>
		<tr>
	  	  <td style="font-weight: bold;" width="5">ID_CLIENTE</td>
	  	  <td style="font-weight: bold;" width="30">ID_PRESTAMO</td>
	  	  <td style="font-weight: bold;" width="30">ABONOS</td>
		  <td style="font-weight: bold;" width="30">PAGAR - ABONO</td>
		  <td style="font-weight: bold;" width="30">SALDO RESTANTE</td>
		  
		  <td style="font-weight: bold;" width="200"></td>
		  <td style="font-weight: bold;" width="200"></td>
		</tr>
		
		<?php
		  
		  while($rowP = $resP->fetch_assoc()){
			  
			  $id_prestamo = $rowP['id_prestamo'];
			  
			  $sqlD = "SELECT SUM(abono) AS ABONO FROM detalleprestamo WHERE id_prestamo = $id_prestamo";
			  $resD = $mysqli->query($sqlD);
			  $rowD = $resD->fetch_assoc();
			  
			  $TOTAL_PAGAR = $rowP['monto_prestado']+$rowP['interes_pagar'];
			  $ABONOS = $rowD['ABONO'];
			  
			  $saldo_restante1 = $TOTAL_PAGAR - $ABONOS;
			  
			  $saldo_restante2 = $rowP['saldo_restante'];
		?>
		
		<tr>
	  	  <td><?php echo $rowP['id_clientes']; //ID ?></td>
	  	
		  <td><?php echo $rowP['id_prestamo']; //ID ?></td>
		  
		  <td>Q <?php echo number_format(($TOTAL_PAGAR),2,".",","); //TOTAL ?></td>
		  
		  <td>Q <?php echo number_format(($ABONOS),2,".",","); //TOTAL ABONOS ?></td>
		  
		  <td style="font-weight: bold;">Q <?php echo number_format(($saldo_restante1),2,".",","); // SANDO RESTANTE ?></td>
		  
		  <td>Q <?php echo number_format(($saldo_restante2),2,".",","); ?></td>
		  
		  <td>
		  	<?php
			  	if(number_format(($saldo_restante1),2,".",",") <> number_format(($saldo_restante2),2,".",",")){
					echo '<font color="RED" style="font-weight: bold;">DIFERENTE</font>';
			?>
					<a href="revisar2.php?saldo_restante_vale=<?php echo $saldo_restante1; ?>&id_prestamo=<?php echo $id_prestamo; ?>">ARREGLAR</a>
			<?php
				}else{
					echo '<font color="GREEN">IGUALES</font>';
				}
			?>
		  </td>
		  
		  <td><a href="clavos.php?cliente=<?php echo $rowP['id_clientes']; //ID ?>&prestamo=<?php echo $rowP['id_prestamo']; //ID ?>" target="_blank">ARREGLAR</a></td>
		</tr>

		<?php
			  
			}
		?>
	  </tbody>
	</table>