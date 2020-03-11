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
		
		if(!empty($_POST))
		{
			$sqlDetalle = "DELETE FROM detalleprestamo WHERE id_prestamo = $id";
			$resDetalle = $mysqli->query($sqlDetalle);
			
			$sqlPrestamo = "DELETE FROM prestamos WHERE id_prestamo = $id";
			$resPrestamo = $mysqli->query($sqlPrestamo);
			
			if($a==1){
				header('Location: eliminar_usuario.php?supr=1&eliminar='.$r);
			}
		}
		
		$title = 'Eliminar prestamo';
		
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
				<h4>Desea eliminar el prestamo</h4>
			</div>
			<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="panel-body" style="margin: 0 15px 0 15px;">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-md-12 ajustar1">
								<div class="pull-right">
								<input type="text" name="aa" id="aa" hidden="">
									<button type="button" class="btn btn-success" onclick="location.href='eliminar_usuario.php?eliminar=<?php echo $r; ?>'" style="outline: none;">
										<span class="glyphicon glyphicon-remove"></span> Cancelar
									</button>
									
									<button type="button" class="btn btn-danger" onClick="validar();" style="outline: none;">
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
  </div>
</body>
</html>