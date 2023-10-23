<?php

namespace App\Model;

use Core\Model;

class R_EST_seguimientoPostulanteModel extends Model
{

    public function ListarSeguimientoPostulantePorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico)
    {
        $query = $this->db->prepare("SELECT 
        distinct
        AL.id as 'id_estudiante',
        AL.nombres,
        AL.apellidos,
        AL.dni,
        GA.grado_estado as 'grado_academico',
        D.nombre as 'distrito_estudiante',
        AR.nombre as 'area'
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join avisos AV on AV.id=ALV.aviso_id
        inner join distritos D on D.id=AL.distrito_id
        inner join grado_academicos GA on GA.id=AL.egresado
        inner join areas AR on AR.id=AL.area_id
        where AL.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$grado_academico."");
        $query->execute();
        return $query->fetchAll();
    }

    public function ContadorActividadEconomicaPostulantes($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico)
    {
        $query = $this->db->prepare("SELECT 
        AE.descripcion as 'actividad_eco',
        count(*) as 'cantidad_eco'
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join avisos AV on AV.id=ALV.aviso_id
        inner join empresas EM on EM.id=AV.empresa_id
        inner join actividad_economicas AE on AE.id=EM.actividad_economica_empresa 
        WHERE AL.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$grado_academico."
        group by AE.descripcion");
        $query->execute();
        return $query->fetchAll();
    }

    public function TraerDataporIDestudiante($id_estudiante)
    {
        $query = $this->db->prepare("SELECT 
        AL.nombres,
        AL.apellidos,
        ALV.created_at as 'fecha_postulacion',
        AV.titulo as 'titulo_oferta',
        EM.ruc as 'ruc_dni',
        EM.razon_social,
        EM.nombre_comercial,
        EST.nombre as 'estado_postulacion'
        from alumno_avisos ALV 
        inner join alumnos AL on AL.id=ALV.alumno_id
        inner join avisos AV on AV.id=ALV.aviso_id
        inner join empresas EM on EM.id=AV.empresa_id
        inner join estados EST on EST.id=ALV.estado_id
        where alumno_id = $id_estudiante");
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

    public function ContadorAreaPorGradoAcademico($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico, $estado_estudiante)
    {
        $query = $this->db->prepare("SELECT
            J2.Area,
            Sum(J2.Estudiante) as Estudiante,
            sum(J2.Egresado) as Egresado,
            sum(J2.Titulado) as Titulado
        From  (
        Select
            J1.area,
            J1.gaid,      
            count(*) as Estudiante,
            0 as Egresado,
            0 as Titulado	
        From (
        select
            ALV.created_at as 'fecha_postulacion',
            AL.apellidos as 'apellido_postulante',
            AL.nombres as 'nombre_postulante',
            D.nombre as 'distrito',
            Ar.nombre as Area,
            ga.id as gaid,
            ga.grado_estado as grado
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join areas as Ar On Ar.id=AL.area_id
        inner join grado_academicos as ga On ga.id=AL.egresado
        inner join distritos D on D.id=AL.distrito_id
        inner join avisos AV on AV.id=ALV.aviso_id
        left join empresas EM on EM.id=AV.empresa_id
        left join estados EST on EST.id=ALV.estado_id
        Where 
            ga.id=0 and AL.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$estado_estudiante."
        ) as J1
        Group by J1.area,
                J1.Grado
        UNION ALL
        Select
            J1.area,
            J1.gaid,      
            0  as Estudiante,
            count(*)  as Egresado,
            0 as Titulado	
        From (
        select
            ALV.created_at as 'fecha_postulacion',
            AL.apellidos as 'apellido_postulante',
            AL.nombres as 'nombre_postulante',
            D.nombre as 'distrito',
            Ar.nombre as Area,
            ga.id as gaid,
            ga.grado_estado as grado
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join areas as Ar On Ar.id=AL.area_id
        inner join grado_academicos as ga On ga.id=AL.egresado
        inner join distritos D on D.id=AL.distrito_id
        inner join avisos AV on AV.id=ALV.aviso_id
        left join empresas EM on EM.id=AV.empresa_id
        left join estados EST on EST.id=ALV.estado_id
        Where 
            ga.id=1 and AL.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$estado_estudiante."
        ) as J1
        Group by J1.area,
                J1.Grado
        UNION ALL
        Select
            J1.area,
            J1.gaid,      
            0  as Estudiante,
            0  as Egresado,
            count(*)  as Titulado	
        From (
        select
            ALV.created_at as 'fecha_postulacion',
            AL.apellidos as 'apellido_postulante',
            AL.nombres as 'nombre_postulante',
            D.nombre as 'distrito',
            Ar.nombre as Area,
            ga.id as gaid,
            ga.grado_estado as grado
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join areas as Ar On Ar.id=AL.area_id
        inner join grado_academicos as ga On ga.id=AL.egresado
        inner join distritos D on D.id=AL.distrito_id
        inner join avisos AV on AV.id=ALV.aviso_id
        left join empresas EM on EM.id=AV.empresa_id
        left join estados EST on EST.id=ALV.estado_id
        Where 
            ga.id=2 and AL.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$estado_estudiante."
        ) as J1
        Group by J1.area,
                J1.Grado
                ) as J2
        group by
                J2.Area
        ");
        $query->execute();
        return $query->fetchAll();
    }

}
