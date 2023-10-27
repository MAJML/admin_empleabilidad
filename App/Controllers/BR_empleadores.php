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
            'tipo_persona'          => $_POST['tipo_persona']
        );
        $respuesta = $this->model->CrearCuentaEmpleador($datos);
        echo json_encode($respuesta);
    }

}
