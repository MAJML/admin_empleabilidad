<?php

namespace App\Model;

use Core\Model;

class R_A_cantidadesModel extends Model
{

    public function ListarCantidadesAvisosPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico)
    {
        $query = $this->db->prepare("SELECT
        EM.ruc,
        EM.razon_social,
        EM.nombre_comercial,
        coalesce(ACT.descripcion, 'no hay dato') as 'actividad_economica',
        coalesce(TP.tipo, 'no hay dato') as 'tipo_persona',
        count(*) as 'cantidades'
        from empresas EM
        inner join avisos AV on AV.empresa_id=EM.id
        left join actividad_economicas ACT on ACT.id=EM.actividad_economica_empresa
        left join tipo_personas TP on TP.id=EM.tipo_persona
        where EM.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and EM.deleted_at is null ".$programa_estudio." ".$grado_academico."
        group by EM.ruc");
        $query->execute();
        return $query->fetchAll();
    }

    public function CantidadesAvisosPorEmpelador($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico)
    {
        $query = $this->db->prepare("SELECT
            J1.Tipo,
            Count(*) as 'cantidad'
        From (
        select 
        distinct
        TP.tipo,
        AV.empresa_id
        from empresas EM
        inner join avisos AV on AV.empresa_id=EM.id
        inner join tipo_personas TP on TP.id=EM.tipo_persona
        where EM.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and EM.deleted_at is null ".$programa_estudio." ".$grado_academico."
        ) as J1
        group by J1.tipo;");
        $query->execute();
        return $query->fetchAll();
    }

    public function TraerDataporFechaExcel($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico)
    {
        $query = $this->db->prepare("SELECT 
        AL.id as 'id_estudiante',
        ALV.created_at as 'fecha_postulacion',
        AL.nombres,
        AL.apellidos,
        AL.dni,
        GA.grado_estado as 'grado_academico',
        D.nombre as 'distrito_estudiante',
        AR.nombre as 'area',
        AV.titulo as 'titulo_oferta',
        EM.ruc,
        EM.razon_social,
        EM.nombre_comercial,
        EST.nombre as 'estados'
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join avisos AV on AV.id=ALV.aviso_id
        inner join distritos D on D.id=AL.distrito_id
        inner join grado_academicos GA on GA.id=AL.egresado
        inner join areas AR on AR.id=AL.area_id
        inner join empresas EM on EM.id=AV.empresa_id
        inner join estados EST on EST.id=ALV.estado_id
        where AL.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$grado_academico."");
        $query->execute();
        return $query->fetchAll();
    }

}
