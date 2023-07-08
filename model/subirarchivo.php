<?php

require_once("../config/conexion.php");
require_once "../controller/clases/documentos.class.php";

$objdocuments = new Documento();

if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {


    $directorio = '../documentosEntrega/';
    $subir_archivo = $directorio . basename($_FILES['archivo']['name']);
    $id = (isset($_POST['idsoli'])) ? $_POST['idsoli'] : null;
    $descrip = (isset($_POST['descripcipon'])) ? $_POST['descripcipon'] : null;
    echo "<div>";
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $subir_archivo)) {

        $validacion = $objdocuments->validarDocumento($id);
        
        if ($validacion) {
            header("Location: ../controller/tecnico/principal.recepcion.php?error=existente");
        } else {
            $fecha = date('Y-m-d');
            $insertar = $objdocuments->subirDocumento($id, $descrip, $subir_archivo, $_FILES['archivo']['name'], $_FILES['archivo']['type'], $_FILES['archivo']['size'], $fecha);

            if ($insertar) {
                header("Location: ../controller/tecnico/principal.recepcion.php?g=subido");
            } else {
                header("Location: ../controller/tecnico/principal.recepcion.php?error=problemaalsubir");
            }
        }
    } else {
        header("Location: ../controller/tecnico/principal.recepcion.php?error=problemaalsubir");
    }
    echo "</div>";

    /* if (move_uploaded_file($_FILES['fichero']['tmp_name'], $upload)) { //movemos el archivo a su ubicacion       

        $validacion = $objdocuments->validarDocumento($id);

        if ($validacion) {
            header("Location: ../controller/tecnico/principal.recepcion.php?error=existente");
        } else {
            $insertar = $objdocuments->subirDocumento($id, $descrip, $ruta, $nombrefinal, $_FILES['archivo']['type'], $_FILES['archivo']['size']);

            if ($insertar) {
                header("Location: ../controller/tecnico/principal.recepcion.php?g=subido");
            } else {
                header("Location: ../controller/tecnico/principal.recepcion.php?error=problemaalsubir");
            }
        }
    } */
}
