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

    public function crearCuenta()
    {
        $departamento = $this->estudiante->departamento();
        $programaEstudios = $this->estudiante->programaEstudios();
        $GradoAcademico = $this->estudiante->GradoAcademico();
        View::render(["registro/estudiantes"],['departamento' => $departamento, 'programaEstudios' => $programaEstudios, 'GradoAcademico' => $GradoAcademico]);
    }

    public function consultarDistrito()
    {
        $id = $_POST["id"];
        $respuesta = $this->estudiante->distrito($id);
        echo json_encode($respuesta);
    }

    public function CrearCuentaAlumno()
    {
        $datos = array(
            'nombres'        =>  $_POST['nombre'],
            'apellidos'      =>  $_POST['apellido'],
            'dni'            =>  $_POST['dni'],
            'telefono'       =>  $_POST['telefono'],
            'email'          =>  $_POST['correo'],
            'nacimiento'     =>  $_POST['nacimiento'],
            'provincia'      =>  $_POST['departamento'],
            'distrito'       =>  $_POST['distrito'],
            'password'       =>  password_hash($_POST['dni'], PASSWORD_DEFAULT),
            'programa_estudio' => $_POST['programa_estudio'],
            'grado_academico'  => $_POST['grado_academico']
        );
        $respuesta = $this->estudiante->RegistrarCuentaAlumno($datos);
        echo json_encode($respuesta);
    }

    public function verificarAlumno()
    {
        $dni = $_POST['dni'];
        $respuesta = $this->estudiante->VerificarAlumnoRepetidos($dni);
        echo json_encode($respuesta);
    }
}
