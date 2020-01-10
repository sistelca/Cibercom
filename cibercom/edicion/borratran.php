<?php 
session_start();

//ini_set('display_errors','On');
date_default_timezone_set("America/Caracas");

if ($_SESSION['n_log']!='luis') {
	echo "<script type='text/javascript'>
		alert('No tiene permiso para borrar esta transaccion...');
	</script>";
	$mostrar=true;
	$historico=false;
	include_once("cliente.php");

} else {

	include_once("../modelo/Basedatos.class.php");

	$cuser = $_SESSION['cod_usu'];

	$fepag = explode("|", $_POST['cfepag']);
	$fvenc = explode("|", $_POST['cfvenc']);

	$fve_act = date("Y-m-d",strtotime($fvenc[0]));
	$fve_ant = date("Y-m-d",strtotime($fvenc[1]));
	$fpa_ant = date("Y-m-d",strtotime($fepag[1]));


	//	Calculo de fecha para remplazar en datos_red
	$dia=substr($fve_ant, 8, 2);
	$mes=substr($fve_ant, 5, 2);
	$ao=substr($fve_ant, 0, 4);

	$feseg=strtotime($mes."/".$dia."/".$ao);  // fecha vencimiento anterior en segundos
	$datse=$feseg-(30*86400); // fecha vencimiento anterior menos 30 dias
	$fegua=date("Y-m-d",$datse);  // fecha a registrar en datos_red

	$cliente = new Cliente();
	$cliente->guardarborrado( $cuser, $fve_act, $fegua, $fve_ant, $fpa_ant);
	$cliente->findeconex(); 

	include_once("muestra_hist.php");
}
?>
