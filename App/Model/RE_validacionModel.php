<?php

namespace App\Model;

use Core\Model;

class RE_validacionModel extends Model
{

    public function ListarREactividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion){
        $query = $this->db->prepare("SELECT
        EM.id,
        EM.ruc,
        COALESCE(EM.razon_social, 'No hay data') as 'razon_social',
        EM.nombre_comercial,
        EM.created_at,
        TP.tipo,
        EM.aprobado,
        COALESCE(AE.codigo, '-') as 'codigo_actividad_eco',
        COALESCE(AE.descripcion, '-') as 'nombre_actividad_eco'
        FROM empresas EM
        left join actividad_economicas AE on AE.id=EM.actividad_economica_empresa
        left join tipo_personas TP on TP.id=EM.tipo_persona
        WHERE EM.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND EM.deleted_at IS NULL ".$validacion."");
        $query->execute();
        return $query->fetchAll();
    }

    public function ContadorTotalValidacion($fecha_inicial, $fecha_final, $validacion)
    {
        $query = $this->db->prepare("SELECT 
            (select count(*) from empresas where created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND aprobado = 1 and deleted_at is null) as validado,
            (select count(*) from empresas where created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND aprobado = 0 and deleted_at is null) as no_validado
        from empresas where tipo_persona in(1,2,3) and deleted_at is null 
        limit 1");
        $query->execute();
        return $query->fetchAll();
    }

    public function ContadorValidacionTipoPersona($fecha_inicial, $fecha_final, $validacion)
    {
        $query = $this->db->prepare("SELECT
                J1.TipoPersona,        
                Sum(J1.Aprobado) as Aprobado,
                Sum(J1.Desaprobado) as Desaprobado
        From (
        select
                TP.tipo as TipoPersona,
                case when EM.Aprobado=0 then 'Desaprobado' else 'Aprobado' end as Tipo,
                count(*) as Desaprobado,
                0 as Aprobado
        from empresas EM
        left join tipo_personas TP on TP.id= EM.tipo_persona
        Where EM.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND EM.deleted_at is null
        and EM.Aprobado=0
        Group by TP.Tipo,
                EM.Aprobado
        Union all
        select
                TP.tipo as TipoPersona,
                case when EM.Aprobado=0 then 'Desaprobado' else 'Aprobado' end as Tipo,
                0 as Desaprobado,
                count(*) as Aprobado
        from empresas EM
        left join tipo_personas TP on TP.id= EM.tipo_persona
        Where EM.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND EM.deleted_at is null
        and EM.Aprobado=1
        Group by TP.Tipo,
                EM.Aprobado
        ) as J1
        Group by
        J1.TipoPersona");
        $query->execute();
        return $query->fetchAll();
    }

    public function ContarActividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion){
        $query = $this->db->prepare("SELECT
            J1.codigo_actividad_eco,
            J1.nombre_actividad_eco,
            count(*) as Cta
        From (
        select 
        actividad_economica_empresa ,
        COALESCE(AE.codigo, '-') as 'codigo_actividad_eco',
        COALESCE(AE.descripcion, '-') as 'nombre_actividad_eco'
        from empresas EM
        left join actividad_economicas AE on AE.id=EM.actividad_economica_empresa
        where EM.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and EM.deleted_at is null ".$validacion."
        ) as J1
        where J1.nombre_actividad_eco <>'-'
        group by J1.codigo_actividad_eco, J1.nombre_actividad_eco
        having count(*) >0");
        $query->execute();
        return $query->fetchAll();
    }

    public function ContadorTotalActividadEcoPorFechas($fecha_inicial, $fecha_final, $validacion){
        $query = $this->db->prepare("SELECT
            sum(J2.Cta) as 'totalCIIU'
        From (
        Select
            J1.nombre_actividad_eco,
            count(*) as Cta
        From (
        select 
        actividad_economica_empresa ,
        COALESCE(AE.codigo, '-') as 'codigo_actividad_eco',
        COALESCE(AE.descripcion, '-') as 'nombre_actividad_eco'
        from empresas EM
        left join actividad_economicas AE on AE.id=EM.actividad_economica_empresa
        where EM.deleted_at is null and EM.tipo_persona=1
        ) as J1
        where J1.nombre_actividad_eco <>'-'
        group by J1.nombre_actividad_eco
        having count(*) >0
        ) as J2");
        $query->execute();
        return $query->fetchAll();
    }

}
