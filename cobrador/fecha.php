<?php
	// funcion suma los dias a la feha ignorando los domingos
	function FechaPago($fecha, $dias)
	{
		for ( $i = 1 ; $i <= $dias; $i ++) {
			$cuota = $i;

			$registrado_fin = strtotime("+$i day", strtotime($fecha));
			$registrado_fin = date('Y-m-d' , $registrado_fin );

			$registrado_fin2 = strtotime("+$i day", strtotime($fecha)) ;
			$registrado_fin2 = date ('D', $registrado_fin2 );

			if ($registrado_fin2 !='Sun'){}
			else{$dias = $dias + 1;}
		}

		return $registrado_fin;
	}

	// Funcion para contar días
	function SumarDia($fecha1, $fecha2)
	{
		$fecha1 = strtotime($fecha1);
		$fecha2 = strtotime($fecha2);
		$dias=0;

		for($fecha1; $fecha1 <= $fecha2; $fecha1 = strtotime('+1 day ' . date('Y-m-d',$fecha1)))
		{
			if((strcmp(date('D',$fecha1),'Sun')!=0))
			{
				//echo date('Y-m-d D',$fecha1) . '<br />'; 
				$dias++;
			}
		}
		return $dias-1;
		//FechaPago(date("Y-m-d"), "1");
	}	

	// Funcion para contar semanas
	function CalcularSemana($fecha1, $fecha2)
	{
		$fecha1 = strtotime($fecha1);
		$fecha2 = strtotime($fecha2);
		$dias=0;

		for($fecha1; $fecha1 <= $fecha2; $fecha1 = strtotime('+7 day ' . date('Y-m-d',$fecha1)))
		{
			if((strcmp(date('D',$fecha1),'Sun')!=0))
			{
				//echo date('Y-m-d D',$fecha1) . '<br />'; 
				$dias++;
			}
		}
		return $dias-1;
		//FechaPago(date("Y-m-d"), "1");
	}




	# PARAMETROS:
	# $fecha_nacimiento - Fecha de nacimiento de una persona.
	#
	# $fecha_control - Fecha actual o fecha a consultar.
	#
	#
	# EJEMPLO:
	# tiempo_transcurrido('22/06/1977', '04/05/2009');
	#
	function tiempo_transcurrido($fecha_nacimiento, $fecha_control)
	{
	   $fecha_actual = $fecha_control;
	   
	   if(!strlen($fecha_actual))
	   {
		  $fecha_actual = date('d/m/Y');
	   }
	   // separamos en partes las fechas 
	   $array_nacimiento = explode ( "/", $fecha_nacimiento ); 
	   $array_actual = explode ( "/", $fecha_actual ); 
	
	   $anos =  $array_actual[2] - $array_nacimiento[2]; // calculamos años 
	   $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
	   $dias =  $array_actual[0] - $array_nacimiento[0]; // calculamos días 
	
	   //ajuste de posible negativo en $días 
	   if ($dias < 0) 
	   { 
		  --$meses; 
		  //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
		  switch ($array_actual[1]) { 
			 case 1: 
				$dias_mes_anterior=31;
				break; 
			 case 2:     
				$dias_mes_anterior=31;
				break; 
			 case 3:  
				if (bisiesto($array_actual[2])) 
				{ 
				   $dias_mes_anterior=29;
				   break; 
				} 
				else 
				{ 
				   $dias_mes_anterior=28;
				   break; 
				} 
			 case 4:
				$dias_mes_anterior=31;
				break; 
			 case 5:
				$dias_mes_anterior=30;
				break; 
			 case 6:
				$dias_mes_anterior=31;
				break; 
			 case 7:
				$dias_mes_anterior=30;
				break; 
			 case 8:
				$dias_mes_anterior=31;
				break; 
			 case 9:
				$dias_mes_anterior=31;
				break; 
			 case 10:
				$dias_mes_anterior=30;
				break; 
			 case 11:
				$dias_mes_anterior=31;
				break; 
			 case 12:
				$dias_mes_anterior=30;
				break; 
		  } 
	
		  $dias=$dias + $dias_mes_anterior;
	
		  if ($dias < 0)
		  {
			 --$meses;
			 if($dias == -1)
			 {
				//$dias = 30;
			 }
			 if($dias == -2)
			 {
				//$dias = 29;
			 }
		  }
	   }
	
	   //ajuste de posible negativo en $meses 
	   if ($meses < 0) 
	   { 
		  --$anos; 
		  $meses=$meses + 12; 
	   }
	   
	   
	   if ($anos < 0)
	   {
		   $tiempo[0] = 0;
		   $tiempo[1] = 0;
		   $tiempo[2] = 0;
	   }
	   else
	   {
		   $tiempo[0] = $anos;
		   $tiempo[1] = $meses;
		   $tiempo[2] = $dias;
	   }
	   
	   return $tiempo;
	}

	function bisiesto($anio_actual){ 
	   $bisiesto=false; 
	   //probamos si el mes de febrero del año actual tiene 29 días 
		 if (checkdate(2,29,$anio_actual)) 
		 { 
		  $bisiesto=true; 
	   } 
	   return $bisiesto; 
	}
?>