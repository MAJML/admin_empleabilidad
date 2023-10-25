<?php

namespace App\Controllers;

use App\Model\InicioModel;
use Core\View;
use Core\Util;

class Inicio
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> inicioModel = new InicioModel();
        $_SESSION['alumnos_online'] = $this->inicioModel->alumnosOnline();
    }

    public function index()
    {
        View::render(["inicio/index"]);
    }

    public function alumnosOnline()
    {
        
    }

    public function ReporteEmpleador()
    {
        $respuesta = $this->inicioModel->ReporteEmpleadorModel();
        View::renderJson($respuesta);
    }

    public function ReporteEstudiante()
    {
        $respuesta = $this->inicioModel->ReporteEstudianteModel();
        view::renderJson($respuesta);
    }

    public function DatosGenerale()
    {
        $fecha_inicio = date("Y-m-d", strtotime($_POST['fecha_ini']));
        $fecha_final = date("Y-m-d", strtotime($_POST['fecha_final']));
        $contadorEmpleadores = $this -> inicioModel -> ContadorEmpleadores($fecha_inicio, $fecha_final);
        $contadorEstudiantes = $this -> inicioModel -> ContadorEstudiantes($fecha_inicio, $fecha_final);
        $contadorAvisos = $this -> inicioModel -> ContadorAvisos($fecha_inicio, $fecha_final);

        $EmpleadorPJuridica = $this -> inicioModel -> ContadorEmpleadorPersonaJuridica($fecha_inicio, $fecha_final);
        $EmpleadorPNatural = $this -> inicioModel -> ContadorEmpleadorPersonaNatural($fecha_inicio, $fecha_final);
        $EmpleadorPNtNegocio = $this -> inicioModel -> ContadorEmpleadorPersonaNconNegocio($fecha_inicio, $fecha_final);

        $AlumnoEnfermeria = $this -> inicioModel -> ContadorAlumnoEnfermeria($fecha_inicio, $fecha_final);
        $AlumnoFarmacia = $this -> inicioModel -> ContadorAlumnoFarmacia($fecha_inicio, $fecha_final);
        $AlumnoFisioterapia = $this -> inicioModel -> ContadorAlumnoFisioterapia($fecha_inicio, $fecha_final);
        $AlumnoLaboratorio = $this -> inicioModel -> ContadorAlumnoLaboratorio($fecha_inicio, $fecha_final);
        $AlumnoProtesis = $this -> inicioModel -> ContadorAlumnoProtesis($fecha_inicio, $fecha_final);

        $AvisosEnfermeria = $this -> inicioModel -> ContadorAvisosEnfermeria($fecha_inicio, $fecha_final);
        $AvisosFarmacia = $this -> inicioModel -> ContadorAvisosFarmacia($fecha_inicio, $fecha_final);
        $AvisosFisioterapia = $this -> inicioModel -> ContadorAvisosFisioterapia($fecha_inicio, $fecha_final);
        $AvisosLaboratorio = $this -> inicioModel -> ContadorAvisosLaboratorio($fecha_inicio, $fecha_final);
        $AvisosProtesis = $this -> inicioModel -> ContadorAvisosProtesis($fecha_inicio, $fecha_final);

        $data  = [
            'empleadores' => $contadorEmpleadores, 
            'estudiantes' => $contadorEstudiantes,
            'avisos'      => $contadorAvisos ,
            'empPersonaJ' => $EmpleadorPJuridica,
            'empPersonaN' => $EmpleadorPNatural,
            'empPersonaNnegocio' => $EmpleadorPNtNegocio,
            'estEnfermeria' => $AlumnoEnfermeria,
            'estFarmacia' => $AlumnoFarmacia,
            'estFisioterapia' => $AlumnoFisioterapia,
            'estLaboratorio' => $AlumnoLaboratorio,
            'estProtesis' => $AlumnoProtesis,
            'avisoEnfermeria' => $AvisosEnfermeria,
            'avisoFarmacia' => $AvisosFarmacia,
            'avisoFisioterapia' => $AvisosFisioterapia,
            'avisoLaboratorio' => $AvisosLaboratorio,
            'avisoProtesis' => $AvisosProtesis
        ];
        View::renderJson($data);
    }

}
