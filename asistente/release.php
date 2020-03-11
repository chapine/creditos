<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');
	
	$l_verificar = 'asistente';
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){
		
		$sql_contar = "SELECT count(*) AS numrows FROM release_note";
		$res_contar = $mysqli->query($sql_contar); // Query para contar los registos
		
		if($row_contar = mysqli_fetch_array($res_contar)){ // Muestra el total de registos o muestra error
			$numrows = $row_contar['numrows'];
		}else{
			echo 'error';
		}

		if($numrows > 0){
			$sql_mostrar = "SELECT * FROM release_note ORDER BY fecha DESC";
			$res_mostrar = $mysqli->query("$sql_mostrar"); // Query para mostrar los registros
?>
    
    		<?php while($row_mostrar = mysqli_fetch_array($res_mostrar)){ ?>
				<div style="font-weight: bold;"><?php echo fecha("d-m-Y", $row_mostrar['fecha']); ?></div>
				<div style="padding-bottom: 15px;"><?php echo $row_mostrar['descripcion']; ?></div>
			<?php } ?>
<?php
		}
	}
?>