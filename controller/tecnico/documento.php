<?php

require '../../fpdf/fpdf.php';

session_start();
$varsesion = $_SESSION['rut'];
if ($varsesion == null || $varsesion == '') {
    header("Location: ../../index.php");
}


class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../view/img/Logo_Municipalidad.jpg', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 30);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 80, 'Entrega', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);

        $this->SetFont('Arial', '', 14);
        $str = utf8_decode("Departamento de informática.");
        $this->Text(135, 32, $str);
        $this->Cell(350, 15, date('d-m-Y'), 0, 0, 'C');
        // Then put a blue underlined link
        $this->SetTextColor(0, 0, 255);
        $this->SetFont('', 'U');
        $this->Ln(30);

        $this->SetTextColor(0 , 0, 0);
        // Comienza con fuente regular
        $this->SetFont('Arial', '', 16);
        $this->Write (5, utf8_decode('Yo, ' . $_GET['nombre'] . ', con fecha ' . date('d/m/Y') . '  confirmo la recepción del equipo con el numero de ID ' .$_GET['idequi'] . ' y solicitud numero ' . $_GET['idsoli'] . ' asociada, de forma satisfactoria, soy consciente de todo el proceso realizado en el y se me han indicado las instrucciones pertinentes en caso de ser necesario.'));
        $this->Ln(10);
        $this->Write(5, utf8_decode('A la solicitud, '.$_GET['idsoli'].', se le ha especificado la siguiente información de mantenimiento: '));
        $this->Ln(10);
        $this->Text( 20,  100,  utf8_decode(' - Fecha de mantención: '.$_GET['fechamanten'].''));
        $this->Text( 20,  105,  utf8_decode(' - ID de mantención: '.$_GET['idmanten'].''));
        $this->Text( 20,  110,  ' - N de serie: '.$_GET['serie'].'');
        $this->Text( 20,  115,  ' - N de inventario: '.$_GET['idequi'].'');
        $this->Text( 20,  120,  ' - Cantidad de RAM: '.$_GET['ram'].'');
        $this->Text( 20,  125,  ' - Almacenamiento: '.$_GET['alma'].'');
        $this->SetXY(19, 126);
        $this->Write( 5, utf8_decode(' - Observación: '.$_GET['obser'].''));
    
        $this->Line(60, 200, 150, 200);
        $this->Text( 98,  210,  'FIRMA');
        $this->Text(85,  220,  utf8_decode(''.$_GET['nombre'].''));
        $this->Text(92,  225,  ''.$_GET['rut'].'');
        // Then put a blue underlined link
        $this->SetFont('', 'U');
    }


    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '', 0, 0, 'C');
    }
}
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetTitle("DocEntrega-" . date("d-m-Y") . "-" . $_GET['nombre'] . "", false);
$pdf->Output();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
/* for($i=1;$i<=40;$i++)
        $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1); */
$pdf->Output();
?>