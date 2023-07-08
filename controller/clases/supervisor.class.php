<?php


require_once 'personal.class.php';

class Supervisor extends Personal
{

    public function validarRegistroTecnico($rut,  $correo)
    {
        //Se crea el objeto conexión
        $conexion = new Conexion();
        //Instanciamos al componente del objeto 
        $conexion->conexion;

        $q = "SELECT * FROM personal where Rut='$rut' OR correo='$correo'";
        $consulta = $conexion->conexion->query($q);
        if ($consulta->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function registrarTecnico(
        $rut,
        $nombre,
        $sexo,
        $correo,
        $departamento,
        $contraseña,
        $rol,
        $estado
    ) {

        //Se crea el objeto conexión
        $conexion = new Conexion();
        //Instanciamos al componente del objeto 
        $conexion->conexion;

        $q = "INSERT INTO `personal`(`Rut`, `Nombre`, `sexo`, `correo`, `departamento`, `password`, `ID_Cargo`, `estado`) VALUES ('" . $rut . "','" . $nombre . "','" . $sexo . "','" . $correo . "','" . $departamento . "','" . $contraseña . "','" . $rol . "', '" . $estado . "')";
        $consulta = $conexion->conexion->query($q);

        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }



    public function listarFuncionarios(){
        $objconexion = new Conexion();

        $q = "SELECT * FROM `personal` ORDER BY `estado`;";

        $consulta = $objconexion->conexion->query($q);

        if($consulta){
            return $consulta;
        }else{
            return false;
        }
    }

    public function editarFuncionarios($rut, $nombre, $sexo, $correo, $departamento, $rol, $estado)
    {

        $objconexion = new Conexion();

        $q = "UPDATE `personal` SET `Nombre`='$nombre',`sexo`='$sexo',`correo`='$correo',`departamento`='$departamento',`ID_Cargo`='$rol',`estado`='$estado' WHERE `Rut` = '$rut'";

        $consulta = $objconexion->conexion->query($q);

        if($consulta){
            return true;
        }else{
            return false;
        }
    }

    public function cambiarContraseña($rut, $contraseña){

        $objconexion = new Conexion();

        $q = "UPDATE `personal` SET `password`='$contraseña' WHERE `Rut` = '$rut'";

        $consulta = $objconexion->conexion->query($q);

        if($consulta){
            return true;
        }else{
            return false;
        }

    }
}
