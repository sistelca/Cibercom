<?php
//ini_set('display_errors','On');
date_default_timezone_set("America/Caracas");
include_once("../modelo/Basedatos.class.php");

if (empty($_POST)) { // Generar xml conecta2

	$reporte = new Reporte();
	$reporte->genconecta2xml();
	$reporte->findeconex();
	
	
} elseif(isset($_POST['fecha_1'])) {  // Generar xml ingresos
		
	if (preg_match( '/^[\0-9]{2}-[\0-9]{2}-[\0-9]{4}$/', $_POST['fecha_1'])==0) {
		$f_tmp=strtotime("now");
	} else {
		$f_tmp=strtotime($_POST['fecha_1']);
	}
	$fecha1=date("Y-m-d",$f_tmp);

	if (preg_match( '/^[\0-9]{2}-[\0-9]{2}-[\0-9]{4}$/', $_POST['fecha_2'])==0) {
		$f_tmp=strtotime("now");
	} else {
		$f_tmp=strtotime($_POST['fecha_2']);
	}

	$fecha2=date("Y-m-d",$f_tmp);

	$f_tmp=strtotime("now");
	$hoy=date("Y-m-d",$f_tmp);

	if ($fecha2>$hoy) {
		$fecha2 = $hoy;
	}

	if ($fecha1>$fecha2) {
		$fecha1 = $fecha2;
	}
	
	$reporte = new Reporte();
	$reporte->geningresosxml($fecha1,$fecha2);
	$reporte->findeconex();
	
	
} else {

	// Generar reporte clientes-detallado

	// variables a listar
	$t_lista = array(); //encabezado de lista
	$cmp_lst = array(); //campos en la lista
	$longe = array(); //longitud de celda en tabla
	$j = 0;


	// El campo nombre y apellido siempre estara presente en este tipo de listado
	$t_lista[$j] = 'Nombre y Apellido';
	$cmp_lst[$j] = 'nom_apell';
	$longe[$j] = 40;
	$j++;

	// Activar cedula
	if ($_POST['ced']== 'on' ) {
		$t_lista[$j] = 'Cedula';
		$cmp_lst[$j] = 'cedula';
		$longe[$j] = 15;
		$j++;
	}

	// Activar direccion
	if ($_POST['dir']== 'on' ) {
		$t_lista[$j] = 'Direccion';
		$cmp_lst[$j] = 'direcc';
		$longe[$j] = 45;
		$j++;
	}

	// Activar telefono
	if ($_POST['tel']== 'on' ) {
		$t_lista[$j] = 'Telefono';
		$cmp_lst[$j] = 'telef';
		$longe[$j] = 15;
		$j++;
	}

	// Activar Ultima fecha de pago
	if ($_POST['fup']== 'on' ) {
		$t_lista[$j] = 'Ult/Pago';
		$cmp_lst[$j] = 'fech_ing';
		$longe[$j] = 11;
		$j++;
	}

	// Activar cuota
	if ($_POST['cuot']== 'on' ) {
		$t_lista[$j] = 'Cuota/Mes';
		$cmp_lst[$j] = 'cuota';
		$longe[$j] = 9;
		$j++;
	}

	// Activar Ultima fecha de vencimiento
	if ($_POST['fep']== 'on' ) {
		$t_lista[$j] = 'Fecha/Vencimiento';
		$cmp_lst[$j] = 'fech_ven';
		$longe[$j] = 11;
		$j++;
	}

	// subgrupos
	if ($_POST['dire']=='todos') {
		$g_dir='%'; 
	}
	else {
		$g_dir='%'.trim($_POST['dire']).'%';
	}

	$g_cuo1=$_POST['cuot1'];
	$g_cuo2=$_POST['cuot2'];



	if (preg_match( '/^[\0-9]{2}-[\0-9]{2}-[\0-9]{4}$/', $_POST['fech'])==0) {
		$f_tmp=strtotime('01-01-2008');
	} else {
		$f_tmp=strtotime($_POST['fech']);
	}
	$g_fep=date("Y-m-d",$f_tmp);


//	Estado de conexion

	$f_tmp=strtotime("now");
	$hoy=date("Y-m-d",$f_tmp);
	$fut="2026-09-01";

	switch ($_POST['stado']) {
	case 0:
		$estado="fech_ven>"."date('".$hoy."')";
		break;
	case 1:
		$estado="fech_ven<="."date('".$hoy."')";
		break;
	default:
		$estado="fech_ven<="."date('".$fut."')";
	}

	// orden
	$campos_orden = array('nom_apell', 'cedula', 'direcc', 'cuota', 'fech_ven');
	$i=$_POST['ord'];
	$campo=$campos_orden[$i];

//	Lo que muestra en pantalla como reporte final detallado-clientes

	$titulo0 = 'Direccion'.' = '.$_POST['dire'].'&nbsp&nbsp&nbsp&nbsp Cuota'.' = ';
	$titulo0.= $_POST['cuot1']." - ".$_POST['cuot2'];
	switch ($_POST['stado']) {
		case 0:
			$i_stado="Activos";
			break;
		case 1:
			$i_stado="Bloqueados";
			break;
		default:
			$i_stado="Todos";
		}
	$titulo1 = 'Fecha Vencimiento (dsd)'.' = '.$_POST['fech'].'&nbsp&nbsp&nbsp&nbsp Estatus';
	$titulo1.= ' = '.$i_stado;

	$reporte = new Reporte();
	$reporte->genstatusxml($j, $cmp_lst, $g_dir, $g_cuo1, $g_cuo2, $g_fep, $estado, $campo);
	$reporte->findeconex();

} 

?>