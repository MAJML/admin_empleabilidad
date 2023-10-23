<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\RE_validacionModel;
use Core\View;
use Core\Util;

class RE_requerimiento
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> reporteEmpleador = new RE_validacionModel();
    }

    public function index()
    {
        View::render(["reporteEmpleador/requerimiento"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $ContadorValidacion = $this -> reporteEmpleador -> ContadorTotalValidacion($fecha_inicial, $fecha_final, $validacion);
        $respuesta = $this -> reporteEmpleador -> ListarREactividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        $ContadorValidacionTipoPersona = $this -> reporteEmpleador -> ContadorValidacionTipoPersona($fecha_inicial, $fecha_final, $validacion);
        $data = array('ConsultaFecha' => $respuesta,
                      'ContadorValidacion' => $ContadorValidacion,
                      'ContadorValidacionTipoPersona' => $ContadorValidacionTipoPersona);
        /* echo json_encode($respuesta); */
        echo json_encode($data);
    }

/*     public function ContarActividadEcoPorFechas()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $respuesta = $this->reporteEmpleador->ContarActividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        echo json_encode($respuesta);        
    } */
    
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
        
        $hoja1 -> getProperties()->setCreator("Reporte Excel Empleador por Validación")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $hoja1 -> setActiveSheetIndex(0)->mergeCells('A1:G1');
        $hoja1 -> setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE DE EMPLEADORES POR VALIDACIÓN');
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
        $hojaActiva -> getColumnDimension('C')->setWidth(25);
        $hojaActiva -> getColumnDimension('D')->setWidth(32);
        $hojaActiva -> getColumnDimension('E')->setWidth(35);
        $hojaActiva -> getColumnDimension('F')->setWidth(40);
        $hojaActiva -> getColumnDimension('G')->setWidth(40);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'FECHA DE REGISTRO')
                    -> setCellValue('C3', 'TIPO DE PERSONA')
                    -> setCellValue('D3', 'RUC/DNI')
                    -> setCellValue('E3', 'RAZÓN SOCIAL / NOMBRE Y APELLIDOS COMPLETOS')
                    -> setCellValue('F3', 'NOMBRE COMERCIAL')
                    -> setCellValue('G3', 'VALIDACIÓN');
        /* END CABEZERA TABLA EXCEL */


        $respuesta = $this -> reporteEmpleador -> ListarREactividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            if($valor->aprobado == 1){
                $aprob = "Validado";
            }else{
                $aprob = "No Validado";
            }

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, $valor->tipo)
                        -> setCellValue('D' . $i, $valor->ruc)
                        -> setCellValue('E' . $i, $valor->razon_social)
                        -> setCellValue('F' . $i, $valor->nombre_comercial)
                        -> setCellValue('G' . $i, $aprob);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Empleador por Validación.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($hoja1, 'Xlsx');
        $writer->save('php://output');

    }

}
