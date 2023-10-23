<?php

namespace App\Controllers; 

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\BR_estudiantesModel;
use Core\View;
use Core\Util;

class BR_estudiantes
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> estudiante = new BR_estudiantesModel();
    }

    public function index()
    {
        View::render(["busquedasRapidas/estudiantes"]);
    }

    public function BusquedaRapidaEstudiantes()
    {
        $valor = $_POST['data'];
        $respuesta = $this->estudiante->BusquedaRapidaEstudiantes($valor);
        echo json_encode($respuesta);
    }

}
