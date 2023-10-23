<?php

namespace App\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Model\UsuarioModel;
use Core\View;
use Core\Util;

class Usuario
{
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['username'])){
            session_destroy();
            header('Location: '.Util::baseUrl());
            exit;
        }
        $this -> Usuario = new UsuarioModel();
    }

    public function index()
    {
        View::render(["usuario/index"]);
    }

    public function ListarUsuarios()
    {
        $respuesta = $this->Usuario->ListarUsuario();
        echo json_encode($respuesta);
    }

    public function RegistrarUsuario()
    {
        $datos = array("nombres"    => $_POST["nombres"],
                        "apellidos" => $_POST["apellidos"],
                        "correo"    => $_POST["correo"],
                        "perfil"    => $_POST["perfil"],
                        "password"  => $_POST["password"]);
        $respuesta = $this->Usuario->ModelRegistrarUsuario($datos);
        echo json_encode($respuesta);
    }

    public function EditarUsuario()
    {
        $datos = array("nombres"    => $_POST["nombresEdit"],
                        "apellidos" => $_POST["apellidosEdit"],
                        "correo"    => $_POST["correoEdit"],
                        "perfil"    => $_POST["perfilEdit"],
                        "password"  => $_POST["passwordEdit"],
                        "idUsuario" => $_POST["idUsuario"]);
        $respuesta = $this->Usuario->ModelEditarUsuario($datos);
        echo json_encode($respuesta);
    }

    public function TraerDataPorID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> Usuario -> VerDataDetalles($id);
        echo json_encode($respuesta);
    }

    public function EliminarDataID()
    {
        $id = $_POST['id'];
        $respuesta = $this -> Usuario -> EliminarDataUsuario($id);
        echo json_encode($respuesta);
    }

}
