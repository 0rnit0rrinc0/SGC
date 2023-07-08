<?php

require_once "../../config/conexion.php";
require_once "../clases/mantenimiento.class.php";
require_once "../clases/solicitud.class.php";
require_once "../clases/documentos.class.php";

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
    <title>RECEPCION - SGC</title>
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
            <a href="principal.mantenimiento.php">Mantenimiento</a>
            <a class="active" href="principal.recepcion.php">Entrega</a>
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

        if ((isset($_GET['g']) && ($_GET['g'] == "subido")) || (isset($_GET['error']) && ($_GET['error'] == "existente"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Documentos emitidos</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Generar documento</button>
            <button class="tablinks" onclick="openCity(event, 'subir')">Subir documento</button>

        <?php
        } elseif ((isset($_GET['error']) && ($_GET['error'] == "problemaalsubir"))) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')">Documentos emitidos</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Generar documento</button>
            <button class="tablinks" onclick="openCity(event, 'subir')" id="defaultOpen">Subir documento</button>

        <?php
        } elseif(isset($_GET['g']) && ($_GET['g'] == "registroexitoso")){
            ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" >Documentos emitidos</button>
            <button class="tablinks" onclick="openCity(event, 'registro')" id="defaultOpen">Generar documento</button>
            <button class="tablinks" onclick="openCity(event, 'subir')">Subir documento</button>
            <?php
        }else {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Documentos emitidos</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Generar documento</button>
            <button class="tablinks" onclick="openCity(event, 'subir')">Subir documento</button>

        <?php
        }

        ?>
    </div>
    <!-- Tab content -->
    <div id="listado" class="tabcontent">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "subido")) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Documento subido!</strong> El documento ha sido almacenado de manera exitosa.
            </div>
        <?php
        } elseif (isset($_GET['error']) && ($_GET['error'] == "existente")) {
        ?>
            <div class="alert">
                <span class="closebtn">&times;</span>
                <strong>¡Solicitud con documento existente!</strong> Ya existe un documento almacenado para esta solicitud. Verifique e intentelo nuevamente.
            </div>
        <?php
        } 
        ?>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>ID del documento</th>
                    <th>ID Solicitud</th>
                    <th>Descripción</th>
                    <th>Nombre del archivo</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Tamaño</th>
                    <th>Ruta</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $objdocumentos = new Documento();

                $listadoDocumento = $objdocumentos->documentosSubidos();

                if ($listadoDocumento) {
                    while ($mostrar = $listadoDocumento->fetch_assoc()) {
                        $fEstado = explode('-', $mostrar['fecha']);
                ?>
                        <tr>
                            <td><?php echo $mostrar['id_documento'] ?></td>
                            <td><?php echo $mostrar['id_solicitud'] ?></td>
                            <td><?php echo $mostrar['descripción'] ?></td>
                            <td><?php echo $mostrar['nombreFichero'] ?></td>
                            <td><?php echo $fEstado[2] . '-' . $fEstado[1] . '-' . $fEstado[0]; ?></td>
                            <td><?php echo $mostrar['tipo'] ?></td>
                            <td><?php echo $mostrar['tamaño'] ?></td>
                            <td><a class="link_edit" href="../../<?php echo $mostrar['ruta']; ?>">Click Aquí</a></td>

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
            <?php
            if (isset($_GET['g']) && ($_GET['g'] == "registroexitoso")) {
            ?>
                <div class="alert info">
                    <span class="closebtn">&times;</span>
                    <strong>¡Mantenimiento registrado!</strong> Ha registrado un mantenimiento. Debe generar el documento de entrega correspondiente a este. 
                    <br>
                    <strong>PASOS A SEGUIR:</strong>
                    <br>
                    1) Generar documento.
                    <br>
                    2) Imprimir documento en la impresora más cercana.
                    <br>
                    3) Una vez entregado el equipo y firmado el documento, escanear documento.
                    <br>
                    4) Subir a la plataforma en el apartado "Entrega"->"Subir documento".
                    <br>
                    *Guarde el documento con un nombre valido para poder ser encontrado de manera más eficiente.
                </div>
            <?php
            }
            ?>
            <form action="../../model/obtenerdatos.php" method="POST">

                <h1>Generación de documento</h1>
                <p>Porfavor complete todo los campos para generar el documento de manera correcta.</p>
                <hr>

                <label><b>Seleccione ID del mantenimiento</b></label>
                <select id="soli" name="soli">
                    <option value=""></option>
                    <?php
                    $objmantencion = new Mantenimiento();

                    $listadoid = $objmantencion->obtenerMantenimientosDocumento();

                    if ($listadoid) {
                        while ($rows = $listadoid->fetch_assoc()) {
                    ?>
                            <option value="<?php echo $rows["idmanten"]; ?>"> <?php echo $rows["idmanten"];
                                                                                echo " - ";
                                                                                echo $rows["name"]; ?></option>
                    <?php


                        }
                    }
                    ?>
                </select>

                <button type="submit" class="registerbtng">Generar documento</button>


            </form>
        </div>
    </div>

    <div id="subir" class="tabcontent">
        <div class="container">
            <?php
            if (isset($_GET['error']) && ($_GET['error'] == "problemaalsubir")) {
            ?>
                <div class="alert">
                    <span class="closebtn">&times;</span>
                    <strong>¡Error!</strong> Ha existido un error al procesar la solictud. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
                </div>
            <?php
            }
            ?>
            <form action="../../model/subirarchivo.php" method="POST" enctype="multipart/form-data">

                <label><b>ID de la solicitud asociada</b></label>
                <br>
                <select id="idsoli" name="idsoli" required>
                    <option value="">Seleccione...</option>
                    <?php
                    $objsolicitud = new Solicitud();

                    $listadoID = $objsolicitud->obtenerSoliMantencion();

                    if ($listadoID) {
                        while ($rows = $listadoID->fetch_assoc()) {
                            $fsoli = explode('-', $rows['fecha']);
                    ?>
                            <option value="<?php echo $rows["ID_Solicitud"];   ?>"><?php echo $rows["ID_Solicitud"];
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
                <label><b>Archivo</b></label>
                <input type="file" name="archivo">
                <br>
                <label><b>Descripción</b></label>
                <textarea type="text" placeholder="Descripción del documento..." name="descripcipon" style="width: 100%;"></textarea>

                <button type="submit" class="registerbtng">Subir documento</button>


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