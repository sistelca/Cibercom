<?php
//ini_set('display_errors','On');
include_once("edicion.php"); 

// formulario de edicion de datos del usuario
echo "<form id='editor' name='editor' method='post' action='' onsubmit='RefrescaEdicion(); return false '>";

echo "<table align='center' border='0'>";
echo "<tr>";
echo "<th  colspan='2' align='center' > Datos Básicos del Cliente</th>";
echo "</tr>";

echo "<tr>";
echo "<td align='right' bgcolor='#dddddd' > $etiq_bas[0] </td>";
echo "<td bgcolor='#f2f2f2'> $val_basi[0] </td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right' bgcolor='#dddddd' > $etiq_bas[1] </td>";
echo "<td bgcolor='#f2f2f2'>";
echo "<input name='nom_apell' type='text' value='$val_basi[1]' size='$bas_long[0]' maxlength='$bas_long[0]' />";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right' bgcolor='#dddddd' > $etiq_bas[2] </td>";
echo "<td bgcolor='#f2f2f2'>";
echo "<input name='cedula' type='text' value='$val_basi[2]' size='$bas_long[1]' maxlength='$bas_long[1]' />";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right' bgcolor='#dddddd' > $etiq_bas[3] </td>";
echo "<td bgcolor='#f2f2f2'>";
echo "<input name='direcc' type='text' value='$val_basi[3]' size='$bas_long[2]' maxlength='$bas_long[2]' />";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right' bgcolor='#dddddd'> $etiq_bas[4] </td>";
echo "<td bgcolor='#f2f2f2'>";
echo "<input name='telef' type='text' value='$val_basi[4]' size='$bas_long[3]' maxlength='$bas_long[3]' />";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td align='right' bgcolor='#dddddd'> $etiq_bas[5] </td>";
echo "<td bgcolor='#f2f2f2'>";
echo "<input name='cuota' type='text' value='$val_basi[5]' size='5' maxlength='$bas_long[5]' />";
echo "</td>";
echo "</tr>";

echo "</table>";
echo "<br>";


////////////////////////
// Encabezado de tabla de datos tecnicos

echo "<div align='center'>";
echo "<table width='220' border='1'>";

echo "<tr>";
echo "<th  colspan='3' align='center' > Datos Tecnicos </th>";
echo "</tr>";

echo "<tr>";
echo "<th width='15' scope='col'><div align='center'>Activa</div></th>";
echo "<th width='50' scope='col'>$etiq_adi[0]</th>";
echo "<th width='300' scope='col'>$etiq_adi[1]</th>"; 
echo "</tr>";

// Primera f/c de datos tecnicos (1ra compu)
echo "<tr>";
echo "<td><div align='center'><input type='checkbox' name='acti0' $activa[0] /> </div></td>";
echo "<td><div aling='center'>";
echo "<select name='sub0' >";
echo "<option value='0' $subred1[0]>Estandar</option>";
echo "<option value='1' $subred2[0]>Alta</option>"; 
echo "</select>";
echo "</div></td>";
echo "<td><div align='center'><input name='mac0' type='text' value='$v_mac[0]' size='$long_adi' maxlength='$long_adi' /></div></td>";

// Segunda f/c de datos tecnicos (2da compu)
echo "<tr>";
echo "<td><div align='center'><input type='checkbox' name='acti1' $activa[1] /> </div></td>";
echo "<td><div align='center'>";
echo "<select name='sub1' >";
echo "<option value='0' $subred1[1]>Estandar</option>";
echo "<option value='1' $subred2[1]>Alta</option>";
echo "</select>";
echo "</div></td>";
echo "<td><div align='center'><input name='mac1' type='text' value='$v_mac[1]' size='$long_adi' maxlength='$long_adi' /></div></td>";


// Tercera f/c de datos tecnicos (3ra compu)
echo "<tr>";
echo "<td><div align='center'><input type='checkbox' name='acti2' id='acti2' $activa[2]> </div></td>";
echo "<td><div align='center'>";
echo "<select name='sub2' >";
echo "<option value='0' $subred1[2]>Estandar</option>"; 
echo "<option value='1' $subred2[2]>Alta</option>";
echo "</select>";
echo "</div></td>";
echo "<td><div align='center'><input name='mac2' type='text' value='$v_mac[2]' size='$long_adi' maxlength='$long_adi' /></div></td>";

// Cuarta f/c de datos tecnicos (4ta compu)
echo "<tr>";
echo "<td><div align='center'><input type='checkbox' name='acti3' $activa[3] /> </div></td>";
echo "<td><div align='center'>";
echo "<select name='sub3' >";
echo "<option value='0' $subred1[3]>Estandar</option>";
echo "<option value='1' $subred2[3]>Alta</option>";
echo "</select>";
echo "</div></td>";
echo "<td><div align='center'><input name='mac3' type='text' value='$v_mac[3]' size='$long_adi' maxlength='$long_adi' /></div></td>";

// Quinta f/c de datos tecnicos (5ta compu)
echo "<tr>";
echo "<td><div align='center'><input type='checkbox' name='acti4' $activa[4] /> </div></td>";
echo "<td><div align='center'>";
echo "<select name='sub4' >";
echo "<option value='0' $subred1[4]>Estandar</option>";
echo "<option value='1' $subred2[4]>Alta</option>";
echo "</select>";
echo "</div></td>";
echo "<td><div align='center'><input name='mac4' type='text' value='$v_mac[4]' size='$long_adi' maxlength='$long_adi' /></div></td>";

echo "</table>";
echo "</div>";

echo "<p>";

$cap_ip=implode("|", $v_ip);
echo "<input type='hidden' value='$cap_ip' name='ips' />";
echo "<input type='hidden' value='$fepa' name='fpa' />";
echo "<input type='hidden' value=$ncuest name='encues' /> \n";

echo "<pre>";
echo "<div align='center'>";

echo "<input type='submit' name='salvar' value='Guardar/Salir' /> \n";

echo "</div>";
echo "</pre>";

echo "</form>";

?>
