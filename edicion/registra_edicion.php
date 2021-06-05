<?php
// ini_set('display_errors','On');

include_once("../modelo/Basedatos.class.php");

// Cargardo los valores dados en el cuestionario en variables
$mcoduser=$_POST["encues"];

// Procesando datos personales
$nap=trim($_POST["nom_apell"]);
$cdla=$_POST["cedula"];
$dirc=trim($_POST["direcc"]);
$tlf=$_POST["telef"];
$cta=$_POST["cuota"];


//Procesando datos tecnicos

// post validar datos tecnicos
//	- Falta registrar el usuario, la fecha y la hora en que se realizo el cambio

$tmp_in=$_POST["ips"];

$tmp_ip=explode("|", $tmp_in);

$fechpg=$_POST["fpa"];

$uno = array($_POST["acti0"], $_POST["acti1"], $_POST["acti2"], $_POST["acti3"], $_POST["acti4"]);
$dos = array($_POST["mac0"], $_POST["mac1"], $_POST["mac2"], $_POST["mac3"], $_POST["mac4"]);
$sbr = array($_POST["sub0"], $_POST["sub1"], $_POST["sub2"], $_POST["sub3"], $_POST["sub4"]);

for ($i=0; $i<=4; $i++) {
	

}

$valida = true;
$i=0;
$tmpmac1;

$cliente = new Cliente();

for ($i=0; $i<=4; $i++) {
	$tmpmac1=$dos[$i];
	$tmip1  = $tmp_ip[$i];
	if (strlen($tmpmac1)>0) {
		if (!$cliente->macvalida($tmip1,$tmpmac1)) {
			die("Error 2.a: Mac ya esta registrada ...");
		}
	}
}

$buscaregistro = $cliente->consulta_basica_cliente($mcoduser, true);
$buscar_pc_reg = $cliente->consulta_pc_cliente($mcoduser);
$buscar_histor =$cliente->consulta_hitorica_cliente($mcoduser);

$result = $cliente->buscarycargardatos($buscaregistro, $buscar_pc_reg, $buscar_histor, true);


$contenidobasicoregistro = $result[1];
$contenidotecnicoregistro = $result[3];

$cambio = array($nap, $cdla, $dirc, $tlf, $cta);

// Cambiar datos personales de usuario registrado

for ($i=1; $i<=5; $i++) {
	if ($cambio[$i-1] != $contenidobasicoregistro[$i]) {
		$cliente->guardaredicionbas($cambio[$i-1], $mcoduser, $i);
	}
}

// Cambiar datos tecnicos de usuario registrado


for ($i=0; $i<=4; $i++) {
	if (strlen($tmp_ip[$i])>0 and strlen($dos[$i])==0) {
		// borrar datos contenidos en esa ip (dir_mac, fech_pag, coduser)
		$cliente->borrarmac($tmp_ip[$i]);
		$cliente->alertacambio();
	} elseif (strlen($tmp_ip[$i])==0 and strlen($dos[$i])>0) {
		// buscar ip vacia en esa subred y registrar datos (dir_mac, fech_pag, coduser)
		if ($sbr[$i]==0) {
			$subnet="192.168.40.";
		}
		if ($sbr[$i]==1) {
			$subnet="192.168.45.";
		}

		$cliente->guardamac($dos[$i], $fechpg, $mcoduser, $subnet);
		$cliente->alertacambio();

	} elseif (strlen($tmp_ip[$i])>0 and strlen($dos[$i])>0) {

		// Verificar si se cambio la subred a la cual pertenece

		if ($sbr[$i]==0) {
			$subnet="192.168.40.";
		}

		if ($sbr[$i]==1) {
			$subnet="192.168.45.";
		}

		if ($subnet==substr($tmp_ip[$i], 0, 11)) {

			// no se cambio la subred y se modifico mac 

			if ($dos[$i]!=$contenidotecnicoregistro[$i][2]) {
				$cliente->modificarmac($dos[$i], $tmp_ip[$i]);
				$cliente->alertacambio();
			}
		} else {
			//registrar en nueva subred
			$cliente->guardamac($dos[$i], $fechpg, $mcoduser, $subnet);

			// borrar datos en ip actual 
			$cliente->borrarmac($tmp_ip[$i]);
			$cliente->alertacambio();
		} 
	} 
} 


//		Agregar datos de usuario nuevo
/*		else {

			mysql_query("insert into formulario (n_entrev, sexo, pc_ksa, red_ksa, hor_int, pre51, pre52, pre53, pre54, pre55, pre61, pre62, pre63, pre64, pre65, pre66, pre67, apre_usint, lic_int) values ('$coduser', '$Pre1', '$Pre2', '$Pre3', '$Pre4', '$Pre51', '$Pre52', '$Pre53', '$Pre54', '$Pre55', '$Pre61', '$Pre62', '$Pre63', '$Pre64', '$Pre65', '$Pre66', '$Pre67', '$Pre7', '$Pre8')", $link);
		} */


$cliente->findeconex();

$mostrar=true;
$historico=false;
include_once("cliente.php");

?>
