<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Comprobar letra DNI</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>

  </head>
  <body>
<script>
$(document).ready(function() {
  $("#compDNI").on('click', function() {
    letraDNI(compDNI);
  });
});
</script>
<div id="boton">
<p>Introduzca su DNI</p>
<input type="text" name="compDNI" value="Enviar"> <button id="dni" type="button" name="button" >Comprobar</button>
</div>
  </body>
</html>
