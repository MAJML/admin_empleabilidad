<?php

namespace App\Model;

use Core\Model;

class UsuariosModel extends Model
{
    public function WhereUsuario($correo)
    {
        $query = $this->db->prepare("SELECT nombre, apellido, correo, perfil, online, password FROM usuarios WHERE correo = '".$correo."'");
        $query->execute();

        return $query->fetch();
    }

    public function TodosUsuarios()
    {
        $query = $this->db->prepare("SELECT * FROM usuarios");
        $query->execute();

        return $query->fetchAll();
    }

    public function RegistroFechaIngreso($horaingreso, $correo)
    {
        $query = $this->db->prepare('UPDATE usuarios SET fecha_ingreso="'.$horaingreso.'", online=1 WHERE correo="'.$correo.'"');
        $query -> execute();
    }

    public function OutSession($horaSalida, $correo)
    {
        $query = $this->db->prepare('UPDATE usuarios SET fecha_desconect="'.$horaSalida.'", online=0 WHERE correo="'.$correo.'"');
        $query -> execute();
    }
}