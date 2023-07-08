<?php

class Documento
{
    private $id_documento;
    private $id_solicitud;
    private $descripcion;
    private $ruta;
    private $nombre_documento;
    private $tipo_documento;
    private $tamano_documento;
    private $fecha;



    public function subirDocumento($id_solicitud, $descripcion, $ruta, $nombre_documento, $tipo_documento, $tamano_documento, $fecha)
    {

        $objconexion = new Conexion();

        $q = "INSERT INTO `documentos`(`id_solicitud`, `descripción`, `nombreFichero`, `ruta`, `tipo`, `tamaño`, `fecha`) VALUES ('".$id_solicitud."','".$descripcion."','".$nombre_documento."','".$ruta."','".$tipo_documento."','".$tamano_documento."', '".$fecha."')";
        $consulta = $objconexion->conexion->query($q);

        if($consulta){
            return true;
        }else{
            return false;
        }
    }

    public function validarDocumento($id_solicitud) {
        $objconexion = new Conexion();

        $q = "SELECT * FROM `documentos` WHERE `id_solicitud`='$id_solicitud'";
        $consulta = $objconexion->conexion->query($q);

        if($consulta->num_rows){
            return true;
        }else{
            return false;
        }
    }

    public function documentosSubidos(){
        $objconexion = new Conexion();

        $q = "SELECT * FROM `documentos` ";
        $consulta = $objconexion->conexion->query($q);

        if($consulta){
            return $consulta;
        }else{
            return false;
        }
    }
}
