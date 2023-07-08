<?php

class Solicitud
{
    private $id_solicitud;
    private $rut;
    private $solicitud;
    private $fecha;

    public function insertarSolicitud($rut, $solicitud, $fecha)
    {

        $conexion = new Conexion();
        $conexion->conexion;

        $q = "INSERT INTO `solicitud`(`Rut`, `solicitud`, `fecha`) VALUES ('" . $rut . "','" . $solicitud . "','" . $fecha . "')";
        $consulta = $conexion->conexion->query($q);

        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }



    //COMPLETAR OBTENCIÓN DE DATOS.

    public function obtenerSolicitud()
    {

        $conexion = new Conexion();
        $conexion->conexion;

        $q = "SELECT * FROM `solicitud`";
        $consulta = $conexion->conexion->query($q);

        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }

    public function obtenerIDSolicitud()
    {
        $conexion = new Conexion();
        $conexion->conexion;

        $q = "SELECT s.`ID_Solicitud` AS `soli`, s.`fecha` AS `f` , p.`Nombre` AS `name` FROM `solicitud` AS s, `personal` AS p WHERE p.`Rut` = s.`Rut`;";
        $consulta = $conexion->conexion->query($q);

        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }

    /* public function obtenerSoli($nombre)
    {

        $objconexion = new Conexion();

        $q = "SELECT `solicitud`.`ID_Solicitud`, `solicitud`.`fecha`, `personal`.`Nombre`
        FROM `solicitud` 
            LEFT JOIN `personal` ON `solicitud`.`Rut` = `personal`.`Rut`
            WHERE `Nombre` ='$nombre';";

        $consulta = $objconexion->conexion->query($q);

        if ($consulta) {
            return $consulta;
        } else {
            return false;
        }
    } */

    public function obtenerSoliMantencion()
    {

        $objconexion = new Conexion();

        $q = "SELECT `solicitud`.`ID_Solicitud`, `solicitud`.`fecha`, `personal`.`Nombre`, `estado`.`estado`
        FROM `solicitud` 
            LEFT JOIN `personal` ON `solicitud`.`Rut` = `personal`.`Rut` 
            LEFT JOIN `estado` ON `estado`.`ID_Solicitud` = `solicitud`.`ID_Solicitud`
             WHERE `estado`.`estado` = 'Solucionado';";

        $consulta = $objconexion->conexion->query($q);

        if ($consulta) {
            return $consulta;
        } else {
            return false;
        }
    }
}
