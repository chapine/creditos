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
	
			
		$pagina = 'generar_tabla.php?opt=11';
		$title = 'Listado de usuarios';
		$link = '../print/print_lista_usuarios.php';
		
		include('head.php');
		$active_usuarios = "active";
    ?>
    
    <script>
		function confirmar(a, b, c)
		{
			if (a == 'eliminar')
			{
				location.href = "eliminar_usuario.php?supr=0&eliminar="+b;
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
                    <a href="index.php" class="btn btn-success">Usuarios</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right hidden-xs">
					<a href="nuevo_usuario.php" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir usuario</a>
					<a class="btn btn-success btnPrint" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir usuarios</a>
				</div>
				<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de usuarios</h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
    <?php include("footer.php"); ?>
</body>
</html>