<!-- CAMPO PARA BUSCAR -- CAMPO PARA BUSCAR  --  CAMPO PARA BUSCAR -->
<div class="row">
	<div class="col-sm-3" style="padding-right: 0px; padding-bottom: 15px;">
		<select class="form-control" id="as" name="as" onChange="load(1);">
			<option value="10">Mostrar 10 registros</option>
			<option value="20">Mostrar 20 registros</option>
			<option value="50">Mostrar 50 registros</option>
			<option value="100">Mostrar 100 registros</option>
		</select>
	</div>
	<div class="col-sm-9" style="padding-bottom: 15px;">
		<div id="custom-search-input">
			<div class="input-group col-md-12">									
				<input type="text" class="form-control" placeholder="Buscar"  id="q" onkeyup="load(1);" autocomplete="off" />
				<span class="input-group-btn">
					<button class="btn btn-info" type="button" onclick="load(1);">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
		</div>
	</div>
</div>
<!-- CAMPO PARA BUSCAR -- CAMPO PARA BUSCAR  --  CAMPO PARA BUSCAR -->

<!-- CARGAR TABLA -->
<!--div id="loader"></div><!- - Carga de datos ajax aqui -->
<div class='clearfix'></div>
<div id="resultados"></div><!-- Carga de datos ajax aqui -->
<div class='outer_div'><div style="background: url(../images/cargando.gif) no-repeat center; min-height: 300px; width: 100%;"></div></div><!-- Carga de datos ajax aqui -->

<input type="text" id="pagina" value="<?php echo $pagina; ?>" hidden>	
<script src="../js/script.js"></script>
<!-- FIN CARGAR TABLA -->