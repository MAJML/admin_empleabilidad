<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\R_EST_intermediacionModel;
use Core\View;
use Core\Util;

class R_EST_intermediacion
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> reporteEmpleador = new R_EST_intermediacionModel();
    }

    public function index()
    {
        View::render(["reporteEstudiantes/intermediacion"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $programa_estudio = $_POST['programa_estudio'];
        $grado_academico = $_POST['grado_academico'];
        $estado_estudiante = $_POST['estado_estudiante'];
        $respuesta = $this -> reporteEmpleador -> ListarIntermediacionPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico, $estado_estudiante);
        $contadorGradoAcademico = $this -> reporteEmpleador -> ContadorAreaPorGradoAcademico($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico, $estado_estudiante);
        $data = array("ListarIntermediacion" => $respuesta, "contadorGradoAcademico" => $contadorGradoAcademico);
        echo json_encode($data);
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 5) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $data_P_A = func_get_arg(2);
            $data_G_A = func_get_arg(3);
            $data_E_E = func_get_arg(4);
            $programa_estudio = str_replace("andAL.area_id", "AND AL.area_id ", $data_P_A);
            $grado_academico = str_replace("andAL.egresado", "AND AL.egresado ", $data_G_A);
            $estado_estudiante = str_replace("andALV.estado_id", "AND ALV.estado_id ", $data_E_E);
        }else if(func_num_args() == 2){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
        }

        $hoja1 = new Spreadsheet();
        
        $hoja1 -> getProperties()->setCreator("Reporte Excel Estudiante por Intermediación")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A1:I1');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE ESTUDIANTE POR INTERMEDIACIÓN');
        $hoja1 -> getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(18);
        $hoja1 -> getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        $hoja1 -> getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A2:I2');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $hoja1 -> getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $hoja1 -> getActiveSheet()->getStyle('A3:I3')->getFont()->setSize(11);
        $hoja1 -> getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
        $hoja1->getActiveSheet()->getStyle('A3:I3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $hoja1 -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(15);
        $hojaActiva -> getColumnDimension('C')->setWidth(25);
        $hojaActiva -> getColumnDimension('D')->setWidth(32);
        $hojaActiva -> getColumnDimension('E')->setWidth(35);
        $hojaActiva -> getColumnDimension('F')->setWidth(40);
        $hojaActiva -> getColumnDimension('G')->setWidth(40);
        $hojaActiva -> getColumnDimension('H')->setWidth(40);
        $hojaActiva -> getColumnDimension('I')->setWidth(40);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'FECHA DE POSTULACIÓN')
                    -> setCellValue('C3', 'APELLIDO ESTUDIANTE')
                    -> setCellValue('D3', 'NOMBRE ESTUDIANTE')
                    -> setCellValue('E3', 'DISTRITO DE INTERMEDIADO')
                    -> setCellValue('F3', 'TITULO DE OFERTA')
                    -> setCellValue('G3', 'RUC / DNI')
                    -> setCellValue('H3', 'RAZÓN SOCIAL / NOMBRES COMPLETO')
                    -> setCellValue('I3', 'NOMBRE COMERCIAL');
        /* END CABEZERA TABLA EXCEL */

        $respuesta = $this -> reporteEmpleador -> ListarIntermediacionPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico, $estado_estudiante);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->fecha_postulacion)
                        -> setCellValue('C' . $i, strtoupper($valor->apellido_postulante))
                        -> setCellValue('D' . $i, strtoupper($valor->nombre_postulante))
                        -> setCellValue('E' . $i, strtoupper($valor->distrito))
                        -> setCellValue('F' . $i, strtoupper($valor->titulo_oferta))
                        -> setCellValue('G' . $i, strtoupper($valor->ruc))
                        -> setCellValue('H' . $i, strtoupper($valor->razon_social))
                        -> setCellValue('I' . $i, strtoupper($valor->nombre_comercial));
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Estudiante por Intermediación.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($hoja1, 'Xlsx');
        $writer->save('php://output');

    }

}
