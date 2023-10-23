<?php

namespace App\Model;

use Core\Model;

class R_A_efectividadAvisoModel extends Model
{

    public function ListarEfectividadAvisosPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $estado_estudiante)
    {
        $query = $this->db->prepare("SELECT
            J1.ruc,
            J1.tipo_persona,
            J1.razon_social,
            J1.nombre_comercial,
            J1.titulo as 'titulo_oferta',
            J1.estado as Estado,
            count(*) as Cant
        from (
        select 
        AV.titulo,
        ALV.estado_id,
        EM.ruc,
        EM.nombre_comercial,
        EM.razon_social,
        EST.nombre as 'estado',
        TP.tipo as 'tipo_persona'
        from alumno_avisos ALV
        left join avisos AV on ALV.aviso_id=AV.id
        inner join empresas EM on EM.id=AV.empresa_id
        left join estados EST on EST.id=ALV.estado_id
        inner join tipo_personas TP on TP.id=EM.tipo_persona
        where EM.deleted_at is null and AV.deleted_at is null AND AV.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' ".$programa_estudio." ".$estado_estudiante."
        ) as J1
        group by J1.titulo,
            J1.estado,
            J1.nombre_comercial");
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

    public function ConsultaEfectividadAvisoGrafico($fecha_inicial, $fecha_final, $programa_estudio, $estado_estudiante)
    {
        $query = $this->db->prepare("SELECT
            (SELECT COUNT(*) FROM avisos AV
            where AV.deleted_at is null AND AV.created_at between '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59') AS Cantidad_Avisos,
            SUM(CASE WHEN nombre = 'Aceptado' THEN cantidad ELSE 0 END) AS Aceptado,
            SUM(CASE WHEN nombre = 'Descartado' THEN cantidad ELSE 0 END) AS Descartado,
            SUM(CASE WHEN nombre = 'Evaluando' THEN cantidad ELSE 0 END) AS Evaluando,
            SUM(CASE WHEN nombre = 'Postulante' THEN cantidad ELSE 0 END) AS Postulante,
            SUM(CASE WHEN nombre = 'Seleccionado' THEN cantidad ELSE 0 END) AS Seleccionado,
            (SUM(CASE WHEN nombre = 'Aceptado' THEN cantidad ELSE 0 END) + 
            SUM(CASE WHEN nombre = 'Descartado' THEN cantidad ELSE 0 END) +
            SUM(CASE WHEN nombre = 'Evaluando' THEN cantidad ELSE 0 END) +
            SUM(CASE WHEN nombre = 'Postulante' THEN cantidad ELSE 0 END) +
            SUM(CASE WHEN nombre = 'Seleccionado' THEN cantidad ELSE 0 END)) AS sumaIntermediacion
        FROM (
        SELECT 
        E.nombre,
        count(*) as Cantidad
        FROM alumno_avisos ALV
        INNER JOIN avisos AV on ALV.aviso_id=AV.id
        inner join estados as E on E.id=ALV.estado_id
        where AV.deleted_at is null AND AV.created_at between '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' ".$programa_estudio." ".$estado_estudiante."
        group by 
        E.nombre
        ) as J1");
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
