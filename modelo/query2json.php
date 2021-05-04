<?php
//ini_set('display_errors','On');

function subcadena($query, $li, $ls='todo') {
	if (!strpos($query, $li)){
		return '';
	}
	$posi = strpos($query, $li)+strlen($li);
	if ( $ls != 'todo') {
		$poss = strpos($query, $ls);
	} else {
		$poss = strlen($query);
	}
	return substr($query, $posi, $poss-$posi);
}

function buscar($query, $elementos) {
	foreach ($elementos as $elemento) {
		if ( stristr($query, $elemento) ) {
			return $elemento;
		};
	}
	return '';
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
    $set = subcadena($query,  $instrucions[$accion][0],  $instrucions[$accion][1]);
    $filtro = subcadena($query,  $instrucions[$accion][1]);
    
    $locdic = [$tabla => ['op' => $accion, 'set' => $set, 'filtro' => $filtro]];
    return $locdic;
}


function procesa($querys) {
    $dicquery = array();
    
    foreach ($querys as $query) {
    
    	$tbla = fragmenta(strtolower($query));
    	array_push($dicquery, $tbla);
    };

    $par_dic = json_encode($dicquery);
    $par_dic  = str_replace("},{", ", ", $par_dic);
    $pru = json_decode($par_dic);
    return str_replace("'", "\'", json_encode($pru[0]));
}

?>
