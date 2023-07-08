<?php

require_once '../config/conexion.php';
require_once '../controller/clases/ip.class.php';

$objip = new Ip();

$ip = (isset($_GET['IP'])) ? $_GET['IP'] : null;

$desvin = $objip->desvincular($ip);

if($desvin){
    header('Location: ../controller/tecnico/principal.ip.php?g=desvinculado');
}else{
    header('Location: ../controller/tecnico/principal.ip.php?error=noprocesado');
}

?>