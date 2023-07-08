<?php

//Puede ser innecesario en algunos casos, ya es llamado en validación.
//include_once ('../../config/conexion.php');

    class Personal {

        //Atributos
        private $rut;
        private $nombre;
        private $correo;
        private $contraseña;
        private $rol;
        private $sexo;
        private $departamento;
        private $estado;

        public function validarUsuario($rut, $contraseña){
            //Se crea el objeto
            $conexion = new Conexion();
            //Debo llamar al componente del objeto:
            $conexion->conexion;

            $q = "SELECT * FROM `personal` WHERE Rut='$rut' AND password='$contraseña' AND `estado` = 'Activo'";
            $consulta = $conexion->conexion->query($q);
            if($consulta->num_rows){
                return true;
            }else{
                return false;
            }
             
        } 
        //$rut y $contraseña son variables locales, son reemplazadas en cuando se ejecutan en otro sector.

        public function obtenerDatos($rut){

            //Se crea el objeto
            $conexion = new Conexion();
            //Debo llamar al componente del objeto:
            $conexion->conexion;

            $q = "SELECT * FROM `personal` WHERE Rut='$rut'";
            $consulta = $conexion->conexion->query($q);
            if($consulta->num_rows){
                $datos = $consulta->fetch_assoc();
                $this->rut=$datos['Rut'];
                $this->nombre=$datos['Nombre'];
                $this->sexo=$datos['sexo'];
                $this->correo=$datos['correo'];
                $this->departamento=$datos['departamento'];
                $this->rol=$datos['ID_Cargo'];
            }else{
                
            }
             
        } 

        public function obtenerRut(){
            //Se crea el objeto
            $conexion = new Conexion();
            //Debo llamar al componente del objeto:
            $conexion->conexion;

            $q = "SELECT `personal`.`Rut`, `personal`.`Nombre`
            FROM `personal`;";
            $consulta = $conexion->conexion->query($q);

            if($consulta->num_rows){
                return $consulta;
            }else{
                return false;
            }

        }

        

        //Metodos
            //GET
        public function getRut(){
            return $this->rut;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getCorreo(){
            return $this->correo;
        }
        public function getContraseña(){
            return $this->contraseña;
        }
        public function getRol(){
            return $this->rol;
        } 
        public function getSexo(){
            return $this->sexo;
        }
        public function getDepartamento(){
            return $this->departamento;
        }

            //SET
        public function setRut($rut){
            $this->rut = $rut;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        public function setCorreo($correo){
            $this->correo = $correo;
        }
        public function setContraseña($contraseña){
            $this->contraseña = $contraseña;
        }
        public function setRol($rol){
            $this->rol = $rol;
        }
        public function setSexo($sexo){
            $this->sexo = $sexo;
        }
        public function setDepartamento($departamento){
            $this->departamento = $departamento;
        }



       

    }
?>