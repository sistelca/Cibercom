<?php
$_SESSION = array();
session_destroy();
session_start();
//ini_set('display_errors','On');

if(isset($_POST['salir'])) {
	$_SESSION['autenticado']=0;
	include_once("./opciones.php");
	return;
}

// VALIDAR USUARIO

$mi_ip=$_SERVER['REMOTE_ADDR'];
$usuario=trim($_POST['usuario']);
$pwdus=$_POST['clave'];

include_once("../modelo/Basedatos.class.php");

$conexion = new Guardia();

$fila = $conexion->buscarusuario($usuario);
$_SESSION['intento']+=1;

if (md5($pwdus)==$fila['clv_psw']) {
	$temp1=rand().rand();
	$_SESSION['admin_t']=md5($usuario.$temp1);
	$_SESSION['n_log']=$usuario;
	$temp=$_SESSION['admin_t']; 
	$conexion->confirmausuario($mi_ip='', $temp, $usuario);
	$_SESSION['autenticado']=1;
	$_SESSION['ingreso']=1;
} else {
	$_SESSION['autenticado']=0;
}
$conexion->findeconex();
include_once("./opciones.php");
?>
