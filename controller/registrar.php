<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../view/css/registro.css " rel="stylesheet" media="screen">
    <title>Registro - SGC</title>
    <script src="../view/js/sgc.js"></script>
</head>

<body>
    <form action="../model/insertarregistro.php" method="POST">
        <div class="container">
            <h1>Registro</h1>
            <p>Porfavor complete todo los campos para registrarse.</p>
            <hr>
            <div>
                <?php
                if (isset($_GET['error']) && ($_GET['error'] == "datosexistentes")) {
                ?>
                    <div class="alert">
                        <span class="closebtn">&times;</span>
                        <strong>¡Registro invalido!</strong> Los datos ingresados ya corresponden a un usuario registrado. Verifique o ingrese con sus credenciales.
                    </div>
                <?php
                } elseif (isset($_GET['error']) && ($_GET['error'] == "passwordIncorrecta")) {
                ?>
                    <div class="alert warning">
                        <span class="closebtn">&times;</span>
                        <strong>¡Precaucion!</strong> Las contraseñas ingresadas no coinciden. Verifique.
                    </div>
                <?php
                }
                ?>
            </div>
            <br>
            <label><b>Ingrese RUT</b></label>
            <br>
            <input type="text" maxlength="12" required oninput="checkRut(this)" placeholder="Sin puntos" name="rut">
            <br>
            <label><b>Ingrese nombre y apellido</b></label>
            <input type="text" placeholder="Nombre y apellido" name="nombre">
            <br>
            <label>Seleccione su sexo:</label>
            <br>
            <select id="sexo" name="sexo">
                <option value="">Seleccione..</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
            <br>
            <label><b>Email</b></label>
            <input type="email" placeholder="Ingresa email" name="email">
            <br>
            <label><b>Departamento</b></label>
            <select name="departamento" required>
                <option value="">Seleccione..</option>
                <?php
                $deptos = ['Abastecimiento', 'Administración municipal', 'Administración y finanzas', 'Alcaldía', 'Áreas verdes', 'Aseo y ornato', 'Asesoría jurídica', 'Asesoría urbana', 'Comunicaciones', 'Contabilidad', 'Control de gestión', 'Convenios y programas', 'Cultura', 'Deportes y recreación', 'Desarrollo comunitario', 'Desarrollo social', 'Edificación', 'Ejecución de obras', 'Estudios y proyectos', 'Fomento productivo', 'Gabinete de alcaldía', 'Infraestructura y servicios', 'Inspección de obras', 'Inventario', 'Juzgado de policía local', 'Licitaciones', 'Medio ambiente', 'Municipales', 'Obras municipales', 'Oficina de Partes e informaciones', 'Recursos humanos', 'SECPLAN', 'Secretaria municipal', 'Seguridad publica', 'Tesorería', 'Transito',  'Unidad control'];

                foreach ($deptos as $depto) {
                    echo '<option value="' . $depto . '"';
                    echo '>' . $depto . '</option>';
                }
                ?>
            </select>
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
            <button id="btn" type="submit" class="registerbtn" disabled>Registrarse</button>
            <hr>
        </div>

        <div class="container signin">
            <p>¿Ya posees una cuenta? <a href="../index.php">Ingresar</a>.</p>
        </div>
    </form>

    <script src="../view/js/alerts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../view/js/strength.js"></script>


</body>

</html>