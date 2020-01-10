<?php 
if ( session_status() == PHP_SESSION_NONE ) {
    session_start();
}


//ini_set('display_errors','On');

include_once("../modelo/Basedatos.class.php");

$oculta_para_historico = 0;

if ((!isset($mostrar)) or (!isset($historico))) {
	$mostrar = $_POST['mtec'];
	$historico = $_POST['mhist'];
}


if ($historico) {
	$oculta_para_historico = 3;
}

// cliente a procesar
$codcliente = $_SESSION['cod_usu'];

$cliente = new Cliente();

$busca_basica = $cliente->consulta_basica_cliente($codcliente); 
$busca_adicional = $cliente->consulta_pc_cliente($codcliente);
$busca_historica = $cliente->consulta_hitorica_cliente($codcliente);

$datos_cliente = $cliente->buscarycargardatos($busca_basica,$busca_adicional,$busca_historica);

$datos_basico_eti = $datos_cliente[0]; // etiquetas para mostrar datos de cliente
$datos_basico_val = $datos_cliente[1]; // datos de cliente

$datos_adic_eti = $datos_cliente[2]; //etiqueta para datos de pc
$datos_adic_val = $datos_cliente[3]; //datos de pc

$datos_hist_eti = $datos_cliente[4]; //etiqueta para historico cliente
$datos_hist_val = $datos_cliente[5]; //datos historico cliente

$cdat_his = count($datos_hist_val);

// convertir cadena a fechas
for ($i = 0; $i < $cdat_his; $i++) {
	$temp1 = $datos_hist_val[$i][0];
	$temp2 = $datos_hist_val[$i][2];
	$datos_hist_val[$i][0] = date("d-m-Y",strtotime($temp1));
	$datos_hist_val[$i][2] = date("d-m-Y",strtotime($temp2));
}

$cliente->findeconex();

if (count($datos_basico_val)==0 or count($datos_adic_val)==0) {
	die("*** Busqueda fallida A ***");
}
else {
	$n_val = count($datos_basico_eti) - $oculta_para_historico;
	include_once("muestra_cliente.php");
}
?>
