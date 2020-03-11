<?php
	function codificar($dato) {
		$resultado = $dato;
		$arrayLetras = array('M', 'A', 'R', 'C', 'O', 'S', 'B', 'X', 'P', 'F', 'N', 'Z');

		$limite = count($arrayLetras) - 1;
		$num = mt_rand(0, $limite);
		for ($i = 1; $i <= $num; $i++) {
			$resultado = base64_encode($resultado);
		}
		$resultado = $resultado . '+' . $arrayLetras[$num];
		$resultado = base64_encode($resultado);
		return $resultado;
	}

	function decodificar($dato) {
		$resultado = base64_decode($dato);
		list($resultado, $letra) = explode('+', $resultado);
		$arrayLetras = array('M', 'A', 'R', 'C', 'O', 'S', 'B', 'X', 'P', 'F', 'N', 'Z');
		for ($i = 0; $i < count($arrayLetras); $i++) {
			if ($arrayLetras[$i] == $letra) {
				for ($j = 1; $j <= $i; $j++) {
					$resultado = base64_decode($resultado);
				}
				break;
			}
		}
		return $resultado;
	}

	function Convertir($sentence){
        $letters = array('I','İ','Ç','Ş','Ü','Ö','Ğ');
        $replace = array('ı','i','ç','ş','ü','ö','ğ');

        $sentence = mb_strtolower(str_replace($letters,$replace,$sentence),"UTF-8");

        $words = array();

        foreach(explode(" ",$sentence) as $word)
        {
            $first = str_replace($replace,$letters,mb_substr($word, 0, 1, "UTF-8"));
            $other = mb_substr($word,1,strlen($word)-1,"UTF-8");

            $words[] = $first.$other;
        }

        $sentence = implode(" ",$words);

        return ucwords($sentence);
	}

	/*function Convertir($string){
		
		/*$sentences = preg_split('/([ ]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
		$new_string = ''; 
		foreach ($sentences as $key => $sentence) {
			$new_string .= ($key & 1) == 0? ucfirst(strtolower(trim($sentence))) : $sentence.' '; 
		}
		
		return trim($new_string);
	}*/

	function formato($numero){
		$largo_numero = strlen($numero); //obtengop el largo del numero
		$largo_maximo = 6; //especifico el largo maximo de la cadena
		$agregar = $largo_maximo - $largo_numero; //tomo la cantidad de ceros a agregar

		for($i =0; $i<$agregar; $i++){ //agrego los ceros
			$numero = "<spam style='color:#BBBBBB'>0</spam>".$numero;
		}

		return '<b>'.$numero.'</b>'; //retorno el valor con ceros
	}

	function fecha($formato, $fecha){
		if($fecha=='1000-01-01' OR $fecha=='01-01-1000'){
			$fecha = '<font color="#cccccc"><b>00-00-0000</b></font>';
		}else{
			if($formato=='d-m-Y' AND $fecha==''){ $fecha = date('d-m-Y'); }
			if($formato=='Y-m-d' AND $fecha==''){ $fecha = date('Y-m-d'); }

			if($formato=='d/m/Y' AND $fecha==''){ $fecha = date('d/m/Y'); }
			if($formato=='Y/m/d' AND $fecha==''){ $fecha = date('Y/m/d'); }

			if($formato == 'd-m-Y' AND $fecha<>''){ $fecha = date('d-m-Y', strtotime($fecha)); }
			if($formato == 'Y-m-d' AND $fecha<>''){ $fecha = date('Y-m-d', strtotime($fecha)); }

			if($formato == 'd/m/Y' AND $fecha<>''){ $fecha = date('d/m/Y', strtotime($fecha)); }
			if($formato == 'Y/m/d' AND $fecha<>''){ $fecha = date('Y/m/d', strtotime($fecha)); }

			if($formato == 'd-m-Y / g:i:s A' AND $fecha<>''){ $fecha = date('d-m-Y / g:i:s A', strtotime($fecha)); }
		}
		
		return($fecha);
	}

	function verificar($cadena){
		if($cadena=='' OR $cadena=='Ninguno'){
			$cadena = '<span style="color: darkgrey">Ninguno</span">';
		}else{
			$cadena = Convertir($cadena);
		}
		
		return($cadena);
	}

	function moneda($monto, $simbolo){
		$monto = str_replace(',', '', $monto);
		$monto = number_format($monto, 2, ".", ",");
		
		if($simbolo==''){ // Si no tiene simbolo le coloca Q.0.00
			$monto = "Q.".$monto;
			
		}elseif($simbolo=='x'){ // Si el simbolo tiene x queda 0.00
			$monto = $monto;
			
		}elseif($simbolo==','){ // Si trae coma se la quita y queda 0000.00
			$monto = str_replace(',', '', $monto);
			$monto = number_format($monto, 2, ".", "");
			
		}else{
			if($monto=='0.00'){
				$monto = "<font color='#cccccc'><b>$simbolo</b> $monto</font>";
			}else{
				$monto = "<b>$simbolo</b> $monto";
			}
		}
		
		return($monto);
	}

	function telefono($cadena, $input){
		if($input=='input'){
			if($cadena==''){
				$cadena = '0000-0000';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10); 
				$cadena = substr($cadena, -8, -4)."-".substr($cadena, -4);
			}
		}else{
			if($cadena==''){
				$cadena = '<span style="color: #BBBBBB"><i class="glyphicon glyphicon-phone-alt"></i> 0000-0000</span">';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10); 
				$cadena = '<i class="glyphicon glyphicon-phone-alt" style="color: #BBBBBB"></i> '.substr($cadena, -8, -4)."-".substr($cadena, -4);
			}
		}
		
		return($cadena);
	}

	function celular($cadena, $input){
		if($input=='input'){
			if($cadena==''){
				$cadena = '0000-0000';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10); 
				$cadena = substr($cadena, -8, -4)."-".substr($cadena, -4);
			}
		}else{
			if($cadena==''){
				$cadena = '<span style="color: #BBBBBB"><i class="glyphicon glyphicon-phone"></i> 0000-0000</span">';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10); 
				$cadena = '<i class="glyphicon glyphicon-phone" style="color: #BBBBBB"></i> '.substr($cadena, -8, -4)."-".substr($cadena, -4);
			}
		}
		
		return($cadena);
	}

	function dpi($cadena, $input){
		if($input=='input'){
			if($cadena==''){
				$cadena = '0000-00000-0000';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10); 
				$cadena = substr($cadena,-14,-9)."-".substr($cadena,-9,-4)."-".substr($cadena,-4);
			}
		}else{
			if($cadena==''){
				$cadena = '<span style="color: darkgrey">0000-00000-0000</span">';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10); 
				$cadena = substr($cadena,-14,-9)."-".substr($cadena,-9,-4)."-".substr($cadena,-4);
			}
		}
		
		return($cadena);
	}

	function ruta($cadena){

		if($cadena=='Ninguno, Ninguno'){
			$cadena = '<span style="color: #BBBBBB"><i class="glyphicon glyphicon-road"></i> Ninguno, Ninguno</span">';
		}else{
			$cadena = '<i class="glyphicon glyphicon-road" style="color: #BBBBBB"></i> '.Convertir($cadena);
		}

		return($cadena);
	}

	function nit($cadena, $input){
		if($input=='input'){
			if($cadena==''){
				$cadena = '0000000-0';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10);
				$cadena = substr($cadena,0,strlen($cadena)-1)."-".substr($cadena,-1,1);
			}
		}else{
			if($cadena==''){
				$cadena = '<span style="color: darkgrey">0000000-0</span">';
			}else{
				$cadena = intval(preg_replace('/[^0-9]+/', '', $cadena), 10);
				$cadena = substr($cadena,0,strlen($cadena)-1)."-".substr($cadena,-1,1);
			}
		}

		return($cadena);
	}

	function porcentaje($v1, $v2){
		$valor_total = ($v1);
		$valor_restante = ($v2);

		$valor_nuevo = ($valor_total-$valor_restante);
		$valor_nuevo = ($valor_nuevo/$valor_total)*100;
		$valor_nuevo = number_format($valor_nuevo, 0, ",", ".");
		
		return($valor_nuevo);
	}
?>