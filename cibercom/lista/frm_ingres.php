<?php
session_start();

// Formulario para Seleccion de Report de ingresos diarios

echo "<form id='fechas' name='fechas' method='post' action='' onsubmit='ListaIngreso(); return false'>";
echo "<br />";
echo "<table align='center' bgcolor='#ECF8E0'>";
echo "<tr><th align='center' >";
echo "Fechas:";
echo "</th></tr>";
echo "<tr><td>";
//	echo "Fechas: &nbsp&nbsp&nbsp&nbsp ";
$fech_in = Date("d-m-Y");
$fech_fi = Date("d-m-Y");
echo "Desde ";
echo "<input name='fecha_1' type='text' value='$fech_in' id='fecha_1' size='10' maxlength='10' onclick='muestra_almanaque(this);' />";
echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ";
echo "Hasta ";
echo "<input name='fecha_2' type='text' value='$fech_fi' id='fecha_2' size='10' maxlength='10' onclick='muestra_almanaque(this);' />";
echo "<div id='calendario7' class='scal tinyscal' style='display:none;position:absolute; top:-50; left:150px;'></div>";

echo "<style>.scal .dayselected {background-color:red; color:white;}</style>";

echo "</td></tr>";
echo "<tr><td>";
echo "<br />";
echo "<div align='center'> <input type='submit' name='enviado' value='Ok'  /> </div>";
echo "</td><tr>";
echo "</table>";

echo "</form>";
?>
