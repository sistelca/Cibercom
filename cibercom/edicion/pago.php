<?php 

$mostrar=false;
$historico=false;

include_once("cliente.php");
$cantdad = $datos_basico_val[5]; // cuota mensual viene de cliente.php (5) posicion en arreglo
$fepago = $datos_adic_val[0][2];
$apago = substr($fepago, 0, 4);
$mpago = substr($fepago, 5, 2);
$dpago = substr($fepago, 8, 2);

echo "<form id='regpago' name='regpago' method='post' action='' onsubmit='RefrescaPago(); return false'>";

echo  "<div style='margin-left:30%;width:40%;float:left;'>";
echo "<b>Cuota cancelar: </b></br>";

echo "<input type='radio' name='cuotas' value='10' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 10 dias</br>";
echo "<input type='radio' name='cuotas' value='15' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 15 dias</br>";
echo "<input type='radio' name='cuotas' value='20' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 20 dias</br>";
echo "<input type='radio' name='cuotas' value='25' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 25 dias</br>";
echo "<input type='radio' name='cuotas' value='30' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 1 mes</br>";
echo "<input type='radio' name='cuotas' value='60' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 2 meses</br>";
echo "<input type='radio' name='cuotas' value='90' onclick='daTotal(this.value,$cantdad/30,$apago,$mpago,$dpago);'> 3 meses</br>";

echo "</div>";

echo "<div style='float:rigth;'>";
echo "</br></br></br></br>";
echo "Total a Cancelar Bf."." &nbsp";
echo "<input type='hidden' name='cantidad' />";
echo "<input type='hidden' value='$fepago' name='fechpag' />";
echo "<input type='text' name='total' size='4' style='border:none; color:#000000; background-color: transparent; ' disabled /> </br>";
echo "Fech. prox. pag."." &nbsp";
echo "<input type='text' name='fven' size='10' style='border:none; color:#000000; background-color: transparent; ' disabled /> \n";

echo "&nbsp"."&nbsp"."&nbsp"."&nbsp ";
echo "<input name=registrar type=submit id=registrar value='Confirmar' /> \n";
echo "<br>";
echo "</div>";
echo "</form>";
echo "<br>";
?>