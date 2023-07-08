<?php

 //Accedemos a la información de configuracion

require_once('config.php');

//Clase para conectarnos a la BD

class Conexion {
    public $conexion;

    public function __construct()
    {

        //Conectamos
        $this->conexion = new mysqli(DB_HOST, DB_USUARIO, DB_CONTRA, DB_NOMBRE);


        //En caso no podemos conectarnos.
        if( $this->conexion->connect_errno) {

            echo "Fallo al conectar a MySQL:" . $this->conexion->connect_error;
            return false;
        }

        //Admitimos la Ñ como caracter
          $this->conexion->set_charset(DB_CHARSET);

    }

} 


?>