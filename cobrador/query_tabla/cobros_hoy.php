<?php
	if($a == 1){
		$sql_contar = "
			SELECT
				count(*) AS numrows 
			FROM
				prestamos p, clientes c, usuarios u, rutas r, departamento d
			WHERE
				c.id_cliente = p.id_clientes AND
				u.id_usuario = p.cobrador AND
				p.fecha_siguiente = '$fecha1' AND
				p.cobrador = $usuario AND
				r.id_ruta = p.id_ruta AND
				d.id_departamento = r.id_departamento AND
						
				(c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%')";
		
		$sql_query = "
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
				p.cobrador = $usuario AND
				r.id_ruta = p.id_ruta AND
				d.id_departamento = r.id_departamento AND
						
				(c.nombre LIKE '%".$query."%' OR r.nombre LIKE '%".$query."%' OR d.nombre LIKE '%".$query."%' OR u.nombre LIKE '%".$query."%') ORDER BY c.nombre ASC";
	}
	
	if($a == 3){
?>

	<table class="table table-striped table-bordered" cellspacing="0" width="100%" style="background-color: white;">
		<thead>
			<tr class="info">
				<th width="2">#</th>
				<th>Código</th>
				<th>Cliente</th>
				<th width="170">Ruta</th>
				<?php if($e==1){ ?><th width="150">Cobrador</th><?php }else{ /*NADA*/ } ?>
				<th width="110">Prestado</th>
				<th width="110">Interes</th>
				<th width="110">Pago</th>
				<th width="90">Fecha</th>
				<th width="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$prestado1=0;
				$interes1=0;
				$pago1=0;
				$pago=0;
				
				$i = $in;
				$finales = 0;

				while($row = mysqli_fetch_array($res_mostrar_registros)){
					
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
					<td align="center"><?php echo formato($row[1]); //id_cliente ?></td>
					<td>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del cliente" onclick="location.href='perfil_cliente.php?id=<?php print($row['ID_CLIENTE']); ?>'" style="color: black;">
							<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['CLIENTE']); ?>
						</a>
					</td>

					<td><?php echo ruta($row['RUTA']); ?></td>
	
					<?php if($e==1){ ?>
						<td>
							<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php print($row['ID_USUARIO']); ?>'" style="color: black;">
								<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row['USUARIO']); //Cobrador?>
							</a>
						</td>
					<?php }else{ /*NADA*/ } ?>
					
					<td><?php echo moneda($row['MONTO_PRESTADO'], 'Q'); ?></td>
					<td><?php echo moneda($row['INTERES_PAGAR'], 'Q'); ?></td>
					
					<td><?php echo moneda($pago, 'Q'); ?></td>

					<td align="center"><?php echo fecha('d-m-Y', $row['FECHA_SIGUIENTE']); //Fecha siguiente ?></td>

					<td width="120" align="center">
						<div class="btn-group">
							<button type="button" class="btn btn-xs btn-primary" onclick="location.href='detalle_prestamo.php?c=<?php echo $row['ID_CLIENTE']; ?>&id=<?php echo $row['ID_PRESTAMO']; ?>'">
								<i class="glyphicon glyphicon-file"></i> ver ptmo
							</button>
						</div>
					</td>
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
				
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($prestado1, 'Q'); //Monto ?></td>
				
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($interes1, 'Q'); //Monto ?></td>
				
				<td style="border-top: 2px solid red; border-bottom: 3px double red;"><?php echo moneda($pago1, 'Q'); //Monto ?></td>
				
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
<?php		
	}
?>