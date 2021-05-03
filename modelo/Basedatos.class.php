<?php
class Database  
{  
	private $micon;
	private $usuario;
	private $esok;
	private $buscar;
	private $resultado;

	public function conectar($validar=true) {  
		$micon = new mysqli("localhost", "root", "prometea2008", "clientes"); // pruebas en clitem
		if ($micon->connect_errno) {
			echo "Fallo al contenctar a MySQL: " . $micon->connect_error;
		}

		if($validar) {
			$usuario = $_SESSION['n_log'];
			$esok = $_SESSION['admin_t'];

			$buscar = "SELECT * FROM usuarios WHERE nom_log='$usuario'";
			$resultado = $micon->query($buscar);
			$fila = $resultado->fetch_assoc();
			
			if($fila["permiso"]==$esok) {
				return $micon;
			} else {
				$_SESSION['autenticado']=0;
				$this->desconectar($micon);
				echo "<script type='text/javascript'> location.href='../'; </script>";
			}
			
		} else {
			return $micon;
		}
	}  

	public function desconectar($conex) {
		$conex->close();
	}
}

class Guardia extends Database
{
	protected $usesion;
	private $buscar;
	private $actualiza;
	private $confirma;

	public function __construct() {
		$this->usesion = parent::conectar(false);
	}

	public function buscarusuario($usuario) {
		$buscar = "SELECT * FROM usuarios WHERE nom_log='$usuario'";
		$resultado = $this->usesion->query($buscar);
		return $resultado->fetch_assoc();
	}

	public function confirmausuario($mi_ip, $temp, $usuario) {
		$confirma = "UPDATE usuarios SET ip='$mi_ip', permiso='$temp'";
		$confirma.= "WHERE nom_log='$usuario'";
		$this->usesion->query($confirma);
	}

	public function findeconex() {
		parent::desconectar($this->usesion);
	}
} 

class Buscador extends Database
{
	protected $ulistado;
	private $buscador;
	private $paquete;

	public function __construct() {
		$this->ulistado = parent::conectar();
	}

	public function consultaclientesnombre($nombre, $apellido, $direccion) {

		$buscador = "SELECT * FROM datos_per WHERE (nom_apell LIKE '%$nombre%' AND"; 			
		$buscador.=" nom_apell LIKE '%$apellido%') OR (direcc LIKE '%$direccion%') "; 			
		$buscador.=" ORDER BY nom_apell";
		return $buscador;
	}

	public function consultaclientesfecha($fecha) {

		$buscador = "SELECT * FROM datos_per, datos_red WHERE fech_pag<'$fecha' and";
		$buscador.= " datos_per.coduser=datos_red.coduser"; 
		$buscador.= " GROUP BY datos_per.coduser ORDER BY nom_apell";
		return $buscador;
	}

	public function buscarycargarvalores($buscar)  {
		$resultado = $this->ulistado->query($buscar);

		$opcion=array();
		$cd_user=array();

		while ($fila = $resultado->fetch_assoc()):
			$opcion[]=$fila["nom_apell"]."-------->".$fila["direcc"];
			$cd_user[]=$fila["coduser"];
		endwhile;
		$i=count($cd_user);
		$paquete = array($opcion, $cd_user, $i);

		return $paquete;
	}

