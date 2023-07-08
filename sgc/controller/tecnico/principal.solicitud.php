<?php

require_once "../../config/conexion.php";
require_once "../clases/solicitud.class.php";
require_once "../clases/personal.class.php";

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
    <title>SOLICITUD - SGC</title>
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
    </div>

    <div class="tab">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "solicitudexitosa")) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Listado de solicitudes</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nueva solicitud</button>
        <?php
        } elseif ((isset($_GET['error']) && ($_GET['error'] == "procesarsolicitud"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')">Listado de solicitudes</button>
            <button class="tablinks" onclick="openCity(event, 'registro')" id="defaultOpen">Nueva solicitud</button>
        <?php
        } else {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Listado de solicitudes</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nueva solicitud</button>
        <?php
        }
        ?>
    </div>

    <!-- Tab content -->
    <div id="listado" class="tabcontent">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "solicitudexitosa")) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Solicitud Exitosa!</strong> La solicitud ha sido ingresada de manera exitosa.
            </div>
        <?php
        }
        ?>
        <table id="example" class="display" style="width:70%">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Rut Funcionario</th>
                    <th>Fecha</th>
                    <th>Solicitud</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $objsolicitud = new Solicitud();

                $listadosolicitudes = $objsolicitud->obtenerSolicitud();

                if ($listadosolicitudes) {
                    while ($mostrar = $listadosolicitudes->fetch_assoc()) {
                        $fEstado = explode('-', $mostrar['fecha']);
                ?>
                        <tr>
                            <td><?php echo $mostrar['ID_Solicitud'] ?></td>
                            <td><?php echo $mostrar['Rut'] ?></td>
                            <td><?php echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></td>
                            <td>
                                <a class="link_edit" href="detalleT.php?id=<?php echo $mostrar["ID_Solicitud"]; ?>">Ver detalle...</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>
                            <td colspan="4" >No existen solicitudes emitidas.</td>
                            </tr>';
                }

                ?>

            </tbody>
        </table>
    </div>
    </div>

    <div id="registro" class="tabcontent">
        <div class="container">
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
            <form action="../../model/insertsolicitudtecnico.php" method="POST">

                <label><b>RUT del funcionario</b></label>
                <select id="rutfuncionario" name="rutfuncionario" required>
                    <option value="">Seleccione...</option>
                    <?php
                    $objpersonal = new Personal();

                    $listadorut = $objpersonal->obtenerRut();

                    if ($listadorut) {
                        while ($rows = $listadorut->fetch_assoc()) {
                    ?>
                            <option value="<?php echo $rows["Rut"]; ?>"> <?php echo $rows["Rut"];
                                                                            echo " - ";
                                                                            echo $rows["Nombre"]; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <br>
                <label for="solicitud"><b>Solicitud</b></label>
                <textarea id="solicitud" maxlength="500" name="solicitud" placeholder="Detalle su solicitud.." style="width:100%"></textarea>

                <input type="submit" value="Enviar" class="registerbtng">

            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="../../view/js/maindata.js"></script>
    <script src="../../view//js/tabs.js"></script>
    <script src="../../view/js/sgc.js"></script>
    <script src="../../view/js/alerts.js"></script>
</body>

</html>