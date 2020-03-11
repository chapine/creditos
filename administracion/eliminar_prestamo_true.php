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
		
		$r = $_REQUEST['id'];
		$a = $_REQUEST['a'];
		$id = $_REQUEST['eliminar'];
		
		$cliente = base64_decode($_REQUEST['cliente']);
		$monto = base64_decode($_REQUEST['monto']);
		$restante = base64_decode($_REQUEST['restante']);
		
		if(!empty($_POST)){
			$sqlDetalle = "DELETE FROM detalleprestamo WHERE id_prestamo = $id";
			$resDetalle = $mysqli->query($sqlDetalle);
			
			$sqlPrestamo = "DELETE FROM prestamos WHERE id_prestamo = $id";
			$resPrestamo = $mysqli->query($sqlPrestamo);
			
			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA

			$usuario_bitacora 			= $_SESSION['nombre'];
			$id_bitacora_codigo			= "23";
			$id_cliente_bitacora		= "$r";
			$id_prestamo_bitacora		= "$id";
			$id_detalle_bitacora		= "";
			$id_ruta_bitacora			= "";
			$id_departamento_bitacora	= "";
			$id_usuario_bitacora		= "";

			$descripcion_bitacora	= "Eliminó el prestamo por la cantidad de ".moneda($monto, '')." con un saldo restante de ".moneda($restante, '')." del cliente $cliente";

			include('../config/bitacora.php');

			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA
			
			$sqlContar = "SELECT count(1) FROM prestamos WHERE id_clientes = $r";
			$resContar = $mysqli->query($sqlContar);
			$rowContar = mysqli_fetch_row($resContar);
			
			if($rowContar[0] == 0){
				$sqlCliente = "UPDATE clientes SET prestamoactivo = '0' WHERE id_cliente = $r";
				$resCliente = $mysqli->query($sqlCliente);
			}

			
			if($a==1){ header("Location: eliminar_usuario.php?eliminar=$r"); $_SESSION["supr"]=1; }
			if($a==2){ header("Location: eliminar_cliente.php?eliminar=$r"); $_SESSION["supr"]=1; }
			if($a==3){ header("Location: lista_prestamos.php?a=1"); $_SESSION["cliente"]=$cliente; }
		}
		
		$title = 'Eliminar prestamo';
		
		include('head.php');
		$active_clientes = "active";
    ?>

    <script>
		function validar()
		{
			document.registro.submit();
		}
	</script>

</head>
<body onload="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main id="page-wrapper6">
        
        <div class="panel panel-danger">
			<div class="panel-heading">
				<h4>Desea eliminar el prestamo de <?php echo Convertir($cliente); ?></h4>
			</div>
			<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-md-12 ajustar1">
								<div class="pull-right">
								<input type="text" name="aa" id="aa" hidden="">
								<?php if($a==1){ ?>
									<button type="button" class="btn btn-success" onclick="location.href='eliminar_usuario.php?eliminar=<?php echo $r; ?>'" style="outline: none;">
										<span class="glyphicon glyphicon-remove"></span> Cancelar
									</button>
								<?php } ?>
								
								<?php if($a==2){ ?>
									<button type="button" class="btn btn-success" onclick="location.href='eliminar_cliente.php?a=2&eliminar=<?php echo $r; ?>'" style="outline: none;">
										<span class="glyphicon glyphicon-remove"></span> Cancelar
									</button>
								<?php } ?>
								
								<?php if($a==3){ ?>
									<button type="button" class="btn btn-success" onclick="location.href='lista_prestamos.php?a=1'" style="outline: none;">
										<span class="glyphicon glyphicon-remove"></span> Cancelar
									</button>
								<?php } ?>
									
									<button type="button" class="btn btn-danger" onClick="validar(); return confirmar_eliminar();" style="outline: none;">
										<span class="glyphicon glyphicon-trash"></span> Eliminar
									</button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</form>
		</div>
    </main>
	
	<?php include("footer.php"); ?>
</body>
</html>