	public function crearusuario() {
		// crear registro de cliente

		$que1 = "INSERT INTO datos_per VALUES()";


		$this->ulistado->query("BEGIN;"); // inicio de transaccion

		$ok1 = $this->ulistado->query($que1);

		if ($ok1) {
			$this->ulistado->query("COMMIT;");
		} else {
			$this->ulistado->query("ROLLBACK;");
		}

		// buscar nuevo registro y cargar codigo de usuario
		$nuevocodigo = "SELECT coduser FROM datos_per WHERE nom_apell='nuevo usuario' and cedula='99.999.999'";
		$resultado = $this->ulistado->query($nuevocodigo);
		$fila = $resultado->fetch_assoc();
		$usuario = $fila["coduser"];


		//seleccionar registro vacio para amarre ip-mac
		$iplibre = "SELECT * FROM datos_red WHERE coduser=0 and dir_ip like '192.168.45.%' LIMIT 1";
		$registro = $this->ulistado->query($iplibre);
		$reglibre = $registro->fetch_assoc();
		$ipdispo = $reglibre["dir_ip"];

		// actualizar registro seleccionado para amarreip-mac

		$que2 = "UPDATE datos_red SET fech_pag='2008-01-01', coduser = '$usuario' WHERE dir_ip='$ipdispo'";

		// iniciar registro de bitacora o historial de pagos
		$que3 = "INSERT INTO histori_pags (coduser, fech_pag, cant_Bf, fech_venc,";
		$que3.= " anfit, cod) VALUES ($usuario, '2008-01-01', 0, '2008-01-31',";
		$que3.= " '192.168.35.69', 'luis')";

		$this->ulistado->query("BEGIN;"); // inicio de transaccion

		$ok2 = $this->ulistado->query($que2);
		$ok3 = $this->ulistado->query($que3);


		if ($ok2 and $ok3) {
			$this->ulistado->query("COMMIT;");
		} else {
			$this->ulistado->query("ROLLBACK;");
		}

		return $usuario;
	}


	public function findeconex() {
		parent::desconectar($this->ulistado);
	}
}

class Cliente extends Database
{
	protected $ucliente;
	private $buscador;
	private $basica;
	private $adicional;
	public $desbloquear;

	public function __construct() {
		$this->ucliente = parent::conectar();
		$this->desbloquear = false; //alerta de desbloquear cliente en sistema
	}

	public function consultaycarga_xdir_cliente($tdirec,$dirabuscar) {
		$buscador_es = "SELECT datos_red.fech_pag, datos_per.nom_apell, datos_per.direcc,";
		$buscador_es.= " datos_per.fech_ing, datos_per.cuota FROM datos_red, datos_per WHERE ";
		$buscador_es.="datos_red.$tdirec LIKE '%$dirabuscar%' AND datos_red.coduser=datos_per.coduser";
		$resultado = $this->ucliente->query($buscador_es);
		$info_es = $resultado->fetch_assoc();
		return $info_es;
 	}

	public function consulta_basica_cliente($codigo, $editar = false) {
		if ($editar) {
			$buscador_bas = "SELECT * FROM datos_per WHERE coduser=$codigo ORDER BY coduser";
		} else {
			$buscador_bas = "SELECT * FROM datos_per, histori_pags WHERE";
			$buscador_bas.= " datos_per.coduser='$codigo' AND histori_pags.coduser='$codigo'";
			$buscador_bas.= " AND datos_per.fech_ing=histori_pags.fech_pag";
		}
		return $buscador_bas;
	}

	public function consulta_pc_cliente($codigo) {
		$buscador_adic = "SELECT * FROM datos_red WHERE coduser='$codigo'";
		return $buscador_adic;
	}

	public function consulta_hitorica_cliente($codigo) {
		$buscador_hist = "SELECT * FROM histori_pags WHERE coduser='$codigo'";
		$buscador_hist.= " ORDER BY fech_venc DESC LIMIT 3";
		return $buscador_hist;
	}

