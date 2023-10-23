<?php

namespace App\Controllers;  
require_once "../public/PHPMailer/Exception.php";
require_once "../public/PHPMailer/PHPMailer.php";
require_once "../public/PHPMailer/SMTP.php";
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use App\Model\BR_empleadoresModel;
use Core\View;
use Core\Util;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class BR_empleadores
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> model = new BR_empleadoresModel();
    }

    public function index()
    {
        View::render(["busquedasRapidas/empleadores"]);
    }

    public function BusquedaRapidaEmpleador()
    {
        $valor = $_POST['data'];
        $respuesta = $this->model->BusquedaRapidaEmpleador($valor);
        echo json_encode($respuesta);
    }

}
