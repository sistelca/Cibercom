function buscarDato(bnuevo) {

	var url = "./busca.php";
	var nombrecli;
	document.clientb.nuevo.disabled=true;

	if (bnuevo) {
		nombrecli = "nuevo cliente";
		document.clientb.nuevo.value = "Ok...";
		
	} else {
		nombrecli = $F("nombre1");
	}

	if (!valnom(nombrecli)) {
		return null
	}

	var myCliente = new Ajax.Updater( "resultado", url, { method: "post", parameters: 'nombre='+nombrecli, evalScripts:true  });

}

function valnom(cadena)	{    // Cortesía de http://www.ejemplode.com

	// funcion que permite validar entrada de nombre de usuario


	var pr1= cadena;
	var pr2= /^([A-Za-z0-9 ñáéíóú]{3,20})$/;

	var valida = true;

	dap = pr1;

	if (pr2.exec(dap)==null) {
		valida=false;
		alert("Nombre no valido...");
	} 

	return valida;  
}

