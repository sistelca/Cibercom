<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Informes</title>

<link rel="stylesheet" href="../estilos/estilo.css" type="text/css">

<style type="text/css">
<!--

.oneColLiqCtrHdr #container {
	width: 85%;  /* this will create a container 80% of the browser width */
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
.oneColLiqCtrHdr #header {
	background: #DDDDDD; 
	padding: 0 10px 0 20px;  /* this padding matches the left alignment of the elements in the divs that appear beneath it. If an image is used in the #header instead of text, you may want to remove the padding. */
}
.oneColLiqCtrHdr #header h1 {
	margin: 0; /* zeroing the margin of the last element in the #header div will avoid margin collapse - an unexplainable space between divs. If the div has a border around it, this is not necessary as that also avoids the margin collapse */
	padding: 10px 0; /* using padding instead of margin will allow you to keep the element away from the edges of the div */
}
.oneColLiqCtrHdr #mainContent {
	padding: 0 20px; /* remember that padding is the space inside the div box and margin is the space outside the div box */
	background: #FFFFFF;
}
.oneColLiqCtrHdr #footer { 
	padding: 0 10px; /* this padding matches the left alignment of the elements in the divs that appear above it. */
	background:#DDDDDD;
} 
.oneColLiqCtrHdr #footer p {
	margin: 0; /* zeroing the margins of the first element in the footer will avoid the possibility of margin collapse - a space between divs */
	padding: 10px 0; /* padding on this element will create space, just as the the margin would have, without the margin collapse issue */
}
body,td,th {
	font-size: 100%;
}
.style1 {color: #0000FF}


form {
position:relative;
overflow:hidden;
margin:0;
/*padding:.5em .5em .5em .5em;*/
}
-->

</style>

<script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript" src="../js/scal.js"></script>
<script type="text/javascript" src="../js/genreport.js"></script>
<script type="text/javascript" src="../js/calendario1.js"></script>
<link href="../estilos/scal.css" media="screen" rel="stylesheet" type="text/css" >

</head>


<body class="oneColLiqCtrHdr">


<div style="border-radius: 15px;" id="container">

<table style="border-collapse: collapse;" align="center" width="600">
<tr><th colspan="4" align="center" bgcolor="#EFF2FB"> Reportes Clientes </th></tr>
<tr>
	<th align="center" bgcolor="#EFF8FB"> Estatus</th>
	<th align="center" bgcolor="#EFF2FB"> Conectados </th>
	<th rowspan="1" align="center" bgcolor="#ECF8E0"> Ingresos </th>
	<th rowspan="1" align="center" bgcolor="#dddddd"> Salir </th>
<tr>
	<td bgcolor="#EFF8FB">
		<form name="form1" action="" onsubmit="MuestraInfo('1'); return false" >
		<label>
		<p align="center">
		<input name="envia" type="submit" value="Cuentas" class="button" />
		</p>
		</label>
		</form>
	</td>

	<td bgcolor="#EFF2FB">
		<form name="form1" action="" onsubmit="ListaConex(); return false">
		<label>
		<p align="center">
		<input name="envia" type="submit" value="Ahora" class="button" />
		</p>
		</label>
		</form>
	</td>

	<td bgcolor="#ECF8E0">
		<form name="form2" action="" onsubmit="MuestraInfo('2'); return false">
		<label>
		<p align="center">
		<input name="envia" type="submit" value="Diarios" class="button" />
		</p>
		</label>
		</form>
	</td>

	<td bgcolor="#dddddd">
		<form name="form3" action="" onsubmit="location.href='../'; return false;" >
		<label>
		<p align="center">
		<input name="salir" type="submit" value="Salir" class="button" />
		</p>
		</label>
		</form>
	</td>
</tr>
</table> 

<hr>
<div id="estado" style="display:none;border-radius:15px;"> <?php include_once("frm_status.php") ?> </div>
<div id="ingresos" style="display:none;border-radius:15px;"> <?php include_once("frm_ingres.php") ?> </div>
<div id="listado">  </div>

<!-- end #container --> </div>
