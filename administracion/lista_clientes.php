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
		
		$numero 	= $_REQUEST['numero'];
		$usuario 	= $_REQUEST['u'];
			
		if($numero == 1){
			$pagina 	= 'generar_tabla.php?opt=1';
			$title 		= 'Listado de clientes';
			$cobrador 	= '';
			$link 		= '../print/print_lista_clientes.php?numero=1';
			
			include('head.php');
			$active_clientes = "active";
			
		}elseif($numero == 2){
			$sqlUU = "SELECT * FROM usuarios WHERE id_usuario = $usuario";
			$resUU = $mysqli->query($sqlUU);
			$rowUU = $resUU->fetch_assoc();
			
			$pagina = 'generar_tabla.php?opt=2&usuario='.$usuario;
			$title = 'Listado de clientes por cobrador';
			
			$cobrador = 
				' de 
					<a href="perfil_usuario.php?id='.$usuario.'" data-toggle="tooltip" data-placement="top" title="Click para ver el perfil del usuario" style="color: black; color:#fff; text-decoration: none;">
						<i class="glyphicon glyphicon-link" style="color:#BBBBBB;"></i> <b> '.Convertir($rowUU['nombre']).'</b>
					</a>
					';
			
			$link = '../print/print_lista_clientes.php?numero=2&u='.$usuario;
			
			include('head.php');
			$active_cobradores = "active";
		}
    ?>
   
    <script>
		function confirmar(a, b)
		{
			if (a == 'eliminar')
			{
				location.href = "eliminar_cliente.php?a=2&eliminar="+b;
			}
		}
	</script>

</head>
<body onload="Reloj()">
    <?php include('menu.php'); ?>
    
    <!-- Contenido -->
    <main role="main" id="page-wrapper6">  

        <!-- Navegador -->
        <div align="right" class="navegar_secciones">
            <div class="row" style="margin-left:0px;">
                <div class="btn-group btn-breadcrumb">
                    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                    <?php if($numero == 2){ ?>
                    	<a href="seleccione_cobrador.php?a=5" class="btn btn-info">Seleccionar cobrador</a>
                    <?php } ?>
                    <a class="btn btn-success">Clientes</a>
                </div>
            </div>
        </div>
        <!-- Navegador -->
        
        <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right hidden-xs">
					<a href="nuevo_cliente.php" class="btn btn-info btn-md"><i class="glyphicon glyphicon-plus"></i> &nbsp; Añadir cliente</a>
					<a class="btn btn-success btnPrint btn-md" href="<?php echo $link; ?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..mensaje personal .. '; return true;"><i class="glyphicon glyphicon-print"></i> &nbsp; Imprimir clientes</a>
				</div>
				<h4><i class='glyphicon glyphicon-list-alt'></i> Lista de clientes <?php echo $cobrador; ?></h4>
			</div>
			<div class="panel-body" style="margin: 0 15px 0 15px;">
				<?php include('tabla.php'); //Mostrar la tabla ?>
			</div>
		</div>
    </main>
    
    <?php
		$alert_cliente = $_SESSION["cliente"];
			
		if($alert_cliente<>""){
			$alert_bandera 	= true;
			$alert_titulo 	= "Exito";
			$alert_mensaje 	= "Se elimino al cliente ".Convertir($alert_cliente)." correctamente";
			$alert_icono 	= "success";
			$alert_boton 	= "success";
			
			unset($_SESSION["cliente"]); // Vaciar variable
		}
	?>
    
	<?php include("footer.php"); ?>
</body>
</html>