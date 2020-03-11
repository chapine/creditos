<script>
	function selecOp()
		{
			var op=document.getElementById("cuotas");
			var tt=document.getElementById("interes");

			if (op.selectedIndex==0)tt.value="20"; //  1
			if (op.selectedIndex==1)tt.value="40"; //  2
			if (op.selectedIndex==2)tt.value="60"; //  3
			if (op.selectedIndex==3)tt.value="80"; //  4
			if (op.selectedIndex==4)tt.value="100"; //  5
			if (op.selectedIndex==5)tt.value="120"; //  6
			if (op.selectedIndex==6)tt.value="140"; //  7
			if (op.selectedIndex==7)tt.value="160"; //  8
			if (op.selectedIndex==8)tt.value="180"; //  9
			if (op.selectedIndex==9)tt.value="200"; //  10
			if (op.selectedIndex==10)tt.value="220"; //  11
			if (op.selectedIndex==11)tt.value="240"; //  12
			if (op.selectedIndex==12)tt.value="260"; //  13
			if (op.selectedIndex==13)tt.value="280"; //  14
			if (op.selectedIndex==14)tt.value="300"; //  15
			if (op.selectedIndex==15)tt.value="320"; //  16
			if (op.selectedIndex==16)tt.value="340"; //  17
			if (op.selectedIndex==17)tt.value="360"; //  18
			if (op.selectedIndex==18)tt.value="380"; //  19
			if (op.selectedIndex==19)tt.value="400"; //  20
			if (op.selectedIndex==20)tt.value="400"; //  21
			if (op.selectedIndex==21)tt.value="400"; //  22
			if (op.selectedIndex==22)tt.value="400"; //  23
			if (op.selectedIndex==23)tt.value="400"; //  24
		}
	
		document.getElementById("interes").value="20";
</script>
<select name="cuotas" id="cuotas" class="form-control custom-select" onchange="selecOp()">
	<option value="4">(4) semanas</option>
	<option value="8">(8) semanas</option>
	<option value="12">(12) semanas</option>
	<option value="16">(16) semanas</option>
	<option value="20">(20) semanas</option>
	<option value="24">(24) semanas</option>
	<option value="28">(28) semanas</option>
	<option value="32">(32) semanas</option>
	<option value="36">(36) semanas</option>
	<option value="40">(40) semanas</option>
	<option value="44">(44) semanas</option>
	<option value="48">(48) semanas</option>
	<option value="52">(52) semanas</option>
	<option value="56">(56) semanas</option>
	<option value="60">(60) semanas</option>
	<option value="64">(64) semanas</option>
	<option value="68">(68) semanas</option>
	<option value="72">(72) semanas</option>
	<option value="76">(76) semanas</option>
	<option value="80">(80) semanas</option>
	<option value="84">(84) semanas</option>
	<option value="88">(88) semanas</option>
	<option value="92">(92) semanas</option>
	<option value="96">(96) semanas</option>
</select>