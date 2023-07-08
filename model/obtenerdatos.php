<?php
require_once "../config/conexion.php";
require_once "../controller/clases/mantenimiento.class.php";

$objmantencion = new Mantenimiento();

$idmanten = (isset($_POST['soli'])) ? $_POST['soli'] : null;

$datos = $objmantencion->datosdocument($idmanten);

if ($datos) {
    while($mostrar = $datos->fetch_assoc()){

        $idmanten = $mostrar['ID_Mantenimiento'];
        $idsoli = $mostrar['ID_Solicitud'];
        $idequi = $mostrar['ID_Equipo'];
        $serie = $mostrar['serie_equipo'];
        $ram = $mostrar['ram'];
        $alma = $mostrar['almacenamiento'];
        $obser = $mostrar['observacion'];
        $fechasoli = $mostrar['fecha'];
        $rut = $mostrar['Rut'];
        $nombre = $mostrar['Nombre'];

        $fsoli = explode('-', $mostrar['fecha_manten']);
        $f = $fsoli[2] . '-' . $fsoli[1] . '-' . $fsoli[0];

        header("Location: ../controller/tecnico/documento.php?idmanten=$idmanten&idsoli=$idsoli&idequi=$idequi&serie=$serie&ram=$ram&alma=$alma&obser=$obser&fechamanten=$f&fechasoli=$fechasoli&rut=$rut&nombre=$nombre");
        /* echo($mostrar['ID_Mantenimiento']);
        echo "<br>";
        echo($mostrar['fecha_manten']);
        echo "<br>";
        echo($mostrar['ram']); */
    }
}
