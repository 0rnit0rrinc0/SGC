<?php

 class Ip{

    private $ip;
    private $rut;
    private $departamento;
    private $nombreUsuario;


    public function consultarIP($ip, $nombreUsuario){
        $conexion = new Conexion();
        $conexion->conexion;


        $q = "SELECT * FROM `red` WHERE `IP` = '$ip' OR `nombre_usuario` = '$nombreUsuario'";
        $consulta = $conexion->conexion->query($q);

        if($consulta->num_rows){
            return true;
        }else{
            return false;
        }

    } 

    public function registrarIP($ip, $rut, $departamento, $nombreUsuario){

        $conexion = new Conexion();
        $conexion->conexion;
        
        $q = "INSERT INTO `red`(`IP`, `Rut`, `departamento`, `nombre_usuario`) VALUES ('".$ip."','".$rut."','".$departamento."','".$nombreUsuario."');";

        $consulta = $conexion->conexion->query($q);

        if($consulta){
            return true;
        }else{
            return false;
        }

    }

    public function mostrarIP(){
        $conexion = new Conexion();

        $q = "SELECT * FROM red";
        $consulta = $conexion->conexion->query($q);


        //Muestra los detalles de la variable.
        //var_dump($consulta);

        if($consulta->num_rows){
            return $consulta;
        }else{
            return false;
        }
    }

    public function desvincular($ip){
        $conexion = new Conexion();

        $q = "DELETE FROM `red` WHERE `red`.`IP` = '$ip';";
        $consulta = $conexion->conexion->query($q);

        if($consulta){
            return true;
        }else{
            return false;
        }
    }




 }



?>
