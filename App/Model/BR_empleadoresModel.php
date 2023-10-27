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

    public function departamento()
    {
        $query = $this->db->prepare("SELECT * FROM provincias where deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function distrito($id)
    {
        $query = $this->db->prepare("SELECT * FROM distritos where provincia_id =$id and deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function ActividadesEconomicas()
    {
        $query = $this->db->prepare("SELECT * FROM actividad_economicas where deleted_at is null order by descripcion");
        $query->execute();
        return $query->fetchAll();
    }

    public function VerificarEmpleadorRepetido($ruc)
    {
        $query = $this->db->prepare("SELECT * FROM empresas where ruc=$ruc and deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function CrearCuentaEmpleador($datos)
    {
        $query = $this->db->prepare('INSERT INTO empresas(ruc, 
                                                          razon_social,
                                                          nombre_comercial, 
                                                          name_comercio, 
                                                          actividad_economica_empresa, 
                                                          provincia_id, 
                                                          distrito_id, 
                                                          direccion, 
                                                          referencia, 
                                                          telefono, 
                                                          email, 
                                                          usuario_empresa, 
                                                          password,
                                                          nombre_contacto,
                                                          cargo_contacto,
                                                          telefono_contacto,
                                                          email_contacto,
                                                          aprobado,
                                                          tipo_persona,
                                                          nombre_paciente,
                                                          enfermedad_paciente,
                                                          online)                                                                                                                     
        VALUES ("'.$datos["ruc"].'",
                "'.$datos["razon_social"].'",  
                "'.$datos["nombre_comercial"].'", 
                "'.$datos["nombre_empresa"].'", 
                "'.$datos['actividad_economica'].'", 
                "'.$datos["ciudad"].'",
                "'.$datos['distrito'].'",
                "'.$datos['direccion'].'",
                "'.$datos['referencia'].'",
                "'.$datos['telefono_empresa'].'",
                "'.$datos['correo'].'",
                "'.$datos['ruc'].'",
                "'.$datos['password'].'",
                "'.$datos['nombre_contacto'].'",
                "'.$datos['cargo_contacto'].'",
                "'.$datos['telefono_contacto'].'",
                "'.$datos['correo_contacto'].'",
                0,
                "'.$datos['tipo_persona'].'",
                "'.$datos['nombre_paciente'].'",
                "'.$datos['enfermedad_paciente'].'",
                0)');
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        } 
    }

    public function ConsultarCuentasCreadas()
    {
        $query = $this->db->prepare("SELECT 
        EM.ruc,
        EM.nombre_comercial,
        EM.created_at,
        D.nombre as 'distritos',
        TP.tipo as 'tipo_persona'
        from empresas EM
        inner join distritos D on D.id=EM.distrito_id 
        inner join tipo_personas TP on TP.id=EM.tipo_persona
        where date(EM.created_at) = date(NOW()) and EM.deleted_at is null 
        order by EM.created_at desc");
        $query->execute();
        return $query->fetchAll();
    }

}