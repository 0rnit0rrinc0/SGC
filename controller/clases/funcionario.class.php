<?php

require_once 'personal.class.php';


    class Funcionario extends Personal{

        public function validarRegistroFuncionario($rut,  $correo)
        {
            //Se crea el objeto conexión
            $conexion = new Conexion();
            //Instanciamos al componente del objeto 
            $conexion->conexion;

            $q = "SELECT * FROM personal where Rut='$rut' OR correo='$correo'";
            $consulta = $conexion->conexion->query($q);
            if($consulta->num_rows){
                return true;
            }else{
                return false;
            }

            /* $conexion = new Conexion();
            $q = "SELECT COUNT(*) as contar from personal where Rut='$rut' OR correo='$correo'";
            $consulta = mysqli_query($this->$conexion,$q);
            $array = mysqli_fetch_array($consulta);

            if($array['contar']>0){
                echo "Ya existe un usuario con los siguientes datos.";
            }else{
                $pass_fuerte = password_hash($contraseña, PASSWORD_DEFAULT, ['cost' => 3]);
                $insertardatos = "INSERT INTO `personal`(`Rut`, `Nombre`, `correo`, `password`, `ID_Cargo`) VALUES ('".$rut."','".$nombre."','".$correo."','".$pass_fuerte."','".$rol."');";
                $ejecutarinsert = $this->$conexion->query($insertardatos);

            } */
        }

        public function registrarFuncionario($rut, $nombre, 
        $sexo, $correo, $contraseña, $rol, $departamento, $estado ){

            //Se crea el objeto conexión
            $conexion = new Conexion();
            //Instanciamos al componente del objeto 
            $conexion->conexion;

            $q = "INSERT INTO `personal`(`Rut`, `Nombre`, `sexo`, `correo`, `departamento`, `password`, `ID_Cargo`, `estado`) VALUES ('".$rut."','".$nombre."','".$sexo."','".$correo."','".$departamento."','".$contraseña."','".$rol."','".$estado."')";
            $consulta = $conexion->conexion->query($q);

            if($consulta){
                return true;
            }else{
                return false;
            }


        }

        public function obtenerEquipos($nombre)
        {
            $objconexion = new Conexion();

            $q = "SELECT `solicitud`.`ID_Solicitud`, `solicitud`.`fecha`, `personal`.`Nombre` FROM `solicitud` LEFT JOIN `personal` ON `solicitud`.`Rut` = `personal`.`Rut`
            WHERE `Nombre` ='$nombre';";
            $consulta = $objconexion->conexion->query($q);

            if($consulta){
                return $consulta;
            }else{
                return false;
            }

        }

        

    }

?>