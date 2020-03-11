<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "administracion";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

		$c = $_REQUEST['c'];
		$id = $_REQUEST['id'];
		$detalle = $_REQUEST['detalle'];
		$cantidad = $_REQUEST['cantidad'];
		$mora = $_REQUEST['mora'];
		$estado = $_REQUEST['estado'];
		$prestado = base64_decode($_REQUEST['prestamo']);
		$prestado = moneda($prestado, ',');

		$sqlDetalle = "DELETE FROM detalleprestamo WHERE id_detalle = $detalle";
		$resDetalle = $mysqli->query($sqlDetalle);

		if ( mysqli_affected_rows($mysqli) > 0 ) {
			// Obtenemos el total de abonos
			$sql_sumar = "SELECT SUM(abono) AS ABONO FROM detalleprestamo WHERE id_prestamo = $id";
			$res_sumar = $mysqli->query($sql_sumar);
			$row_sumar = $res_sumar->fetch_assoc();
			$total_abonos = $row_sumar['ABONO'];

			// Nuevo saldo restante
			$nuevo_saldo_restante = ($prestado - $total_abonos);

			if($estado==0){
				// Actualizamos el nuevo saldo_restante y el estado del prestamo
				$sqlP = "UPDATE prestamos SET saldo_restante = $nuevo_saldo_restante, prestamo_activo = 1 WHERE id_prestamo = $id";
				$resP = $mysqli->query($sqlP);

				// Actualizamos el estado del prestamo en detalle de prestamo
				$sqlD = "UPDATE detalleprestamo SET estado = 1 WHERE id_prestamo = $id";
				$resD = $mysqli->query($sqlD);
			}elseif($estado==1){
				// Actualizamos el nuevo saldo_restante y el estado del prestamo
				$sqlP = "UPDATE prestamos SET saldo_restante = $nuevo_saldo_restante WHERE id_prestamo = $id";
				$resP = $mysqli->query($sqlP);
			}
			
			
			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA
			$usuario_bitacora 			= $_SESSION['nombre'];
			$id_bitacora_codigo			= "26";
			$id_cliente_bitacora		= "$c";
			$id_prestamo_bitacora		= "$id";
			$id_detalle_bitacora		= "$detalle";
			$id_ruta_bitacora			= "";
			$id_departamento_bitacora	= "";
			$id_usuario_bitacora		= "";

			$cliente = base64_decode($_REQUEST['cliente']);
			$prestamo = base64_decode($_REQUEST['prestamo']);

			$descripcion_bitacora	= "Eliminó un pago de Q.$cantidad con una mora de Q.$mora del prestamo de Q.$prestamo del cliente $cliente";

			include('../config/bitacora.php');
			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA
			
			$nuevo_saldo_restante = number_format($nuevo_saldo_restante, 2, ".", ",");
			
			// Alerta para confirmar pago
			$_SESSION['alert_titulo'] = "Éxito";
			$_SESSION['alert_mensaje'] = "Se eliminó el pago por la cantidad de Q $cantidad y una mora de Q $mora el nuevo saldo restante es Q $nuevo_saldo_restante";
			$_SESSION['alert_boton'] 	= 'success';
			$_SESSION['alert_icono'] 	= 'success';
			
		}else{
			// Alerta para confirmar pago
			$_SESSION['alert_titulo'] = "Error";
			$_SESSION['alert_mensaje'] = "No se pudo eliminar el pago seleccionado ó actualizo la página antes de terminar el proceso";
			$_SESSION['alert_boton'] 	= 'warning';
			$_SESSION['alert_icono'] 	= 'danger';
			
		}

		$mysqli->close();

		header("Location: detalle_prestamo.php?c=$c&id=$id");
?>