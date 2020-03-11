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
		$usuario = base64_decode($_REQUEST['usuario']);
		
		if(!empty($_POST)){
			$sqlUsuario = "DELETE FROM usuarios WHERE id_usuario = $id";
			$resUsuario = $mysqli->query($sqlUsuario);
			
			$sql_b = "DELETE FROM permisos WHERE id_usuario = $id";
			$res_b = $mysqli->query($sql_b);
		
			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA

			$usuario_bitacora 			= $_SESSION['nombre'];
			$id_bitacora_codigo			= "11";
			$id_cliente_bitacora		= "";
			$id_prestamo_bitacora		= "";
			$id_detalle_bitacora		= "";
			$id_ruta_bitacora			= "";
			$id_departamento_bitacora	= "";
			$id_usuario_bitacora		= "";

			$descripcion_bitacora	= "Eliminó al usuario $usuario";

			include('../config/bitacora.php');

			// BITACORA  --  BITACORA  --  BITACORA
			// BITACORA  --  BITACORA  --  BITACORA

			header('Location: lista_usuarios.php');
		}
		
		$title = 'Eliminar usuario';
		
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
				<h4>Desea eliminar al usuario</h4>
			</div>
			<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-md-12 ajustar1">
								<div class="pull-right">
								<input type="text" name="aa" id="aa" hidden="">
									<button type="button" class="btn btn-success" onclick="location.href='eliminar_usuario.php?eliminar=<?php echo $id; ?>'" style="outline: none;">
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