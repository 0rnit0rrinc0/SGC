<?php

include("../../config/config.php");

//Seguridad de paginacion

session_start();
$varsesion = $_SESSION['rut'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../index.php");
}

$nuser = $_SESSION['nombre'];



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../view/css/bienvenida.css" rel="stylesheet" media="screen">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>SOLICITUD - SGC</title>
</head>

<body>
    <div>
        <div class="scrollmenu">
            <div class="header">
                <img class="logo" src="../../view/img/logoimo.png" alt="municipalidad" height="75px" width="75px">
            </div>
            <a href="bienvenida.php">Bienvenida</a>
            <a href="equiposenviados.php">Seguimiento</a>
            <a class="active" href="solicitud.php">Nueva solicitud</a>
            <div class="header-right">
                <a class="cerrar" href="../../model/cerrarsesion.php">Cerrar Sesión</a>
            </div>
            <div class="header-right-text">
                <?php
                echo ($_SESSION['nombre']);
                echo "<br>";
                echo ($_SESSION['rut']);
                ?>
                <br>
            </div>
        </div>
    </div>

    <div class="container">
        <div>
            <?php
            if (isset($_GET['error']) && ($_GET['error'] == "procesarsolicitud")) {
            ?>
                <div class="alert">
                    <span class="closebtn">&times;</span>
                    <strong>¡Error!</strong> Ha existido un error al procesar la solictud. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
                </div>

            <?php

            }

            ?>
        </div>
        <form action="../../model/insertsolicitud.php" method="POST">
            <label><b>R.U.T</b></label>
            <input name="rutfuncionario" type="text" value="<?php echo $_SESSION['rut']; ?> " readonly>
            <br>
            <label><b>Nombre y apellido</b></label>
            <input type="text" value="<?php echo $_SESSION['nombre']; ?> " readonly>
            <br>
            <label><b>Correo electronico</b></label>
            <input type="text" value="<?php echo $_SESSION['correo']; ?> " readonly>
            <br>
            <label><b>Departamento</b></label>
            <input type="text" value="<?php echo $_SESSION['departamento']; ?> " readonly>
            <br>
            <label for="solicitud">Solicitud:</label>
            <textarea id="solicitud" name="solicitud" placeholder="Detalle su solicitud.." style="width:100%"></textarea>

            <button type="submit" class="registerbtn">Enviar solicitud</button>

        </form>
    </div>




</body>

</html>