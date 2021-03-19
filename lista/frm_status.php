<?php
session_start();

echo "<h3 align=center> Reporte Selectivo detallado de Clientes </h3>";

echo "<form id='formul' name='formul' method='post' action='' onsubmit='ListaStatus(); return false'>";

echo "<table bgcolor='#EFF8FB' border=1 align='center'>";
echo "<tr>";
echo "<th scope='col' align='center'>Datos de clientes</th>";
echo "<th scope='col' align='center'>Subgrupo* </th>";
echo "<th scope='col' align='center'>Orden* </th>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='nap' checked disabled /> ";
echo "Nombres y Apellidos </td>";
echo "<td align='left'>  </td>";
echo "<td align='center'> <input type='radio' name='ord' value='0' checked /> </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='ced' />";
echo "Cedula  </td>";
echo "<td align='left'>  </td>";
echo "<td align='center'> <input type='radio' name='ord' value='1' /> </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='dir' />";
echo "Direccion </td>";
echo "<td align='left'> <input name='dire' type='text' value='todos' size='6' maxlength='6' /> </td>";
echo "<td align='center'> <input type='radio' name='ord' value='2' /> </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='tel' />";
echo " Telefono  </td>";
echo "<td align='left'>  </td>";
echo "<td align='left'>  </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='fup' />";
echo " Ultimo Pago  </td>";
echo "<td align='left'>  </td>";
echo "<td align='left'>  </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='cuot' />";
echo " Cuota  </td>";
echo "<td align='left'> <input name='cuot1' type='text' value='0' size='5' maxlength='5' /> ";
echo "/"."&nbsp";
echo "<input name='cuot2' type='text' value='30000' size='5' maxlength='5' /> </td>";
echo "<td align='center'> <input type='radio' name='ord' value='3' /> </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='left'> <input type='checkbox' name='fep' />";
echo " Fecha de Vencimiento </td>";
echo "<td align='left'> ";

echo "<input name='fech' type='text' value='todas' size='10' maxlength='10' onclick='muestra_calendario(this);' /> ";

echo "<div id='calendario6' class='scal tinyscal' style='display:none;position:absolute; top:-50; left:150px;'></div>";
echo "<style>.scal .dayselected {background-color:red; color:white;}</style>";
echo "</div>";

echo "</td>";

echo "<td align='center'> <input type='radio' name='ord' value='4' /> </td>";
echo "</tr>";

echo "<td align='left'> <input type='checkbox' name='edoc' />";
echo " Estado de la conexion  </td>";
echo "<td align='left'>";
echo " <select name='stado' id='stado'>";
echo "<option value='0' selected>Activos</option> ";
echo "<option value='1' >Bloqueados</option> ";
echo "<option value='2' >Todos</option> ";
echo "</select> ";
echo "</td>";
echo "<td align='left'>  </td>";
echo "</tr>";

echo "</table>";

echo "<br />";
echo "<div align='center'> <input type='submit' name='enviado' id='enviado' value='Ok'  /> </div>";
echo "</form>";

?>

