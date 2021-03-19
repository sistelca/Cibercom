<?php
session_start();
// ini_set('display_errors','On');

include_once("../modelo/Basedatos.class.php");

$ncuest = $_SESSION['cod_usu']; // cliente a procesar

$cliente = new Cliente();

$consulta_dp = $cliente->consulta_basica_cliente($ncuest, true);
$consulta_dt = $cliente->consulta_pc_cliente($ncuest);
$consulta_dh = $cliente->consulta_hitorica_cliente($ncuest);

$datos_cliente = $cliente->buscarycargardatos($consulta_dp, $consulta_dt, $consulta_dh, true);

$cliente->findeconex();

$etiq_bas = $datos_cliente[0]; // etiquetas para mostrar datos de cliente
$val_basi = $datos_cliente[1]; // datos de cliente
$bas_long = $datos_cliente[6]; // longitud de campos de datos cliente

$etiq_adi = $datos_cliente[2]; //etiqueta para datos de pc
$val_adic = $datos_cliente[3]; //datos de pc
$long_adi = $datos_cliente[7]; // longitud de campo direccion mac

$activa = array('', '', '', '', '');
$subred1 =  array('', '','', '', '');
$subred2 = array('', '','', '', '');

$v_ip = array('', '', '', '', '');
$v_mac = array('', '', '', '', '');

$t_conx=array('', '');


//Cargar datos tecnicos (del pc del usuario)

$n_pcs = count($val_adic); 


for ($i = 0; $i < $n_pcs; $i++) {
	$activa[$i] = 'CHECKED';
	$v_ip[$i] = $val_adic[$i][0];	//ip
	$v_mac[$i] = $val_adic[$i][1];	//mac
	$fepa = $val_adic[$i][2];	//fecha de pago

	if (substr($v_ip[$i], 0, 11)=='192.168.40.') {
		$subred1[$i]='SELECTED'; //Estandar 192.168.40.*(codificacion del select)
	}
	elseif (substr($v_ip[$i], 0, 11)=='192.168.45.'){
		$subred2[$i]='SELECTED'; //Alta 192.168.45.* 	(codificacion del select)
	} 
}

?>
