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
		$id = $_REQUEST['id']; // OBTIENE EL ID A EDITAR

		$sql = "SELECT * FROM clientes WHERE id_cliente = $id";
		$res = $mysqli->query($sql);
		$row1 = $res->fetch_assoc();
		// OBTIENE DATOS PARA EL FORMULARIO
	
		if(!empty($_POST)){
			$id_cobrador = mysqli_real_escape_string($mysqli,$_POST['id_cobrador']);
			
			$sqlCambiarCobrador = "UPDATE clientes SET cobrador = $id_cobrador WHERE id_cliente = $id;";
			$resCambiarCobrador = $mysqli->query($sqlCambiarCobrador);
			
			$sql_A = "UPDATE prestamos SET cobrador = '$id_cobrador' WHERE id_clientes = '$id'";
			$res_A = $mysqli->query($sql_A);

			$sql_B = "UPDATE detalleprestamo SET id_usuario = '$id_cobrador' WHERE id_clientes = '$id'";
			$res_B = $mysqli->query($sql_B);

			if($resCambiarCobrador > 0 AND $res_A > 0 AND $res_B > 0){
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				$usuario_bitacora 			= $_SESSION['nombre'];
				$id_bitacora_codigo			= "7";
				$id_cliente_bitacora		= "$id";
				$id_prestamo_bitacora		= "";
				$id_detalle_bitacora		= "";
				$id_ruta_bitacora			= "";
				$id_departamento_bitacora	= "";
				$id_usuario_bitacora		= "";
				
				$descripcion_bitacora	= "Asigno el $cobrador al cliente ".$row1['nombre'];

				include('../config/bitacora.php');
				// BITACORA  --  BITACORA  --  BITACORA
				// BITACORA  --  BITACORA  --  BITACORA
				
				// MENSAJE SI EL REGISTRO ES INGRESADO
				$alert_bandera 	= true;
				$alert_titulo 	= "Exito";
				$alert_mensaje 	= "Se actualizó el cobrador";
				$alert_icono 	= "success";
				$alert_boton 	= "success";
			}else{
				$alert_bandera = true;
				$alert_titulo ="Error";
				$alert_mensaje ="Error al actualizar el registro";
				$alert_icono ="error";
				$alert_boton = "danger";
			}
			
			$sql = "SELECT * FROM clientes WHERE id_cliente = $id";
			$res = $mysqli->query($sql);
			$row1 = $res->fetch_assoc();
		}
	

		$title = 'Asignar cobrador';		
		include('head.php');
		$active_clientes="active";
    ?>
    
	<script>
		function cobrador()
		{
			indice = document.getElementById("id_cobrador").selectedIndex;
			if( indice == null || indice==0 ) {
				swal({ title: "Seleccione un cobrador", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(), registro.tipo_usuario.focus(); }
					}
				);
				return false;
			} else { return true;}
		}

		function validar()
		{
			if(cobrador())
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
                    <a href="lista_clientes.php?numero=1" class="btn btn-success">Clientes</a>
                    <a class="btn btn-danger">Asignar cobrador</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-briefcase'></i> <?php echo $title; ?></h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<div style="padding: 10px;">
						<div class="row">
							<div class="col-6 col-md-3" align="right">
								<label for="nombre">Nombre:</label>
							</div>
							<div class="col col-md-9">
								<?php echo Convertir($row1['nombre']); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-3" align="right">
								<label for="dpi">DPI:</label>
							</div>
							<div class="col col-md-9">
								<?php echo dpi($row1['dpi'], 'input'); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-6 col-md-3" align="right">
								<label for="dpi">Cobrador asigando:</label>
							</div>
							<div class="col col-md-9">
								<?php 
									if($row1['cobrador']==0){
										$nombre_cobrador = verificar('');
									}else{
										$sqlCC = "SELECT * FROM usuarios WHERE id_usuario = " . $row1['cobrador'];
										$resCC = $mysqli->query($sqlCC);
										$rowCC = $resCC->fetch_assoc();

										$nombre_cobrador = $rowCC['nombre']; 
									}
								?>
								<?php echo $nombre_cobrador; ?>
							</div>
						</div>


						<hr>

						<div class="row">
							<div class="col col-md-12">
							<div class="alert alert-info" role="alert">
								<div class="row">
									<div class="col-6 col-md-3" align="right">
										<label for="cobrador">Seleccione un cobrador:</label>
									</div>
									<div class="col col-md-9">
											<select class='form-control selectpicker' id='id_cobrador' name='id_cobrador' data-live-search="true" title="Seleccione una cobrador" required>
													<?php
														$res_select = $mysqli->query("SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador' AND id_usuario <> ".$row1['cobrador']);

														while( $row_select = mysqli_fetch_array($res_select) ){
															$arra_select[$row_select[0]] = $row_select[4];

															$i++;
														}

														foreach($arra_select as $key => $datos){
															if( (!empty($key) AND !empty($datos)) OR (!empty($datos)) ){
																//($key==$ip_radio) ? $sel='selected' : $sel='';

																$option .= "					<option $sel value='$key'>$datos</option>\n";
															}
														}

														echo $option;
													?>
											</select>
									</div>
								</div>

								<div class="row" style="padding-top: 15px;">
									<div class="col-6 col-md-3" align="right">
										<label for="cobrador"></label>
									</div>
									<div class="col col-md-9" align="right">
										<button type="button" class="btn btn-success" name="registar" onclick="location.href='lista_clientes.php?numero=1'" style="outline: none;">
											<span class="glyphicon glyphicon-backward"></span> Regresar
										</button>

										<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
											<span class="glyphicon glyphicon-plus"></span> Guardar
										</button>
									</div>
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