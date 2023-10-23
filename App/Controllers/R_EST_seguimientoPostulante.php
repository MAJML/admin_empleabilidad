<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\R_EST_seguimientoPostulanteModel;
use Core\View;
use Core\Util;

class R_EST_seguimientoPostulante
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> reporteEmpleador = new R_EST_seguimientoPostulanteModel();
    }

    public function index()
    {
        View::render(["reporteEstudiantes/seguimientoPostulante"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $programa_estudio = $_POST['programa_estudio'];
        $grado_academico = $_POST['grado_academico'];
        $respuesta = $this -> reporteEmpleador -> ListarSeguimientoPostulantePorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico);
        $contadorAe = $this -> reporteEmpleador -> ContadorActividadEconomicaPostulantes($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico);
        $data = array("ListarSeguimientoPostulante" => $respuesta, "ContadorAEPostulante" => $contadorAe);
        echo json_encode($data);
    }

    public function TraerDataSegunID()
    {
        $id_estudiante = $_POST['idEst'];
        $respuesta = $this -> reporteEmpleador -> TraerDataporIDestudiante($id_estudiante);
        echo json_encode($respuesta);
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 4) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $data_P_A = func_get_arg(2);
            $data_G_A = func_get_arg(3);
            $programa_estudio = str_replace("andAL.area_id", "AND AL.area_id ", $data_P_A);
            $grado_academico = str_replace("andAL.egresado", "AND AL.egresado ", $data_G_A);
        }else if(func_num_args() == 2){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
        }

        $hoja1 = new Spreadsheet();
        
        $hoja1 -> getProperties()->setCreator("Reporte Excel Estudiante por Postulante")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A1:M1');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE ESTUDIANTE POSTULADOS');
        $hoja1 -> getActiveSheet()->getStyle('A1:M1')->getFont()->setSize(18);
        $hoja1 -> getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
        $hoja1 -> getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A2:M2');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
        $hoja1 -> getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $hoja1 -> getActiveSheet()->getStyle('A3:M3')->getFont()->setSize(11);
        $hoja1 -> getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true);
        $hoja1->getActiveSheet()->getStyle('A3:M3')->getFill()
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
        $hojaActiva -> getColumnDimension('I')->setWidth(32);
        $hojaActiva -> getColumnDimension('J')->setWidth(32);
        $hojaActiva -> getColumnDimension('K')->setWidth(32);
        $hojaActiva -> getColumnDimension('L')->setWidth(32);
        $hojaActiva -> getColumnDimension('M')->setWidth(32);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'FECHA POSTULACION')
                    -> setCellValue('C3', 'APELLIDOS DEL ESTUDIANTE')
                    -> setCellValue('D3', 'NOMBRE DEL ESTUDIANTE')
                    -> setCellValue('E3', 'DNI')
                    -> setCellValue('F3', 'DISTRITO DEL ESTUDIANTE')
                    -> setCellValue('G3', 'PROGRAMA ACADÉMICO')
                    -> setCellValue('H3', 'GRADO DEL ESTUDIANTE')
                    -> setCellValue('I3', 'TÍTULO DE OFERTA')
                    -> setCellValue('J3', 'RUC')
                    -> setCellValue('K3', 'RAZON SOCIAL')
                    -> setCellValue('L3', 'NOMBRE COMERCIAL')
                    -> setCellValue('M3', 'ESTADO ESTUDIANTE');
        /* END CABEZERA TABLA EXCEL */

        $respuesta = $this -> reporteEmpleador -> TraerDataporFechaExcel($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico);
        $i    = 3;
        $cant = 0;
        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->fecha_postulacion)
                        -> setCellValue('C' . $i, strtoupper($valor->apellidos))
                        -> setCellValue('D' . $i, strtoupper($valor->nombres))
                        -> setCellValue('E' . $i, strtoupper($valor->dni))
                        -> setCellValue('F' . $i, strtoupper($valor->distrito_estudiante))
                        -> setCellValue('G' . $i, strtoupper($valor->area))
                        -> setCellValue('H' . $i, strtoupper($valor->grado_academico))
                        -> setCellValue('I' . $i, strtoupper($valor->titulo_oferta))
                        -> setCellValue('J' . $i, $valor->ruc)
                        -> setCellValue('K' . $i, strtoupper($valor->razon_social))
                        -> setCellValue('L' . $i, strtoupper($valor->nombre_comercial))
                        -> setCellValue('M' . $i, strtoupper($valor->estados));
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Estudiante por Intermediación.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($hoja1, 'Xlsx');
        $writer->save('php://output');

    }

}
