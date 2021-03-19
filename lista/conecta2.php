<?php
session_start();
//ini_set('display_errors','On');
include_once("pedirlistado.php");

echo "<pre>";

echo "<table align='center' width='650' border='1'>";
echo "<tr style="."background-color:#F2F2F2".">";
	echo "<th  colspan='4' align='center' > Clientes Conectados </th>";
echo "</tr>";
echo "<tr style="."background-color:#F2F2F2".">";
	echo "<th width='40%' scope='col'><div align='center'>Nombres y Apellidos</div></th>";
	echo "<th width='40%' scope='col'><div align='center'>Direccion</div></th>";
	echo "<th width='15%' scope='col'><div align='center'>Dir. IP</div></th>";
	echo "<th width='5%' scope='col'><div align='center'>Nun. Conex.</div></th>";
echo "</tr>";


$pcs_conx=0;

$data2=strtotime("today");

$conecta2 = new SimpleXMLElement('/tmp/conecta2.xml', null, true);

foreach($conecta2->cliente as $cliente) {

	$pcs_conx+=1;
	$red0 = strrpos($cliente->Dir_IP, '.168.40.');
	$red1 = strrpos($cliente->Dir_IP, '.168.45.');
	
	echo '<tr>';
	
	if($red0>0) {
		$iniecho = '<td class="normal">';		
	} elseif($red1>0) {
		$iniecho = '<td class="alto">';	
	}		

	echo $iniecho .$cliente->Nombres_Apellidos. '</td>';
	echo $iniecho .$cliente->Direccion. '</td>';
	echo $iniecho .$cliente->Dir_IP. '</td>';
	echo $iniecho .'<center>'.$cliente->Num_Conex.'</center>'.'</td>';

		
	echo '</tr>';

}

echo "</table>";
echo "<br>";
echo "<div align='right'> <b> Total PC's conectadas = $pcs_conx </b> </div>\n";
echo "<br />";
echo "</pre>";

?>
