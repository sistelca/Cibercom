<?php
//ini_set('display_errors','On');

function subcadena($query, $li, $ls='todo') {
	$query1 = strtolower($query);
	if (!strpos($query1, $li)){
		return '';
	}
	$posi = strpos($query1, $li)+strlen($li);
	if ( $ls != 'todo') {
		$poss = strpos($query1, $ls);
	} else {
		$poss = strlen($query1);
	}
	return substr($query, $posi, $poss-$posi);
}

function buscar($query, $elementos) {
	foreach ($elementos as $elemento) {
		if ( stristr($query, $elemento)) {
			$strtmp = stristr($query, $elemento);
			return substr($strtmp, 0, strlen($elemento));
		}
	}
}

function listkeys($array) {
    $actions = array();
    foreach ($array as $clave => $valor) {
    	$actions[] = $clave;
    }
    return $actions;
}


function fragmenta($query) {
// todo query en este caso estara definido
//  por tabla + accion + set + filtro
    
    // parametros
    $tablas = array('datos_per', 'datos_red', 'histori_pags');
    
    $instrucions = [ 'update' => ['set', 'where'],
                     'insert into' => ['(', ') values'],
                     'delete from' => ['where', 'todo']
                    ];

    $acciones = listkeys($instrucions);

    $tabla = buscar($query, $tablas);
    $accion = buscar($query, $acciones);
    $set = subcadena($query,  $instrucions[strtolower($accion)][0],  $instrucions[strtolower($accion)][1]);
    $filtro = subcadena($query,  $instrucions[strtolower($accion)][1]);
    
    $locdic = [$tabla => ['op' => $accion, 'set' => $set, 'filtro' => $filtro]];
    return $locdic;
}


function procesa($querys) {
    $dicquery = array();
    
    foreach ($querys as $query) {
    
    	$tbla = fragmenta($query);
    	array_push($dicquery, $tbla);
    };

    $par_dic = json_encode($dicquery);
    $par_dic  = str_replace("},{", ", ", $par_dic);
    $pru = json_decode($par_dic);
    return str_replace("'", "\'", json_encode($pru[0]));
}

?>
