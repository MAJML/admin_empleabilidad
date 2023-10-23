<?php

namespace App\Controllers;

use App\Model\UsuariosModel;
use Core\View;
use Core\Util;

class Home
{
    public function __construct()
    {
        date_default_timezone_set('America/Lima');
        session_start();
        if(!empty($_SESSION['username'])){
            header('Location:'.Util::baseUrl().'inicio');
        }
        $this -> model = new UsuariosModel();
    }

    public function index()
    {
        $respuesta = $this -> model -> TodosUsuarios();
        $args  = [
                'title' => 'Home', 
                'baseurl' => Util::baseUrl(),
                'data' => $respuesta
                 ];
        View::login(["home/index"], $args);
    }

    public function IngresarSistema()
    {
        $correo = $_POST['email'];
        $password = $_POST['password'];
        $respuesta = $this -> model -> WhereUsuario($correo);
        if($correo == $respuesta->correo && $password == $respuesta->password){
            $_SESSION['username'] = $respuesta->nombre.' '.$respuesta->apellido;
            $_SESSION['correo'] = $respuesta->correo;
            $_SESSION['perfil'] = $respuesta->perfil;
            $_SESSION['online'] = $respuesta->online;
            $horaingreso = date('Y-m-d H:i:s');
            $registroFecha = $this->model->RegistroFechaIngreso($horaingreso, $correo);
            header('Location: ../Inicio');
        }else{
            header('Location: '.Util::baseUrl());
        }
    }

    public function cerrar_sesion()
    {
        session_destroy();
        $horaSalida = date('Y-m-d H:i:s');
        $correo = $_SESSION['correo'];
        $outsession = $this->model->OutSession($horaSalida, $correo);
        header('Location: '.Util::baseUrl());
		exit;
    }

}
