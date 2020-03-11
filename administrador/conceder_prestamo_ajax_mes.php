<script>
	function selecOp()
		{
			var op=document.getElementById("cuotas");
			var tt=document.getElementById("interes");

			if (op.selectedIndex==0)tt.value="15";		// 01
			if (op.selectedIndex==1)tt.value="30";		// 02
			if (op.selectedIndex==2)tt.value="45";		// 03
			if (op.selectedIndex==3)tt.value="60";		// 04
			if (op.selectedIndex==4)tt.value="75";		// 05
			if (op.selectedIndex==5)tt.value="90";		// 06


			if (op.selectedIndex==6)tt.value="105";		// 07
			if (op.selectedIndex==7)tt.value="120";		// 08
			if (op.selectedIndex==8)tt.value="135";		// 9
			if (op.selectedIndex==9)tt.value="150";		// 10
			if (op.selectedIndex==10)tt.value="165";	// 11
			if (op.selectedIndex==11)tt.value="180";	// 12
		}
	
		document.getElementById("interes").value="15";
</script>
<select name="cuotas" id="cuotas" class="form-control custom-select" onchange="selecOp()">
	<option value="23">Un mes (23 cuotas)</option>
	<option value="46">Dos meses (46 cuotas)</option>
	<option value="69">Tres meses (69 cuotas)</option>
	<option value="92">Cuatro meses (92 cuotas)</option>
	<option value="115">Cinco meses (115 cuotas)</option>
	<option value="138">Seis meses (138 cuotas)</option>
	<option value="161">Siete meses (161 cuotas)</option>
	<option value="184">Ocho meses (184 cuotas)</option>
	<option value="207">Nueve meses (207 cuotas)</option>
	<option value="230">Diez meses (230 cuotas)</option>
	<option value="253">Once meses (253 cuotas)</option>
	<option value="276">Doce meses (276 cuotas)</option>
</select>