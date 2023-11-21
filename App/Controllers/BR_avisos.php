<?php

namespace App\Controllers; 

use Dompdf\Dompdf;
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

    public function crearCuenta()
    {
        $distrito = $this->avisos->Distrito();
        $empresas = $this->avisos->empresas();
        $carrera = $this->avisos->Carrera();
        $grado_academico = $this->avisos->GradoAcademico();
        View::render(['registro/crear_avisos'],['empresas' => $empresas, 'carrera' => $carrera, 'distrito' => $distrito, 'grado_academico' => $grado_academico]);
    }

    public function BusquedaRapidaAviso()
    {
        $valor = $_POST['data'];
        $respuesta = $this->avisos->BusquedaRapidaAviso($valor);
        echo json_encode($respuesta);
    }

    public function CrearAviso()
    {
        $data = array(
            'empresa_id'            => $_POST['id_empresa'],
            'titulo'                => $_POST['titulo_aviso'],
            'link'                  => $_POST['titulo_aviso'], 
            'distrito_id'           => $_POST['id_distrito'],
            'descripcion'           => $_POST['descripcion_aviso'],
            'direccion'             => $_POST['direccion_aviso'],
            'referencia'            => $_POST['referencia_aviso'],
            'salario'               => $_POST['salario_aviso'],
            'vacantes'              => $_POST['vacantes_aviso'],
            'carrera'               => $_POST['id_carrera'],
            'solicita_grado'        => $_POST['grado_academic_aviso'],
            'ciclo'                 => $_POST['ciclo_aviso'],
            'creacion_aviso'        => $_POST['creacion_aviso'],
            'vigencia'              => $_POST['vigencia_aviso']
        );
        $respuesta = $this->avisos->RegistroAviso($data);
        if($respuesta == "ok"){
            /* window.location.href='https://ial.edu.pe/admin_empleabilidad/BR_avisos/crearCuenta' */
            echo "<script> 
                    window.location.href='http://localhost:8080/admin_empleabilidad/BR_avisos/crearCuenta'
                    window.history.replaceState( null, null, window.location.href);
            </script>";
        }else{
            echo "<script> 
                    window.location.href='http://localhost:8080/admin_empleabilidad/BR_avisos/crearCuenta'
                    window.history.replaceState( null, null, window.location.href);
            </script>";
        }
/*         $distrito = $this->avisos->Distrito();
        $empresas = $this->avisos->empresas();
        $carrera = $this->avisos->Carrera();
        $grado_academico = $this->avisos->GradoAcademico();
        View::render(['registro/crear_avisos'],['empresas' => $empresas, 'carrera' => $carrera, 'distrito' => $distrito, 'grado_academico' => $grado_academico]); */
    }

    public function ListaAvisosCreados()
    {
        $respuesta = $this->avisos->ListaAvisosCreados();
        View::renderJson($respuesta);
    }

}
