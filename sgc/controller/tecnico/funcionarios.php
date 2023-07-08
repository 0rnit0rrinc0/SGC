<?php

require_once '../../config/conexion.php';
require_once '../clases/supervisor.class.php';

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>FUNCIONARIOS - SGC</title>
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
            <a href="principal.recepcion.php">Entrega</a>
            <?php
            if ($_SESSION['rol'] == 3) {
            ?>
                <a class="active" href="funcionarios.php">Funcionarios</a>
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
        <button class="tablinks" onclick="openCity(event, 'listado')" id="defaultOpen">Funcionarios</button>
        <button class="tablinks" onclick="openCity(event, 'registro')">Nuevo Funcionario</button>
    </div>
    <!-- Tab content -->
    <div id="listado" class="tabcontent">
        <?php
        if ((isset($_GET['g']) && ($_GET['g'] == "solicitudexitosa"))) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Editado correctamente!</strong> Los datos del funcionario han sido editados de manera correcta.
            </div>

        <?php
        } elseif ((isset($_GET['error']) && ($_GET['error'] == "problema"))) {
        ?>
            <div class="alert">
                <span class="closebtn">&times;</span>
                <strong>¡Error!</strong> Ha existido un error al procesar la solictud para editar los datos del funcionario. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
            </div>
        <?php
        } elseif ((isset($_GET['g']) && ($_GET['g'] == "exitoso"))) {
        ?>
            <div class="alert success">
                <span class="closebtn">&times;</span>
                <strong>¡Contraseña cambiada!</strong> La contraseña del funcionario ha sido cambiada de manera exitosa.
            </div>

        <?php
        } elseif ((isset($_GET['error']) && ($_GET['error'] == "procesar"))) {
        ?>
            <div class="alert">
                <span class="closebtn">&times;</span>
                <strong>¡Error!</strong> Ha existido un error al procesar la solictud de cambio de contraseña del funcionario. Intentelo nuevamente, si el problema persiste comuniquese con el administrador.
            </div>
        <?php
        }

        ?>
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Correo</th>
                    <th>Departamento</th>
                    <th>ID del Cargo</th>
                    <th>Estado actual</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $objsupervisor = new Supervisor();

                $listadotecnicos = $objsupervisor->listarFuncionarios();

                if ($listadotecnicos) {
                    while ($mostrar = $listadotecnicos->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $mostrar['Rut'] ?></td>
                            <td><?php echo $mostrar['Nombre'] ?></td>
                            <td><?php echo $mostrar['sexo'] ?></td>
                            <td><?php echo $mostrar['correo'] ?></td>
                            <td><?php echo $mostrar['departamento'] ?></td>
                            <td><?php echo $mostrar['ID_Cargo'] ?></td>
                            <td><?php echo $mostrar['estado'] ?></td>
                            <td>
                                <a class="link_edit" href="actualizartecnico.php?id=<?php echo $mostrar["Rut"]; ?>">Editar</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>
                        <td colspan="7" >No existen datos.</td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="registro" class="tabcontent">
        <form action="../../model/insertartecnico.php" method="POST">

            <div class="container">
                <div>
                    <?php
                    if (isset($_GET['error']) && ($_GET['error'] == "datosexistentes")) {
                        echo "Ya existe un usuario registrado con estos datos. Verifique.";
                    }

                    ?>
                </div>
                <h1>Registro</h1>
                <p>Porfavor complete todo los campos para registrarse.</p>
                <hr>

                <label><b>Ingrese RUT</b></label>
                <br>
                <input type="text" maxlength="12" required oninput="checkRut(this)" placeholder="Sin puntos" name="rut">
                <br>
                <label><b>Ingrese nombre y apellido</b></label>
                <input type="text" placeholder="Nombre y apellido" name="nombre" required>
                <br>
                <label>Seleccione su sexo:</label>
                <br>
                <select id="sexo" name="sexo" required>
                    <option value="">Seleccione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <br>
                <label><b>Email</b></label>
                <input type="email" placeholder="Ingresa email" name="email" required>
                <br>

                <label><b>Departamento del funcionario</b></label>
                <select name="departamento" required>
                    <option value="">Seleccione..</option>
                    <?php
                    $deptos = ['Abastecimiento', 'Administración municipal', 'Administración y finanzas', 'Alcaldía', 'Áreas verdes', 'Aseo y ornato', 'Asesoría jurídica', 'Asesoría urbana', 'Comunicaciones', 'Contabilidad', 'Control de gestión', 'Convenios y programas', 'Cultura', 'Deportes y recreación', 'Desarrollo comunitario', 'Desarrollo social', 'Edificación', 'Ejecución de obras', 'Estudios y proyectos', 'Fomento productivo', 'Gabinete de alcaldía', 'Informática', 'Infraestructura y servicios', 'Inspección de obras', 'Inventario', 'Juzgado de policía local', 'Licitaciones', 'Medio ambiente', 'Municipales', 'Obras municipales', 'Oficina de Partes e informaciones', 'Recursos humanos', 'SECPLAN', 'Secretaria municipal', 'Seguridad publica', 'Tesorería', 'Transito',  'Unidad control'];

                    foreach ($deptos as $depto) {
                        echo '<option value="' . $depto . '"';
                        echo '>' . $depto . '</option>';
                    }
                    ?>
                </select>
                <br>
                <div class="container">
                    <label><b>Contraseña</b></label>
                    <input id="pass1" type="password" placeholder="Ingresa Contraseña" name="psw">
                    <br>
                    <label><b>Vuelva a ingresar su contraseña</b></label>
                    <input id="pass2" type="password" placeholder="Ingresa Contraseña" name="psw2">
                    <div id="pswd_info">
                        <label id="txt"></label><br>
                        <label id="length" class="invalid"></label><br>
                        <label id="letter" class="invalid"></label><br>
                        <label id="number" class="invalid"></label><br>
                        <label id="poo" class="invalid"></label><br>
                    </div>
                    <br>
                    <button id="btn" type="submit" class="registerbtnm" disabled>Registrarse</button>
                    <hr>
                </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="../../view/js/strength.js"></script>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="../../view/js/maindata.js"></script>
    <script src="../../view//js/tabs.js"></script>
    <script src="../../view/js/sgc.js"></script>
    <script src="../../view/js/alerts.js"></script>
</body>

</html>