	public function buscarycargardatos($d_basica, $d_adicional, $d_historica, $editar = false)  {
		$resultado1 = $this->ucliente->query($d_basica);
		$resultado2 = $this->ucliente->query($d_adicional);
		$resultado3 = $this->ucliente->query($d_historica);

		$info_basica = $resultado1->fetch_assoc();
		$mx_long_ba = array();
		$mx_long_ad = array();
		$long_mac = 17;  // longitud de direccion fisica

		//Etiquetas dependientes de campos de bd

		if (!$editar) {
			$etique = array('Codigo de Usuario', 'Nombre', 'Cedula', 'Direccion', 'Telefono',
			'Cuota Mensual (Bs.F)', 'Prepago hasta', 'Ultimo pago');

			//Info de campos de db
			$info_depu = array($info_basica['coduser'], $info_basica['nom_apell'], 
			$info_basica['cedula'], $info_basica['direcc'], $info_basica['telef'], 
			$info_basica['cuota']);

			// Calculos basados en campos de bd
			$info_depu[] = $this->etiq_estado($info_basica["fech_ven"]);
			$info_depu[] = $this->ulti_pago($info_basica["fech_ing"], $info_basica["cant_Bf"]);

			$etiq_adic = array("IP", "MAC");

		} else {

			$etique = array('Codigo de Usuario', 'Nombre', 'Cedula', 'Direccion', 'Telefono',
			'Cuota Mensual (Bs.)');

			//Info de campos de db
			$info_depu = array($info_basica['coduser'], $info_basica['nom_apell'], 
			$info_basica['cedula'], $info_basica['direcc'], $info_basica['telef'], 
			$info_basica['cuota']);

			$etiq_adic = array("Subred", "MAC");
			$mx_long_ba = array(40, 15, 45, 15, 6);
		}

		$info_adic = array(); //acumulador de datos de pc

		while ($fila = $resultado2->fetch_assoc()):
			$info_adic[]=array($fila['dir_ip'], $fila['dir_mac'], $fila['fech_pag']);
		endwhile;

		$etiq_hist = array("Fecha", "Monto (Bs)", "Fecha Corte");
		$info_hist = array(); //acumulador de datos historico de pago cliente

		while ($fila = $resultado3->fetch_assoc()):
			$info_hist[]=array($fila['fech_pag'], $fila['cant_Bf'], $fila['fech_venc']);
		endwhile;

		$paquete = array($etique, $info_depu, $etiq_adic, $info_adic, $etiq_hist, $info_hist, $mx_long_ba, $long_mac);

		return $paquete;
	}

	private function etiq_estado($fecha) {
		date_default_timezone_set("America/Caracas");
		$tcon = "<font color='#088A08'> ACTIVO </font>";
		$f_tmp=strtotime("now");
		$fecan1=date("Y-m-d",$f_tmp);

		$fpago=$fecha;
		$dia=substr($fpago, 8, 2);
		$mes=substr($fpago, 5, 2);
		$ao=substr($fpago, 0, 4);
		$data1=strtotime($mes."/".$dia."/".$ao);
		$data2=strtotime("today");

		$fref=date("d/m/Y",$data1);

		// Compara fechas procesadas
		if ($data1<=$data2) {
			$tcon = "<font color='#FF0000'> BLOQUEADO</font>";
		}

		return $fref.' -----> '.$tcon;
	}

	private function ulti_pago($ingreso, $cantidad) {
		$tmp = $ingreso;
		$dia=substr($tmp, 8, 2);
		$mes=substr($tmp, 5, 2);
		$ao=substr($tmp, 0, 4);
		$tmp = $dia."/".$mes."/".$ao;
		$tmp1 = $cantidad;
		return $tmp.' -----> '.$tmp1;
	}

	public function alertacambio() {
		$this->desbloquear = true;
		$que_desbl = "UPDATE indica SET cambio=1"; //alerta de cambio al sistema debloqueo
                $ok = $this->ucliente->query($que_desbl);
	}

	public function que2dic(...$querys) {
		include_once("./modelo/query2json.php");
		$queplus = "INSERT INTO  Actzl (instruc, firma)";
		$datos_guardados = procesa($querys);
		$firma = sha1($datos_guardados);
 		$queplus.= " VALUES ('$datos_guardados', '$firma')";
		return $queplus;
	}

