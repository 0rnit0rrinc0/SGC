<?php


session_start();

if (isset($_SESSION['rut'])) {
  if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '3') {
    header("Location: controller/tecnico/bienvenida.php ");
  }
  if ($_SESSION['rol'] == '2') {
    header("Location: controller/funcionario/bienvenida.php ");
  }
} else {
  session_unset();
  session_destroy();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="view/css/diselogin.css" rel="stylesheet" media="screen">
  <title>INGRESO - SGC</title>
  <script src="view/js/sgc.js"></script>
  <script src="view/js/alert.js"></script>
</head>

<body>
  <form action="model/validacion.php" method="post">
    <div class="imgcontainer">
      <img src="view/img/Logo_Municipalidad.jpg" alt="Avatar" class="avatar" height="200px" width="250px">
    </div>
    <div>
      <?php
      if (isset($_GET['error']) && ($_GET['error'] == "1")) {
      ?>
        <div class="alert">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
          El rut o la contraseña ingresada no es valida, verifique.
        </div>
      <?php
      }
      if (isset($_GET['g']) && ($_GET['g'] == "registrocompleto")) {
      ?>
        <div class="alert success">
          <span class="closebtn">&times;</span>
          <strong>¡Registro exitoso!</strong> Inicie sesión con sus credenciales ingresadas anteriormente.
        </div>

      <?php
      }

      ?>
    </div>
    <div class="container">
      <label for="uname"><b>RUT (sin puntos y con dígito verificador)</b></label>
      <br>
      <input type="text" maxlength="12" required oninput="checkRut(this)" id="uname" placeholder="Ingrese RUT" name="rut" required>
      <br>

      <label for="psw"><b>Contraseña</b></label>
      <input type="password" placeholder="Ingrese contraseña" name="psw" id="psw" required>

      <button type="submit">Ingresar</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <span class="psw">¿No tiene cuenta? <a href="controller/registrar.php">Registrese</a></span>
    </div>
  </form>

  <script src="view/js/alerts.js"></script>
</body>

</html>