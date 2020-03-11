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
		
		$id = $_REQUEST['id'];
		
		$sqlR = "SELECT r.id_ruta, r.nombre AS RUTA, d.nombre as DEPTO, r.id_departamento FROM rutas r, departamento d WHERE d.id_departamento = r.id_departamento AND id_ruta = $id";
		$resR = $mysqli->query($sqlR);
		$rowR = mysqli_fetch_row($resR);
		
		$sqlD = "SELECT * FROM departamento";
		$resD = $mysqli->query($sqlD);

		if(!empty($_POST)){
			$nombre = mysqli_real_escape_string($mysqli,$_POST['nombre']);
			$departamento = mysqli_real_escape_string($mysqli,$_POST['departamento']);

			$sqlRuta = "UPDATE rutas SET nombre = '$nombre', id_departamento = '$departamento' WHERE id_ruta = '$id'";
			$resRuta = $mysqli->query($sqlRuta);
			
			$resR = $mysqli->query($sqlR);
			$rowR = mysqli_fetch_row($resR);
			
			$resD = $mysqli->query($sqlD);
			
			$sqlDE = "SELECT * FROM departamento WHERE id_departamento = $departamento";
			$resDE = $mysqli->query($sqlDE);
			$rowDE = mysqli_fetch_row($resDE);

			if($resRuta>0){
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "14";
				$id_cliente_bitacora		= "";
				$id_prestamo_bitacora		= "";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "$id";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "";

				$descripcion_bitacora	= "Modificó la ruta $nombre, ".$rowDE[1];

				include('../config/bitacora.php');

				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				// MENSAJE SI EL REGISTRO ES INGRESADO
				$alert_bandera 	= true;
				$alert_titulo 	= "Exito";
				$alert_mensaje 	= "Ruta actualizada correctamente";
				$alert_icono 	= "success";
				$alert_boton 	= "success";
				
			}else{
				// MENSAJE DE ERROR SI EL REGISTRO NO SE INGRESA
				$alert_bandera 	= true;
				$alert_titulo 	= "Error";
				$alert_mensaje 	= "Error al actualizar la ruta";
				$alert_icono 	= "error";
				$alert_boton 	= "danger";
			}
		}
			
		$title = 'Editar ruta';
		include('head.php');
		$active_rutas="active";
    ?>
    
    <script>
		function validarNombre()
		{
			valor = document.getElementById("nombre").value;
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
                    <a href="lista_rutas.php" class="btn btn-success">Lista de rutas</a>
                    <a class="btn btn-danger">Editar ruta</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-plus'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']."?a=b"; ?>" method="POST" >
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="30%" align="right"><label for="nombre">Nombre:</label></td>
							<td>
								<div class="has-success has-feedback">
									<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $rowR[1]; ?>">
									<span class="glyphicon glyphicon-italic form-control-feedback"></span>
								</div>
							</td>
						</tr>

						<tr>
							<td align="right"><label for="departamento">Departamento:</label></td>
							<td>
								<div class="has-success has-feedback">
									<select class="form-control" id="departamento" name="departamento">
										<option value="<?php echo $rowR[3]; ?>"><?php echo $rowR[2]; ?></option>
										<option disabled>------------------------------------</option>
										<?php $i=1; while($rowD = mysqli_fetch_row($resD)){  ?>
										<option value="<?php echo $rowD[0]; ?>"><?php echo $rowD[1]; ?></option>
										<?php } ?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
								</button>

								<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_rutas.php'" style="outline: none;">
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