	public function guardarpago( $fereg, $codcliente, $fecan1, $totalcnt, $c_prxcrt, $admin_r) {

		$ip_bs = $_SERVER['REMOTE_ADDR'];
		$val_or = "$ip_bs=='192.168.35.69' or $ip_bs=='192.168.45.221' or $ip_bs='192.168.45.225'";
		$val_or.= " or $ip_bs=='192.168.45.222' or $ip_bs=='192.168.45.224'";

		if ($val_or) {

			//rpgo ="'fereg': $fereg, 'codcliente': $codcliente, 'totalcnt': $totalcnt, 'c_prxcrt': $c_prxcrt";
			/*
			$datos_guardados = json_encode(array(
			     "datos_red" => array(
			                  "op" => "UPDATE",
			                  "fields" => array(
			                                    'fech_pag' => $fereg)),
			     "histori_pags" => array(
			                   "op" => "INSERT INTO",
			                   "fields" => array(
			                                     'coduser'=> $codcliente,
			                                     'fech_pag'=> $fecan1,
			                                     'cant_Bf'=> $totalcnt,
			                                     'fech_venc'=> $c_prxcrt)),
			     "datos_per" => array(
			     		   "op" => 'UPDATE',
			     		   "fields" => array('fech_ing' => $fecan1,
			                                     'fech_ven' => $c_prxcrt))));
			// fin de diccionario */

			$que1 = "UPDATE datos_red SET fech_pag='$fereg' WHERE coduser='$codcliente'";

			$que2 = "INSERT INTO histori_pags (coduser, fech_pag, cant_Bf, fech_venc,";
			$que2.= " anfit, cod) VALUES ($codcliente, '$fecan1', $totalcnt, '$c_prxcrt',";
			$que2.= " '$ip_bs', '$admin_r')";

			$que3 = "UPDATE datos_per SET fech_ing='$fecan1', fech_ven='$c_prxcrt'";
			$que3.= " WHERE coduser='$codcliente'";

			//$firma = sha1($datos_guardados);

			//$que4 = "INSERT INTO  Actzl (instruc, firma) VALUES ('$datos_guardados', '$firma')";
			// proposal
			$que4 = $this->que2dic($que1, $que2, $que3);
			// esta ok en clitem


			$this->ucliente->query("BEGIN;"); // inicio de transaccion

			$ok1 = $this->ucliente->query($que1);
			$ok2 = $this->ucliente->query($que2);
			$ok3 = $this->ucliente->query($que3);

			//$ok4 = true;
			$ok4 = $this->ucliente->query($que4);

			if ($ok1 and $ok2 and $ok3 and $ok4) {
				$this->ucliente->query("COMMIT;");
			} else {
				$this->ucliente->query("ROLLBACK;");
			}

		}

	}

	public function guardaredicionbas($cambio, $coduser, $posicion_col) {

		switch ($posicion_col) {
		    case 1:
			$campo  = "nom_apell";
		        break;
		    case 2:
                        $campo  = "cedula";
		        break;
		    case 3:
                        $campo  = "direcc";
		        break;
		    case 4:
			$campo  = "telef";
			break;
		    case 5:
			$campo  = "cuota";
			break;
		}

		$que  = "update datos_per set $campo='$cambio' where coduser='$coduser'";
		$ok   = $this->ucliente->query($que);
	}

	public function guardamac($nuevamac, $fecha, $usuario, $subred) {
		$que ="update datos_red set dir_mac='$nuevamac', fech_pag='$fecha', coduser='$usuario'";
		$que.=" where dir_ip like '$subred%' and coduser=0 limit 1";
		if (!($this->ucliente->query($que))) {
			die ("No hay Ip disponibles en la subred");
		}
	}

	public function modificarmac($nuevamac, $ipdestino) {
		$que = "update datos_red set dir_mac='$nuevamac' where dir_ip='$ipdestino'";
		$ok = $this->ucliente->query($que);
	}

	public function borrarmac($ipdestino) {
		$que = "update datos_red set dir_mac='00:00:00:00:00:00', fech_pag='2008-01-01', coduser=0";
		$que.= " where dir_ip='$ipdestino'";
		$ok = $this->ucliente->query($que);
	}

	public function macvalida($ip, $mac) {
		$existe = $this->ucliente->query("SELECT * FROM datos_red WHERE dir_mac='$mac'");

		if ($fila = $existe->fetch_assoc()) {
			if ( $ip!=$fila['dir_ip']) {
				return false;
			}
		}

		return true;
	}

	public function guardarborrado( $cuser, $fve_act, $fegua, $fve_ant, $fpa_ant) {

		$que1="delete from histori_pags where coduser='$cuser' and fech_venc='$fve_act'";
		$que2="update datos_red set fech_pag='$fegua' where coduser='$cuser'";
		$que3="update datos_per set fech_ven='$fve_ant', fech_ing='$fpa_ant' where coduser='$cuser'";

		$this->ucliente->query("BEGIN;"); // inicio de transaccion

		$ok1 = $this->ucliente->query($que1);
		$ok2 = $this->ucliente->query($que2);
		$ok3 = $this->ucliente->query($que3);

		$ok4 = true;

		if ($ok1 and $ok2 and $ok3 and $ok4) {
			$this->ucliente->query("COMMIT;");
		} else {
			$this->ucliente->query("ROLLBACK;");
		} 

		$this->alertacambio();
	}

