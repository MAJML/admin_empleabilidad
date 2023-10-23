<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\R_A_efectividadAvisoModel;
use Core\View;
use Core\Util;

class R_A_efectividadAviso
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> reporteAviso = new R_A_efectividadAvisoModel();
    }

    public function index()
    {
        View::render(["reporteAvisos/efectividad_aviso"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $programa_estudio = $_POST['programa_estudio'];
        $estado_estudiante = $_POST['estado_estudiante'];
        $respuesta = $this -> reporteAviso -> ListarEfectividadAvisosPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $estado_estudiante);
        $EfectividadAvisoGrafico = $this -> reporteAviso -> ConsultaEfectividadAvisoGrafico($fecha_inicial, $fecha_final, $programa_estudio, $estado_estudiante);
        $data = array("ListadoEfectividad" => $respuesta, "CatindadesEfectividad" => $EfectividadAvisoGrafico);
        echo json_encode($data);
    }

    public function TraerDataSegunID()
    {
        $id_estudiante = $_POST['idEst'];
        $respuesta = $this -> reporteAviso -> TraerDataporIDestudiante($id_estudiante);
        echo json_encode($respuesta);
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 4) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $data_P_A = func_get_arg(2);
            $data_E_E = func_get_arg(3);
            $programa_estudio = str_replace("andAV.solicita_carrera", "AND AV.solicita_carrera ", $data_P_A);
            $estado_estudiante = str_replace("andALV.estado_id", "AND ALV.estado_id ", $data_E_E);
        }else if(func_num_args() == 2){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
        }

        $hoja1 = new Spreadsheet();
        
        $hoja1 -> getProperties()->setCreator("Reporte Excel Efectividad Aviso")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A1:H1');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE EFECTIVIDAD POR AVISO');
        $hoja1 -> getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(18);
        $hoja1 -> getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $hoja1 -> getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A2:H2');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $hoja1 -> getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $hoja1 -> getActiveSheet()->getStyle('A3:H3')->getFont()->setSize(11);
        $hoja1 -> getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
        $hoja1->getActiveSheet()->getStyle('A3:H3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $hoja1 -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(25);
        $hojaActiva -> getColumnDimension('C')->setWidth(25);
        $hojaActiva -> getColumnDimension('D')->setWidth(32);
        $hojaActiva -> getColumnDimension('E')->setWidth(32);
        $hojaActiva -> getColumnDimension('F')->setWidth(32);
        $hojaActiva -> getColumnDimension('G')->setWidth(32);
        $hojaActiva -> getColumnDimension('H')->setWidth(32);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'RUC')
                    -> setCellValue('C3', 'TIPO DE PERSONA')
                    -> setCellValue('D3', 'RAZÓN SOCIAL')
                    -> setCellValue('E3', 'NOMBRE COMERCIAL')
                    -> setCellValue('F3', 'TITULO DE LA OFERTA')
                    -> setCellValue('G3', 'ESTADO DE INTERMEDIADOS')
                    -> setCellValue('H3', 'CANTIDAD DE INTERMEDIADOS POR ESTADO');
        /* END CABEZERA TABLA EXCEL */

        $respuesta = $this -> reporteAviso -> ListarEfectividadAvisosPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $estado_estudiante);
        $i    = 3;
        $cant = 0;
        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->ruc)
                        -> setCellValue('C' . $i, strtoupper($valor->tipo_persona))
                        -> setCellValue('D' . $i, strtoupper($valor->razon_social))
                        -> setCellValue('E' . $i, strtoupper($valor->nombre_comercial))
                        -> setCellValue('F' . $i, strtoupper($valor->titulo_oferta))
                        -> setCellValue('G' . $i, strtoupper($valor->Estado))
                        -> setCellValue('H' . $i, strtoupper($valor->Cant));
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Efectividad por Aviso.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($hoja1, 'Xlsx');
        $writer->save('php://output');

    }

}