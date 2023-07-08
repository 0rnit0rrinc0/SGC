<?php

require_once '../../config/conexion.php';
require_once '../clases/funcionario.class.php';
require_once '../clases/solicitud.class.php';
require_once '../clases/estados.class.php';


$objconexion = new Conexion();
$objconexion->conexion;

$q = "SELECT * FROM estado WHERE ID_Solicitud = '" . $_REQUEST["id"] . "' ";
$q2 = "SELECT * FROM solicitud WHERE ID_Solicitud = '" . $_REQUEST["id"] . "' ";
$busqueda = $objconexion->conexion->query($q);

if ($resultado = mysqli_fetch_assoc($busqueda)) {
}

$busqueda2 = $objconexion->conexion->query($q2);
if ($resultado2 = mysqli_fetch_assoc($busqueda2)) {
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
    <script src="../../view//js/tabs.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>DETALLE - SGC</title>

</head>

<body>
    <div>
        <div class="scrollmenu">
            <div class="header">
                <img class="logo" src="../../view/img/logoimo.png" alt="municipalidad" height="75px" width="75px">
            </div>
            <a href="bienvenida.php">Bienvenida</a>
            <a class="active" href="equiposenviados.php">Seguimiento</a>
            <a href="solicitud.php">Nueva solicitud</a>
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
            <h1>Seguimiento de solicitud N°<?php echo $resultado2['ID_Solicitud'] ?></h1>
            <!-- <a href="javascript:history.back();">Volver</a> -->
            <hr>
            <label><b>RUT</b></label>
            <br>
            <input type="text" maxlength="12" name="rut" value="<?php echo $_SESSION['rut']; ?>" readonly>
            <br>
            <label><b>Solicitud</b></label>
            <input type="text" name="solicitud" value="<?php echo $resultado2['solicitud']; ?>" readonly>
            <br>
            <hr>
            <div class="table-centrado">
                <table id="example" class="display" style="width:80%">
                    <thead>
                        <tr>
                            <th>ID Solicitud</th>
                            <th>Estados</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $objestados = new Estados();

                            $listadoequipos = $objestados->obtenerEstadosRegistradosF($resultado['ID_Solicitud']);

                            if ($listadoequipos == true) {
                                while ($mostrar = $listadoequipos->fetch_assoc()) {
                                    $fEstado = explode('-', $mostrar['fecha']);
                            ?>
                                    <td><?php echo $mostrar['ID_Solicitud'] ?></td>
                                    <td><?php echo $mostrar['estado'] ?></td>
                                    <td><?php echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></td>
                        </tr>
                            <?php
                                }
                            } else {
                                echo '<tr>
                                <td colspan="3" >Aún no se ha notificado ningún estado. Por favor esperar.</td>
                                </tr>';
                            }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../view//js/maindata.js"></script>
</body>

</html>