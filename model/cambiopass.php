<?php 

require_once '../config/conexion.php';
require_once '../controller/clases/supervisor.class.php';

$objsupervisor = new Supervisor();

$psw = (isset($_POST['psw'])) ? sha1(md5($_POST['psw'])) : null;
$psw2 = (isset($_POST['psw2'])) ? sha1(md5($_POST['psw2'])) : null;

if($psw == $psw2){
    $rut = (isset($_POST['rut'])) ? $_POST['rut'] : null;

    $cpass = $objsupervisor->cambiarContraseña($rut, $psw);

    echo $cpass;

    if($cpass){
        header ("Location: ../controller/tecnico/funcionarios.php?g=exitoso");
    }else{
        header ("Location: ../controller/tecnico/funcionarios.php?error=procesar");
    }

}else{
    header ("Location: ../controller/tecnico/funcionarios.php?error=novalido");
}
