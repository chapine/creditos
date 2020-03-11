<?php
	//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
	session_start();
	require('../config/conexion.php');
	
	$l_verificar = 'administrador';
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
			include('../administrador/query_tabla/lista_clientes.php');
		}
		
		if($opt == 2){  // MOSTRAR CLIENTES POR USUARIOS
			$a = 2;
			$usuario = $_REQUEST['usuario'];
			include('../administrador/query_tabla/lista_clientes.php');
		}
		
		if($opt == 3){  // MOSTRAR CLIENTES SIN PRESTAMOS
			$a = 1;
			$estado = $_REQUEST['estado'];
			include('../administrador/query_tabla/lista_clientes_prestamos.php');
		}
		
		if($opt == 4){  // MOSTRAR PRESTAMOS
			$estado = $_REQUEST['estado'];
			
			if($estado == 4){ $date = $_REQUEST['date']; }
			if($estado == 5){ $usuario = $_REQUEST['usuario']; }
			if($estado == 6){ $usuario = $_REQUEST['usuario']; $date = $_REQUEST['date']; }
			if($estado == 7){ $usuario = $_REQUEST['usuario']; }
			
			include('../administrador/query_tabla/lista_prestamos.php');
		}
		
		if($opt == 5){  // MOSTRAR COBROS REALIZADOS POR FECHAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $usuario = $_REQUEST['usuario']; $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			
			include('../administrador/query_tabla/cobros_realizados.php');
		}
		
		if($opt == 6){  // LISTA DE RUTAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 3){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 4){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; }
			
			include('../administrador/query_tabla/reporte_ruta.php');
		}
		
		if($opt == 7){  // LISTA DE RUTAS
			$a = 1;
			include('../administrador/query_tabla/lista_rutas.php');
		}
		
		if($opt == 8){  // COBROS PARA HOY
			$usuario = $_REQUEST['usuario'];
			
			if($usuario == 0){
				$a = 1;
			}else{
				$a = 2;
			}
			
			$fecha1 = $_REQUEST['fecha1'];
			include('../administrador/query_tabla/cobros_hoy.php');
		}
		
		
		if($opt == 9){  // LISTA DE RUTAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 3){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 4){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; }
			
			include('../administrador/query_tabla/reporte_ruta_cobros.php');
		}
		
		
		if($opt == 11){ // LISTA DE USUARIOS
			$a = 1;
			if($_SESSION['tipo_usuario']=='a'){ include('../a/query_tabla/lista_usuarios_a.php'); }
			if($_SESSION['tipo_usuario']=='s'){ include('../a/query_tabla/lista_usuarios_s.php'); }
		}
		
		if($opt == 12){ // LISTA DE COBRADORES
			$a = 1;
			include('../administrador/query_tabla/lista_cobradores.php');
		}
		
		if($opt == 13){ // BITACORA DEL CAPITAL :V
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $registro = $_REQUEST['registro']; $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 3){ $usuario = base64_decode($_REQUEST['usuario']); $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 4){ $registro = $_REQUEST['registro']; $usuario = base64_decode($_REQUEST['usuario']); $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			
			include('../administrador/query_tabla/bitacora.php');
		}
		
		
		if($opt == 14){ // PRESTAMOS VENCIDOS
			$estado = $_REQUEST['estado'];
			
			require('fecha.php');
			
			if($estado == 1){ $fecha = fecha('Y-m-d'); }
			if($estado == 2){ $fecha = fecha('Y-m-d'); $usuario = $_REQUEST['u']; }
			
			include('../administrador/query_tabla/lista_prestamos_vencidos.php');
		}
		
		if($opt == 15){ // PRESTAMOS VENCIDOS
			$estado = $_REQUEST['estado'];
			require('fecha.php');
			$fecha = fecha('Y-m-d');
			
			include('../administrador/query_tabla/lista_prestamos_renovados.php');
		}
		
		if($opt == 16){ // LISTA DE SESIONES ACTIVAS
			$a = 1;
			include('../administrador/query_tabla/sesiones.php');
		}
		
		
		if($opt == 17){  // LISTA DE RUTAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 3){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 4){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; }
			
			include('../administrador/query_tabla/reporte_ruta_renovaciones.php');
		}
		
		if($opt == 18){  // LISTA DE RUTAS
			$estado = $_REQUEST['estado'];
			
			if($estado == 1){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; }
			if($estado == 2){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 3){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $cobrador = $_REQUEST['cobrador']; }
			if($estado == 4){ $fecha1 = $_REQUEST['fecha1']; $fecha2 = $_REQUEST['fecha2']; $ruta = $_REQUEST['ruta']; }
			
			include('../administrador/query_tabla/reporte_ruta_renovaciones_cobros.php');
		}
		
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		// INCLUIR QUERY     --     INCLUIR QUERY     --     INCLUIR QUERY
		
		include '../config/pagination.php'; //Paginador		
		
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1; //Variables para paginador
		$per_page = intval($_REQUEST['per_page']); //Cuentos registros quieren mostrar
		
		$adjacents  = 1; //espacio entre páginas después del número adyacente
		$offset = ($page - 1) * $per_page; //Cuenta el numero de filas

		$res_contar_registros = $mysqli->query($sql_contar); // Query para contar los registos
		
		if($row = mysqli_fetch_array($res_contar_registros)){ // Muestra el total de registos o muestra error
			$numrows = $row['numrows'];
			
			if($per_page=='all'){ $per_page=$numrows; }
		}else{
			//echo 'Error en la base de datos.';
		}
		
		$total_pages = ceil($numrows/$per_page); // total de paginas para el paginador
		
		$res_mostrar_registros = $mysqli->query("$sql_query  LIMIT $offset, $per_page"); // Query para mostrar los registros
		
		
		// Muestra el numero correlativo y el total de regisros en el paginador
		$in = $offset +1;
		$fi += $in -1;

		if ($numrows>0){

		?>
		
			<div id="scroll_x" style="overflow-x: auto; overflow-y: auto; white-space:nowrap">
				<?php
					if($opt == 1){ // MOSTRAR TODOS LOS CLIENTES
						$a = 3;
						include('../administrador/query_tabla/lista_clientes.php');
					}
			
					if($opt == 2){ // MOSTRAR CLIENTES POR USUARIOS
						$a = 3;
						include('../administrador/query_tabla/lista_clientes.php');
					}
			
					if($opt == 3){ // MOSTRAR CLIENTES SIN PRESTAMOS
						$a = 2;

						$estado = $_REQUEST['estado'];
						include('../administrador/query_tabla/lista_clientes_prestamos.php');
					}
			
					if($opt == 4){  // MOSTRAR PRESTAMOS
						$a = 1;
						require('fecha.php');
						
						include('../administrador/query_tabla/lista_prestamos.php');
					}
			
			
					if($opt == 5){  // MOSTRAR COBROS REALIZADOS POR FECHAS
						$a = 1;
						include('../administrador/query_tabla/cobros_realizados.php');
					}
			
			
					if($opt == 6){  // LISTA DE RUTAS
						$a = 1;
						require('fecha.php');
						include('../administrador/query_tabla/reporte_ruta.php');
					}
			
					if($opt == 7){  // LISTA DE RUTAS
						$a = 2;
						include('../administrador/query_tabla/lista_rutas.php');
					}
			
					if($opt == 8){  // COBROS PARA HOY
						$a =3;
						
						$usuario = $_REQUEST['usuario'];
						
						if($usuario == 0){
							$e = 1;
						}
						
						include('../administrador/query_tabla/cobros_hoy.php');
					}
			
			
					if($opt == 9){  // LISTA DE RUTAS
						$a = 1;
						require('fecha.php');
						include('../administrador/query_tabla/reporte_ruta_cobros.php');
					}
			
			
					if($opt == 11){ // LISTA DE USUARIOS
						$a = 2;
						//include('../a/query_tabla/lista_usuarios.php');
						if($_SESSION['tipo_usuario']=='a'){ include('../administrador/query_tabla/lista_usuarios_a.php'); }
						if($_SESSION['tipo_usuario']=='s'){ include('../administrador/query_tabla/lista_usuarios_s.php'); }
					}
			
					if($opt == 12){ // LISTA DE COBRADORES
						$a = 2;
						include('../administrador/query_tabla/lista_cobradores.php');
					}
			
					if($opt == 13){ // BITACORA DEL CAPITAN :V
						$a = 1;
						include('../administrador/query_tabla/bitacora.php');
					}
			
					if($opt == 14){ // PRESTAMOS VENCIDOS
						$a = 1;
						
						include('../administrador/query_tabla/lista_prestamos_vencidos.php');
					}
			
					if($opt == 15){ // PRESTAMOS VENCIDOS
						$a = 1;
						
						include('../administrador/query_tabla/lista_prestamos_renovados.php');
					}
			
					if($opt == 16){ // LISTA DE SESIONES ACTIVAS
						$a = 2;
						include('../administrador/query_tabla/sesiones.php');
					}
			
			
					if($opt == 17){  // LISTA DE RUTAS
						$a = 1;
						require('fecha.php');
						include('../administrador/query_tabla/reporte_ruta_renovaciones.php');
					}

					if($opt == 18){  // LISTA DE RUTAS
						$a = 1;
						require('fecha.php');
						include('../administrador/query_tabla/reporte_ruta_renovaciones_cobros.php');
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