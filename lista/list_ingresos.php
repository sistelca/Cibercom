<?php
session_start();

echo "<pre>";
// Reporte para reporte detallado de ingresos diarios
$titulo = 'Ingresos Diarios:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp desde '.$_POST['fecha_1'];
$titulo.='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp hasta '.$_POST['fecha_2'];
echo "<h3 align='center' class='style1'> $titulo </h3>";

echo "<div align='center'>";
echo "<table bgcolor='#ECF8E0' border='1'>";

echo "<tr>";
echo "<th  scope='col'><div align='center'>Fecha</div></th>";
echo "<th  scope='col'><div align='center'>Nombres y Apellidos</div></th>";
echo "<th  scope='col'><div align='center'>Cedula</div></th>";
echo "<th  scope='col'><div align='center'>Direccion</div></th>";
echo "<th  scope='col'><div align='center'>Telefono</div></th>";
echo "<th  scope='col'><div align='center'>Monto</div></th>";
echo "<th  scope='col'><div align='center'>Anfit.</div></th>";
echo "</tr>";

//////////////////////
include_once("pedirlistado.php");


$mont_recau = 0;

$entrada = new SimpleXMLElement('/tmp/ingresos.xml', null, true);

foreach($entrada->ingreso as $ingreso) {

	$estotal = strrpos($ingreso->TeloTot, 'tal');
	if($estotal>0) {
		$resaltado_inicio='<div align=center> <b>';
		$resaltado_fin ='</b> </div>';
	} else {
		$resaltado_inicio='<div align=center>';
		$resaltado_fin ='</div>';
		$mont_recau+=$ingreso->Monto;	
	}


	echo "<tr>";
		echo "<td>". $ingreso->Fecha ."</td>";
		echo "<td>". $ingreso->Nombre ."</td>";
		echo "<td>". $ingreso->Cedula ."</td>";
		echo "<td>". $ingreso->Direccion ."</td>";
		echo "<td>". $resaltado_inicio .$ingreso->TeloTot . $resaltado_fin ."</td>";
		echo "<td>". $resaltado_inicio .$ingreso->Monto . $resaltado_fin ."</td>";
		echo "<td>". $ingreso->Anfit ."</td>";
	echo "</tr>";
}

echo "</table>";
echo "<br />";

echo "<div align='right'> <b> Total Recaudado = $mont_recau </b> </div>\n";
echo "<br />";
echo "</pre>";

?>