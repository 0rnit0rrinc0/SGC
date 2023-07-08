<?php

require_once '../config/conexion.php';
require_once '../controller/clases/supervisor.class.php';

$supervisor = new Supervisor();

if($_POST['psw'] == $_POST['psw2']){
    $psw = (isset($_POST['psw'])) ? sha1(md5($_POST['psw'])) : null;
    $rut = (isset($_POST['rut'])) ? $_POST['rut'] : null;
    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
    $correo = (isset($_POST['email'])) ? $_POST['email'] : null;
    $depa = (isset($_POST['departamento'])) ? $_POST['departamento'] : null;
    $sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : null;

    if($depa == "Informática "){
        $rol = 1;
    }else{
        $rol = 2;
    }

    $estado = "Activo";
    

    $validarRegistro = $supervisor->validarRegistroTecnico($rut, $correo);
    
    if($validarRegistro){
        header("Location: ../controller/tecnico/funcionarios.php?error=datosexistentes");
    }else{
        $registrarTecnico =$supervisor->registrarTecnico($rut, $nombre, $sexo, $correo, $depa, $psw, $rol, $estado);
        if($registrarTecnico){
            header("Location: ../controller/tecnico/funcionarios.php");
        }
    }

}else{

}



/* 
$q = "SELECT COUNT(*) as contar from personal where Rut='$rut' OR correo='$correo'";

$consulta = mysqli_query($conexion, $q);
$array = mysqli_fetch_array($consulta);

if($array['contar']>0){
    echo "Ya existe un usuario con los siguientes datos.";
    header("location: ../controller/Tecnico/registrartecnico.php");
}else{
    if($pass == '' or $correo == '' or $nombre == '' or $rut ==''){
        echo "Rellene todos los campos.";
        header("location: ../controller/Tecnico/registrartecnico.php");
    }else{
        echo "Registro correcto";
        $insertardatos = "INSERT INTO `personal`(`Rut`, `ID_Cargo`, `password`, `Nombre`, `correo`) VALUES ('".$rut."','".$rol."' ,'".$pass."','".$nombre."','".$correo."');";
        $ejecutarinsert = $conexion->query($insertardatos);

        if($ejecutarinsert){
            header("Location: ../controller/Tecnico/registrartecnico.php");
        }else{
            echo "Error de registro";
        }
    }
} */



?>