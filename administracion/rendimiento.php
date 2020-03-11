<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');

		$l_verificar = "administracion";
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	
		// OBTIENE DATOS PARA EL FORMULARIO	
		$id = $_REQUEST['u']; // OBTIENE EL ID

		$sql1 = "SELECT * FROM usuarios WHERE id_usuario = ".$id;
		$res1 = $mysqli->query($sql1);
		$row1 = $res1->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO

		$bandera = false;
			
		$title = 'Datos';		
		include('head.php');
		$active_cobros = "active";
    ?>

</head>
<body onload="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">

        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <a href="seleccione_cobrador.php?a=3" class="btn btn-success">Cobrador</a>
                    <a class="btn btn-danger">Pefil del usuario</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<a href="seleccione_cobrador.php?a=3" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar</a>
				</div>
				<h4><i class='glyphicon glyphicon-user'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">			
				<div style="padding: 10px;">
					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Nombre:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<?php echo Convertir($row1['nombre']); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-6 col-md-3 ajustar1">
							<b>Usuario:</b>
						</div>
						<div class="col col-md-9 ajustar4">
							<div class="has-feedback">
								<?php echo $row1['usuario']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    
    	<div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-stats'></i> Estadística</h4>
			</div>	

			<div class="panel-body">
				<div style="padding: 10px;">
				
					<?php
						$sql2 = "SELECT count(cobrador) as cobrador FROM prestamos WHERE cobrador = $id";
						$res2 = $mysqli->query($sql2);
						$row2 = $res2->fetch_assoc();
			
						$sql3 = "SELECT interes_pagar, fecha_inicial FROM prestamos WHERE cobrador = $id";
						$res3 = $mysqli->query($sql3);
						//$row3 = $res3->fetch_assoc();
			
						$sql4 = "SELECT sum(interes_pagar) as interes FROM prestamos WHERE cobrador = $id";
						$res4 = $mysqli->query($sql4);
						$row4 = $res4->fetch_assoc();
			
						$sql5 = "SELECT count(prestamo_activo) as activos FROM prestamos WHERE prestamo_activo = 1 AND cobrador = $id";
						$res5 = $mysqli->query($sql5);
						$row5 = $res5->fetch_assoc();
			
						$sql6 = "SELECT count(prestamo_activo) as finalizados FROM prestamos WHERE prestamo_activo = 0 AND cobrador = $id";
						$res6 = $mysqli->query($sql6);
						$row6 = $res6->fetch_assoc();
			
						$sql7 = "SELECT count(cobrador) as cobrador FROM clientes WHERE ocultar = 0 AND cobrador = $id";
						$res7 = $mysqli->query($sql7);
						$row7 = $res7->fetch_assoc();
			
						// TOTAL PRESTAMOS FINALIZADOS
						$sql8 = "SELECT sum(monto_prestado+interes_pagar) as monto_prestado_finalizado FROM prestamos WHERE prestamo_activo = 0 AND cobrador = $id";
						$res8 = $mysqli->query($sql8);
						$row8 = $res8->fetch_assoc();
			
						// TOTAL PRESTAMOS ACTIVOS
						$sql9 = "SELECT sum(monto_prestado+interes_pagar) as monto_prestado_activo FROM prestamos WHERE prestamo_activo = 1 AND cobrador = $id";
						$res9 = $mysqli->query($sql9);
						$row9 = $res9->fetch_assoc();
			
						// TOTAL COBROS FINALIZADOS
						$sql10 = "SELECT sum(total) as monto_cobrado_finalizado FROM detalleprestamo WHERE estado = 0 AND id_usuario = $id";
						$res10 = $mysqli->query($sql10);
						$row10 = $res10->fetch_assoc();
			
						// TOTAL COBROS ACTIVOS
						$sql11 = "SELECT sum(total) as monto_cobrado_activo FROM detalleprestamo WHERE estado = 1 AND id_usuario = $id";
						$res11 = $mysqli->query($sql11);
						$row11 = $res11->fetch_assoc();
			
						// TOTAL DE INTERESES
						$sql12 = "SELECT sum(interes_pagar) as intereses FROM prestamos WHERE cobrador = $id";
						$res12 = $mysqli->query($sql12);
						$row12 = $res12->fetch_assoc();
			
						// TOTAL DE MORA
						$sql13 = "SELECT sum(mora) as mora FROM detalleprestamo WHERE id_usuario = $id";
						$res13 = $mysqli->query($sql13);
						$row13 = $res13->fetch_assoc();
			
						// PRESTAMOS ACTIVOS TOTAL
						$sql14 = "SELECT sum(monto_prestado) as monto_prestado FROM prestamos WHERE prestamo_activo = 1 AND cobrador = $id";
						$res14 = $mysqli->query($sql14);
						$row14 = $res14->fetch_assoc();
			
			
						// TOTAL PRESTAMOS SIN INTERES FINALIZADOS
						$sql15 = "SELECT sum(monto_prestado) as monto_prestado_finalizado FROM prestamos WHERE prestamo_activo = 0 AND cobrador = $id";
						$res15 = $mysqli->query($sql15);
						$row15 = $res15->fetch_assoc();
			
						// TOTAL PRESTAMOS SIN INTERES ACTIVOS
						$sql16 = "SELECT sum(monto_prestado) as monto_prestado_activo FROM prestamos WHERE prestamo_activo = 1 AND cobrador = $id";
						$res16 = $mysqli->query($sql16);
						$row16 = $res16->fetch_assoc();
					?>
					
					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="30%" align="right"><b>Clientes asigandos</b></td>
										<td width="70%"><?php echo $row7['cobrador']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="30%" align="right"><b>Créditos finalizados (+)</b></td>
										<td width="70%"><?php echo $row6['finalizados']; ?></td>
									</tr>
									<tr>
										<td align="right"><b>Créditos activos (+)</b></td>
										<td style="border-bottom: 1px solid #9C0002;"><?php echo $row5['activos']; ?></td>
									</tr>
									<tr>
										<td align="right" ><b>Total de créditos (=)</b></td>
										<td style="border-bottom: 2px solid #9C0002;"><?php echo $row2['cobrador']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="30%" align="right"><b>Porcentaje de avance de (ptmo. + interes) activos</b></td>
										<td width="70%"> 
											<?php
												$avance = (($row11['monto_cobrado_activo']/$row9['monto_prestado_activo'])*100);
												echo number_format($avance, 0, ".", ",");
											?>
											%
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="30%" align="right"><b>Monto (prestado sin interes) finalizado (+)</b></td>
										<td width="70%"><?php echo moneda($row15['monto_prestado_finalizado'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Monto (prestamos sin interes) activo (+)</b></td>
										<td style="border-bottom: 1px solid #9C0002;"><?php echo moneda($row16['monto_prestado_activo'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Total prestado (=)</b></td>
										<td style="border-bottom: 2px solid #9C0002;"><?php echo moneda(($row15['monto_prestado_finalizado']+$row16['monto_prestado_activo']), 'Q'); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="30%" align="right"><b>Monto (prestado + interes) finalizado (+)</b></td>
										<td width="70%">Q <?php echo moneda($row8['monto_prestado_finalizado'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Monto (prestado + interes) activo (+)</b></td>
										<td style="border-bottom: 1px solid #9C0002;"><?php echo moneda($row9['monto_prestado_activo'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Total prestado (=)</b></td>
										<td style="border-bottom: 2px solid #9C0002;"><?php echo moneda(($row8['monto_prestado_finalizado']+$row9['monto_prestado_activo']), 'Q'); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="<strong>30%</strong>" align="right"><b>Monto cobrado finalizado (+)</b></td>
										<td width="70%"><?php echo moneda($row10['monto_cobrado_finalizado'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Monto cobrado activo (+)</b></td>
										<td style="border-bottom: 1px solid #9C0002;"><?php echo moneda($row11['monto_cobrado_activo'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Total cobrado (=)</b></td>
										<td style="border-bottom: 2px solid #9C0002;"><?php echo moneda(($row10['monto_cobrado_finalizado']+$row11['monto_cobrado_activo']), 'Q'); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="col col-md-12 ajustar5">
							<table class="table table-striped table-bordered" width="100%" style="margin-bottom: 0px;">
								<tbody>
									<tr>
										<td width="30%" align="right"><b>Total de intereses</b></td>
										<td width="70%">Q <?php echo moneda($row12['intereses'], 'Q'); ?></td>
									</tr>
									<tr>
										<td align="right"><b>Total de Mora</b></td>
										<td>Q <?php echo moneda($row13['mora'], 'Q'); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
    	</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>