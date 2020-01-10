<?php
session_start();
//ini_set('display_errors','On');

include_once("../modelo/Basedatos.class.php");

if (empty($_POST)) {

	if($i>0) { 

		echo "<form id='elije' name='elije' method='post' action='menuclientes.php' >";

		// Tabulador
		echo "<Blockquote> \n";

	
		echo "<select name='q_usuario' onchange='this.form.submit()' > \n";
		echo "<option value=-1 disabled selected>$mensaje</option> \n";
		for ($k=0; $k<count($cd_user); $k+=1):
			echo "<option value=$k>$opcion[$k]</option> \n";
		endfor;
		echo "</select> \n";
	
		echo "</Blockquote> \n";
	
		echo "<input type='hidden' value='$cuser' name='cd_users' />\n";
		echo "</form>";
	

	} elseif($busqueda!='nuevo cliente') {
		echo "<script language='JavaScript'> 
			alert('*** Nombre no esta en lista de clientes ***');
		</script>";
	} elseif($busqueda=='nuevo cliente') {
		// agregar cliente
		$nuevo = new Buscador();
		$codigousuario = $nuevo->crearusuario();
		$nuevo->findeconex();

		$_SESSION['cod_usu'] = $codigousuario; 

		echo "<form id='elije' name='elije' method='post' action='menuclientes.php' >";
		echo "<input type='hidden' value='-1' name='q_usuario' />\n";
		echo "</form>";
		echo "<script language='JavaScript'> 
			document.elije.submit();
		</script>";

	}

} elseif ( $_POST['q_usuario']>=0 ) {

	$cd_user=explode("|", $_POST['cd_users']);
	$posicion=$_POST['q_usuario'];
	$r_usua=$cd_user[$posicion];
	$_SESSION['cod_usu'] = $r_usua;

	Header("Location: ../edicion/cliente.html");
} else {
	Header("Location: ../edicion/cliente.html");
}
?>
