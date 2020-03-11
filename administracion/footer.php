</div> <!-- cierra wrapper del menú -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

	<script>
		//$('select').selectpicker();
		
		$(document).ready(function(){
			$("#release").click(function(){
				$("#release_note").modal({backdrop: "static"}); //no cerrar al dar clicke en el fondo
		
				$(document).ready(function(){
					loadd(1);
				});

				function loadd(){
					var parametros = {"action":"ajax"};
					$("#loaderr").fadeIn('slow');
					$.ajax({
						url:'release.php',
						data: parametros,

						beforeSend: function(objeto){
							$(".outer_divv").html('<div style="background: url(../images/cargando.gif) no-repeat center; min-height: 300px; width: 100%;"></div>');
						}, // FIN BEFORESEND
						
						success: function(data){
							$(".outer_divv").html(data).fadeIn('slow'); //Mostrar datos si todo es correcto
							$("#loaderr").html(""); // ocultar loader

							
							if(data == "error"){ // Si regresa error muestra mensaje
								$(".outer_divv").html('Error, no se puede mostrar los datos.').fadeIn('slow'); //Nostrar el mensaje de error
								
								setTimeout(function(){ // Funcion para cerrar modal en el tiempo indicado
								  	$('#release_note').modal('toggle'); // Cerrar el modal al pasar el tiempo seleccionado
								}, 10000); // Fin SETTIMEOUT
								
							} // Fin si ERROR
						} // Succes Function
					}) // Fin AJAX
				} // Fin LOAD
				
				
				
			});
		});
		
		
	</script>
	<footer class="footer hidden-xs">
		<div class="row">
			<div class="pull-right" style="padding-right: 30px;">
				<b>Versión</b> 2.4
			</div>
			
			<div class="pull-right" style="padding-right: 30px;">|</div>
			
			<div class="pull-right" style="padding-right: 30px;"><a href="javascript:void(0);" id="release">Release Note</a></div>
			<!--div class="quitar" style="padding-left: 280px;">
				<strong>Copyright © 2018-2019 - <a href="http://creditosescozep.com">Sistemas Web</a></strong>.
			</div-->
		</div>
	</footer>
	
	<div class="modal fade" id="release_note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Nostas de publicación del sistema</h4>
				</div>
				<div class="modal-body pre-scrollable" id="contenido">
					<div class='clearfix'></div>
					<samp id="loaderr"></samp>
					<div class='outer_divv'></div>
				</div>
			</div>
		</div>
	</div>

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
		
		function confirmar_eliminar(){
			swal({
				title: "...Espere...",
				text: "Será redirecionado al finalizar el proceso",
				type: "info",

				showCancelButton: false,
				showConfirmButton: false
			});
		}
		
		
		function confirmar_eliminar_(){
			swal({
				title: "...Espere...",
				text: "Será redirecionado al finalizar el proceso",
				type: "info",

				showCancelButton: false,
				showConfirmButton: true
			});
		}
		
		/*Ocultar y mostrar menú*/
		$("#menu-toggle").click(function(e){e.preventDefault();$("#wrapper").toggleClass("toggled");});

		// Cerrar o abrir el menú
		document.querySelector( "#menu-toggle" ).addEventListener( "click", function() { this.classList.toggle( "open" ); });
		
		// Cambiar el left del footer
		$("div.slidebar-toggle").click(function(){
			if ($(this).hasClass('open')){
				$( "div.quitar" ).attr( "style", "padding-left: 280px;" );
				
			}else{
				$( "div.quitar" ).attr( "style", "padding-left: 25px;" );
			}
		});
	</script>
	