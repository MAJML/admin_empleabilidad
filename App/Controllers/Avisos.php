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
use App\Model\AvisosModel;
use Core\View;
use Core\Util;

class Avisos
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> Estudiante = new AvisosModel();
    }

    public function index()
    {
        $distrito = $this->Estudiante->Distrito();
        $carrera = $this->Estudiante->Carrera();
        $grado_academico = $this->Estudiante->GradoAcademico();
        $estadoPost = $this->Estudiante->EstadoPost();
        View::render(["avisos/index"], ['distrito' => $distrito, 'carrera' => $carrera, 'grado_academico' => $grado_academico, 'estadoPost' => $estadoPost]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $respuesta = $this -> Estudiante -> ListarAvisosPorFechas($fecha_inicial, $fecha_final, $validacion);
        echo json_encode($respuesta);
    }

    public function RegistrarDataPostulantes()
    {
        $datos = array("aviso_id"          => $_POST["aviso_id"],
                        "nombre"            => $_POST["nombre"],
                        "dni"               => $_POST["dni"],
                        "celular"           => $_POST["celular"],
                        "correo"            => $_POST["correo"],
                        "grado_academico"   => $_POST["grado_academico"],
                        "estado"            => $_POST["estado"]);
        $respuesta = $this -> Estudiante -> RegistrarPostulantemManual($datos);
        echo json_encode($respuesta);
    }

    public function ListarTablaPostulantesManual()
    {
        $id = $_POST['id'];
        $respuesta = $this -> Estudiante -> ListarTablaPostulantesManual($id);
        echo json_encode($respuesta);
    }

    public function verAviso()
    {
        $id= $_POST["id"];
        $respuesta = $this->Estudiante->verDataAviso($id);
        echo json_encode($respuesta);
    }

    public function TraeDataAvisoModific()
    {
        $id=$_POST["id"];
        $respuesta = $this->Estudiante->verDataAviso($id);
        echo json_encode($respuesta);
    }

    public function RegistrarCuadroSeguimiento()
    {
        $datos = array("fecha_envio_postulante" => $_POST["fecha_envio_postulante"],
                        "aviso_id_f"            => $_POST["aviso_id_f"],
                        "fecha_seguimiento"     => $_POST["fecha_seguimiento"],
                        "comentario"            => $_POST["comentario"]);
        $respuesta = $this->Estudiante->RegistrarCuadroSeguimiento($datos);
        echo json_encode($respuesta);
    }

    public function ConsultarAlumno()
    {
        $alumno = $_POST['data'];
        $idAviso = $_POST['idAviso'];
        $respuesta = $this->Estudiante->ConsultarAlumno($alumno, $idAviso);
        echo json_encode($respuesta);
    }

    public function ValidarAlumnoID()
    {
        $id = $_POST['id'];
        $idAviso = $_POST['idAviso'];
        $respuesta = $this->Estudiante->ValidarAlumnoID($id, $idAviso);
        echo json_encode($respuesta);
    }

    public function SelectAlumnoID()
    {
        $id = $_POST['id'];
        $respuesta = $this->Estudiante->SelectAlumnoID($id);
        echo json_encode($respuesta);
    }

    public function AgregarAlumnoPostulante()
    {
        $idAlumnos = $_POST['alumnos'];
        $idAviso = $_POST['idAviso'];
        $respuesta = $this->Estudiante->AgregarAlumnoPostulante($idAlumnos, $idAviso);
        echo json_encode($respuesta);
    }

    public function TraerDataPorID()
    {
        $id = $_POST['id'];
        $respuesta = $this->Estudiante->VerAvisosAlumnos($id);
        echo json_encode($respuesta);
    }

    public function EditarEstadoPost()
    {
        $datos = array(
            'idEstado' => $_POST['estado_postulante'],
            'idAviso' => $_POST['idAviso'],
            'idAlumno' => $_POST['idAlumno'],
            'fechaPostulacion'  => $_POST['fecha_registro_postulante']
        );
        $respuesta = $this->Estudiante->EditarEstadoPost($datos);
        echo json_encode($respuesta);
    }

    public function EliminarDataID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> Estudiante -> EliminarDataEmpleadores($id);
        echo json_encode($respuesta);
    }

    public function ModificarAviso()
    {
        $datos = array("id_aviso" => $_POST["id_aviso"],
                       "mod_form_titulo" => $_POST["mod_form_titulo"],
                       "mod_form_distrito" => $_POST["mod_form_distrito"],
                       "mod_form_vacantes" => $_POST["mod_form_vacantes"],
                       "mod_form_carrera" => $_POST["mod_form_carrera"],
                       "mod_form_estado" => $_POST["mod_form_estado"],
                       "mod_form_vigencia" => $_POST["mod_form_vigencia"],
                       "mod_form_grado" => $_POST["mod_form_grado"],
                       "mod_form_descripcion" => $_POST["mod_form_descripcion"],
                       "mod_form_salario" => $_POST["mod_form_salario"]);
        $respuesta = $this->Estudiante->ModificarAviso($datos);
        echo json_encode($respuesta);
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 3) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $data_valida = func_get_arg(2);
            $validacion = str_replace("andA.solicita_carrera=", "AND A.solicita_carrera=", $data_valida);
        }else if(func_num_args() == 2){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet -> getProperties()->setCreator("Reporte Excel Avisos")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A1:L1');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A1', 'LISTA DE AVISOS');
        $spreadsheet -> getActiveSheet()->getStyle('A1:L1')->getFont()->setSize(18);
        $spreadsheet -> getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        $spreadsheet -> getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A2:P2');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $spreadsheet -> getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $spreadsheet -> getActiveSheet()->getStyle('A3:L3')->getFont()->setSize(11);
        $spreadsheet -> getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:L3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $spreadsheet -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(24);
        $hojaActiva -> getColumnDimension('C')->setWidth(30);
        $hojaActiva -> getColumnDimension('D')->setWidth(40);
        $hojaActiva -> getColumnDimension('E')->setWidth(40);
        $hojaActiva -> getColumnDimension('F')->setWidth(20);
        $hojaActiva -> getColumnDimension('G')->setWidth(35);
        $hojaActiva -> getColumnDimension('H')->setWidth(25);
        $hojaActiva -> getColumnDimension('I')->setWidth(25);
        $hojaActiva -> getColumnDimension('J')->setWidth(20);
        $hojaActiva -> getColumnDimension('K')->setWidth(30);
        $hojaActiva -> getColumnDimension('L')->setWidth(30);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'FECHA DE REGISTRO')
                    -> setCellValue('C3', 'TIPO DE PERSONA')
                    -> setCellValue('D3', 'RUC / DNI')
                    -> setCellValue('E3', 'RAZON SOCIAL / NOMBRE COMPLETO')
                    -> setCellValue('F3', 'NOMBRE COMERCIAL')
                    -> setCellValue('G3', 'TITULO DE PUESTO')
                    -> setCellValue('H3', 'DISTRITO')
                    -> setCellValue('I3', 'GRADO ACADÉMICO SOLICITADO')
                    -> setCellValue('J3', 'FECHA DE VIGENCIA')
                    -> setCellValue('K3', 'REMUNERACIÓN')
                    -> setCellValue('L3', 'CANTIDAD DE VACANTES');
        /* END CABEZERA TABLA EXCEL */


        $respuesta = $this -> Estudiante -> ListarAvisosPorFechas($fecha_inicial, $fecha_final, $validacion);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;
            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, $valor->tipo_persona)
                        -> setCellValue('D' . $i, $valor->rucEmpresa)
                        -> setCellValue('E' . $i, $valor->razon_social)
                        -> setCellValue('F' . $i, $valor->nombre_comercial)
                        -> setCellValue('G' . $i, $valor->titulo)
                        -> setCellValue('H' . $i, $valor->nombre_distrito)
                        -> setCellValue('I' . $i, $valor->grado_academico)
                        -> setCellValue('J' . $i, $valor->periodo_vigencia)
                        -> setCellValue('K' . $i, $valor->salario)
                        -> setCellValue('L' . $i, $valor->vacantes);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Avisos.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }

}
