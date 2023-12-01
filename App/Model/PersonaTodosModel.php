<?php

namespace App\Model;

use Core\Model;

class PersonaTodosModel extends Model
{
    /* EJEMPLO DE UNA CONEXION CON UN PROCEDIMIENTO ALMACENADO */
    public function selectCurriculaInterna($fecha_inicial, $fecha_final, $validacion, $tipoPersona){
        $parametros = array();
        $query = "  CALL JCEProgCurriculaInterna_Buscar ?, ?, ?, ?, ?";
        
        $parametros[] = $tipoPersona;
        $parametros[] = $fecha_inicial;
        $parametros[] = $fecha_final;
        $parametros[] = $validacion;
        $result = $this->db->query($query,$parametros);
        $result->execute();
        return $result->fetchAll();
    }

    public function ListarPersonaJuridicaPorFechas($fecha_inicial, $fecha_final, $validacion, $tipoPersona)
    {    
        $query = $this->db->prepare("SELECT 
        E.id,
        E.ruc,
        E.razon_social,
        E.nombre_comercial,
        E.name_comercio,
        E.actividad_economica_empresa,
        E.direccion,
        E.referencia,
        E.telefono,
        E.email,
        E.usuario_empresa,
        E.descripcion,
        E.logo,
        E.nombre_contacto,
        E.apellido_contacto,
        E.cargo_contacto,
        E.telefono_contacto,
        E.email_contacto,
        E.aprobado,
        E.tipo_persona,
        E.nombre_paciente,
        E.enfermedad_paciente,
        E.evidencias_paciente,
        E.created_at,
        P.nombre AS 'nombre_provincia',
        D.nombre AS 'nombre_distritos'
        FROM empresas E 
        LEFT JOIN provincias P ON P.id=E.provincia_id 
        LEFT JOIN distritos D ON D.id=E.distrito_id
        WHERE E.tipo_persona ".$tipoPersona." AND E.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND E.deleted_at IS NULL AND E.aprobado ".$validacion."");
        $query->execute();
        return $query->fetchAll();
    }

    public function modificarEmpleador($datos)
    {
        $query = $this->db->prepare('UPDATE empresas SET nombre_contacto="'.$datos["nombre_contacto"].'", cargo_contacto="'.$datos['cargo_contacto'].'", telefono_contacto="'.$datos["telefono_contacto"].'", email_contacto="'.$datos["email_contacto"].'", nombre_paciente="'.$datos["nombre_paciente"].'", enfermedad_paciente="'.$datos["enfermedad_paciente"].'", created_at="'.$datos["fecha_registro"].'" WHERE id="'.$datos["id"].'"');
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

    public function VerDataDetalles($id)
    {
        $query = $this->db->prepare("SELECT 
        E.id,
        E.ruc,
        E.razon_social,
        E.nombre_comercial,
        E.name_comercio,
        E.actividad_economica_empresa,
        E.direccion,
        E.referencia,
        E.telefono,
        E.email,
        E.usuario_empresa,
        E.logo,
        E.nombre_contacto,
        E.apellido_contacto,
        E.cargo_contacto,
        E.telefono_contacto,
        E.email_contacto,
        E.aprobado,
        E.tipo_persona,
        E.nombre_paciente,
        E.enfermedad_paciente,
        E.evidencias_paciente,
        E.created_at as 'fecha_registro',
        P.nombre AS 'nombre_provincia',
        D.nombre AS 'nombre_distritos'
        FROM empresas E 
        LEFT JOIN provincias P ON P.id=E.provincia_id 
        LEFT JOIN distritos D ON D.id=E.distrito_id
        WHERE E.id=$id");
        $query->execute();
        return $query->fetch();
    }

    public function EliminarDataEmpleadores($id)
    {
        $query = $this->db->prepare("DELETE FROM empresas WHERE id = $id");  
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

    public function ValidacionEmpleador($id, $estado)
    {
        $query = $this->db->prepare("UPDATE empresas SET aprobado = $estado WHERE id = $id");  
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

}