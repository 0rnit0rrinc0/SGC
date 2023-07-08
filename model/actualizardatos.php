<?php

require_once "../config/conexion.php";
require_once "../controller/clases/supervisor.class.php";


$objsupervisor = new Supervisor();

$rut = (isset($_POST['rut'])) ? $_POST['rut'] : null;
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
$correo = (isset($_POST['email'])) ? $_POST['email'] : null;
$depa = (isset($_POST['departamento'])) ? $_POST['departamento'] : null;
$sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : null;
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : null;

if($depa == "Informática"){
    $rol = 1;
}else{
    $rol = 2;
}


$actualizar = $objsupervisor->editarFuncionarios($rut, $nombre, $sexo, $correo, $depa, $rol, $estado);



if($actualizar){
    header ("Location: ../controller/tecnico/funcionarios.php?g=solicitudexitosa");
}else{
    header ("Location: ../controller/tecnico/funcionarios.php?error=problema");
}

?>