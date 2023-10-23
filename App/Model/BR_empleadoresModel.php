<?php

namespace App\Model;

use Core\Model;

class BR_empleadoresModel extends Model
{

    public function BusquedaRapidaEmpleador($valor)
    {
        $query = $this->db->prepare('SELECT 
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
        P.nombre AS "nombre_provincia",
        D.nombre AS "nombre_distritos"
        FROM empresas E 
        LEFT JOIN provincias P ON P.id=E.provincia_id 
        LEFT JOIN distritos D ON D.id=E.distrito_id
        WHERE (E.ruc LIKE "'.$valor.'%" or E.nombre_comercial like "%'.$valor.'%" ) AND E.deleted_at IS NULL limit 20');
        $query->execute();
        return $query->fetchAll();
    }

}