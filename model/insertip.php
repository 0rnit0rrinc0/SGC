<?php

require_once ("../config/conexion.php");
require_once "../controller/clases/ip.class.php";

$objip = new Ip();



$ip1 = (isset($_POST['ip'])) ? $_POST['ip'] : null;
$ip2 = (isset($_POST['ip2'])) ? $_POST['ip2'] : null;
$ip3 = (isset($_POST['ip3'])) ? $_POST['ip3'] : null;
$ip4 = (isset($_POST['ip4'])) ? $_POST['ip4'] : null;


$ip = $ip1.".".$ip2.".".$ip3.".".$ip4;



$rutfuncionario = (isset($_POST['rutfuncionario'])) ? $_POST['rutfuncionario'] : null;
$depa = (isset($_POST['depa'])) ? $_POST['depa'] : null;
$nusuario = (isset($_POST['nusuario'])) ? $_POST['nusuario'] : null;



$validacionip = $objip->consultarIP($ip, $nusuario);

if($validacionip){
    header('Location: ../controller/tecnico/principal.ip.php?error=datoexistente');
}else{
    $insertarip = $objip->registrarIP($ip, $rutfuncionario, $depa, $nusuario);
    if($insertarip){
        header('Location: ../controller/tecnico/principal.ip.php?g=registrocompleto');
    }else{
        header('Location: ../controller/tecnico/principal.ip.php?error=procesarsolicitud');

    }
}

/* 
$q = "SELECT COUNT(*) as contar from red where IP='$ip' OR nombre_usuario='$nusuario'";

$consulta = mysqli_query($conexion, $q);
$array = mysqli_fetch_array($consulta);

if($array['contar']>0){
    echo "Ya existe un usuario con los mismos datos registrados.";
    header("location: ../controller/Tecnico/registroip.php");
}else{
    if($ip == '' or $rutfuncionario == '' or $depa == '' or $nusuario ==''){
        echo "Rellene todos los campos.";
        header("location: ../controller/Tecnico/registroip.php");
    }else{
        echo "Registro correcto";
        $insertardatos = "INSERT INTO `red`(`IP`, `Rut`, `departamento`, `nombre_usuario`) VALUES ('".$ip."','".$rutfuncionario."','".$depa."','".$nusuario."');";
        $ejecutarinsert = $conexion->query($insertardatos);

        if($ejecutarinsert){
            header("Location: ../controller/Tecnico/registroip.php");
        }else{
            echo "Error de registro";
        }
    }
} */



?>