<!DOCTYPE html>
<html>
<head>
	<?php
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		session_start();
		require('../config/conexion.php');
	
		$l_verificar = 'administrador';
		require('../config/verificar.php');
		//Sesiones  //Sesiones  //Sesiones  //Sesiones  //Sesiones
		
		$a = $_REQUEST['a'];
		$t = $_REQUEST['t'];
		$fecha1 = $_REQUEST['fecha1'];
		$fecha2 = $_REQUEST['fecha2'];
		
		$sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador' AND id_usuario = $t";
		$res = $mysqli->query($sql);
		$row1 = mysqli_fetch_row($res);
		
		if($a==1 AND $t<>0){
			$pagina = 'generar_tabla.php?opt=5&estado=1&usuario='.$t.'&fecha1='.$fecha1.'&fecha2='.$fecha2;
			
			$title_link = '
				<a href="perfil_usuario.php?id='.$t.'" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" style="color: black; color:#fff; text-decoration: none;">
					<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i>
					<b>'.Convertir($row1[4]).'</b>
				</a>';
			
			$title_panel = 'Todos los cobros realizados entre la fecha '.fecha('d-m-Y', $fecha1).' a la '.fecha('d-m-Y', $fecha2).' del cobrador '.$title_link;
			
			$title = 'Todos los cobros realizados entre la fecha '.fecha('d-m-Y', $fecha1).' a la '.fecha('d-m-Y', $fecha2).' del cobrador '.Convertir($row1[4]);
		}
		elseif($a==1 AND $t==0){
			$pagina = 'generar_tabla.php?opt=5&estado=2&fecha1='.$fecha1.'&fecha2='.$fecha2;
			
			$title = 'Todos los cobros realizados entre la fecha '.fecha('d-m-Y', $fecha1).' a la '.fecha('d-m-Y', $fecha2).' de todos los cobradores';
			$title_panel = $title;
		}
		
		$result = $mysqli->query($sql);
		$res1 = $mysqli->query($sql);
		
		$link = '../print/print_cobros_realizados.php?a='.$a.'&t='.$t.'&fecha1='.$fecha1.'&fecha2='.$fecha2;
		
		include('head.php');
		$active_cobradores = "active";
    ?>
    
    <script>
		function confirmar(a, b)
		{
			if (a == 'eliminar')
			{
				if(confirm('¿Está seguro que desea eliminar el registro <b>'+b+'</b>?\n\nLos registros eliminados no se podrán recuperar.'))
				{
					location.href = "?eliminar="+b;
					return true;
				}
				else
				{
					return false;
				}
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
                    <a href="seleccionar_fecha.php?a=<?php echo $a; ?>" class="btn btn-success">Fechas</a>
                    <a class="btn btn-primary">Prestamos según fechas</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
        		<div class="btn-group pull-right hidden-xs">
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir reporte</a>
				</div>
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $title_panel; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>


    </main>
  </div>
</body>
</html>