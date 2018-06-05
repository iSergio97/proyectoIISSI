<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Comprobar letra DNI</title>
    <link rel="stylesheet" href="css/listaOrdenada.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>

  </head>
  <body>
<script>
$(document).ready(function() {
  $("#compDNI").on('click', function() {
    calcularLetraDNI(compDNI.value);
  });
});

</script>
<div id="boton">
<p>Introduzca su DNI</p>
<form class="" action="calcularLetraDNI.php" method="post">
<input type="text" name="compDNI"> <button id="compDNI" type="button" name="button" class="btn btn-info">Comprobar</button>
</form>
</div>
  </body>
</html>
