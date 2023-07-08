<?php

require_once ("../config/conexion.php");
require_once "../controller/clases/mantenimiento.class.php";

$objmantencion = new Mantenimiento();

$id = (isset($_POST['idsoli'])) ? $_POST['idsoli'] : null;
$ninventario = (isset($_POST['ninventario'])) ? $_POST['ninventario'] : null;
$nserie = (isset($_POST['nserie'])) ? $_POST['nserie'] : null;
$ram = (isset($_POST['ram'])) ? $_POST['ram'] : null;
$almacenamiento = (isset($_POST['almacenamiento'])) ? $_POST['almacenamiento'] : null;
$solicitud = (isset($_POST['solicitud'])) ? $_POST['solicitud'] : null;
$fecha = date('Y-m-d');

$validacion = $objmantencion->validarMantenimiento($id);

if($validacion){
    header ("Location: ../controller/tecnico/principal.mantenimiento.php?error=mantencionregistradapreviamente");

}else{
    $registromantencion = $objmantencion->registrarMantenimiento($id, $ninventario, $nserie, $ram, $almacenamiento, $solicitud, $fecha);

    if($registromantencion){
        header ("Location: ../controller/tecnico/principal.recepcion.php?g=registroexitoso");
    }else{
        header ("Location: ../controller/tecnico/principal.mantenimiento.php?error=problemasolicitud");
    }
}

?>