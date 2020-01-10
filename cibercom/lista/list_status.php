<?php
session_start();
//ini_set('display_errors','On');
$edoc = $_POST['edoc'];

include_once("pedirlistado.php");

echo "<pre>";
echo "<p align='center' class='style1'>Subgrupo Seleccionado: $titulo0 </p>";
echo "<p align='center' class='style1'>$titulo1 </p>";

echo "<div align='center'>";
echo "<table bgcolor='#EFF8FB' border='1'>";
echo "<tr>";

$i = 0;
for ($i = 0; $i<$j; $i++) {
	echo "<th scope='col'><div align='center'>$t_lista[$i]</div></th>";
}

echo "</tr>";

$k=0;

$listado = simplexml_load_file('/tmp/estatus.xml');

foreach($listado->cliente as $cliente) {

	echo "<tr>";
	for ($i = 0; $i<$j; $i++) {
		echo "<td>";

		$tmp = $cmp_lst[$i];

		switch ($tmp) {
			case 'fech_ven':case 'fech_ing':
				echo "<div align='center'>".$cliente->$tmp."</div>";
				break;

			case 'cuota':
				echo "<div align='center'>".$cliente->$tmp."</div>";
				break;

			default:
				echo "<div align='left'>".$cliente->$tmp."</div>";
		}

		echo "</td>";
	}

	echo "</tr>";
	$k++;
}

echo "</table>";
echo "<br />";

echo "<div align='right'> <b> Total Casos = $k </b> </div>\n";
echo "<br />";
echo "</pre>";

?>