	public function findeconex() {
		parent::desconectar($this->ucliente);
	}
}

class Reporte extends Database
{
	protected $listado;
	private $buscador;
	private $paquete;

	public function __construct() {
		$this->listado = parent::conectar();
	}

	public function genconecta2xml() {

		$buscar = "select datos_per.nom_apell, datos_per.direcc, datos_per.fech_ven, ";
		$buscar.= "conecta2.ip, conecta2.nun_conx from datos_per, conecta2 ";
		$buscar.= "where datos_per.coduser=conecta2.coduser ";
		$buscar.= "order by substring(conecta2.ip, 1, 10), datos_per.direcc";
		
		$resultado = $this->listado->query($buscar);
		
		$salida_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$salida_xml.= "<informacion>\n";		

		while ($fila = $resultado->fetch_assoc()):
    		$salida_xml .= "\t<cliente>\n";
    		$salida_xml .= "\t\t<Nombres_Apellidos>" . $fila['nom_apell'] . "</Nombres_Apellidos>\n";
    		$salida_xml .= "\t\t<Direccion>" . $fila['direcc'] . "</Direccion>\n";
    		$salida_xml .= "\t\t<Dir_IP>" . $fila['ip'] . "</Dir_IP>\n";
    		$salida_xml .= "\t\t<Num_Conex>" . $fila['nun_conx'] . "</Num_Conex>\n";
    		$salida_xml .= "\t\t<Fe_Ven>" . $fila['fech_ven'] . "</Fe_Ven>\n";
   		$salida_xml .= "\t</cliente>\n";
		endwhile;

		$salida_xml .= "</informacion>\n\r";

		$xmlobj=new SimpleXMLElement($salida_xml);
		$xmlobj->asXML("/tmp/conecta2.xml");
		
	}

