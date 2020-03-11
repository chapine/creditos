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
		
		$id = $_REQUEST['eliminar'];
		$supr = $_REQUEST['supr'];
		
		$sqlU = "SELECT * FROM usuarios WHERE id_usuario = $id";
		$resU = $mysqli->query($sqlU);
		//$rowU = mysqli_fetch_row($resU);
		$rowU = $resU->fetch_assoc();
		
		$sqlC = "SELECT * FROM clientes WHERE cobrador = $id";
		$resC = $mysqli->query($sqlC);
		
		$title = 'Eliminar usuarios';
		
		
		$sqlContar1 = "SELECT count(1) FROM clientes WHERE cobrador = $id";
		$resContar1 = $mysqli->query($sqlContar1);
		$rowContar1 = mysqli_fetch_row($resContar1);

		$sqlContar2 = "SELECT count(1) FROM prestamos WHERE cobrador = $id";
		$resContar2 = $mysqli->query($sqlContar2);
		$rowContar2 = mysqli_fetch_row($resContar2);
		
		
		include('head.php');
		$active_usuarios = "active";
    ?>
    
    <script>
		function confirmar(a, b, c, d, e)
		{
			if (a == 'prestamo')
			{
				location.href = "eliminar_prestamo_true.php?a=1&eliminar="+b+"&id=<?php echo $id; ?>&cliente="+c+"&monto="+d+"&restante="+e;
			}
			
			if (a == 'cliente')
			{
				location.href = "eliminar_cliente_true.php?a=1&eliminar="+b+"&id=<?php echo $id; ?>&cliente="+c;
			}
			
			if (a == 'todo')
			{
				location.href = "eliminar_todo_usuario.php?a=1&eliminar="+b+"&usuario="+c;
			}
		}
	</script>
	
	<style>
		.oscuro{
			color: #7A7A7A;
		}
	</style>

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
                    <a href="lista_usuarios.php" class="btn btn-success">Usuarios</a>
                    <a href="#" class="btn btn-warning">Eliminar usuario</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<?php if($rowContar1[0] == 0 AND $rowContar2[0] == 0){ //COMPROBAR SI NO TIENE CLIENTES O PRESTAMOS ?>
					<div class="btn-group pull-right">
						<a href="eliminar_usuario_true.php?eliminar=<?php echo $id; ?>&usuario=<?php echo base64_encode($rowU['nombre']); ?>" class="btn btn-danger"><i class="glyphicon glyphicon-plus"></i> &nbsp; Eliminar usuario</a>
					</div>
				<?php } ?>
				<h4><i class='glyphicon glyphicon-user'></i> Usuario a eliminar</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<div style="padding: 10px;">
					<div class="row">
						<div class="col-md-1 ajustar1">
							<b>Nombre:</b>
						</div>
						<div class="col-md-11 ajustar4">
							<?php echo Convertir($rowU['nombre']); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1 ajustar1">
							<b>Usuario:</b>
						</div>
						<div class="col-md-11 ajustar4">
							<div class="has-feedback">
								<?php echo $rowU['usuario']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
       
       <div class="panel panel-success">
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				Nota: antes de eliminar el usuario, tienes que eliminar sus prestamos y clientes.
			</div>
		</div>
       
        <?php if($rowContar1[0] == 0 AND $rowContar2[0] == 0){ //COMPROBAR SI NO TIENE CLIENTES O PRESTAMOS ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de clientes y prestamos.</h4>
				</div>
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					No se encontrarón registros
				</div>
			</div>
		<?php }else{ ?>
        
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="btn-group pull-right">
						<a href="#" onclick="return confirmar('todo', '<?php echo $id; ?>', '<?php echo base64_encode($rowU['usuario']); ?>');" class="btn btn-danger"><i class="glyphicon glyphicon-plus"></i> &nbsp; Eliminar todo</a>
					</div>
					<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de clientes y prestamos asignados.</h4>
				</div>
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<?php 
						$i=1;
							while($rowC = $resC->fetch_assoc()){ 

								$id_cliente = $rowC['id_cliente'];

								$sqlContar = "SELECT count(1) FROM prestamos WHERE id_clientes = $id_cliente";
								$resContar = $mysqli->query($sqlContar);
								$rowContar = mysqli_fetch_row($resContar);
					?>
						<table class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr class="info">
									<th><?php echo $i; ?></th>
									<th><?php echo $rowC['id_cliente'].' - '.$rowC['nombre'];?></th>
									<th style="color: #d9edf7;"><i class="glyphicon glyphicon-trash"></i></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$sqlP = "SELECT * FROM prestamos WHERE id_clientes = $id_cliente";
									$resP = $mysqli->query($sqlP);

									if($rowContar[0] > 0){

										while($rowP = $resP->fetch_assoc()){
								?>
											<tr>
												<td class="oscuro" width="2%">L</td>
												<td class="oscuro" width="93%"><?php echo '<b>Monto prestado: </b>'.moneda(($rowP['monto_prestado']+$rowP['interespagar']), 'Q').' <b>Saldo restante </b>'.moneda(($rowP['saldo_restante']), 'Q');?></td>
												<td width="5%" align="center">
													<button type="button" class="btn btn-xs btn-danger command-delete" onclick="return confirmar('prestamo', '<?php echo $rowP['id_prestamo']; ?>', '<?php echo base64_encode($rowC['nombre']); ?>', '<?php echo base64_encode(number_format(($rowP['monto_prestado']+$rowP['interespagar']),2,".",",")); ?>', '<?php echo base64_encode(number_format(($rowP['saldo_restante']),2,".",",")); ?>');"><i class="glyphicon glyphicon-trash"></i> Eliminar prestamo</button>
												</td>
											</tr>
								<?php
										}
									}else{
								?>
									<tr>
										<td class="oscuro" width="2%">L</td>
										<td class="oscuro" width="96%">
											<button type="button" class="btn btn-xs btn-danger command-delete" onclick="return confirmar('cliente', '<?php echo $rowC['id_cliente'];?>', '<?php echo base64_encode($rowC['nombre']);?>');"><i class="glyphicon glyphicon-trash"></i> Eliminar cliente</button>
										</td>
										<td width="2%" align="center"></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php $i++;} ?>
				</div>
			</div>
		<?php } ?>
    </main>
   
    <?php
		if($_SESSION["supr"]==1){
			$alert_bandera 	= true;
			$alert_titulo 	= "Exito";
			$alert_mensaje 	= "Prestamo eliminado correctamente";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["supr"]); // Vaciar variable

		}elseif($_SESSION["supr"]==2){
			$alert_bandera 	= true;
			$alert_titulo 	= "Exito";
			$alert_mensaje 	= "Cliente eliminado correctamente";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["supr"]); // Vaciar variable
			
		}elseif($_SESSION["supr"]==3){
			$alert_bandera 	= true;
			$alert_titulo 	= "Exito";
			$alert_mensaje 	= "Se ha eliminado clientes y prestamos asignados al usuario";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["supr"]); // Vaciar variable
		}
	?>
   
    <?php include("footer.php"); ?>
</body>
</html>