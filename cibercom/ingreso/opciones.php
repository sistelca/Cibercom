<?php
//session_start();
//ini_set('display_errors','On');

if ($_SESSION['intento']>0) {
	$fallo = $_SESSION['intento'];
} else {
	$fallo = 0;
}
if ($_SESSION["autenticado"]==1) {
	$bienve = $_SESSION['n_log'];
	if ($_SESSION["ingreso"]==1) {
		echo "<p><b><font color=#0000FF> * Bienvenido $bienve * </font></b></p>\n";
		$_SESSION['ingreso']=0;
		$_SESSION['intento']=0;
	}
	include_once("oprinc.html");
} 	else {

	if ($fallo ==0) {
		include_once("ingreso.html");
	} elseif ($fallo>=1 and $fallo<=3) {
		echo "<p><center><b><font color='#DF0101'>usuario/clave fallido</font></b></center></p>";
		include_once("ingreso.html");
	} else {
		echo "<p><center><b><font color='#DF013A'>usuario/demasiados intentos fallidos</font></b></center></p>";
		die("*** :( ***");
	}
}
?>
