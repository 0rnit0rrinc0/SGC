<?php

class Mantenimiento
{
    private $id_solicitud;
    private $id_mantencion;
    private $id_equipo;
    private $observacion;
    private $serie_equipo;
    private $ram;
    private $almacenamiento;

    public function validarMantenimiento($id_solicitud)
    {
        $objconexion = new Conexion();

        //Consultamos si existe un mantenimiento registrado con la id de la solicitud asignada, 
        $q = "SELECT * FROM `mantenimiento` WHERE ID_Solicitud='$id_solicitud'";
        $consulta = $objconexion->conexion->query($q);

        //En caso de encontrar retornamos->true, en caso contrario false.
        if ($consulta->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerMantenimientos()
    {

        $objconexion = new Conexion();

        $q = "SELECT * FROM `mantenimiento`";
        $consulta = $objconexion->conexion->query($q);

        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }

    public function obtenerMantenimientosDocumento()
    {

        $objconexion = new Conexion();

        $q = "SELECT p.`Rut` AS `ru`, `s`.`ID_Solicitud` AS `soli`, `m`.`ID_Mantenimiento` AS `idmanten`, p.`Nombre` AS `name`
        FROM `personal` AS `p`
        INNER JOIN `solicitud` AS `s` ON `p`.`Rut` = `s`.`Rut` 
        INNER JOIN `mantenimiento` AS `m` ON `s`.`ID_Solicitud` = `m`.`ID_Solicitud` ";
        $consulta = $objconexion->conexion->query($q);

        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }




    public function registrarMantenimiento($id_solicitud, $id_equipo, $serie_equipo, $ram, $almacenamiento, $observacion, $fecha)
    {
        $objconexion = new Conexion();

        //Insertamos los datos en nuestra tabla mantenimiento.
        $q = "INSERT INTO `mantenimiento`(`ID_Solicitud`, `ID_Equipo`, `serie_equipo`, `ram`, `almacenamiento`, `observacion`, `fecha_manten`) VALUES ('" . $id_solicitud . "','" . $id_equipo . "','" . $serie_equipo . "','" . $ram . "','" . $almacenamiento . "','" . $observacion . "','".$fecha."')";
        $consulta = $objconexion->conexion->query($q);

        //Si nuestra insercion se realizo de manera correcta retorna->true, de lo contrario false.
        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }

    public function datosdocument($id_mantencion)
    {
        $objconexion = new Conexion();

        $q = "SELECT `mantenimiento`.*, `solicitud`.`ID_Solicitud`, `solicitud`.`Rut`, `personal`.`Rut`, `personal`.`Nombre`, `solicitud`.`fecha`
        FROM `mantenimiento` 
            LEFT JOIN `solicitud` ON `mantenimiento`.`ID_Solicitud` = `solicitud`.`ID_Solicitud` 
            LEFT JOIN `personal` ON `solicitud`.`Rut` = `personal`.`Rut` WHERE `ID_Mantenimiento` = '$id_mantencion';";

        $consulta = $objconexion->conexion->query($q);

        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }
}
