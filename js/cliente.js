MostrarConsulta = function(dato) {
	var element = null;

   if (dato=='1') {  // pago cliente
	var url = './pago.php';
   } else if (dato=='2') { //editar datos cliente
	var url = './frm_edicion.php';
   } else if (dato=='3') {  //mostrar datos cliente
	element = {mtec: 1, mhist: 0};
	var url = './cliente.php';
   } else if (dato=='4') {  //borrar transaccion cliente
	var url = './muestra_hist.php';
   }
   var myAjax = new Ajax.Updater( 'resultado', url, { method: 'post', parameters: element, evalScripts:true });  

}

RefrescaPago = function() {
	document.regpago.registrar.value = "Enviando...";
	document.regpago.registrar.disabled=true;
	var url = "./registra_pago.php";
	var form = $("regpago"); 

	var element = form.serialize(); 
	var n = document.regpago.cuotas.value;

	if ( !n ){
		alert("Error: Seleccione cuota");
		document.regpago.registrar.value = "Confirmar";
		document.regpago.registrar.disabled=false;
		return null
	}

	var myRefrePa = new Ajax.Updater( "resultado", url, { method: "post", parameters: element });
}

RefrescaEdicion = function() {
	var url = "./registra_edicion.php";
	var form = $("editor"); 
	var element = form.serialize(); 

	var formulariovalido = Valmac();

	if (!formulariovalido) {
		return null
	} 

	var myRefrEd = new Ajax.Updater( "resultado", url, { method: "post", parameters: element });
}

RefrescaBorra = function() {
	var borralo = confirm('Desea borrar ultimo pago?');
	if (!borralo) {
		return
	}
	var url = "./borratran.php";
	var form = $("borrar");
	var element = form.serialize();
	var myRefreBr = new Ajax.Updater( "resultado", url, { method: "post", parameters: element, evalScripts:true });
}

Valmac = function()	{    // Cortesía de http://www.ejemplode.com
	/* funcion que permite validar entradas de datos tecnicos del formulario 
	de ingreso de nuevos usuarios, o modificacion de datos de usuario, 
	la entrada de datos tecnicos a validar consiste en direccion fisica (MAC) y
	si el checkbuton activo. de la tabla del formulario
	*/

	var pr1= new Array("nom_apell", "cedula", "direcc", "telef", "cuota");
	var pr2= new Array(/^([A-Za-z ñáéíóú]{6,40})$/, /^([0-9]{1,2}.[0-9]{3}.[0-9]{3})$/, /^([0-9A-Za-z \-#º()ñáéíóú]{6,40})$/, /^([0-9]{4}-[0-9]{7})$/, /^([0-9]{4,6})$/);
	var dap = new Array();


	var uno = new Array("acti0", "acti1","acti2","acti3","acti4");
	var dos= new Array("mac0", "mac1", "mac2", "mac3", "mac4");

	var valida = true;
	var i=0;
	var j=0;
	var cuenta=0;
	var act = new Array();
	var mac = new Array();
	var tmpr = false;
	var tmpa = false;
	var tmpmac1;
	var tmpmac2;
	var form = $("editor"); 


	for (i = 0; i<=4; i++) {
		tmpuno = form[pr1[i]];
		dap[i] = $F(tmpuno);
		ra = pr2[i];
		if (ra.exec(dap[i])==null) {
			valida=false;
			alert("Datos Personales Incorrectos...");
			return valida;
		} 
	}

	if (dap[4]<30) {
		valida=false;
		alert("Monto no valido...");
		return valida;
	} 

	for (i = 0; i<=3; i++) {
		for (j =i+1; j<=4; j++) {
			tmpmac1 = form[dos[i]];
			tmpma_1 = $F(tmpmac1);

			tmpmac2 = form[dos[j]];
			tmpma_2 = $F(tmpmac2);

			if (tmpma_1 == tmpma_2 && tmpma_1.length>0) {
				alert('Error: direcciones fisicas deben ser distintas');
				valida = false;
				return valida;
			}
		}
	}

	var re=/^[\a-f0-9]{2}:[\a-f0-9]{2}:[\a-f0-9]{2}:[\a-f0-9]{2}:[\a-f0-9]{2}:[\a-f0-9]{2}$/;

	for (i=0; i<=4; i++) {

		act[i] = form[uno[i]].checked;

		mac[i] = form[dos[i]].value;

		tmpra= act[i];
		if (re.exec(mac[i])==null) {
			tmpr=false;
		} else {
			tmpr=true;
		}

		if (tmpra && tmpr)  {
			cuenta++;
		} else if  (!tmpra && !tmpr && mac[i].length==0)  {
			cuenta=cuenta+0;  // necesario else para diferenciar de anterior
		} else {
		 	valida=false;
		} 
	}

	if (!(valida && cuenta>=1)) {
		alert("Direccion fisica no valida...");
		valida = false;
	} 

	return valida; 
}

daTotal = function (par0,par1,aven,mven,dven) {
	// redondear a multiplo de 50
	var roundto = 100;
	var numero =par0*par1/roundto;
	
	//var producto = roundto*Math.round(numero);
	var producto = roundto*Math.round(numero);
	document.regpago.total.value= producto;
	document.regpago.cantidad.value= producto;

	// estimar fecha de vencimiento
	var myDate = new Date();
	var myDate1 = new Date(aven,mven,dven);
	var myDias = Math.round(par0);
	
	if (myDate>myDate1) {
		
		var dayOfMonth = myDate.getDate();
		myDate.setDate(dayOfMonth + myDias);
		document.regpago.fven.value= myDate.toLocaleDateString('en-GB');
	} else {
		var dayOfMonth = myDate1.getDate();
		myDate1.setDate(dayOfMonth + myDias+1);
		document.regpago.fven.value= myDate1.toLocaleDateString('en-GB');
	}		
}
