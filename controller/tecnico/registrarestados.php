<?php

require_once "../../config/conexion.php";
require_once "../clases/solicitud.class.php";
require_once "../clases/tecnico.class.php";

//Seguridad de paginacion

session_start();
$varsesion = $_SESSION['rut'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../../index.php");
}

/* $nuser = $_SESSION['rut'];
$sql = "SELECT Rut, Nombre FROM personal WHERE rut = '$nuser'";
$resultado = $conexion->query($sql);
$row = $resultado->fetch_assoc();
 */




//$usuario = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../view/css/solicitud.css" rel="stylesheet" media="screen">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>BIENVENIDO TECNICO - SGC</title>
</head>

<body>
    <div>
        <div class="sidebar">
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
            <div class="user">
                <?php
                echo ($_SESSION['nombre']);
                echo "<br>";
                echo ($_SESSION['rut']);
                ?>
            </div>
            <a class="cerrar" href="../../model/cerrarsesion.php">Cerrar Sesión</a>
        </div>
        <div>
            <img class="logo" src="../../view/img/Logo_Municipalidad.jpg" alt="municipalidad" height="150px" width="150px">
        </div>
        <div class="container">
            <form action="../../model/insertestado.php" method="POST">
                <?php
                if (isset($_GET['error']) && ($_GET['error'] == "existente")) {
                    echo "El estado ya ha sido ingresado. Verifique.";
                }
                ?>

                <label>Seleccione ID de la solicitud a notificar</label>
                <select id="idsoli" name="idsoli">
                    <option value=""></option>
                    <?php
                    $objsolicitud = new Solicitud();

                    $listadoID = $objsolicitud->obtenerIDSolicitud();

                    if ($listadoID) {
                        while ($rows = $listadoID->fetch_assoc()) {
                    ?>
                            <option value="<?php echo $rows["ID_Solicitud"];  ?>"><?php echo $rows["ID_Solicitud"]; ?></option>
                    <?php


                        }
                    }
                    ?>
                </select>
                <br>
                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <option value=""></option>
                    <option value="recepcionado">Recepcionado</option>
                    <option value="diagnosticando">Diagnosticando</option>
                    <option value="solucionando">Solucionando</option>
                    <option value="entregado">Entregado</option>
                </select>

                <label for="tecnico">Nombre del encargado del estado</label>
                <select id="tecnico" name="tecnico">
                    <option value=""></option>
                    <?php
                    $objtecnico = new Tecnico();

                    $listadonombres = $objtecnico->obtenerTecnicos();

                    if ($listadonombres) {
                        while ($rows = $listadonombres->fetch_assoc()) {
                    ?>
                            <option value="<?php echo $rows["Nombre"];  ?>"><?php echo $rows["Nombre"]; ?></option>
                    <?php


                        }
                    }
                    ?>
                </select>

                <label for="observacion">Observación</label>
                <textarea id="observacion" maxlength="500" name="observacion" placeholder="Detalle la observación.." style="height:200px"></textarea>

                <input type="submit" value="Enviar">

            </form>
        </div>




</body>

</html>