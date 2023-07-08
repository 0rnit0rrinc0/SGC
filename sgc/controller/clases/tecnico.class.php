<?php

require_once 'personal.class.php';

    class Tecnico extends Personal{

        public function obtenerTecnicos(){
            $objconexion = new Conexion();

            $q = "SELECT `personal`.`Nombre`, `personal`.`ID_Cargo`, `personal`.`estado`
            FROM `personal` WHERE `personal`.`ID_Cargo` = '1' AND `personal`.`estado` = 'Activo';";

            $consulta = $objconexion->conexion->query($q);

            if($consulta){
                return $consulta;
            }else{
                return false;
            }

        }

        /* public function obtenerEquipos($nombre)
        {
            $objconexion = new Conexion();

            $q = "SELECT `solicitud`.`ID_Solicitud`, `estado`.`estado`, `estado`.`fecha`, `personal`.`Nombre` FROM `solicitud` LEFT JOIN `estado` ON `estado`.`ID_Solicitud` = `solicitud`.`ID_Solicitud` LEFT JOIN `personal` ON `solicitud`.`Rut` = `personal`.`Rut`
            WHERE `Nombre` ='$nombre';";
            $consulta = $objconexion->conexion->query($q);

            if($consulta){
                return $consulta;
            }else{
                return false;
            }

        } */

    }

?>