<?php

require_once "../../config/conexion.php";
require_once "../clases/estados.class.php";
require_once "../clases/solicitud.class.php";
require_once "../clases/tecnico.class.php";

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
    <title>ESTADOS - SGC</title>
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
            <a class="active" href="principal.estados.php">Estado</a>
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
        if (isset($_GET['g']) && ($_GET['g'] == "registroexitoso") || (isset($_GET['g']) && ($_GET['g'] == "registroexitosofm"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Estados registrados</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nuevo estado</button>
        <?php
        } elseif ((isset($_GET['error']) && ($_GET['error'] == "procesamiento")) || (isset($_GET['error']) && ($_GET['error'] == "existente"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')">Estados registrados</button>
            <button class="tablinks" onclick="openCity(event, 'registro')" id="defaultOpen">Nuevo estado</button>
        <?php
        } else {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Estados registrados</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nuevo estado</button>
        <?php
        }
        ?>

    </div>
    <br>

    <!-- Tab content -->
    <div id="listado" class="tabcontent">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "registroexitoso")) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Estado registrado! </strong> El estado ha sido registrado e informado de manera correcta.
            </div>
        <?php
        } elseif ((isset($_GET['g']) && ($_GET['g'] == "registroexitosofm"))) {
        ?>
            <div class="alert info">
                <span class="closebtn">&times;</span>
                <strong>¡Solicitud solucionada!</strong> Se ha informado que ha sido solucionado el problema existente. Debe registrar la mantención realizada.
            </div>
        <?php
        }
        ?>
        <table id="example" class="display" style="width:80%">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $objestados = new Estados();

                $listadoestados = $objestados->obtenerEstadosRegistrados();

                if ($listadoestados) {
                    while ($mostrar = $listadoestados->fetch_assoc()) {
                        $fEstado = explode('-', $mostrar['fecha']);
                ?>
                        <tr>
                            <td><?php echo $mostrar['ID_Solicitud'] ?></td>
                            <td><?php echo $mostrar['estado'] ?></td>
                            <td><?php echo $mostrar['responsable'] ?></td>
                            <td><?php echo $mostrar['observacion'] ?></td>
                            <td><?php echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>
        <td colspan="5" >No existen datos.</td>
        </tr>';
                }

                ?>
            </tbody>
        </table>
    </div>

    <div id="registro" class="tabcontent">
        <form action="../../model/insertestado.php" method="POST">
            <div class="container">
                <?php
                if (isset($_GET['error']) && ($_GET['error'] == "existente")) {
                ?>
                    <div class="alert">
                        <span class="closebtn">&times;</span>
                        <strong>¡Estado existente!</strong> El estado ya ha sido registrado con anterioridad. Verifique.
                    </div>
                <?php
                } elseif ((isset($_GET['error']) && ($_GET['error'] == "procesamiento"))) {
                ?>
                    <div class="alert">
                        <span class="closebtn">&times;</span>
                        <strong>¡Error!</strong> Ha existido un error al procesar la solictud. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
                    </div>
                <?php

                }
                ?>

                <label>Seleccione ID de la solicitud a notificar</label>
                <select id="idsoli" name="idsoli" required>
                    <option value=""></option>
                    <?php
                    $objsolicitud = new Solicitud();

                    $listadoID = $objsolicitud->obtenerIDSolicitud();

                    if ($listadoID) {
                        while ($rows = $listadoID->fetch_assoc()) {
                            $fEstado = explode('-', $rows['f']);
                    ?>
                            <option value="<?php echo $rows["soli"];  ?>"><?php echo $rows["soli"];
                                                                            echo " - ";
                                                                            echo $rows['name'];
                                                                            echo " - ";
                                                                            echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></option>
                    <?php


                        }
                    }
                    ?>
                </select>
                <br>
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value=""></option>
                    <option value="Recepcionado">Recepcionado</option>
                    <option value="En proceso...">En proceso...</option>
                    <option value="Solucionado">Solucionado</option>
                    <option value="Entregado">Entregado</option>
                </select>

                <label for="tecnico">Nombre del encargado del estado</label>
                <select id="tecnico" name="tecnico" required>
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
                <textarea id="observacion" maxlength="500" name="observacion" placeholder="Detalle la observación.." style="width:100%"></textarea></textarea>

                <input type="submit" value="Registrar estado" class="registerbtng">
            </div>>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="../../view/js/maindata.js"></script>
    <script src="../../view//js/tabs.js"></script>
    <script src="../../view/js/sgc.js"></script>
    <script src="../../view/js/alerts.js"></script>

</body>

</html>