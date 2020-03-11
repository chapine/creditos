<?php
	if($usuario_bitacora <> 'edba'){
		
		$fecha_bitacora = date('Y-m-d H:i:s');

		$sql_bitacora = 
			"INSERT INTO bitacora 
			
			(id_bitacora, id_bitacora_codigo, descripcion, usuario, id_cliente, id_prestamo, id_detalle, id_ruta, id_departamento, id_usuario, fecha) VALUES 
			
			(NULL, '$id_bitacora_codigo', '$descripcion_bitacora', '$usuario_bitacora', '$id_cliente_bitacora', '$id_prestamo_bitacora', '$id_detalle_bitacora', '$id_ruta_bitacora', '$id_departamento_bitacora', '$id_usuario_bitacora', '$fecha_bitacora')";
		
		$res_bitacora = $mysqli->query($sql_bitacora);
	}
?>