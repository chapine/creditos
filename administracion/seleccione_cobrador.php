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
		
		$a = $_REQUEST['a'];
		
		if($a==1){
			$texto = 'Seleccione un cobrador para generar un reporte de prestamos activos';
			$numero = '5';
			$titulo = 'Préstamos activos por cobrador';
			$permisos_c = "lista_prestamos_5";
			
		}elseif($a==2){
			$fecha = fecha('d-m-Y');
			$fecha1 = '&d='.fecha('Y-m-d');
			$texto = 'Seleccione un cobrador para generar un reporte de prestamos atrasados a la fecha actual: '.$fecha;
			$numero = '6';
			$titulo = 'Prestamos atrasados por cobrador';
			$permisos_c = "lista_prestamos_6";
			
		}elseif($a==3){
			$texto = 'Seleccione un cobrador para generar un reporte de rendimiento';
			$titulo = 'rendimiento por cobrador';
			$permisos_c = "rendimiento";
			
		}elseif($a==4){
			$texto = 'Seleccione un cobrador para generar un reporte de prestamos finalizados';
			$numero = '7';
			$titulo = 'Prestamos finalizados por cobrador';
			$permisos_c = "lista_prestamos_7";
			
		}elseif($a==5){
			$texto = 'Seleccione un cobrador para generar un reporte de sus clientes';
			$numero = '2';
			$titulo = 'Listado de clientes por cobrador';
			$permisos_c = "lista_clientes_2";
			
		}elseif($a==6){
			$texto = 'Seleccione un cobrador para generar un reporte de préstamos vencidos por cobrador';
			$titulo = 'Préstamos vencidos por cobrador';
			$permisos_c = "lista_prestamos_vencidos_2";
		}
		
		$sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'cobrador'";
		$res = $mysqli->query($sql);

		$title = $texto;
		$excel = $title;
		$hoja = 'portrait'; // Vertical = portrait   Horizontal = landscape
		$imprimir='0,1,2,3,4';
		
		include('head.php');
			
		if($a==1 OR $a==2 OR $a==4){
			$active_cobradores = "active";
		}elseif($a==3){
			$active_cobros = "active";
		}elseif($a==5){
			$active_cobradores = "active";
		}elseif($a==6){
			$active_cobradores = "active";
		}
		
		
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
                    <a class="btn btn-primary">Cobrador</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $texto; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<div >
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr class="info">
							<th width="4%">#</th>
							<th width="90%">Cobrador</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; while($row = mysqli_fetch_row($res)){ ?>
							<tr>
								<td><?php echo $i; ?></td>
								
								<td>
									<a href="#" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" onclick="location.href='perfil_usuario.php?id=<?php print($row[0]); ?>'" style="color: black;">
										<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <?php echo Convertir($row[4]); //Cliente?>
									</a>
								</td>
								
								<td width="120" align="center">
									<div class="btn-group" role="group">

<?php if($a==1 OR $a==2 OR $a==4){ ?>
	<div class="btn-group">
	  <button onclick="location.href='lista_prestamos.php?a=<?php echo $numero; ?>&u=<?php echo $row[0]; ?><?php echo $fecha1; ?>'" type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Seleccionar <i class="glyphicon glyphicon-chevron-right"></i>
	  </button>
	</div>
<?php }elseif($a==3){ ?>
	<div class="btn-group">
	  <button onclick="location.href='rendimiento.php?a=3&u=<?php echo $row[0]; ?>'" type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Seleccionar <i class="glyphicon glyphicon-chevron-right"></i>
	  </button>
	</div>
<?php }elseif($a==5){ ?>
	<div class="btn-group">
	  <button onclick="location.href='lista_clientes.php?numero=<?php echo $numero; ?>&u=<?php echo $row[0]; ?>'" type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Seleccionar <i class="glyphicon glyphicon-chevron-right"></i>
	  </button>
	</div>
<?php }elseif($a==6){ ?>
	<div class="btn-group">
	  <button onclick="location.href='lista_prestamos_vencidos.php?a=2&u=<?php echo $row[0]; ?>'" type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Seleccionar <i class="glyphicon glyphicon-chevron-right"></i>
	  </button>
	</div>
<?php } ?>



								</td>
							</tr>
						<?php $i++;} ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>