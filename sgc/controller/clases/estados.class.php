<?php

class Estados
{

    private $id_solicitud;
    private $estado;
    private $responsable;
    private $observacion;
    private $fecha;

    public function validarEstadoARegistrar($id_solicitud, $estado)
    {

        $objconexion = new Conexion();

        //Consultamos si el estado ha sido registrado anteriormente con la misma solicitud

        $q = "SELECT * FROM `estado` WHERE estado='$estado' AND ID_Solicitud='$id_solicitud'";
        $consulta = $objconexion->conexion->query($q);

        //Si es encontrado algun campo coincidente entones -> True o de lo contrario False
        if ($consulta->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function registrarEstado($id_solicitud, $estado, $responsable, $observacion, $fecha)
    {

        $objconexion = new Conexion();

        //Insertamos los datos en neustra BD
        $q = "INSERT INTO `estado`(`ID_Solicitud`, `estado`, `responsable`, `observacion`, `fecha`) VALUES ('" . $id_solicitud . "','" . $estado . "','" . $responsable . "','" . $observacion . "','" . $fecha . "')";
        $consulta = $objconexion->conexion->query($q);

        //Si la insercion se realizo con exito -> true, de lo contrario false
        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerEstadosRegistrados()
    {
        $objconexion = new Conexion();

        //Obtenemos los datos almacenados en la tabla
        $q = "SELECT * FROM `estado`";
        $consulta = $objconexion->conexion->query($q);

        //Si la consulta encuentra datos almacenados entones retornamos -> Consulta(Datos obtenidos), de lo contrario false.
        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }

    public function obtenerEstadosRegistradosF($id_solicitud)
    {
        $objconexion = new Conexion();

        //Obtenemos los datos almacenados en la tabla
        $q = "SELECT * FROM `estado` WHERE `ID_Solicitud` = '$id_solicitud'";
        $consulta = $objconexion->conexion->query($q);

        //Si la consulta encuentra datos almacenados entones retornamos -> Consulta(Datos obtenidos), de lo contrario false.
        if ($consulta->num_rows) {
            return $consulta;
        } else {
            return false;
        }
    }

    public function obtenerNEstados($id_solicitud)
    {

        $objconexion = new Conexion();

        $q = "SELECT * FROM `estado` WHERE `estado`.`ID_Solicitud` = '$id_solicitud';";

        $consulta = $objconexion->conexion->query($q);

        if($consulta){
            return $consulta;
        }else{
            return false;
        }
    }
}
