<?php

require_once '../config/conexion.php';
require_once '../controller/clases/funcionario.class.php';


$funcionario = new Funcionario();

if($_POST['psw'] == $_POST['psw2']){
    $psw = (isset($_POST['psw'])) ? sha1(md5($_POST['psw'])) : null;
    $rut = (isset($_POST['rut'])) ? $_POST['rut'] : null;
    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
    $correo = (isset($_POST['email'])) ? $_POST['email'] : null;
    $depa = (isset($_POST['departamento'])) ? $_POST['departamento'] : null;
    $sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : null;
    $rol = 2;
    $estado = "Activo";
    
    $validarRegistro = $funcionario->validarRegistroFuncionario($rut, $correo);
    
    if($validarRegistro){
        header("Location: ../controller/registrar.php?error=datosexistentes");
    }else{
        if ($funcionario->registrarFuncionario($rut, $nombre, $sexo, $correo, $psw, $rol, $depa, $estado)){
            header("Location: ../index.php?g=registrocompleto");
        }
    }
}else{
    header("Location: ../controller/registrar.php?error=passwordIncorrecta");
}







?>