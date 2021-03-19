<?php
session_start();

//ini_set('display_errors','On');
date_default_timezone_set("America/Caracas");
include_once("../modelo/Basedatos.class.php");

$busqueda=$_POST['nombre'];
$_POST = null;



$cliente_cad='';
if (strlen(trim($busqueda))>2) {

	$conexion = new Buscador();
	
	if ($busqueda!='nuevo cliente') {
		$mensaje='<h3 align=center class=style1> Selecciona un Cliente </h3>';

		// Valida-post nombre

		$pr1= $busqueda;
		$pr2= '/^([A-Za-z0-9 ñáéíóú]{3,20})$/';

		if (preg_match( $pr2, $pr1)==0) {
			die("*** Error: Nombre no valido...");
		} 

		$cliente_cad=trim($busqueda);
		$lst_clients=explode(" ", $cliente_cad);
		$cliente_nom=$lst_clients[0];
		$cliente_apl=$lst_clients[1];
		$padir=$lst_clients[0].' '.$lst_clients[1];

		//Consultar por nombre o direccion
		$pregunta = $conexion->consultaclientesnombre($cliente_nom, $cliente_apl, $padir);

	} elseif ($busqueda=='nuevo cliente') {
		$mensaje='<h2 align=center class=style1> Clientes sin actividad los ultimos 3 meses (CAMBIAR) </h2>';

		$datalim=strtotime("now")-(120*86400);
		$fechlim=date("Y-m-d", $datalim);

		//Consular por fecha
		$pregunta = $conexion->consultaclientesfecha($fechlim);
	}

	$valores = $conexion->buscarycargarvalores($pregunta);
	$conexion->findeconex();

	$opcion = $valores[0];
	$cd_user = $valores[1];
	$i = $valores[2];

	$cuser = implode("|", $cd_user);

	include_once("menuclientes.php");
}
?>
