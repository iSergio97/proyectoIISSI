<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sweet Modas: Página principal</title>
  </head>
  <body><?php
    if(consul($conexion, $nuevoUsuario)) {
      $_SESSION['login'] = $nuevoUsuario['email'];
      $_SESSION['login'] = $nuevoUsuario['user_name'];
    }
  ?>
    <p>Hola (nombre de usuario) <?php echo $user_name; ?>, todo está bien.</p>
    <p>Hola (email) <?php echo $email; ?>, todo está bien.</p>
    <a href="logout.php">Desconectar</a>
  </body>
</html>
