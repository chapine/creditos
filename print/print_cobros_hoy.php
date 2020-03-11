<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
		
		if($_SESSION['tipo_usuario']=='administracion'){ $l_verificar = "administracion"; }
		if($_SESSION['tipo_usuario']=='administrador'){ $l_verificar = "administrador"; }
		if($_SESSION['tipo_usuario']=='asistente'){ $l_verificar = "asistente"; }

		if($_SESSION['tipo_usuario'] <> "$l_verificar"){
			echo"<script language='javascript'>window.location='../index.php'</script>;";
			exit();
		}
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	
		$t = $_REQUEST['t'];
		$fecha1 = $_REQUEST['fecha1'];
		
		$sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador' AND id_usuario = $t";
		$res = $mysqli->query($sql);
		$row1 = mysqli_fetch_row($res);
		
		if($t<>0){
			$sql = "
			SELECT
        		p.id_prestamo 		AS ID_PRESTAMO,
                p.id_clientes		AS ID_CLIENTE,
                p.cobrador			AS ID_USUARIO,
				c.nombre 			AS CLIENTE,
                concat_ws(', ', r.nombre, d.nombre) AS RUTA,
				u.nombre			AS USUARIO,
				p.fecha_siguiente	AS FECHA_SIGUIENTE,
             
             	p.prestamo_activo	AS PRESTAMO_ACTIVO,
                
                p.mensualidades		AS MENSUALIDADES,
                p.cuota				AS CUOTA,
                
                p.monto_prestado	AS MONTO_PRESTADO,
                p.interes_pagar		AS INTERES_PAGAR
                
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			WHERE
				c.id_cliente = p.id_clientes AND
				u.id_usuario = p.cobrador AND
				p.fecha_siguiente = '$fecha1' AND
				p.cobrador = $t AND
				r.id_ruta = p.id_ruta AND
				d.id_departamento = r.id_departamento ORDER BY c.nombre ASC
		";
			
			$res = $mysqli->query($sql);
			
			
			$titulo = 'Todos los cobros realizados entre la fecha '.fecha('d-m-Y', $fecha1).' a la '.fecha('d-m-Y', $fecha2).' del cobrador '.Convertir($row1[4]);
		}
		elseif($t==0){
			$sql = "
				SELECT
        		p.id_prestamo 		AS ID_PRESTAMO,
                p.id_clientes		AS ID_CLIENTE,
                p.cobrador			AS ID_USUARIO,
				c.nombre 			AS CLIENTE,
                concat_ws(', ', r.nombre, d.nombre) AS RUTA,
				u.nombre			AS USUARIO,
				p.fecha_siguiente	AS FECHA_SIGUIENTE,
             
             	p.prestamo_activo	AS PRESTAMO_ACTIVO,
                
                p.mensualidades		AS MENSUALIDADES,
                p.cuota				AS CUOTA,
                
                p.monto_prestado	AS MONTO_PRESTADO,
                p.interes_pagar		AS INTERES_PAGAR
                
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			WHERE
				c.id_cliente = p.id_clientes AND
				u.id_usuario = p.cobrador AND
				p.fecha_siguiente = '$fecha1' AND
				r.id_ruta = p.id_ruta AND
				d.id_departamento = r.id_departamento ORDER BY c.nombre ASC
			";
			
			$res = $mysqli->query($sql);
			
			$titulo = 'Cobros para hoy "'.fecha('d-m-Y', $fecha1).'" de todos los cobradores';
		}
    ?>
	<style>
		table, tr, th, td{
			font-size: 10px;
			border: 1px solid #BDBDBD;
			font-family: tahoma;
		}
		
		th{
			font-weight: bold;
		}
	</style>
