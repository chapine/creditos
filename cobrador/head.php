	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta charset="utf-8">
	<meta name="theme-color" content="#3498db">
	<meta http-equiv="Content-Language" content="es" />
	<title><?php echo $title; ?></title>

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <script src="../js/bootstrap.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../css/navegador.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/botones.css">
  	
	<!-- Imprimir -->
	<script src="../print/files/jquery.printPage.js" type="text/javascript"></script>

	<!-- Contar caracteres -->
	<script src="../js/charCount.js" type="text/javascript"></script>

	<!-- Sweet -->
	<script src="../js/sweetalert.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

	<!-- Estilos varios -->
    <link rel="stylesheet" type="text/css" href="../css/otros.css">
    
   <script>
		// Evitar el reenvio de formulario
		if(window.history.replaceState){
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
   
    <?php
    	$active_clientes="";
		$active_usuarios="";
		$active_prestamos="";
		$active_cobros="";
		$active_cobradores="";
    ?>