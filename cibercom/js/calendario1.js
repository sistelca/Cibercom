var calendario7 = null;
muestra_almanaque = function(campo) {
  campo = $(campo);

  // Si no existe el campo pasado no hacemos nada
  if (campo == null) {
    return
  }
  // Primero escondemos el calendario, por si está abierto ya para otro campo
  esconde_almanaque();
  // Creamos una instancia del calendario en la variable global calendario7
  calendario7 = new scal('calendario7', nueva_date.curry(campo), {
      titleformat: 'mmm yyyy',
      closebutton: 'X',
      dayheadlength: 2,
      weekdaystart: 1
  });
  // Si el usuario ha seleccionado ya una fecha para el campo, intentamos leerla para abrir el calendario con la fecha correcta seleccionada ya
  var date = new Date(campo.readAttribute('data-date'));
  if (date.valueOf() > 0) {
    calendario7.setCurrentDate(date, true);
  }
  // Movemos el contenedor del calendario al lado del campo. !Esto sólo funciona bien si el FORM del campo tiene position:relative y el DIV calendario7 tiene position:absolute!
  var contenedor = $('calendario7');
  Position.clone($(campo), contenedor, {setWidth: false, setHeight: false, offsetLeft: campo.getWidth() + 2, offsetTop: 5+ (campo.getHeight() - contenedor.getHeight())/2});
  // Y por fin podemos mostrar el contenedor del calendario
  $('calendario7').show();
}
function esconde_almanaque() {
  // Escondemos el contenedor del calendario y eliminamos el calendario creado por la librería scal
  $('calendario7').hide();
  if (calendario7 != null) {
    calendario7.destroy();
    calendario7 = null;
  }
}
function nueva_date(campo, fecha){
  // Cambiamos el valor del campo a la nueva fecha con un formato especial
  $(campo).setValue(fecha.format('dd-mm-yyyy'));
  // Tambien guardamos la fecha en un formato estandard en un atributo creado por nosotros en el campo. Esto nos sirve para poder abrir el calendario con la fecha correcta si el usuario vuelve a hacer clic en el campo
  $(campo).writeAttribute('data-date', fecha.format('yyyy/mm/dd'));
  esconde_almanaque();
} 
