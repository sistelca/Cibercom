<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Red Comunitaria</title>

<link rel="stylesheet" href="./estilos/estilo.css" type="text/css" />

<style type="text/css"> 



/* Tips for Elastic layouts 
1. Since the elastic layouts overall sizing is based on the user's default fonts size, they are more unpredictable. Used correctly, they are also more accessible for those that need larger fonts size since the line length remains proportionate.
2. Sizing of divs in this layout are based on the 100% font size in the body element. If you decrease the text size overall by using a font-size: 80% on the body element or the #container, remember that the entire layout will downsize proportionately. You may want to increase the widths of the various divs to compensate for this.
3. If font sizing is changed in differing amounts on each div instead of on the overall design (ie: #sidebar1 is given a 70% font size and #mainContent is given an 85% font size), this will proportionately change each of the divs overall size. You may want to adjust based on your final font sizing.
*/



</style>


<script type="text/javascript" src="./js/iniajax.js"></script> 

</head>

<body class="twoColElsLtHdr">

<div style="border-radius: 15px;width: 700px;height: 24em;padding: 0% 0;" id="container">
<div style="border-radius: 15px;height: 6em;" id="header">


<div style="text-align: center;width: 90%;padding: 1% 0;"> <h2>Red Comunitaria JJ Osuna Rodriguez</h2></div>

    <!-- end #header --></div>


<div style="border-radius: 15px;text-align: center;" id="mainContent">
<?php
session_start();
$_SESSION['intento']=0;
include_once("./ingreso/opciones.php");
?>

    <!-- end #mainContent --></div>

<!-- end #container --></div>
</body>
</html>

