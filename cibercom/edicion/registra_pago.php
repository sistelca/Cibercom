<?php
session_start();
//ini_set('display_errors','On');
date_default_timezone_set("America/Caracas");

$ncanceladas = $_POST['cuotas'];   // contiene el numero (entero) de dias que ha cancelado cliente
$totalcnt = $_POST['cantidad'];
$fpago = $_POST['fechpag'];


if ( $ncanceladas>0 ) {
	include_once("../modelo/Basedatos.class.php");

	$codcliente = $_SESSION['cod_usu']; // cliente a procesar

	$f_tmp=strtotime("today");
	$fecan1=date("Y-m-d",$f_tmp);

		// fechas

	$dia=substr($fpago, 8, 2);
	$mes=substr($fpago, 5, 2);
	$ao=substr($fpago, 0, 4);

	$data1=strtotime($mes."/".$dia."/".$ao);
	$data2=strtotime("today");

	if (($data1+(30*86400))<=$data2) {
		$fareg=$data2+(($ncanceladas-30)*86400); // fecha a registrar en archivo
		$prxcrt=($data2+($ncanceladas*86400))+86400; // fecha a mostrar en pantalla

		$cambioenfw= true;

	}
	else {
		$fareg=$data1+($ncanceladas*86400); // fecha a registrar en archivo
		$prxcrt=($data1+(($ncanceladas+30)*86400))+86400; // fecha a mostrar en pantalla y guardar en historico
		$cambioenfw= false;	
	}

	$fereg=date("Y-m-d",$fareg);
	$c_prxcrt=date("Y-m-d",$prxcrt);
	$admin_r=$_SESSION['admin_t'];

	$cliente = new Cliente();
	$cliente->guardarpago( $fereg, $codcliente, $fecan1, $totalcnt, $c_prxcrt, $admin_r);

	if($cambioenfw) {	$cliente->alertacambio();}
	$cliente->findeconex();
}

$mostrar=true;
$historico=false;
include_once("cliente.php");
?>