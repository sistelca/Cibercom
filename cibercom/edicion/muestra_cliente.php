<?php 
echo "<table align='center' border='0'>";
echo "<tr>";
echo "<th  colspan='2' align='center' > Datos Básicos del Cliente</th>";
echo "</tr>";

for ($i = 0; $i < $n_val; $i++) {
	$etiqueta = $datos_basico_eti[$i];
	$valor = $datos_basico_val[$i]; 

	echo "<tr>";
	echo "<td align='right' bgcolor='#dddddd' > $etiqueta </td>";
	if (strrpos($etiqueta, "Mensual")>0) { //Cuota mensual
		$valor = "<b> $valor </b>";
	}
	echo "<td bgcolor='#f2f2f2'> $valor </td>";
	echo "</tr>";
}

if ($mostrar) {
	$eti1 = $datos_adic_eti[0];
	$eti2 = $datos_adic_eti[1];
	$n_val = count($datos_adic_val);

	echo "<tr>";
	echo "<th  colspan='2' align='center' > Datos Técnicos </th>";
	echo "</tr>";

	echo "<tr>";
	echo "<th align='center' > $eti1 </th>";
	echo "<th align='center' > $eti2 </th>";
	echo "</tr>";

	for ($i = 0; $i < $n_val; $i++) {
		$val1 = $datos_adic_val[$i][0];
		$val2 = $datos_adic_val[$i][1];
		echo "<tr>";
		echo "<td align='center' bgcolor='#dddddd'> $val1 </td>";
		echo "<td align='center' bgcolor='#f2f2f2'> $val2 </td>";
		echo "</tr>";
	}
}

echo "</table>";
echo "<br>";
?>
