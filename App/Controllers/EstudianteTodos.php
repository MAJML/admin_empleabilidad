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
use App\Model\EstudianteTodosModel;
use Core\View;
use Core\Util;

class EstudianteTodos
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> Estudiante = new EstudianteTodosModel();
    }

    public function index()
    {
        View::render(["estudiantes/estudianteTodos"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $tipoEstudiante = $_POST['tipoEstudiante'];
        $respuesta = $this -> Estudiante -> ListaEstudiantePorFechas($fecha_inicial, $fecha_final, $validacion, $tipoEstudiante);
        echo json_encode($respuesta);
    }

    public function TraerDataPorID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> Estudiante -> VerDataDetalles($id);
        echo json_encode($respuesta);
    }

    public function EliminarDataID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> Estudiante -> EliminarDataEmpleadores($id);
        echo json_encode($respuesta);
    }

    public function validacionEmpleador()
    {
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $respuesta = $this -> Estudiante -> ValidacionEmpleador($id, $estado);
        echo json_encode($respuesta);
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 4) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $tipoEstudiante = func_get_arg(2);            
            $validacion = func_get_arg(3);

        }else if(func_num_args() == 3){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
            $tipoEstudiante = func_get_arg(2);   
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet -> getProperties()->setCreator("Reporte Excel Estudiantes Alumnos")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A1:K1');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A1', 'LISTA DE TODOS LOS ESTUDIANTES');
        $spreadsheet -> getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(18);
        $spreadsheet -> getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
        $spreadsheet -> getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A2:P2');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $spreadsheet -> getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $spreadsheet -> getActiveSheet()->getStyle('A3:K3')->getFont()->setSize(11);
        $spreadsheet -> getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:K3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $spreadsheet -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(24);
        $hojaActiva -> getColumnDimension('C')->setWidth(20);
        $hojaActiva -> getColumnDimension('D')->setWidth(40);
        $hojaActiva -> getColumnDimension('E')->setWidth(40);
        $hojaActiva -> getColumnDimension('F')->setWidth(20);
        $hojaActiva -> getColumnDimension('G')->setWidth(35);
        $hojaActiva -> getColumnDimension('H')->setWidth(25);
        $hojaActiva -> getColumnDimension('I')->setWidth(25);
        $hojaActiva -> getColumnDimension('J')->setWidth(20);
        $hojaActiva -> getColumnDimension('K')->setWidth(30);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'FECHA DE REGISTRO')
                    -> setCellValue('C3', 'DNI')
                    -> setCellValue('D3', 'APELLIDOS')
                    -> setCellValue('E3', 'NOMBRES')
                    -> setCellValue('F3', 'FECHA DE NACIMIENTO')
                    -> setCellValue('G3', 'DIRECCIÓN')
                    -> setCellValue('H3', 'CIUDAD')
                    -> setCellValue('I3', 'DISTRITO')
                    -> setCellValue('J3', 'TELEFONO')
                    -> setCellValue('K3', 'CORREO');
        /* END CABEZERA TABLA EXCEL */
        $respuesta = $this -> Estudiante -> ListaEstudiantePorFechas($fecha_inicial, $fecha_final, $validacion, $tipoEstudiante);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;
            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, $valor->dni)
                        -> setCellValue('D' . $i, $valor->apellidos)
                        -> setCellValue('E' . $i, $valor->nombres)
                        -> setCellValue('F' . $i, $valor->fecha_nacimiento)
                        -> setCellValue('G' . $i, $valor->direccion)
                        -> setCellValue('H' . $i, $valor->nombre_provincia)
                        -> setCellValue('I' . $i, $valor->nombre_distritos)
                        -> setCellValue('J' . $i, $valor->telefono)
                        -> setCellValue('K' . $i, $valor->email);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Todos los Estudiantes.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }

    public function PdfCV($id)
    {
        /* $id= $_POST['id']; */
        /* $id = 10952; */
        $styles = file_get_contents("../App/Views/estudiantes/cv_alumno.php");
        $alumno = $this->Estudiante->DataAlumnos($id);
        $distrito = $this->Estudiante->DataDistritos($alumno[0]->distrito_id);
        $experienciaLaboral = $this->Estudiante->DataExperienciaLaborals($alumno[0]->id);
        $educacion = $this->Estudiante->DataEducacion($alumno[0]->id);
        $cursos = $this->Estudiante->DataCursos($alumno[0]->id);

        foreach ($cursos as $key => $value) {
            $htmlCursos .= '
            <div class="caja_item_esperiencia">
                <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
                    <b class="text_empresa_experiencia">'.$value->name_curso.'</b> <br>
                    <b class="text_sector_experiencia">'.$value->institucion.'</b>
                </div>
                <div class="datos_experiencia_cursos">
                    <p> ( '.$value->inicio_curso.' - '.$value->fin_curso.' )</p>         
                </div>
            </div>';
        }

        foreach ($experienciaLaboral as $key => $value) {
            $exp_laborals .='
            <div class="caja_item_esperiencia">
                <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
                    <b class="text_empresa_experiencia">'.$value->empresa.'</b> <br>
                    <span class="text_sector_experiencia">'.$value->sector.'</span> <br>
                    <b class="text_puesto_experiencia">'.$value->puesto.'</b> 
                    <p class="fin_exp">'.$value->descripcion.'</p>    
                </div>
                <div class="datos_experiencia">
                    <p> ( '.$value->inicio_laburo.'  -  '.$value->fin_laburo.' )</p>         
                </div>
            </div>';   
        }

        foreach ($educacion as $key => $value) {
            if($value->estado == 'Estudiante'){
                $htmlEducacion.='
                <div class="info-content">
                    <div class="caja_item_esperiencia">
                        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b>
                            <b class="txt_area_educacion">'.$value->nombreArea.' </b> <br>
                            <b class="txt_area_intitucion">'.$value->institucion.'</b> <br>
                                <span class="fecha_educacion"> ( '.$value->estudio_inicio.' - '.$value->estado_estudiante.' )</span>
                                <span class="txt_estado_estado">'.$value->estado.' del '.$value->ciclo.' ciclo</span>          
                        </div><br>
                    </div>
                </div>';
            }else{
                $htmlEducacion.='
                <div class="info-content">
                    <div class="caja_item_esperiencia">
                        <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b>
                            <b class="txt_area_educacion">'.$value->nombreArea.' </b> <br>
                            <b class="txt_area_intitucion">'.$value->institucion.'</b> <br>
                                <span class="fecha_educacion"> ( '.$value->estudio_inicio.' - '.$value->estudio_fin.' )</span>
                                <span class="txt_estado_estado">'.$value->estado.'</span>          
                        </div><br>
                    </div>
                </div>';
            }
        }

        $pagina='
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Curriculum Vitae Alumnos</title>
            </head>
            '.$styles.'
            <body>
                <div class="head_cv">
                    <div class="sect_datos_personales">
                        <h2 class="titulo_nombres">'.$alumno[0]->nombres.' '.$alumno[0]->apellidos.'</h2>
                        <div class="tipo_letra">
                            <b>DNI:</b>'.$alumno[0]->dni.',
                            <b>Dirección:</b> '.$alumno[0]->direccion.',
                            <b>Celular: '.$alumno[0]->telefono.'</b>,
                            <b>Email: '.$alumno[0]->email.'</b>
                        </div>
                        <p class="letra_perfil_profesional">'.$alumno[0]->perfil_profesional.'</p>
                    </div>
                </div>
                <!-- EXPERIENCIA LABORAL -->
                <div class="titulo_exp_laboral" style='.(count($experienciaLaboral) >= 1 ? "display:block" : "display:none").'><b>EXPERIENCIA LABORAL</b></div>
                '.$exp_laborals.'
                <!--  EDUCACIÓN Y FORMACIÓN -->
                <div class="titulo_educacion" style='.(count($educacion) >= 1 ? "display:block" : "display:none").'><b>EDUCACIÓN Y FORMACIÓN</b> </div>
                '.$htmlEducacion.'
                <!-- CURSOS -->
                <div class="titulo_cursos" style='.(count($cursos) >= 1 ? "display:block" : "display:none").'><b>CURSOS</b></div>
                '.$htmlCursos.'
                <div class="titulo_habilidades" style='.(strlen($alumno[0]->referentes_carrera) >= 1 ? "display:block" : "display:none").'><b>OTRAS HABILIDADES</b> </div>
                '.$alumno[0]->referentes_carrera.'
            </body>
        </html>
        ';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($pagina);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="output.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
        echo $dompdf->output();


    }

}
