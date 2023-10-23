<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\RE_actividadEconomicaModel;
use Core\View;
use Core\Util;

class RE_actividadEconomica
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> reporteEmpleador = new RE_actividadEconomicaModel();
    }

    public function index()
    {
        View::render(["reporteEmpleador/actividadEconomica"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $respuesta = $this -> reporteEmpleador -> ListarREactividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        echo json_encode($respuesta);
    }

    public function ContarActividadEcoPorFechas()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $respuesta = $this->reporteEmpleador->ContarActividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        echo json_encode($respuesta);        
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 3) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $data_valida = func_get_arg(2);
            $validacion = str_replace("andEM.tipo_persona", "AND EM.tipo_persona ", $data_valida);

            /* and EM.tipo_persona in(1,3) */
        }else if(func_num_args() == 2){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
        }

        $hoja1 = new Spreadsheet();
        
        $hoja1 -> getProperties()->setCreator("Reporte Excel Empleador por Actividad Económica")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A1:G1');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE DE EMPLEADORES POR ACTIVIDAD ECONÓMICA');
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
        $hojaActiva -> getColumnDimension('B')->setWidth(15);
        $hojaActiva -> getColumnDimension('C')->setWidth(15);
        $hojaActiva -> getColumnDimension('D')->setWidth(32);
        $hojaActiva -> getColumnDimension('E')->setWidth(35);
        $hojaActiva -> getColumnDimension('F')->setWidth(35);
        $hojaActiva -> getColumnDimension('G')->setWidth(40);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'FECHA DE REGISTRO')
                    -> setCellValue('C3', 'TIPO DE PERSONA')
                    -> setCellValue('D3', 'RUC')
                    -> setCellValue('E3', 'RAZÓN SOCIAL')
                    -> setCellValue('F3', 'NOMBRE COMERCIAL')
                    -> setCellValue('G3', 'ACTIVIDAD ECONÓMICA CIU');
        /* END CABEZERA TABLA EXCEL */


        $respuesta = $this -> reporteEmpleador -> ListarREactividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;
            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, strtoupper($valor->tipo))
                        -> setCellValue('D' . $i, strtoupper($valor->ruc))
                        -> setCellValue('E' . $i, strtoupper($valor->razon_social))
                        -> setCellValue('F' . $i, strtoupper($valor->nombre_comercial))
                        -> setCellValue('G' . $i, strtoupper($valor->codigo_actividad_eco)." ".strtoupper($valor->nombre_actividad_eco));
        }

        
        /* CREANDO NUEVA HOJA */
        $nueva_hoja = $hoja1->createSheet();
        $hoja1 -> setActiveSheetIndex(1)->mergeCells('A1:C1');
        $hoja1 -> setActiveSheetIndex(1)->setCellValue('A1', 'CANTIDAD DE ACTIVIDAD ECONÓMICA CIIU');
        $hoja1 -> getActiveSheet(1)->getStyle('A1:C1')->getFont()->setSize(18);
        $hoja1 -> getActiveSheet(1)->getStyle('A1:C1')->getFont()->setBold(true);
        $hoja1 -> getActiveSheet(1)->getStyle('A1:C1')->getAlignment()->setHorizontal('center');

        $hoja1 -> setActiveSheetIndex(1)->mergeCells('A2:C2');
        $hoja1 -> setActiveSheetIndex(1)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $hoja1 -> getActiveSheet(1)->getStyle('A2:C2')->getFont()->setBold(true);

        $hoja1 -> getActiveSheet(1)->getStyle('A3:C3')->getFont()->setSize(11);
        $hoja1 -> getActiveSheet(1)->getStyle('A3:C3')->getFont()->setBold(true);
        $hoja1->getActiveSheet(1)->getStyle('A3:C3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $hoja1 -> getActiveSheet(1);
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(75);
        $hojaActiva -> getColumnDimension('C')->setWidth(25);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'ACTIVIDAD ECONÓMICA CIIU')
                    -> setCellValue('C3', 'CANTIDAD POR ACTIVIDAD');

        $DataCantidadCIIU = $this->reporteEmpleador->ContarActividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        $e    = 3;
        $cant2 = 0;
        $totalCIIU = 0;
        $ndato = count($DataCantidadCIIU)+4;
        foreach ($DataCantidadCIIU as $clave => $value) {
            $totalCIIU += $value->Cta;
            $e++;
            $cant2++;
            $hojaActiva -> setCellValue('A' . $e, $cant2) 
                        -> setCellValue('B' . $e, $value->codigo_actividad_eco." - ".$value->nombre_actividad_eco)
                        -> setCellValue('C' . $e, $value->Cta)
                        -> setCellValue('C'.$ndato, 'TOTAL:'.$totalCIIU);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Empleador por Actividad Económica.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($hoja1, 'Xlsx');
        $writer->save('php://output');

    }

}
