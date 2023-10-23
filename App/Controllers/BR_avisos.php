<?php

namespace App\Controllers; 


/* use Fpdf\Fpdf; */

use Dompdf\Dompdf;

/* use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter; */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\BR_avisosModel;
use Core\View;
use Core\Util;

class BR_avisos
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> avisos = new BR_avisosModel();
    }

    public function index()
    {
        $distrito = $this->avisos->Distrito();
        $carrera = $this->avisos->Carrera();
        $grado_academico = $this->avisos->GradoAcademico();
        $estadoPost = $this->avisos->EstadoPost();
        View::render(["busquedasRapidas/avisos"], ['distrito' => $distrito, 'carrera' => $carrera, 'grado_academico' => $grado_academico, 'estadoPost' => $estadoPost]);
    }

    public function BusquedaRapidaAviso()
    {
        $valor = $_POST['data'];
        $respuesta = $this->avisos->BusquedaRapidaAviso($valor);
        echo json_encode($respuesta);
    }
}
