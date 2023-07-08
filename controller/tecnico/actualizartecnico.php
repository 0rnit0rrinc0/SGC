<?php

require_once '../../config/conexion.php';
require_once '../clases/supervisor.class.php';

$objconexion = new Conexion();
$objconexion->conexion;

$q = "SELECT * FROM personal WHERE Rut = '" . $_REQUEST["id"] . "' ";
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>Actualizacion - SGC</title>

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
                echo utf8_decode($_SESSION['rut']);
                ?>
                <br>
            </div>
        </div>
    </div>


    <form action="../../model/actualizardatos.php" method="POST">
        <div class="container">
            <div>
                <?php
                if (isset($_GET['error']) && ($_GET['error'] == "datosexistentes")) {
                    echo "Ya existe un usuario registrado con estos datos. Verifique.";
                }

                ?>
            </div>
            <h1>Actualizar</h1>
            <a href="javascript:history.back();">Volver</a>
            <hr>

            <label><b>Ingrese RUT</b></label>
            <br>
            <input type="hidden" maxlength="12" name="rut" value="<?php echo $resultado['Rut']; ?>">
            <input type="text" maxlength="12" name="rut" value="<?php echo $resultado['Rut']; ?>" disabled>
            <br>
            <label><b>Ingrese nombre y apellido</b></label>
            <input type="text" placeholder="Nombre y apellido" name="nombre" value="<?php echo $resultado['Nombre']; ?>">
            <br>
            <label>Seleccione su sexo:</label>
            <br>
            <input type="text" name="sexo" value="<?php echo $resultado['sexo']; ?>">
            <br>
            <label><b>Email</b></label>
            <input type="email" name="email" value="<?php echo $resultado['correo']; ?>">
            <br>
            <label><b>Departamento del funcionario</b></label>
            <select name="departamento" required>
                <?php

                $deptos = ['Abastecimiento', 'Administración municipal', 'Administración y finanzas', 'Alcaldía', 'Áreas verdes', 'Aseo y ornato', 'Asesoría jurídica', 'Asesoría urbana', 'Comunicaciones', 'Contabilidad', 'Control de gestión', 'Convenios y programas', 'Cultura', 'Deportes y recreación', 'Desarrollo comunitario', 'Desarrollo social', 'Edificación', 'Ejecución de obras', 'Estudios y proyectos', 'Fomento productivo', 'Gabinete de alcaldía', 'Informática', 'Infraestructura y servicios', 'Inspección de obras', 'Inventario', 'Juzgado de policía local', 'Licitaciones', 'Medio ambiente', 'Municipales', 'Obras municipales', 'Oficina de Partes e informaciones', 'Recursos humanos', 'SECPLAN', 'Secretaria municipal', 'Seguridad publica', 'Tesorería', 'Transito',  'Unidad control'];
                foreach ($deptos as $depto) {
                    echo '<option value="' . $depto . '"';
                    if ($resultado['departamento'] == $depto) echo ' selected';
                    echo '>' . $depto . '</option>';
                }
                ?>
            </select>
            <br>
            <label><b>Rol</b></label>
            <input type="text" name="cargo" value="<?php echo $resultado['ID_Cargo']; ?>" disabled>
            <br>
            <label><b>Estado</b></label>
            <select id="estado" name="estado" required>
                <option value="Activo" <?php if ($resultado['estado'] == 'Activo') {
                                            echo 'selected';
                                        } ?>>Activo</option>
                <option value="Inactivo" <?php if ($resultado['estado'] == 'Inactivo') {
                                                echo 'selected';
                                            } ?>>Inactivo</option>
            </select>
            <br>

            <button type="submit" class="registerbtng">Guardar</button>

            <hr>


        </div>
    </form>
    <form action="../../model/cambiopass.php" method="POST">
        <div class="container">
            <input type="hidden" maxlength="12" name="rut" value="<?php echo $resultado['Rut']; ?>">
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

</body>

</html>