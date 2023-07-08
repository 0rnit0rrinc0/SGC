<?php

require_once "../../config/conexion.php";
require_once "../clases/mantenimiento.class.php";
require_once "../clases/solicitud.class.php";

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
    <title>MANTENIMIENTO - SGC</title>
</head>

<body>
    <div>
        <div class="scrollmenu">
            <div class="header">
                <img class="logo" src="../../view/img/logoimo.png" alt="municipalidad" height="75px" width="75px">
            </div>
            <a href="bienvenida.php">Bienvenida</a>
            <a href="principal.ip.php">IP</a>
            <a href="principal.solicitud.php">Solicitudes</a>
            <a href="principal.estados.php">Estado</a>
            <a class="active" href="principal.mantenimiento.php">Mantenimiento</a>
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
        if ((isset($_GET['g']) && ($_GET['g'] == "registroexitoso"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Mantenimientos realizados</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nuevo Mantenimiento</button>
        <?php
        } elseif (((isset($_GET['error']) && ($_GET['error'] == "mantencionregistradapreviamente"))) || ((isset($_GET['error']) && ($_GET['error'] == "problemasolicitud"))) || (isset($_GET['g']) && ($_GET['g'] == "registroexitosofm"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')">Mantenimientos realizados</button>
            <button class="tablinks" onclick="openCity(event, 'registro')" id="defaultOpen">Nuevo Mantenimiento</button>
        <?php
        } else {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Mantenimientos realizados</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nuevo Mantenimiento</button>

        <?php
        }
        ?>
    </div>

    <div id="listado" class="tabcontent">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "registroexitoso")) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Registro exitoso!</strong> La mantención se ha registrado de manera exitosa.
            </div>
        <?php
        }
        ?>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID mantenimiento</th>
                    <th>ID Solicitud</th>
                    <th>ID Equipo</th>
                    <th>Numero de serie</th>
                    <th>Ram</th>
                    <th>Almacenamiento</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $objmantencion = new Mantenimiento();

                $listadosolicitudes = $objmantencion->obtenerMantenimientos();

                if ($listadosolicitudes) {
                    while ($mostrar = $listadosolicitudes->fetch_assoc()) {
                        $fEstado = explode('-', $mostrar['fecha_manten']);
                ?>
                        <tr>
                            <td><?php echo $mostrar['ID_Mantenimiento'] ?></td>
                            <td><?php echo $mostrar['ID_Solicitud'] ?></td>
                            <td><?php echo $mostrar['ID_Equipo'] ?></td>
                            <td><?php echo $mostrar['serie_equipo'] ?></td>
                            <td><?php echo $mostrar['ram'] ?></td>
                            <td><?php echo $mostrar['almacenamiento'] ?></td>
                            <td><?php echo $mostrar['observacion'] ?></td>
                            <td><?php echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>
                    <td colspan="8" >No existen datos.</td>
                    </tr>';
                }

                ?>

            </tbody>
        </table>
    </div>

    <div id="registro" class="tabcontent">
        <div class="container">
            <form action="../../model/insertmantenimiento.php" method="POST">
                <div class="container">
                    <?php
                    if (isset($_GET['error']) && ($_GET['error'] == "mantencionregistradapreviamente")) {
                    ?>
                        <div class="alert">
                            <span class="closebtn">&times;</span>
                            <strong>¡Mantención registrada previamente!</strong> Ya existe una mantención registrada para esta solicitud. Verifique e intentelo nuevamente.
                        </div>
                    <?php
                    } elseif (isset($_GET['error']) && ($_GET['error'] == "problemasolicitud")) {
                    ?>
                        <div class="alert">
                            <span class="closebtn">&times;</span>
                            <strong>¡Error!</strong> Ha existido un error al procesar la solictud. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
                        </div>
                    <?php
                    } elseif (isset($_GET['g']) && ($_GET['g'] == "registroexitosofm")) {
                    ?>
                        <div class="alert info">
                            <span class="closebtn">&times;</span>
                            <strong>¡Solicitud solucionada!</strong> Se ha informado que ha sido solucionado el problema existente. Debe registrar la mantención realizada.
                        </div>
                    <?php
                    }
                    ?>
                    <h1>Registro de mantención</h1>
                    <p>Porfavor complete todo los campos para registrar la mantención realizada.</p>
                    <hr>

                    <label><b>Seleccione ID de la solicitud</b></label>
                    <br>
                    <select id="idsoli" name="idsoli" required>
                        <option value=""></option>
                        <?php
                        $objsolicitud = new Solicitud();

                        $listadoID = $objsolicitud->obtenerSoliMantencion();

                        if ($listadoID) {
                            while ($rows = $listadoID->fetch_assoc()) {
                                $fsoli = explode('-', $rows['fecha']);
                        ?>
                                <option value="<?php echo $rows["ID_Solicitud"];  ?>"><?php echo $rows["ID_Solicitud"];
                                                                                        echo " - ";
                                                                                        echo $rows["Nombre"];
                                                                                        echo " - ";
                                                                                        echo $fsoli[2] . '-' . $fsoli[1] . '-' . $fsoli[0];
                                                                                        echo " - ";
                                                                                        echo $rows["estado"]; ?></option>
                        <?php


                            }
                        }
                        ?>
                    </select>
                    <br>
                    <label><b>N° Inventario del Equipo</b></label>
                    <br>
                    <input type="number" placeholder="Ingresa numero de inventario del equipo" name="ninventario" required style="width:100%">
                    <br>
                    <label><b>N° de Serie del Equipo</b></label>
                    <br>
                    <input type="number" placeholder="Numero de serie el equipo" name="nserie" required style="width:100%">
                    <br>
                    <label><b>Cantidad de RAM</b></label>
                    <input type="text" placeholder="Especifique cantidad de RAM" name="ram" required>
                    <br>
                    <label id="almacenamiento"><b>Cantidad de almacenamiento</b></label>
                    <input type="text" placeholder="Ingresa cantidad de almacenamiento total" name="almacenamiento" required>

                    <label id="solicitud"><b>Observación</b></label>
                    <br>
                    <textarea id="solicitud" maxlength="500" name="solicitud" placeholder="Detalle la observación de lo realizado.." style="width:100%"></textarea>

                    <hr>

                    <button type="submit" class="registerbtng">Registrar IP</button>
                </div>
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