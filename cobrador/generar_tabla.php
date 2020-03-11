<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');
		
	$l_verificar = "cobrador";
	require('../config/verificar.php');
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones

	$opt = $_REQUEST['opt'];

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){
		$query = mysqli_real_escape_string($mysqli,(strip_tags($_REQUEST['query'], ENT_QUOTES)));
		
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		
		if($opt == 1){ // MOSTRAR TODOS LOS CLIENTES
			$a = 1;
			$usuario = $_REQUEST['usuario'];
			include('../cobrador/query_tabla/lista_clientes.php');
		}
		
		if($opt == 2){ // MOSTRAR TODOS LOS CLIENTES
			$a = 1;
			$estado = $_REQUEST['estado'];
			$usuario = $_REQUEST['usuario'];
			
			include('../cobrador/query_tabla/lista_clientes_prestamos.php');
		}
		
		if($opt == 3){ // MOSTRAR TODOS LOS CLIENTES
			$estado = $_REQUEST['estado'];

			if($estado == 1){ $usuario = $_REQUEST['usuario']; }
			if($estado == 2){ $usuario = $_REQUEST['usuario']; }
			if($estado == 3){ $usuario = $_REQUEST['usuario']; }
			
			if($estado == 4){ $usuario = $_REQUEST['usuario']; $date = $_REQUEST['date']; }
			
			include('../cobrador/query_tabla/lista_prestamos.php');
		}
		
		if($opt == 4){  // COBROS PARA HOY
			$usuario = $_REQUEST['usuario'];
			$fecha1 = $_REQUEST['fecha1'];
			
			$a = 1;
			
			include('../cobrador/query_tabla/cobros_hoy.php');
		}
		
		
		if($opt == 6){  // LISTA DE RUTAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 3){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 4){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; }
			
			include('../cobrador/query_tabla/reporte_ruta.php');
		}
		
		if($opt == 9){  // LISTA DE RUTAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 3){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 4){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; }
			
			include('../cobrador/query_tabla/reporte_ruta_cobros.php');
		}
		
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		
		include '../config/pagination.php'; //Paginador		
		
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1; //Variables para paginador
		$per_page = intval($_REQUEST['per_page']); //Cuentos registros quieren mostrar
		
		$adjacents  = 2; //espacio entre páginas después del número adyacente
		$offset = ($page - 1) * $per_page; //Cuenta el numero de filas

		$res_contar_registros = $mysqli->query($sql_contar); // Query para contar los registos
		
		if($row = mysqli_fetch_array($res_contar_registros)){ // Muestra el total de registos o muestra error
			$numrows = $row['numrows'];
		}else{
			echo 'Error en la base de datos.';
		}
		
		$total_pages = ceil($numrows/$per_page); // total de paginas para el paginador
		
		$res_mostrar_registros = $mysqli->query("$sql_query  LIMIT $offset, $per_page"); // Query para mostrar los registros
		
		
		// Muestra el numero correlativo y el total de regisros en el paginador
		$fi = '';
		
		$in = $offset +1;
		$fi += $in -1;

		if ($numrows>0){

		?>

			<div id="scroll_x" style="overflow-x: auto; overflow-y: auto; white-space:nowrap">
				<?php
					if($opt == 1){ // MOSTRAR TODOS LOS CLIENTES
						$a = 2;
						include('../cobrador/query_tabla/lista_clientes.php');
					}
			
					if($opt == 2){ // MOSTRAR TODOS LOS CLIENTES
						$a = 2;
						include('../cobrador/query_tabla/lista_clientes_prestamos.php');
					}
			
					if($opt == 3){ // MOSTRAR TODOS LOS CLIENTES
						$a = 1;
						include('../cobrador/query_tabla/lista_prestamos.php');
					}
			
					if($opt == 4){  // COBROS PARA HOY
						$a =3;
						
						include('../cobrador/query_tabla/cobros_hoy.php');
					}
			
			
					if($opt == 6){  // LISTA DE RUTAS
						$a = 1;
						require('fecha.php');
						include('../cobrador/query_tabla/reporte_ruta.php');
					}
			
			
					if($opt == 9){  // LISTA DE RUTAS
						$a = 1;
						require('fecha.php');
						include('../cobrador/query_tabla/reporte_ruta_cobros.php');
					}
				?>
				
				<table width="100%" border="0">
					<tr>
						<td class="hidden-xs"> 
							<?php
								$inicios = $offset +1;
								$finales += $inicios -1;
			
								$inicios = number_format($inicios,0,".",",");
								$finales = number_format($finales,0,".",",");
								$numrows = number_format($numrows,0,".",",");
			
								echo "Mostrando $inicios al $finales de $numrows registros";
							?>
						</td>
						
						<td align="center" class="hidden-xs"><samp id="loader"></samp></td>
					
						<td> 
							<?php
								echo paginate( $page, $total_pages, $adjacents);
							?>
						</td>
					</tr>
				</table>
			</div>
			
			<script type="text/javascript"> // Tool tip text
				$(document).ready(function(){
					$('[data-toggle="tooltip"]').tooltip(); 
				});
		
				// MouseWheel
				(function() {
					function scrollHorizontally(e) {
						e = window.event || e;
						var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
						document.getElementById('scroll_x').scrollLeft -= (delta*40); // Multiplied by 40
						e.preventDefault();
					}
					if (document.getElementById('scroll_x').addEventListener) {
						// IE9, Chrome, Safari, Opera
						document.getElementById('scroll_x').addEventListener("mousewheel", scrollHorizontally, false);
						// Firefox
						document.getElementById('scroll_x').addEventListener("DOMMouseScroll", scrollHorizontally, false);
					} else {
						// IE 6/7/8
						document.getElementById('scroll_x').attachEvent("onmousewheel", scrollHorizontally);
					}
				})();
			</script>
			
		<?php	
		}else{
			echo '<b>No se encontraron registros...</b>';
		?>
			<script type="text/javascript">	
				$(".outer_div").css("display", "none");

				$(document).ready(function(){
					$('[data-toggle="tooltip"]').tooltip(); 
				});
			</script>
		<?php
		}
	}
?>