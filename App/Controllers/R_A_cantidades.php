<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\R_A_cantidadesModel;
use Core\View;
use Core\Util;

class R_A_cantidades
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> reporteEmpleador = new R_A_cantidadesModel();
    }

    public function index()
    {
        View::render(["reporteAvisos/cantidades"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $programa_estudio = $_POST['programa_estudio'];
        $grado_academico = $_POST['grado_academico'];
        $respuesta = $this -> reporteEmpleador -> ListarCantidadesAvisosPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico);
        $cantidadTipoEm = $this -> reporteEmpleador -> CantidadesAvisosPorEmpelador($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico);
        $data = array("ListaCantidadesAvisos" => $respuesta , "CantidadTipoEm" => $cantidadTipoEm);
        echo json_encode($data);
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 4) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $data_P_A = func_get_arg(2);
            $data_G_A = func_get_arg(3);
            $programa_estudio = str_replace("andAV.solicita_carrera", "AND AV.solicita_carrera ", $data_P_A);
            $grado_academico = str_replace("andAV.solicita_grado_a", "AND AV.solicita_grado_a ", $data_G_A);
        }else if(func_num_args() == 2){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
        }

        $hoja1 = new Spreadsheet();
        
        $hoja1 -> getProperties()->setCreator("Reporte Excel Avisos por Cantidad")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A1:G1');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE CANTIDAD DE AVISOS PUBLICADOS POR EMPLEADORES');
        $hoja1 -> getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(18);
        $hoja1 -> getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $hoja1 -> getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A2:G2');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $hoja1 -> getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $hoja1 -> getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(11);
        $hoja1 -> getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
        $hoja1->getActiveSheet()->getStyle('A3:G3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $hoja1 -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(25);
        $hojaActiva -> getColumnDimension('C')->setWidth(35);
        $hojaActiva -> getColumnDimension('D')->setWidth(32);
        $hojaActiva -> getColumnDimension('E')->setWidth(32);
        $hojaActiva -> getColumnDimension('F')->setWidth(32);
        $hojaActiva -> getColumnDimension('G')->setWidth(25);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'RUC')
                    -> setCellValue('C3', 'NOMBRE COMERCIAL')
                    -> setCellValue('D3', 'RAZÓN SOCIAL')
                    -> setCellValue('E3', 'TIPO DE PERSONA')
                    -> setCellValue('F3', 'ACTIVIDAD ECONÓMICA')
                    -> setCellValue('G3', 'CANTIDAD DE AVISOS');
        /* END CABEZERA TABLA EXCEL */

        $respuesta = $this -> reporteEmpleador -> ListarCantidadesAvisosPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico);
        $i    = 3;
        $cant = 0;
        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->ruc)
                        -> setCellValue('C' . $i, strtoupper($valor->nombre_comercial))
                        -> setCellValue('D' . $i, strtoupper($valor->razon_social))
                        -> setCellValue('E' . $i, strtoupper($valor->tipo_persona))
                        -> setCellValue('F' . $i, strtoupper($valor->actividad_economica))
                        -> setCellValue('G' . $i, strtoupper($valor->cantidades));
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Avisos por Cantidad.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($hoja1, 'Xlsx');
        $writer->save('php://output');

    }

}
