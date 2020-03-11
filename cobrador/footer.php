</div> <!-- cierra wrapper del menú -->
	<footer class="footer hidden-xs">
		<div class="row">
			<div class="pull-right" style="padding-right: 30px;">
				<b>Versión</b> 2.4
			</div>
			<!--div class="quitar" style="padding-left: 280px;">
				<strong>Copyright © 2018-2019 - <a href="http://creditosescozep.com">Sistemas Web</a></strong>.
			</div-->
		</div>
	</footer>
	
	<script>
		<?php if($alert_bandera){ ?>
			swal({
				title: "<?php echo($alert_titulo); ?>",
				text: "<?php echo($alert_mensaje); ?>",
				type: "<?php echo($alert_icono); ?>",

				confirmButtonClass: 'btn-<?php echo($alert_boton); ?>',
				confirmButtonText: 'Aceptar',
				animation: "slide-from-top",
			});
		
		<?php }elseif($alert_redireccionar){ ?>
			swal({
				title: "<?php echo($alert_titulo); ?>",
				text: "<?php echo($alert_mensaje); ?>",
				type: "<?php echo($alert_icono); ?>",

				confirmButtonClass: "btn-<?php echo($alert_boton); ?>",
				confirmButtonText: "Aceptar",
			},
				function(isConfirm){
				if (isConfirm){
					window.location.href='<?php echo $alert_link; ?>';
				}
			});
		<?php }elseif($alert_confirmar){ ?>
			swal({
				title: "<?php echo($alert_titulo); ?>",
				text: "<?php echo($alert_mensaje); ?>",
				type: "<?php echo($alert_icono); ?>",
				
				showCancelButton: true,
				confirmButtonClass: "btn-<?php echo($alert_boton); ?>",
				confirmButtonText: "Si",
				cancelButtonText: "No",
				closeOnConfirm: false,
				closeOnCancel: false
			},
				function(isConfirm){
				if (isConfirm){
					<?php echo $alert_si; ?>
				}else{
					<?php echo $alert_no; ?>
				}
			});
		<?php } ?>
		
		/*Ocultar y mostrar menú*/
		$("#menu-toggle").click(function(e){e.preventDefault();$("#wrapper").toggleClass("toggled");});

		// Cerrar o abrir el menú
		document.querySelector( "#menu-toggle" )
		.addEventListener( "click", function() {
			this.classList.toggle( "open" );
		});
		
		// Cambiar el left del footer
		$("div.slidebar-toggle").click(function(){
			if ($(this).hasClass('open')){
				$( "div.quitar" ).attr( "style", "padding-left: 280px;" );
				
			}else{
				$( "div.quitar" ).attr( "style", "padding-left: 25px;" );
			}
		});

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
	