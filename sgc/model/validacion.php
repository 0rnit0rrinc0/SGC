<?php

require_once '../config/conexion.php';
require_once '../controller/clases/personal.class.php';

$personal = new Personal();

//Funciona dentro de un servidor "Apache"
//HTML = Nivel del cliente -> Envia datos al servidor
//PHP = Toma los datos enviados en el servidor

//1. Toma los datos enviados por el usuario y los almacena en dos $rut y $contra

//Operador ternario
//Variable = (pregunta) ? valor_si_verdadero : valor_si_falso;

$rut = (isset($_POST['rut'])) ? $_POST['rut'] : null;
$psw = (isset($_POST['psw'])) ? sha1(md5($_POST['psw'])) : null;
/* 
echo $rut;
echo "<br>";
echo $psw;
echo "<br>";
echo sha1(md5('1234'));
echo "<br>"; */


/* $rut = $_POST["rut"]; */
/* $contra = $_POST["psw"]; */

//2. Ejecuta el metodo de consulta ("Validacion de usuario").
$validar = $personal->validarUsuario($rut, $psw);


//El metodo puede ser implementado dentro del IF
//Validar ya es un booleano con TRUE O FALSE
if ($validar){
    //echo "Mensaje: ".$validar;
    
    //Crear otro metodo para almacenar en el array SESSION (Rut, Nombre, Rol)
    session_start();
    
    //Llamar a un metodo de personal que obtenga los datos del usuario
    $personal->obtenerDatos($rut);
    
    $_SESSION['rut'] = $personal->getRut();
    $_SESSION['nombre'] = $personal->getNombre();
    $_SESSION['rol'] = $personal->getRol();
    $_SESSION['departamento'] = $personal->getDepartamento();
    $_SESSION['correo'] = $personal->getCorreo();
    $_SESSION['sexo'] = $personal->getSexo();

    if (($_SESSION['rol'] == 1) or ($_SESSION['rol'] == 3)){
        header("Location: ../controller/tecnico/bienvenida.php");
    }elseif($_SESSION['rol'] == 2){
        header("Location: ../controller/funcionario/bienvenida.php");
    }

}else{

    //echo "Error";
    header("Location: ../index.php?error=1");
}

/* $q = "SELECT COUNT(*) as contar from personal where RUT='$usuario' AND password='$clave'";

$consulta = mysqli_query($conexion, $q);
$array = mysqli_fetch_array($consulta);
 */






?>
