<?php 
//ini_set('display_errors','On');

$mostrar=false;
$historico=true;

include_once("cliente.php");

echo "<form id='borrar' name='borrar' method='post' action='' onsubmit='RefrescaBorra(); return false;'>";

echo "<table align='center' border='0'>";

echo "<tr>";
echo "<th  colspan='3' align='center' > Historico de Pagos (3) </th>";
echo "</tr>";

echo "<tr>";
echo "<th align='center' > $datos_hist_eti[0] </th>";
echo "<th align='center' > $datos_hist_eti[1] </th>";
echo "<th align='center' > $datos_hist_eti[2] </th>";
echo "<th align='center' > Borrar </th>";
echo "<th align='center' >  </th>";
echo "</tr>";

$fepag = array();
$monto = array();
$fvenc = array();

for ($i = 0; $i < $cdat_his; $i++) {
	$fepag[] = $datos_hist_val[$i][0];
	$monto[] = $datos_hist_val[$i][1];
	$fvenc[] = $datos_hist_val[$i][2];


	
	echo "<tr>";
	echo "<td align='center' bgcolor='#dddddd'> $fepag[$i] </td>";
	echo "<td align='center' bgcolor='#f2f2f2'> $monto[$i] </td>";
	echo "<td align='center' bgcolor='#dddddd'> $fvenc[$i] </td>";
	echo "<td align='center' bgcolor='#f2f2f2'>";

	$cfepag=implode("|", $fepag);
	$cfvenc=implode("|", $fvenc);

	echo "<input type='hidden' value='$cfepag' name='cfepag' />";
	echo "<input type='hidden' value='$cfvenc' name='cfvenc' />";

	if ($i==0) {
		echo "<input title='Borrar' type='image'  src='../imagens/equis.png' alt='Borrar_Pago' width='15' height='15' />";
	}

	echo "</td>";
	echo "</tr>";
}

echo "</table>";

echo "<br>";

echo "</form>";

echo "<br>";

?>
