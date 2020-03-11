<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
	
		$l_verificar = 'administrador';
		require('../config/verificar.php');
	

		if(!empty($_POST)){
			$tema = mysqli_real_escape_string($mysqli,$_POST['tema']);
			$id_usuario = $_SESSION['id_usuario'];

			$sqlUsuario = "UPDATE usuarios SET id_tema = '$tema' WHERE id_usuario = $id_usuario";
			$resultUsuario = $mysqli->query($sqlUsuario);
		}
			
		$title = 'Temas';
		include('head.php');
		$active_temas="active";
    ?>
    
    <script>
		function validar(){
			var group = document.registro.tema;

			for(var i=0; i<group.length; i++){
				if (group[i].checked)
				break;
			}

			if(i==group.length){
				swal({ title: "Seleccione un tema", type: "info", confirmButtonClass: "btn-info", confirmButtonText: "Aceptar", closeOnConfirm: false, },
					function(isConfirm){
						if(isConfirm){ swal.close(); }
					}
				);
			}else{
				document.registro.submit();	
			}
		}
	</script>
	
	<style>
		/* HIDE RADIO */
		[type=radio] { 
		  position: absolute;
		  opacity: 0;
		  width: 0;
		  height: 0;
		}

		/* IMAGE STYLES */
		[type=radio] + img {
		  cursor: pointer;
		}

		/* CHECKED STYLES */
		[type=radio]:checked + img {
		  outline: 4px solid #f00;
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
                    <a class="btn btn-danger">Cambiar tema</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-edit'></i> <?php echo $title; ?> - Seleccione un tema y presione guardar</h4>
			</div>	

			<div class="panel-body">
				<form id="registro" name="registro" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" >
					<table class="table table-bordered" width="100%">
						<tr>
							<td>
							
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="1">
								<img src="../css/temas/bootstrap.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="2">
								<img src="../css/temas/cerulean.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="3">
								<img src="../css/temas/cosmo.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="4">
								<img src="../css/temas/cyborg.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="5">
								<img src="../css/temas/darkly.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="6">
								<img src="../css/temas/flatly.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="7">
								<img src="../css/temas/journal.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="8">
								<img src="../css/temas/lumen.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="9">
								<img src="../css/temas/paper.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="10">
								<img src="../css/temas/readable.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="11">
								<img src="../css/temas/sandstone.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="12">
								<img src="../css/temas/simplex.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="13">
								<img src="../css/temas/slate.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="14">
								<img src="../css/temas/spacelab.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="15">
								<img src="../css/temas/superhero.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="16">
								<img src="../css/temas/united.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
				<div class="col-lg-4 col-sm-6">
					<div class="preview">
						<div class="image">
							<label>
								<input type="radio" name="tema" id="tema" value="17">
								<img src="../css/temas/yeti.png" class="img-responsive">
							</label>
						</div>
					</div>
				</div>
				
				
			</div>


							
							</td>
						</tr>
						
						
						<tr>
							<td colspan="2" align="right">

								<button type="button" class="btn btn-primary" name="registar" onClick="validar();" style="outline: none;">
									<span class="glyphicon glyphicon-plus"></span> Guardar
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