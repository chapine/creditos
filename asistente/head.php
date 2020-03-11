	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	
	<meta name="theme-color" content="#3498db">
	<meta http-equiv="Content-Language" content="es" />
	<title><?php echo $title; ?></title>

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
    
    <!-- Bootstrap -->
    
    <?php
		$id_usuario_tema = $_SESSION['id_usuario'];

		$sql_tema_1 = "SELECT id_usuario, id_tema FROM usuarios WHERE id_usuario = $id_usuario_tema";
		$res_tema_1 = $mysqli->query($sql_tema_1);
		$row_tema_1 = $res_tema_1->fetch_assoc();

		$id_tema = $row_tema_1['id_tema'];

		$sql_tema_2 = "SELECT * FROM temas WHERE id_tema = $id_tema";
		$res_tema_2 = $mysqli->query($sql_tema_2);
		$row_tema_2 = $res_tema_2->fetch_assoc();

		$css = $row_tema_2['css'];
	?>
    <link rel="stylesheet" type="text/css" href="../css/<?php echo $css; ?>">
    
    
    <script src="../js/bootstrap.js"></script>
    
    
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"/>
    
	<script>
		// Evitar el reenvio de formulario
		if(window.history.replaceState){
			window.history.replaceState(null, null, window.location.href);
		}
		
		// Imprimir
		$(document).ready(function() {
			$(".btnPrint").printPage();
		});

		// Deshabilitar f5
		function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
		//$(document).on("keydown", disableF5);
		
		//Contar
		$(document).ready(function(){	
			//default usage
			$("#observaciones").charCount({
				allowed: 200,		
				warning: 20,
				//counterText: 'Characters left: '	
			});
			
			$("#mensaje").charCount({
				allowed: 80,		
				warning: 20,
				//counterText: 'Characters left: '	
			});
		});
		
		// Mostrar reloj
		var Hoy = new Date("<?php echo date("d M Y G:i:s");?>")
	
		function Reloj(){
			Hora = Hoy.getHours()
			Minutos = Hoy.getMinutes()
			Segundos = Hoy.getSeconds()

						
			var dn="PM"
			if (Hora<12) dn="AM"
			if (Hora>12) Hora=Hora-12
			if (Hora==0) Hora=12
				
			if (Hora<=9) Hora = "0" + Hora
			if (Minutos<=9) Minutos = "0" + Minutos
			if (Segundos<=9) Segundos = "0" + Segundos
			
			var Dia = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
			var Mes = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var Anio = Hoy.getFullYear();
			var Fecha = Dia[Hoy.getDay()] + ", " + Hoy.getDate() + " de " + Mes[Hoy.getMonth()] + " de " + Anio + ", a las ";
			var Inicio, Script, Final, Total
			
			Inicio = "<font size='3' face='Arial'><b>" 
			//Script = Fecha + Hora + ":" + Minutos + ":" + Segundos
			Script = "<font size='2' face='Arial'><b>Hora</b></font> " + Hora + ":" + Minutos + ":" + Segundos + " <font size='1' face='Arial'><b>" + dn + "</b></font>"
			Final = "</b></font>" 
			Total = Inicio + Script + Final 
			
			document.getElementById('Fecha_Reloj').innerHTML = Total 
			Hoy.setSeconds(Hoy.getSeconds() +1)
			setTimeout("Reloj()",1000) 
		}
	</script>

 
    <?php
    	$active_clientes="";
		$active_usuarios="";
		$active_prestamos="";
		$active_cobros="";
		$active_cobradores="";
		$active_porcentaje="";
		$active_rutas="";
		$active_bitacora="";
		$active_mantenimiento="";
		$active_temas="";
    ?>