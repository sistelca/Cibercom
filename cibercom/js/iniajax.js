//Desarrollado por Jesus Liñán
//webmaster@ribosomatic.com
//ribosomatic.com
//Puedes hacer lo que quieras con el código
//pero visita la web cuando te acuerdes

function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function ValidaDo(origen){

	//donde se mostrará lo resultados
	divmainContent = document.getElementById('mainContent');
	//valores de los inputs
	if (origen) {
		usua=document.validador.usuario.value;
		clav=document.validador.clave.value;
		if (usua.length==0 | clav.length==0) {
			return false;
		}
	}
	//instanciamos el objetoAjax
	ajax = new objetoAjax();
	//usando del medoto POST
	//archivo que realizará la operacion
	//actualizacion.php
	divmainContent.innerHTML = "";
	ajax.open("POST", "./ingreso/acepcion.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divmainContent.innerHTML = ajax.responseText;
		}
	}
	//muy importante este encabezado ya que hacemos uso de un formulario
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	if (origen) {
		ajax.send("usuario="+usua+"&clave="+clav);
	} else {
		ajax.send("salir="+true);
	}
}