	public function geningresosxml($fecha1,$fecha2) {
		$k=0;
		
		$buscar="SELECT histori_pags.fech_pag, histori_pags.coduser, histori_pags.cant_Bf, ";
		$buscar.="histori_pags.anfit, datos_per.coduser, datos_per.nom_apell, datos_per.cedula, ";
		$buscar.="datos_per.direcc, datos_per.telef from histori_pags, datos_per ";
		$buscar.="where fech_pag>='$fecha1' AND fech_pag<='$fecha2' AND ";
		$buscar.="histori_pags.coduser=datos_per.coduser ORDER BY histori_pags.fech_pag";
		
		$resultado = $this->listado->query($buscar);
		
		$salida_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$salida_xml.= "<informacion>\n";
		
		$fch_fit='01/01/2008';
		$mont_dia=0;		

		while ($fila = $resultado->fetch_assoc()):
			$fref = $this->converfecha($fila['fech_pag']);
			$fechimp='';
	
			if ($fch_fit!=$fref) {
				$fechimp=$fref;
				if ($k>1) {
					$salida_xml .= "\t<ingreso>\n";
					$salida_xml .= "\t\t<Fecha>" . '' . "</Fecha>\n";					
					$salida_xml .= "\t\t<Nombre>" . '' . "</Nombre>\n";
					$salida_xml .= "\t\t<Cedula>" . '' . "</Cedula>\n";
					$salida_xml .= "\t\t<Direccion>" . '' . "</Direccion>\n"; 
					$salida_xml .= "\t\t<TeloTot>" . 'Total' . "</TeloTot>\n"; 
					$salida_xml .= "\t\t<Monto>" . $mont_dia . "</Monto>\n";
					$salida_xml .= "\t\t<Anfit>" . '' . "</Anfit>\n";
					$salida_xml .= "\t</ingreso>\n";
				}
					$mont_dia=0;
			}
			
			$mont_dia+= $fila['cant_Bf'];
			$fch_fit=$fref;

			$anfisal=substr($fila['anfit'], 8, 6);
			if (strlen($anfisal)==0) {
				$anfisal='Serv';
			}
			$k++;
			$monto=$fila['cant_Bf'];
			
			
			$salida_xml .= "\t<ingreso>\n";
			$salida_xml .= "\t\t<Fecha>" . $fechimp . "</Fecha>\n";					
			$salida_xml .= "\t\t<Nombre>" . $fila['nom_apell'] . "</Nombre>\n";
			$salida_xml .= "\t\t<Cedula>" . $fila['cedula'] . "</Cedula>\n";
			$salida_xml .= "\t\t<Direccion>" . substr($fila['direcc'], 0, 25) . "</Direccion>\n"; 
			$salida_xml .= "\t\t<TeloTot>" . $fila['telef'] . "</TeloTot>\n"; 
			$salida_xml .= "\t\t<Monto>" . $monto . "</Monto>\n";
			$salida_xml .= "\t\t<Anfit>" . $anfisal . "</Anfit>\n";
			$salida_xml .= "\t</ingreso>\n";
		endwhile;

		$salida_xml .= "\t<ingreso>\n";
		$salida_xml .= "\t\t<Fecha>" . '' . "</Fecha>\n";					
		$salida_xml .= "\t\t<Nombre>" . '' . "</Nombre>\n";
		$salida_xml .= "\t\t<Cedula>" . '' . "</Cedula>\n";
		$salida_xml .= "\t\t<Direccion>" . '' . "</Direccion>\n"; 
		$salida_xml .= "\t\t<TeloTot>" . 'Total' . "</TeloTot>\n"; 
		$salida_xml .= "\t\t<Monto>" . $mont_dia . "</Monto>\n";
		$salida_xml .= "\t\t<Anfit>" . '' . "</Anfit>\n";
		$salida_xml .= "\t</ingreso>\n";

		$salida_xml .= "</informacion>\n\r";

		$xmlobj=new SimpleXMLElement($salida_xml);
		$xmlobj->asXML("/tmp/ingresos.xml");
		
	}

	public function genstatusxml($j, $cmp_lst, $g_dir, $g_cuo1, $g_cuo2, $g_fep, $estado, $campo) {
		$buscar = "SELECT * FROM datos_per WHERE direcc like '$g_dir' AND cuota>=$g_cuo1 ";
		$buscar.= "AND cuota<=$g_cuo2 AND fech_ven>=date('$g_fep') AND $estado ORDER BY $campo";

		$resultado = $this->listado->query($buscar);
		
		$xml = new DomDocument('1.0', 'UTF-8');
		$listado = $xml->createElement('listado');
		$listado = $xml->appendChild($listado);

		while ($fila = $resultado->fetch_assoc()):

    		$cliente = $xml->createElement('cliente');
    		$cliente = $listado->appendChild($cliente);

			for ($i = 0; $i<$j; $i++) {
				$tmp = $cmp_lst[$i];

				switch ($tmp) {

					case 'fech_ven':case 'fech_ing':
						$fref = $this->converfecha($fila[$tmp]);

		   			$etique = $xml->createElement($tmp,$fref);
    					$etique = $cliente->appendChild($etique);
						
						break;

					default:
		   			$etique = $xml->createElement($tmp,$fila[$tmp]);
    					$etique = $cliente->appendChild($etique);
				}

			}

		endwhile;

    	$xml->formatOutput = true;
    	$el_xml = $xml->saveXML();
    	$xml->save('/tmp/estatus.xml');

//echo "<p><b>El XML ha sido creado.... Mostrando en texto plano:</b></p>".
//         htmlentities($el_xml)."<br/><hr>";


	}
	
	private function converfecha($fch_tmp) {
			date_default_timezone_set("America/Caracas");
			$dia=substr($fch_tmp, 8, 2);
			$mes=substr($fch_tmp, 5, 2);
			$ao=substr($fch_tmp, 0, 4);
			$data1=strtotime($mes."/".$dia."/".$ao);
			$fref=date("d/m/Y",$data1);
			return $fref;
	}

	public function findeconex() {
		parent::desconectar($this->listado);
	}

}

?>
