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
		

		$a = $_REQUEST['a'];
		$id = $_REQUEST['eliminar'];
		$cliente = base64_decode($_REQUEST['cliente']);
		
		if($a==1){ $r = $_REQUEST['id']; $link = "eliminar_usuario.php?eliminar=$r"; }
		if($a==2){ $r = $_REQUEST['eliminar']; $link = "eliminar_cliente.php?a=2&eliminar=$r"; }
	
		if(!empty($_POST)){
			$sqlCliente = "DELETE FROM clientes WHERE id_cliente = $id";
			$resCliente = $mysqli->query($sqlCliente);
			
			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA

			$usuario_bitacora 			= $_SESSION['nombre'];
			$id_bitacora_codigo			= "5";
			
			$id_cliente_bitacora		= "";
			$id_prestamo_bitacora		= "";
			$id_detalle_bitacora		= "";
			$id_ruta_bitacora			= "";
			$id_departamento_bitacora	= "";
			$id_usuario_bitacora		= "";

			$descripcion_bitacora	= "Eliminó al cliente $cliente";

			include('../config/bitacora.php');

			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA
			
			if($a==1){ header("Location: eliminar_usuario.php?eliminar=$r"); $_SESSION["supr"]=2; }
			if($a==2){ header("Location: lista_clientes.php?numero=1"); $_SESSION["cliente"]=$cliente; }
		}
		
		$title = 'Eliminar el cliente';
		
		include('head.php');
		$active_usuarios = "active";
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
				<h4>Desea eliminar al cliente</h4>
			</div>
			<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-md-12 ajustar1">
								<div class="pull-right">
								<input type="text" name="aa" id="aa" hidden="">
									<button type="button" class="btn btn-success" onclick="location.href='<?php echo $link; ?>'" style="outline: none;">
										<span class="glyphicon glyphicon-remove"></span> Cancelar
									</button>
									
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