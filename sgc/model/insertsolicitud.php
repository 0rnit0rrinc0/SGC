<?php

require_once "../config/conexion.php";
require_once '../controller/clases/solicitud.class.php';

$objsolicitud = new Solicitud();

$rut = (isset($_POST['rutfuncionario'])) ? $_POST['rutfuncionario'] : null;


$solicitud = (isset($_POST['solicitud'])) ? $_POST['solicitud'] : null;

$fecha = date('Y-m-d');

$insertarsolicitud = $objsolicitud->insertarSolicitud($rut, $solicitud, $fecha);

echo $insertarsolicitud;

if($insertarsolicitud){
    header('Location: ../controller/funcionario/equiposenviados.php?g=exitoso');
}else{
    header('Location: ../controller/funcionario/solicitud.php?error=procesarsolicitud');
}




?>