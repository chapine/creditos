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
		
		$id_user = $_REQUEST['user'];
		$id_ruta = $_REQUEST['ruta'];
		
		$sqlU = "SELECT u.nombre AS COBRADOR FROM usuarios u WHERE id_usuario = $id_user";
		$resU = $mysqli->query($sqlU);
		$rowU = mysqli_fetch_array($resU);
	
		$sqlR = "SELECT r.id_ruta AS ID, concat_ws(', ', r.nombre, d.nombre) AS RUTA FROM rutas r, departamento d WHERE r.id_ruta = $id_ruta AND d.id_departamento = r.id_departamento";
		$resR = $mysqli->query($sqlR);
		$rowR = mysqli_fetch_array($resR);
		
		$sqlC = "SELECT id_usuario, tipo_usuario, nombre FROM usuarios WHERE id_usuario > 0 AND id_usuario <> $id_user";
		$resC = $mysqli->query($sqlC);
	
		if(!empty($_POST)){
			$id_cobrador = mysqli_real_escape_string($mysqli,$_POST['cobradore']);
			
			$sql_clientes = "SELECT id_cliente, cobrador, id_ruta FROM clientes WHERE cobrador = $id_user AND id_ruta = $id_ruta";
			$res_clientes = $mysqli->query($sql_clientes);
			
			while($row_clientes = mysqli_fetch_array($resC)){
				
				$id_cliente = $row_clientes['id_cliente'];
				$cobrador_actual  = $row_clientes['cobrador'];
				$id_ruta_actual  = $row_clientes['id_ruta'];

				$sql_B = "UPDATE detalleprestamo SET id_usuario = '$id_cobrador' WHERE id_clientes = $id_cliente";
				$res_B = $mysqli->query($sql_B);
			}
			
			$sql_C = "UPDATE prestamos SET cobrador = '$id_cobrador' WHERE id_clientes = $id_user AND id_ruta = $id_ruta";
			$res_C = $mysqli->query($sql_C);
			
			$sql_D = "UPDATE clientes SET cobrador = '$id_cobrador' WHERE cobrador = $id_user AND id_ruta = $id_ruta";
			$res_D = $mysqli->query($sql_D);
			
			if($res_C > 0 AND $res_D > 0){
				$resU = $mysqli->query($sqlU);
				$rowU = mysqli_fetch_array($resU);

				$resR = $mysqli->query($sqlR);
				$rowR = mysqli_fetch_array($resR);

				$resC = $mysqli->query($sqlC);

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA

				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "31";
				$id_cliente_bitacora		= "";
				$id_prestamo_bitacora		= "";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "";

				$sqlUU = "SELECT u.nombre AS COBRADOR FROM usuarios u WHERE id_usuario = $id_cobrador";
				$resUU = $mysqli->query($sqlUU);
				$rowUU = mysqli_fetch_array($resUU);
				
				$ruta = $rowR['RUTA'];
				$user_actual = Convertir($rowU['COBRADOR']);
				$user_nuevo = Convertir($rowUU['COBRADOR']);
				
				
				$descripcion_bitacora	= "Se cambió la ruta $ruta del usuario $user_actual al usuario $user_nuevo";

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				header("Location: cambiar_rutas.php?a=1"); $_SESSION["ruta_true"]=1; $_SESSION['mensaje']="Se cambió la ruta $ruta del usuario $user_actual al usuario $user_nuevo";
			}else{
				$alert_bandera = true;
				$alert_titulo ="Error";
				$alert_mensaje ="Error al actualizar el registro";
				$alert_icono ="error";
				$alert_boton = "danger";
			}
		}
			
		$title = 'Editar ruta de cobrador';
		include('head.php');
		$active_cobradores="active";
    ?>
    
    <script>
		function validarNombre()
		{
			valor = document.getElementById("cobradore").value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
				swal({ title: "Necesita llenar el campo nombre", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.nombre.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validar()
		{
			if(validarNombre())
			{
				document.registro.submit();
			}
		}
	</script>
	
	<style>
		.color{ color: #BBBBBB; }
		.color1{ color: #BBBBBB; }
		.marco_1{ border: 1px solid #cccccc; padding: 15px 10px 0 10px; margin-bottom: 15px; border-radius: 4px; }
		.marco_2{ border: 1px solid #cccccc; padding: 0 10px 0 10px; margin-bottom: 15px; border-radius: 4px; }
		.marco_3{ border: 1px solid #cccccc; padding: 0 10px 0 10px; border-radius: 4px; }
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
                    <a href="lista_rutas.php" class="btn btn-success">Cambiar rutas</a>
                    <a class="btn btn-danger">Editar ruta del cobrador</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-plus'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<div class="marco_1">
					<table class="table table-striped" cellspacing="0" width="100%" style="background-color: white; margin-bottom: 10px;">
						<tbody>
							<tr>
								<td align="right" valign="middle" width="150"><b>Cobrador:</b></td>
								<td><span class="glyphicon glyphicon-user color"></span> <?php echo Convertir($rowU['COBRADOR']); ?></td>
							</tr>

							<tr>
								<td align="right"><b>Ruta:</b></td>
								<td><span class="glyphicon glyphicon-road color"></span> <?php echo $rowR['RUTA']; ?></td>
							</tr>

						</tbody>
					</table>
				</div>
				
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
					<table class="table table-bordered" width="100%">
						<tr>
							<td align="right" width="150"><label for="cobradore">Cobradore:</label></td>
							<td>
								<select class="form-control" id="cobradore" name="cobradore">
									<?php while($rowC = mysqli_fetch_array($resC)){  ?>
									<option value="<?php echo $rowC['id_usuario']; ?>"><?php echo $rowC['tipo_usuario'].' - '.convertir($rowC['nombre']); ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" name="registar" onClick="validar(); return confirmar_eliminar_();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='cambiar_rutas.php'" style="outline: none;">
									<span class="glyphicon glyphicon-backward"></span> Regresar
								</button>								
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>