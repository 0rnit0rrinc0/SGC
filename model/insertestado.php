<?php

require_once "../config/conexion.php";
require_once "../controller/clases/estados.class.php";

$objestado = new Estados();



$idsolicitud = (isset($_POST['idsoli'])) ? $_POST['idsoli'] : null;
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : null;
$tecnico = (isset($_POST['tecnico'])) ? $_POST['tecnico'] : null;
$observacion = (isset($_POST['observacion'])) ? $_POST['observacion'] : null;

$fecha = date('Y-m-d');

$validarEstado = $objestado->validarEstadoARegistrar($idsolicitud, $estado);

if($validarEstado){
    header("Location: ../controller/tecnico/principal.estados.php?error=existente");
}else{
    $registrarestado = $objestado->registrarEstado($idsolicitud, $estado, $tecnico, $observacion, $fecha);

    if($registrarestado){
        if($estado != "Solucionado"){
            header("Location: ../controller/tecnico/principal.estados.php?g=registroexitoso");
        }elseif ($estado = "Solucionado"){
            header("Location: ../controller/tecnico/principal.mantenimiento.php?g=registroexitosofm");
        }
    }else{
        header("Location: ../controller/tecnico/principal.estados.php?error=procesamiento");
    }
}



?>