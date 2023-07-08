<?php

require_once("../../config/conexion.php");
require_once "../clases/funcionario.class.php";
require_once "../clases/estados.class.php";

//Seguridad de paginacion

session_start();
$varsesion = $_SESSION['rut'];
if ($varsesion == null || $varsesion = '') {
    header("Location: ../../view/index.html");
    die();
}

$nuser = $_SESSION['nombre'];
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
    <link href="../../view/css/mantenimiento.css" rel="stylesheet" media="screen">
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
    <div class="table-centrado">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "exitoso")) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Solicitud Exitosa!</strong> La solicitud ha sido ingresada de manera exitosa.
            </div>
        <?php
        }
        ?>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Fecha</th>
                    <th>Estados</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $objfuncionario = new Funcionario();

                    $listadoequipos = $objfuncionario->obtenerEquipos($_SESSION['nombre']);

                    if ($listadoequipos) {
                        while ($mostrar = $listadoequipos->fetch_assoc()) {
                            $fEstado = explode('-', $mostrar['fecha']);
                    ?>
                            <td><?php echo $mostrar['ID_Solicitud'] ?></td>
                            <td><?php echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></td>

                            <?php

                            $objestados = new Estados();

                            $nestados = $objestados->obtenerNEstados($mostrar['ID_Solicitud']);

                            if ($nestados) {
                            ?>
                                <td><a class="link_edit" href="detalleF.php?id=<?php echo $mostrar["ID_Solicitud"]; ?>">Hacer seguimiento...</a></td>
                            <?php
                            } else {
                                echo '<tr>
                                <td colspan="3" >No existen solicitudes realizadas..</td>
                                </tr>';
                            }

                            ?>


                </tr>
        <?php
                        }
                    } else {
                        echo '<tr>
                    <td colspan="3" >Aún no ha ingresado ninguna solicitud.</td>
                    </tr>';
                    }
        ?>
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="../../view/js/maindata.js"></script>
    <script src="../../view//js/tabs.js"></script>
    <script src="../../view/js/sgc.js"></script>
    <script src="../../view/js/alerts.js"></script>
</body>

</html>