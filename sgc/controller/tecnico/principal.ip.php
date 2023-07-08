<?php

require_once "../../config/conexion.php";
require_once "../clases/ip.class.php";
require_once "../clases/personal.class.php";

//Seguridad de paginacion

session_start();
$varsesion = $_SESSION['rut'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../../index.php");
}

/* $nuser = $_SESSION['rut'];
$sql = "SELECT Rut, Nombre FROM personal WHERE rut = '$nuser'";
$resultado = $conexion->query($sql);
$row = $resultado->fetch_assoc(); */





//$usuario = $_SESSION['username'];

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
    <title>IP - SGC</title>
</head>

<body>
    <div>
        <div class="scrollmenu">
            <div class="header">
                <img class="logo" src="../../view/img/logoimo.png" alt="municipalidad" height="75px" width="75px">
            </div>
            <a href="bienvenida.php">Bienvenida</a>
            <a class="active" href="principal.ip.php">IP</a>
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
    </div>
    <div>
    </div>
    <!-- Tab links -->
    <div class="tab">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "registrocompleto")) {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Listado de IP</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nueva IP</button>
        <?php
        } elseif ((isset($_GET['error']) && ($_GET['error'] == "datoexistente")) || (isset($_GET['error']) && ($_GET['error'] == "procesarsolicitud")) )  {
        ?>
            <button class="tablinks" onclick="openCity(event, 'listado')">Listado de IP</button>
            <button class="tablinks" onclick="openCity(event, 'registro')" id="defaultOpen">Nueva IP</button>
        <?php
        }else{
            ?>
            <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Listado de IP</button>
            <button class="tablinks" onclick="openCity(event, 'registro')">Nueva IP</button>
        <?php
        }
        ?>

    </div>

    <!-- Tab content -->
    <div id="listado" class="tabcontent">
        <?php
        if (isset($_GET['g']) && ($_GET['g'] == "registrocompleto")) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Registro exitoso!</strong> La nueva IP ha sido registrada de manera correcta.
            </div>
        <?php
        }

        ?>
        <table id="example" class="display" style="width:70%">
            <thead>
                <tr>
                    <th>IP</th>
                    <th>Rut Funcionario</th>
                    <th>Departamento</th>
                    <th>Nombre de usuario</th>
                    <!-- <th>Acción</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $objip = new Ip();

                $listadoip = $objip->mostrarIP();

                if ($listadoip) {
                    while ($mostrar = $listadoip->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $mostrar['IP'] ?></td>
                            <td><?php echo $mostrar['Rut'] ?></td>
                            <td><?php echo $mostrar['departamento'] ?></td>
                            <td><?php echo $mostrar['nombre_usuario'] ?></td>
                            <!-- <td>
                                <a class="link_edit" href="../../model/desvincular.php?id=<?php echo $mostrar["IP"]; ?>">Desvincular IP</a>
                            </td> -->
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>
                        <td colspan="4" >No existen datos.</td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
    </div>

    <div id="registro" class="tabcontent">
        <form action="../../model/insertip.php" method="POST">
            <div class="container">
                <div>
                    <?php
                    if (isset($_GET['error']) && ($_GET['error'] == "datoexistente")) {
                    ?>
                        <div class="alert">
                            <span class="closebtn">&times;</span>
                            <strong>¡Registro existente!</strong> Ya existe una IP para este funcionario o la IP ha sido asignada a otra persona. Verifique.
                        </div>

                    <?php
                    } elseif (isset($_GET['error']) && ($_GET['error'] == "procesarsolicitud")) {
                    ?>
                        <div class="alert">
                            <span class="closebtn">&times;</span>
                            <strong>¡Erorr!</strong> Ha existido un error al procesar la solictud. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
                        </div>

                    <?php
                    }

                    ?>
                </div>
                <h1>Registro de IP</h1>
                <p>Porfavor complete todo los campos para registrar una IP.</p>
                <hr>

                <label><b>Ingrese IP</b></label>
                <br>
                <div class="ip">
                    <input value="192" readonly oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="3" name="ip"><a class="separador">.</a>
                    <input required min="0" max="255" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="3" name="ip2"> <a class="separador">.</a>
                    <input required min="0" max="255" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="3" name="ip3"> <a class="separador">.</a>
                    <input required min="0" max="255" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="3" name="ip4">
                </div>
                <br>
                <label><b>RUT del funcionario</b></label>
                <br>
                <select id="rutfuncionario" name="rutfuncionario" required>
                    <option value="">Seleccione..</option>
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
                <label><b>Departamento</b></label>
                <input type="text" placeholder="Ingresa departamento al que pertenece el funcionario" name="depa" required>

                <label><b>Nombre de usuario</b></label>
                <input type="text" placeholder="Nombre de usuario asignado al funcionario" name="nusuario" required>

                <hr>

                <button type="submit" class="registerbtng">Registrar IP</button>
            </div>

        </form>
    </div>

    <div id="Tokyo" class="tabcontent">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="../../view/js/maindata.js"></script>
    <script src="../../view//js/tabs.js"></script>
    <script src="../../view/js/sgc.js"></script>
    <script src="../../view/js/alerts.js"></script>



</body>

</html>