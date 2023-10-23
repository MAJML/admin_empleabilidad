<?php

namespace App\Model;

use Core\Model;

class R_EST_intermediacionModel extends Model
{

    public function ListarIntermediacionPorFecha($fecha_inicial, $fecha_final, $programa_estudio, $grado_academico, $estado_estudiante)
    {
        $query = $this->db->prepare("SELECT
            ALV.created_at as 'fecha_postulacion',
            AL.apellidos as 'apellido_postulante',
            AL.nombres as 'nombre_postulante',
            D.nombre as 'distrito',
            AV.titulo as 'titulo_oferta',
            COALESCE(EM.ruc , 'No hay ruc') as 'ruc',
            COALESCE(EM.razon_social, 'No hay razon social') as 'razon_social',
            COALESCE(EM.nombre_comercial, 'No hay nombre comercial') as 'nombre_comercial',
            EST.nombre as 'estado_alumno'
        from alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id=AL.id
        inner join distritos D on D.id=AL.distrito_id
        left join avisos AV on AV.id=ALV.aviso_id
        left join empresas EM on EM.id=AV.empresa_id
        left join estados EST on EST.id=ALV.estado_id
        where ALV.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND AL.deleted_at is null ".$programa_estudio." ".$grado_academico." ".$estado_estudiante."");
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
            ga.id=0 and ALV.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$estado_estudiante."
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
            ga.id=1 and ALV.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$estado_estudiante."
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
            ga.id=2 and ALV.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' and AL.deleted_at is null ".$programa_estudio." ".$estado_estudiante."
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
