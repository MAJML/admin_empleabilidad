<?php

namespace App\Model;

use Core\Model;

class UsuarioModel extends Model
{

    public function ListarUsuario()
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    public function ModelRegistrarUsuario($datos)
    {
        $query = $this->db->prepare('INSERT INTO usuarios(nombre, apellido, correo, perfil, password) 
        VALUES ("'.$datos["nombres"].'", "'.$datos["apellidos"].'", "'.$datos["correo"].'", "'.$datos["perfil"].'", "'.$datos["password"].'")');
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

    public function ModelEditarUsuario($datos)
    {
        if($datos["password"] == ""){
            $query = $this->db->prepare('UPDATE usuarios SET nombre="'.$datos["nombres"].'", apellido="'.$datos["apellidos"].'", correo="'.$datos["correo"].'", perfil="'.$datos["perfil"].'" WHERE id="'.$datos["idUsuario"].'"');
            if($query->execute()){
                return "ok";
            }else{
                return "error";          
            }
        }else{
            $query = $this->db->prepare('UPDATE usuarios SET nombre="'.$datos["nombres"].'", apellido="'.$datos["apellidos"].'", correo="'.$datos["correo"].'", perfil="'.$datos["perfil"].'", password="'.$datos["password"].'" WHERE id="'.$datos["idUsuario"].'"');
            if($query->execute()){
                return "ok";
            }else{
                return "error";          
            }
        }
    }

    public function EliminarDataUsuario($id)
    {
        $query = $this->db->prepare("DELETE FROM usuarios WHERE id = $id");  
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

    public function VerDataDetalles($id)
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE id=$id AND deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

}