</head>
<body>
	<center style="font-size: 16px; font-weight: bold;"><?php echo $titulo; ?><br><br></center>
	<table class="table table-striped table-bordered" cellspacing="0" width="100%" style="background-color: white;">
		<thead>
			<tr class="info">
				<th width="2">#</th>
				<th>Código</th>
				<th width="30%">Cliente</th>
				<th width="170">Ruta</th>
				<?php if($e==1){ ?><th width="150">Cobrador</th><?php }else{ /*NADA*/ } ?>
				<th width="110">Prestado</th>
				<th width="110">Interes</th>
				<th width="110">Pago</th>
				<th width="90">Fecha</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$prestado1=0;
				$interes1=0;
				$pago1=0;
				$pago=0;
				$i=1;

				while($row = mysqli_fetch_array($res)){
					
					if($row['MENSUALIDADES']==1){	$diario = 1;} // DIARIO
					if($row['MENSUALIDADES']==2){	$diario = 2;} // SEMANAL
					if($row['MENSUALIDADES']==3){	$diario = 3;} // QUINCENAL
					if($row['MENSUALIDADES']==4){	$diario = 4;} // MENSUAL

					if($row['CUOTA']==23){			$mes	= 1;} // 1 MES
					if($row['CUOTA']==46){			$mes	= 2;} // 2 MESES
					if($row['CUOTA']==69){			$mes	= 3;} // 3 MESES
					if($row['CUOTA']==92){			$mes	= 4;} // 4 MESES
					if($row['CUOTA']==138){			$mes	= 6;} // 6 MESES

					$monto_prestado = ($row['MONTO_PRESTADO']+$row['INTERES_PAGAR']);

					$monto_p = $row['MONTO_PRESTADO'];
					$interes_p = $row['INTERES_PAGAR'];
					
					// PAGA DIARIO
					if($diario == 1 && $mes	== 1){ $pago = ($monto_prestado/23);  }
					if($diario == 1 && $mes == 2){ $pago = ($monto_prestado/46);  }
					if($diario == 1 && $mes == 3){ $pago = ($monto_prestado/69);  }
					if($diario == 1 && $mes	== 4){ $pago = ($monto_prestado/92);  }
					if($diario == 1 && $mes == 6){ $pago = ($monto_prestado/138); }

					// PAGA SEMANAL
					if($diario == 2 && $mes	== 1){ $pago = ($monto_prestado/5);   }
					if($diario == 2 && $mes == 2){ $pago = ($monto_prestado/10);  }
					if($diario == 2 && $mes == 3){ $pago = ($monto_prestado/15);  }
					if($diario == 2 && $mes	== 4){ $pago = ($monto_prestado/20);  }
					if($diario == 2 && $mes == 6){ $pago = ($monto_prestado/30);  }

					// PAGA QUINCENAL
					if($diario == 3 && $mes	== 1){ $pago = ($monto_prestado/2);   }
					if($diario == 3 && $mes == 2){ $pago = ($monto_prestado/4);   }
					if($diario == 3 && $mes == 3){ $pago = ($monto_prestado/6);   }
					if($diario == 3 && $mes	== 4){ $pago = ($monto_prestado/8);   }
					if($diario == 3 && $mes == 6){ $pago = ($monto_prestado/12);  }

					// PAGA QUINCENAL
					if($diario == 4 && $mes	== 1){ $pago = ($monto_prestado/1);   }
					if($diario == 4 && $mes == 2){ $pago = ($monto_prestado/2);   }
					if($diario == 4 && $mes == 3){ $pago = ($monto_prestado/3);   }
					if($diario == 4 && $mes	== 4){ $pago = ($monto_prestado/4);   }
					if($diario == 4 && $mes == 6){ $pago = ($monto_prestado/6);   }	
						
			?>
				<tr>
					<td align="center" style="color: darkgrey; font-weight: bold;"><?php echo $i; ?></td>
					<td align="center"><b><?php echo formato($row[1]); //id_cliente?></b></td>
					<td><?php echo Convertir($row['CLIENTE']); //Cliente?></td>
					<td><?php echo ruta($row['RUTA']); ?></td>
	
					<?php if($e==1){ ?>
						<td><?php echo Convertir($row['USUARIO']); //Cobrador?></td>
					<?php }else{ /*NADA*/ } ?>
					
					<td><?php echo moneda($row['MONTO_PRESTADO'], 'Q'); ?></td>
					<td><?php echo moneda($row['INTERES_PAGAR'], 'Q'); ?></td>
					
					<td><?php echo moneda($pago, 'Q'); ?></td>

					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_SIGUIENTE']); //Fecha siguiente ?></td>
				</tr>
			<?php $i++; $finales++; $prestado1=$prestado1+$monto_p; $interes1=$interes1+$interes_p; $pago1=$pago1+$pago; } ?>
		</tbody>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<?php if($e==1){ ?><td></td><?php }else{ /*NADA*/ } ?>
				<td align="right"><b>Totales:</b></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($prestado1, 'Q'); ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($interes1, 'Q'); ?></td>
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($pago1, 'Q'); ?></td>
				
				<td></td>
			</tr>
		</tbody>
	</table>
</body>
</html>