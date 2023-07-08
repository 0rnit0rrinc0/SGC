<?php

require_once '../../config/conexion.php';
require_once '../clases/supervisor.class.php';

$objconexion = new Conexion();
$objconexion->conexion;

$q = "SELECT * FROM solicitud WHERE ID_Solicitud = '" . $_REQUEST["id"] . "' ";
$busqueda = $objconexion->conexion->query($q);


if ($resultado = mysqli_fetch_assoc($busqueda)) {
}
$rut = (isset($resultado['Rut'])) ? $resultado['Rut'] : null;




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
    <link href="../../view/css/mantenimiento.css" rel="stylesheet" media="screen">
    <title>DETALLE - SGC</title>

</head>

<body>
    <div>
        <div class="scrollmenu">
            <div class="header">
                <img class="logo" src="../../view/img/logoimo.png" alt="municipalidad" height="75px" width="75px">
            </div>
            <a href="bienvenida.php">Bienvenida</a>
            <a href="principal.ip.php">IP</a>
            <a class="active" href="principal.solicitud.php">Solicitudes</a>
            <a href="principal.mantenimiento.php">Mantenimiento</a>
            <a href="principal.estados.php">Estado</a>
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
    </div>
    <br>
    <form action="../../model/actualizardatos.php" method="POST">
        <div class="container">
            <h1>Detalle de solicitud</h1>
            <!-- <a href="javascript:history.back();">Volver</a> -->
            <hr>
            <label><b>ID de Solicitud</b></label>
            <input type="text" name="nombre" value="<?php echo $resultado['ID_Solicitud']; ?>" readonly>
            <br>
            <label><b>RUT</b></label>
            <br>
            <input type="text" maxlength="12" name="rut" value="<?php echo $resultado['Rut']; ?>" readonly>
            <br>
            <label><b>Solicitud</b></label>
            <input type="text" name="solicitud" value="<?php echo $resultado['solicitud']; ?>" readonly>
            <br>
            <hr>
        </div>
    </form>
</body>

</html>