<?php

include("../../config/conexion.php");

//Seguridad de paginacion

session_start();
$varsesion = $_SESSION['rut'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../../index.php");
}

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
    <title>BIENVENIDO TECNICO - SGC</title>
</head>

<body>
    <nav class="nav-collapse">
        <div class="scrollmenu">
            <div class="header">
                <img class="logo" src="../../view/img/logoimo.png" alt="municipalidad" height="75px" width="75px">
            </div>
            <a class="active" href="bienvenida.php">Bienvenida</a>
            <a href="principal.ip.php">IP</a>
            <a href="principal.solicitud.php">Solicitudes</a>
            <a href="principal.estados.php">Estado</a>
            <a href="principal.mantenimiento.php">Mantenimiento</a>
            <a href="principal.recepcion.php">Entrega</a>
            <?php
            if ($_SESSION['rol'] == 3) {
            ?>
                <a href="funcionarios.php">Funcionarios</a>
            <?php
            }
            ?>
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
    </nav>

    <div>
        <img class="logo2" src="../../view/img/Logo_Municipalidad.jpg" alt="municipalidad" height="350px" width="350px">

        <div class="user">
            <?php
            if ($_SESSION['sexo'] == "Masculino") {
                echo "<h1>Bienvenido</h1>";
            } elseif ($_SESSION['sexo'] == "Femenino") {
                echo "<h1>Bienvenida</h1>";
            }
            echo ($_SESSION['nombre']);
            echo "<br>";
            echo ($_SESSION['rut']);
            ?>
        </div>
    </div>
    <script src="../../view/js/responsivemenu.js"></script>
</body>

</html>