<?php

namespace App\Controllers;  
require_once "../public/PHPMailer/Exception.php";
require_once "../public/PHPMailer/PHPMailer.php";
require_once "../public/PHPMailer/SMTP.php";
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\BR_empleadoresModel;
use Core\View;
use Core\Util;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class BR_empleadores
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> model = new BR_empleadoresModel();
        date_default_timezone_set('America/Lima');
    }

    public function index()
    {
        View::render(["busquedasRapidas/empleadores"]);
    }

    public function BusquedaRapidaEmpleador()
    {
        $valor = $_POST['data'];
        $respuesta = $this->model->BusquedaRapidaEmpleador($valor);
        echo json_encode($respuesta);
    }

    public function crearCuenta()
    {
        $departamento = $this->model->departamento();
        $actividadesEconomicas = $this->model->ActividadesEconomicas();
        View::render(['registro/empleadores'],['ciudad' => $departamento, 'actividadesEconomicas' => $actividadesEconomicas]);
    }

    public function BuscarEmpleadorRuc()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.apidevs.pro/api/ruc/".$_POST['ruc']."?api_token=3fcaa8c48f59ff6ee58afff70a360af5fdcc214f512128165cdc050da28ee770",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function ListaCuentaCreadas()
    {
        $respuesta = $this->model->ConsultarCuentasCreadas();
        echo json_encode($respuesta);
    }

    public function BuscarEmpleadorDni()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.apidevs.pro/api/dni/".$_POST['dni']."?api_token=3fcaa8c48f59ff6ee58afff70a360af5fdcc214f512128165cdc050da28ee770",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function VerificarRucRepetido()
    {
        $ruc = $_POST['ruc'];
        $respuesta = $this->model->VerificarEmpleadorRepetido($ruc);
        echo json_encode($respuesta);
    }

    public function CrearCuentaEmpleadores()
    {
        $datos = array(
            'ruc'                   => $_POST['ruc'],
            'nombre_empresa'        => $_POST['nombre_empresa'],
            'nombre_comercial'      => $_POST['nombre_comercial'],
            'razon_social'          => $_POST['razon_social'],
            'actividad_economica'   => $_POST['actividad_economica'],
            'direccion'             => $_POST['direccion'],
            'referencia'            => $_POST['referencia'],
            'ciudad'                => $_POST['ciudad'],
            'distrito'              => $_POST['distrito'],
            'telefono_empresa'      => $_POST['telefono_empresa'],
            'correo'                => $_POST['correo'],
            'password'              => password_hash($_POST['ruc'], PASSWORD_DEFAULT),
            'nombre_contacto'       => $_POST['nombre_contacto'],
            'cargo_contacto'        => $_POST['cargo_contacto'],
            'telefono_contacto'     => $_POST['telefono_contacto'],
            'correo_contacto'       => $_POST['correo_contacto'],
            'nombre_paciente'       => $_POST['nombre_paciente'],
            'enfermedad_paciente'   => $_POST['enfermedad_paciente'],
            'tipo_persona'          => $_POST['tipo_persona'],
            'fecha_creacion'        => $_POST['fecha_creacion']
        );
        $respuesta = $this->model->CrearCuentaEmpleador($datos);
        echo json_encode($respuesta);
    }

    public function EsportarTodoExcel()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet -> getProperties()->setCreator("Reporte Excel Empleadores")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A1:T1');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A1', 'LISTA EMPLEADORES');
        $spreadsheet -> getActiveSheet()->getStyle('A1:T1')->getFont()->setSize(18);
        $spreadsheet -> getActiveSheet()->getStyle('A1:T1')->getFont()->setBold(true);
        $spreadsheet -> getActiveSheet()->getStyle('A1:T1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A2:T2');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A2', 'Estos son todos los empleadores');
        $spreadsheet -> getActiveSheet()->getStyle('A2:T2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $spreadsheet -> getActiveSheet()->getStyle('A3:T3')->getFont()->setSize(11);
        $spreadsheet -> getActiveSheet()->getStyle('A3:T3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:T3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $spreadsheet -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(24);
        $hojaActiva -> getColumnDimension('C')->setWidth(18);
        $hojaActiva -> getColumnDimension('D')->setWidth(20);
        $hojaActiva -> getColumnDimension('E')->setWidth(55);
        $hojaActiva -> getColumnDimension('F')->setWidth(55);
        $hojaActiva -> getColumnDimension('G')->setWidth(55);
        $hojaActiva -> getColumnDimension('H')->setWidth(55);
        $hojaActiva -> getColumnDimension('I')->setWidth(55);
        $hojaActiva -> getColumnDimension('J')->setWidth(30);
        $hojaActiva -> getColumnDimension('K')->setWidth(30);
        $hojaActiva -> getColumnDimension('L')->setWidth(20);
        $hojaActiva -> getColumnDimension('M')->setWidth(30);
        $hojaActiva -> getColumnDimension('N')->setWidth(30);
        $hojaActiva -> getColumnDimension('O')->setWidth(20);
        $hojaActiva -> getColumnDimension('P')->setWidth(20);
        $hojaActiva -> getColumnDimension('Q')->setWidth(30);
        $hojaActiva -> getColumnDimension('R')->setWidth(30);
        $hojaActiva -> getColumnDimension('S')->setWidth(30);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'Fecha de Registro')
                    -> setCellValue('C3', 'RUC / DNI')
                    -> setCellValue('D3', 'Razon Social / Nombre y Apellidos completos')
                    -> setCellValue('E3', 'Nombre Comercial')
                    -> setCellValue('F3', 'Dirección')
                    -> setCellValue('G3', 'Referencia')
                    -> setCellValue('H3', 'Telefono de la Empresa')
                    -> setCellValue('I3', 'Correo de la Empresa')
                    -> setCellValue('J3', 'Nombre y apellido del contacto')
                    -> setCellValue('K3', 'Cargo del contacto')
                    -> setCellValue('L3', 'Telefono del contacto')
                    -> setCellValue('M3', 'Correo del contacto')
                    -> setCellValue('N3', 'Vacantes Totales')
                    -> setCellValue('O3', 'Avisos Publicados')
                    -> setCellValue('P3', 'Nombre completo del Paciente')
                    -> setCellValue('Q3', 'Enfermedad del Paciente')
                    -> setCellValue('R3', 'Diagnóstico Médico')
                    -> setCellValue('S3', 'Estado');
        /* END CABEZERA TABLA EXCEL */

        $respuesta = $this->model->TodosEmpleador();
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            if($valor->aprobado == 1){
                $estado = "Activado";
            }else if($valor->aprobado == 0){
                $estado = "Inactivo";
            }

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, $valor->ruc)
                        -> setCellValue('D' . $i, $valor->razon_social)
                        -> setCellValue('E' . $i, $valor->nombre_comercial)
                        -> setCellValue('F' . $i, $valor->direccion)
                        -> setCellValue('G' . $i, $valor->referencia)
                        -> setCellValue('H' . $i, $valor->telefono)
                        -> setCellValue('I' . $i, $valor->email)
                        -> setCellValue('J' . $i, $valor->nombre_contacto)
                        -> setCellValue('K' . $i, $valor->cargo_contacto)
                        -> setCellValue('L' . $i, $valor->telefono_contacto)
                        -> setCellValue('M' . $i, $valor->email_contacto)
                        -> setCellValue('N' . $i, $valor->VacantesTotales)
                        -> setCellValue('O' . $i, $valor->CantidadAvisos)
                        -> setCellValue('P' . $i, $valor->nombre_paciente)
                        -> setCellValue('Q' . $i, $valor->enfermedad_paciente)
                        -> setCellValue('R' . $i, $valor->evidencias_paciente)
                        -> setCellValue('S' . $i, $estado);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Busqueda rapida empleadores.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 1) {
            $valor = func_get_arg(0);
        }else if(func_num_args() == 0){
            $valor = func_get_arg(0);
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet -> getProperties()->setCreator("Reporte Excel Empleadores")->setTitle('Mi Excel');

        /* TITULO EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A1:T1');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A1', 'LISTA EMPLEADORES');
        $spreadsheet -> getActiveSheet()->getStyle('A1:T1')->getFont()->setSize(18);
        $spreadsheet -> getActiveSheet()->getStyle('A1:T1')->getFont()->setBold(true);
        $spreadsheet -> getActiveSheet()->getStyle('A1:T1')->getAlignment()->setHorizontal('center');
        /* END TITULO EXCEL */

        /* FILA DE LA FECHA DE LA TABLA DEL EXCEL */
        $spreadsheet -> setActiveSheetIndex(0)->mergeCells('A2:T2');
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL DE ACUERDO A LA BUSQUEDA QUE HIZO');
        $spreadsheet -> getActiveSheet()->getStyle('A2:T2')->getFont()->setBold(true);
        /* END DE LA FECHA DE LA TABLA DEL EXCEL */

        /* CABEZERA TABLA EXCEL */
        $spreadsheet -> getActiveSheet()->getStyle('A3:T3')->getFont()->setSize(11);
        $spreadsheet -> getActiveSheet()->getStyle('A3:T3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:T3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('AED6F1');

        $hojaActiva = $spreadsheet -> getActiveSheet();
        $hojaActiva -> getColumnDimension('A')->setWidth(6);
        $hojaActiva -> getColumnDimension('B')->setWidth(24);
        $hojaActiva -> getColumnDimension('C')->setWidth(18);
        $hojaActiva -> getColumnDimension('D')->setWidth(20);
        $hojaActiva -> getColumnDimension('E')->setWidth(55);
        $hojaActiva -> getColumnDimension('F')->setWidth(55);
        $hojaActiva -> getColumnDimension('G')->setWidth(55);
        $hojaActiva -> getColumnDimension('H')->setWidth(55);
        $hojaActiva -> getColumnDimension('I')->setWidth(55);
        $hojaActiva -> getColumnDimension('J')->setWidth(30);
        $hojaActiva -> getColumnDimension('K')->setWidth(30);
        $hojaActiva -> getColumnDimension('L')->setWidth(20);
        $hojaActiva -> getColumnDimension('M')->setWidth(30);
        $hojaActiva -> getColumnDimension('N')->setWidth(30);
        $hojaActiva -> getColumnDimension('O')->setWidth(20);
        $hojaActiva -> getColumnDimension('P')->setWidth(20);
        $hojaActiva -> getColumnDimension('Q')->setWidth(30);
        $hojaActiva -> getColumnDimension('R')->setWidth(30);
        $hojaActiva -> getColumnDimension('S')->setWidth(30);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'Fecha de Registro')
                    -> setCellValue('C3', 'RUC / DNI')
                    -> setCellValue('D3', 'Razon Social / Nombre y Apellidos completos')
                    -> setCellValue('E3', 'Nombre Comercial')
                    -> setCellValue('F3', 'Dirección')
                    -> setCellValue('G3', 'Referencia')
                    -> setCellValue('H3', 'Telefono de la Empresa')
                    -> setCellValue('I3', 'Correo de la Empresa')
                    -> setCellValue('J3', 'Nombre y apellido del contacto')
                    -> setCellValue('K3', 'Cargo del contacto')
                    -> setCellValue('L3', 'Telefono del contacto')
                    -> setCellValue('M3', 'Correo del contacto')
                    -> setCellValue('N3', 'Vacantes Totales')
                    -> setCellValue('O3', 'Avisos Publicados')
                    -> setCellValue('P3', 'Nombre completo del Paciente')
                    -> setCellValue('Q3', 'Enfermedad del Paciente')
                    -> setCellValue('R3', 'Diagnóstico Médico')
                    -> setCellValue('S3', 'Estado');
        /* END CABEZERA TABLA EXCEL */

        $respuesta = $this->model->BusquedaRapidaEmpleador($valor);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            if($valor->aprobado == 1){
                $estado = "Activado";
            }else if($valor->aprobado == 0){
                $estado = "Inactivo";
            }

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, $valor->ruc)
                        -> setCellValue('D' . $i, $valor->razon_social)
                        -> setCellValue('E' . $i, $valor->nombre_comercial)
                        -> setCellValue('F' . $i, $valor->direccion)
                        -> setCellValue('G' . $i, $valor->referencia)
                        -> setCellValue('H' . $i, $valor->telefono)
                        -> setCellValue('I' . $i, $valor->email)
                        -> setCellValue('J' . $i, $valor->nombre_contacto)
                        -> setCellValue('K' . $i, $valor->cargo_contacto)
                        -> setCellValue('L' . $i, $valor->telefono_contacto)
                        -> setCellValue('M' . $i, $valor->email_contacto)
                        -> setCellValue('N' . $i, $valor->VacantesTotales)
                        -> setCellValue('O' . $i, $valor->CantidadAvisos)
                        -> setCellValue('P' . $i, $valor->nombre_paciente)
                        -> setCellValue('Q' . $i, $valor->enfermedad_paciente)
                        -> setCellValue('R' . $i, $valor->evidencias_paciente)
                        -> setCellValue('S' . $i, $estado);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Busqueda rapida empleadores.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }
}
