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
		
		$sqlC = "SELECT * FROM clientes WHERE id_cliente = $id";
		$resC = $mysqli->query($sqlC);
		$rowC = $resC->fetch_assoc();

		$sqlContar2 = "SELECT count(1) FROM prestamos WHERE id_clientes = $id";
		$resContar2 = $mysqli->query($sqlContar2);
		$rowContar2 = mysqli_fetch_row($resContar2);
		
		$title = 'Eliminar cliente';
		include('head.php');
		$active_clientes = "active";
    ?>
    
    <script>
		function confirmar(a, b, c, d, e)
		{
			if (a == 'prestamo')
			{
				location.href = "eliminar_prestamo_true.php?a=2&eliminar="+b+"&id=<?php echo $id; ?>&cliente="+c+"&monto="+d+"&restante="+e;
			}
			
			if (a == 'cliente')
			{
				location.href = "eliminar_cliente_true.php?a=2&eliminar="+b+"&id=<?php echo $id; ?>";
			}
			
			if (a == 'todo')
			{
				location.href = "eliminar_todo_prestamo.php?a=2&eliminar="+b+"&cliente="+c;
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
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    <a href="#" class="btn btn-warning">Eliminar cliente</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<?php if($rowContar2[0] == 0){ //COMPROBAR SI NO TIENE PRESTAMOS ?>
					<div class="btn-group pull-right">
						<a href="eliminar_cliente_true.php?eliminar=<?php echo $id; ?>&a=2&cliente=<?php echo base64_encode($rowC['nombre']); ?>" class="btn btn-danger"><i class="glyphicon glyphicon-plus"></i> &nbsp; Eliminar cliente</a>
					</div>
				<?php } ?>
				<h4><i class='glyphicon glyphicon-user'></i> Cliente a eliminar</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<div style="padding: 10px;">
					<div class="row">
						<div class="col-md-1 ajustar1">
							<b>Nombre:</b>
						</div>
						<div class="col-md-11 ajustar4">
							<?php echo Convertir($rowC['nombre']); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
       
       <div class="panel panel-success">
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				Nota: antes de eliminar al cliente tiene que eliminar sus prestamos.
			</div>
		</div>

        <?php if($rowContar2[0] == 0){ //COMPROBAR SI NO TIENE PRESTAMOS ?>
		
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4><i class='glyphicon glyphicon-list-alt'></i> Lista prestamos.</h4>
				</div>
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					No se encontrarón registros
				</div>
			</div>
		
		<?php }else{ ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="btn-group pull-right">
						<a href="#" onclick="return confirmar('todo', '<?php echo $id; ?>', '<?php echo base64_encode($rowC['nombre']); ?>');" class="btn btn-danger"><i class="glyphicon glyphicon-plus"></i> &nbsp; Eliminar todo</a>
					</div>
					<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de prestamos.</h4>
				</div>
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<?php
						$sqlP = "SELECT * FROM prestamos WHERE id_clientes = $id";
						$resP = $mysqli->query($sqlP);

						$sqlContar = "SELECT count(1) FROM prestamos WHERE id_clientes = $id";
						$resContar = $mysqli->query($sqlContar);
						$rowContar = mysqli_fetch_row($resContar);
					?>
					<table class="table table-striped table-bordered" cellspacing="0" width="100%">
						<tbody>
							<?php $i=1; while($rowP = $resP->fetch_assoc()){ ?>
								<tr>
									<td class="oscuro" width="2%"><?php echo $i; ?></td>
									<td class="oscuro" width="93%">
										<?php echo '<b>Monto prestado:</b> '.moneda(($rowP['monto_prestado']+$rowP['interespagar']), 'Q').' <b>Saldo restante</b> '.moneda(($rowP['saldo_restante']), 'Q');?>
									</td>
									<td width="5%" align="center">
										<button type="button" class="btn btn-xs btn-danger command-delete" onclick="return confirmar('prestamo', '<?php echo $rowP['id_prestamo']; ?>', '<?php echo base64_encode($rowC['nombre']); ?>', '<?php echo base64_encode(number_format(($rowP['monto_prestado']+$rowP['interespagar']),2,".",",")); ?>', '<?php echo base64_encode(number_format(($rowP['saldo_restante']),2,".",",")); ?>');"><i class="glyphicon glyphicon-trash"></i> Eliminar prestamo</button>
									</td>
								</tr>
							<?php $i++; } ?>
						</tbody>
					</table>
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
			$alert_mensaje 	= "Se han eliminado todos prestamos del cliente";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["supr"]); // Vaciar variable
		}
	?>
   
    <?php include("footer.php"); ?>
</body>
</html>