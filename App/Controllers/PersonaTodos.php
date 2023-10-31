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

use App\Model\PersonaTodosModel;
use Core\View;
use Core\Util;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PersonaTodos
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> PersonaJModel = new PersonaTodosModel();
    }

    public function index()
    {
        View::render(["empleador/personaTodos"]);
    }

    public function ConsultaDataPorFecha()
    {
        $fecha_inicial = $_POST['fecha_inicial'];
        $fecha_final = $_POST['fecha_final'];
        $validacion = $_POST['validacion'];
        $tipoPersona = $_POST['tipoPersona'];
        $respuesta = $this -> PersonaJModel -> ListarPersonaJuridicaPorFechas($fecha_inicial, $fecha_final, $validacion, $tipoPersona);
        echo json_encode($respuesta);
    }

    public function modificarEmpleador()
    {
        $datos = array(
            'id'                 => $_POST['id_empleador'],
            'nombre_contacto'    => $_POST['nombre_contacto'],
            'telefono_contacto'  => $_POST['telefono_contacto'],
            'cargo_contacto'     => $_POST['cargo_contacto'],
            'email_contacto'     => $_POST['email_contacto'],
            'nombre_paciente'    => $_POST['nombre_paciente'],
            'enfermedad_paciente' => $_POST['enfermedad_paciente']
        );
        $respuesta = $this -> PersonaJModel -> modificarEmpleador($datos);
        echo json_encode($respuesta);
    }

    public function TraerDataPorID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> PersonaJModel -> VerDataDetalles($id);
        echo json_encode($respuesta);
    }

    public function EliminarDataID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> PersonaJModel -> EliminarDataEmpleadores($id);
        echo json_encode($respuesta);
    }

    public function validacionEmpleador()
    {
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $respuesta = $this -> PersonaJModel -> ValidacionEmpleador($id, $estado);
        echo json_encode($respuesta);
    }

    public function enviarEmail(){
        $destino = $_POST['email'];
        $vista = "../public/plantillas/EmailEmpleador.php";

        $mail = new PHPMailer(true);  
        try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'loayzadigital01@gmail.com';
        $mail->Password = 'offpeevvhbhabuzc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  
    
        $mail->setFrom('loayzadigital01@gmail.com','Instituto Arzobispo Loayza');
        $mail->addAddress($destino,'LOAYZA LOAYZA');

        $mail->isHTML(true);
        $mail->Subject = 'Instituto Arzobispo Loayza';
        $mail->Body = file_get_contents($vista);

        $mail->send();

        echo json_encode("enviado"); 
            
        } catch(Exception $e){
            /* return "error"; */
            echo json_encode("error");
        }
    }
    
    public function EsportarExcel()
    {
        if (func_num_args() == 4) {
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = func_get_arg(2);
            $tipoPersona = func_get_arg(3);
        }else if(func_num_args() == 3){
            $fecha_inicial = func_get_arg(0);
			$fecha_final = func_get_arg(1);
            $validacion = ' ';
            $tipoPersona = func_get_arg(3);
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
        $spreadsheet -> setActiveSheetIndex(0)->setCellValue('A2', 'LOS DATOS SON DEL '.$fecha_inicial.' HASTA '.$fecha_final);
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
        $hojaActiva -> getColumnDimension('T')->setWidth(30);

        $hojaActiva -> setCellValue('A3', 'N°') 
                    -> setCellValue('B3', 'Fecha de Registro')
                    -> setCellValue('C3', 'Tipo de Persona')
                    -> setCellValue('D3', 'RUC / DNI')
                    -> setCellValue('E3', 'Razon Social / Nombre y Apellidos completos')
                    -> setCellValue('F3', 'Nombre Comercial')
                    -> setCellValue('G3', 'Actividad Economica')
                    -> setCellValue('H3', 'Dirección')
                    -> setCellValue('I3', 'Referencia')
                    -> setCellValue('J3', 'Ciudad')
                    -> setCellValue('K3', 'Distrito')
                    -> setCellValue('L3', 'Telefono de la Empresa')
                    -> setCellValue('M3', 'Correo de la Empresa')
                    -> setCellValue('N3', 'Nombre y apellido del contacto')
                    -> setCellValue('O3', 'Cargo del contacto')
                    -> setCellValue('P3', 'Telefono del contacto')
                    -> setCellValue('Q3', 'Correo del contacto')
                    -> setCellValue('R3', 'Nombre completo del Paciente')
                    -> setCellValue('S3', 'Enfermedad del Paciente')
                    -> setCellValue('T3', 'Diagnóstico Médico');
        /* END CABEZERA TABLA EXCEL */


        $respuesta = $this -> PersonaJModel -> ListarPersonaJuridicaPorFechas($fecha_inicial, $fecha_final, $validacion, $tipoPersona);
        $i    = 3;
        $cant = 0;

        foreach ($respuesta as $clave => $valor) {
            $i++;
            $cant++;

            if($valor->tipo_persona == 1){
                $tipoPersona = "Persona Juridica";
            }else if($valor->tipo_persona == 2){
                $tipoPersona = "Persona Natural";
            }else if($valor->tipo_persona == 3){
                $tipoPersona = "Persona Natural con Negocio";
            }

            $hojaActiva -> setCellValue('A' . $i, $cant) 
                        -> setCellValue('B' . $i, $valor->created_at)
                        -> setCellValue('C' . $i, $tipoPersona)
                        -> setCellValue('D' . $i, $valor->ruc)
                        -> setCellValue('E' . $i, $valor->razon_social)
                        -> setCellValue('F' . $i, $valor->nombre_comercial)
                        -> setCellValue('G' . $i, $valor->actividad_economica_empresa)
                        -> setCellValue('H' . $i, $valor->direccion)
                        -> setCellValue('I' . $i, $valor->referencia)
                        -> setCellValue('J' . $i, $valor->nombre_provincia)
                        -> setCellValue('K' . $i, $valor->nombre_distritos)
                        -> setCellValue('L' . $i, $valor->telefono)
                        -> setCellValue('M' . $i, $valor->email)
                        -> setCellValue('N' . $i, $valor->nombre_contacto)
                        -> setCellValue('O' . $i, $valor->cargo_contacto)
                        -> setCellValue('P' . $i, $valor->telefono_contacto)
                        -> setCellValue('Q' . $i, $valor->email_contacto)
                        -> setCellValue('R' . $i, $valor->nombre_paciente)
                        -> setCellValue('S' . $i, $valor->enfermedad_paciente)
                        -> setCellValue('T' . $i, $valor->evidencias_paciente);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte Empleadores.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }


}
