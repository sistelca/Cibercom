function MuestraInfo(dato) {  
	$("listado").update();

	if (dato=='1') {
		$('estado').show();
		$('ingresos').hide();
	} else if (dato=='2') {
		$('estado').hide();
		$('ingresos').show();
	}
 }  

function ListaConex() {
	$('ingresos').hide();
	$('estado').hide();
	var url = './conecta2.php';

	var myConects = new Ajax.Updater( 'listado', url );  

}

ListaStatus = function () {  
	var url = './list_status.php';
	var form = $("formul"); 
	var element = form.serialize(); 
	$("estado").hide();

	var myRen = new Ajax.Updater( 'listado', url, { method: 'post', parameters: element });  
 }  

ListaIngreso = function () {  
	var url = './list_ingresos.php';
	var form = $("fechas"); 
	var element = form.serialize(); 
	$("ingresos").hide();
	var myIgres = new Ajax.Updater( "listado", url, { method: "post", parameters: element });
 } 

  Object.extend(Date.prototype, {
    monthnames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    daynames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
});

var calendario6 = null;
muestra_calendario = function(campo) {
  campo = $(campo);

  // Si no existe el campo pasado no hacemos nada
  if (campo == null) {
    return
  }
  // Primero escondemos el calendario, por si está abierto ya para otro campo
  esconde_calendario();
  // Creamos una instancia del calendario en la variable global calendario6
  calendario6 = new scal('calendario6', nueva_fecha.curry(campo), {
      titleformat: 'mmm yyyy',
      closebutton: 'X',
      dayheadlength: 2,
      weekdaystart: 1
  });
  // Si el usuario ha seleccionado ya una fecha para el campo, intentamos leerla para abrir el calendario con la fecha correcta seleccionada ya
  var date = new Date(campo.readAttribute('data-date'));
  if (date.valueOf() > 0) {
    calendario6.setCurrentDate(date, true);
  }
  // Movemos el contenedor del calendario al lado del campo. !Esto sólo funciona bien si el FORM del campo tiene position:relative y el DIV calendario6 tiene position:absolute!
  var contenedor = $('calendario6');
  Position.clone($(campo), contenedor, {setWidth: false, setHeight: false, offsetLeft: campo.getWidth() + 2, offsetTop: campo.getHeight() - contenedor.getHeight()});
  // Y por fin podemos mostrar el contenedor del calendario
  $('calendario6').show();
}
function esconde_calendario() {
  // Escondemos el contenedor del calendario y eliminamos el calendario creado por la librería scal
  $('calendario6').hide();
  if (calendario6 != null) {
    calendario6.destroy();
    calendario6 = null;
  }
}
function nueva_fecha(campo, fecha){
  // Cambiamos el valor del campo a la nueva fecha con un formato especial
  $(campo).setValue(fecha.format('dd-mm-yyyy'));
  // Tambien guardamos la fecha en un formato estandard en un atributo creado por nosotros en el campo. Esto nos sirve para poder abrir el calendario con la fecha correcta si el usuario vuelve a hacer clic en el campo
  $(campo).writeAttribute('data-date', fecha.format('yyyy/mm/dd'));
  esconde_calendario();
} 
