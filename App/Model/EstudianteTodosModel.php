<?php

namespace App\Model;

use Core\Model;

class EstudianteTodosModel extends Model
{

    public function ListaEstudiantePorFechas($fecha_inicial, $fecha_final, $validacion, $tipoEstudiante)
    {
        $sql = "SELECT 
            A.id,
            A.nombres,
            A.apellidos,
            A.dni,
            A.tipo_documento,
            A.genero,
            A.nacionalidad,
            A.estado_civil,
            A.telefono,
            A.email,
            A.perfil_profesional,
            A.curso_talleres,
            A.referentes_carrera,
            A.fecha_nacimiento,
            P.nombre AS 'nombre_provincia',
            D.nombre AS 'nombre_distritos',
            AR.nombre AS 'nombre_area',
            A.ciclo,
            A.direccion,
            A.presentacion,
            A.aprobado,
            A.egresado,
            A.anio_egreso,
            A.semestre,
            A.salario,
            A.disponibilidad,
            A.created_at
        FROM alumnos A 
        INNER JOIN provincias P ON P.id=A.provincia_id 
        INNER JOIN distritos D ON D.id=A.distrito_id
        INNER JOIN areas AR ON AR.id=area_id
        LEFT JOIN educacions EDU ON EDU.alumno_id=A.id
        WHERE A.egresado ".$tipoEstudiante." AND date(A.created_at) BETWEEN ? AND ? AND A.deleted_at IS NULL";
    
        switch ($validacion) {
            case "COMPLETADO":
                $sql .= " AND EDU.alumno_id IS NOT NULL";
                break;
            case "FALTA_COMPLETAR":
                $sql .= " AND EDU.alumno_id IS NULL";
                break;
            default:
                // No se agregan condiciones adicionales
                break;
        }

        $query = $this->db->prepare($sql);
        $query->bindValue(1, $fecha_inicial);
        $query->bindValue(2, $fecha_final);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function ListaEstudiantePorFechasAntiguo($fecha_inicial, $fecha_final, $validacion, $tipoEstudiante)
    {
        if($validacion == "COMPLETADO"){
            $query = $this->db->prepare("SELECT 
            A.id,
            A.nombres,
            A.apellidos,
            A.dni,
            A.tipo_documento,
            A.genero,
            A.nacionalidad,
            A.estado_civil,
            A.telefono,
            A.email,
            A.perfil_profesional,
            A.curso_talleres,
            A.referentes_carrera,
            A.fecha_nacimiento,
            P.nombre AS 'nombre_provincia',
            D.nombre AS 'nombre_distritos',
            AR.nombre AS 'nombre_area',
            A.ciclo,
            A.direccion,
            A.presentacion,
            A.aprobado,
            A.egresado,
            A.anio_egreso,
            A.semestre,
            A.salario,
            A.disponibilidad,
            A.created_at
            FROM alumnos A 
            INNER JOIN provincias P ON P.id=A.provincia_id 
            INNER JOIN distritos D ON D.id=A.distrito_id
            INNER JOIN areas AR ON AR.id=area_id
            INNER JOIN educacions EDU ON EDU.alumno_id=A.id
            WHERE A.egresado ".$tipoEstudiante." AND A.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND A.deleted_at IS NULL
            AND EDU.alumno_id IS NOT NULL 
            AND EDU.deleted_at IS NULL");
            $query->execute();
            return $query->fetchAll();
        }else if($validacion == "FALTA_COMPLETAR"){
            $query = $this->db->prepare("SELECT 
            A.id,
            A.nombres,
            A.apellidos,
            A.dni,
            A.tipo_documento,
            A.genero,
            A.nacionalidad,
            A.estado_civil,
            A.telefono,
            A.email,
            A.perfil_profesional,
            A.curso_talleres,
            A.referentes_carrera,
            A.fecha_nacimiento,
            P.nombre AS 'nombre_provincia',
            D.nombre AS 'nombre_distritos',
            AR.nombre AS 'nombre_area',
            A.ciclo,
            A.direccion,
            A.presentacion,
            A.aprobado,
            A.egresado,
            A.anio_egreso,
            A.semestre,
            A.salario,
            A.disponibilidad,
            A.created_at
            FROM alumnos A 
            INNER JOIN provincias P ON P.id=A.provincia_id 
            INNER JOIN distritos D ON D.id=A.distrito_id
            INNER JOIN areas AR ON AR.id=area_id
            LEFT JOIN educacions EDU ON EDU.alumno_id=A.id
            WHERE A.egresado ".$tipoEstudiante." AND A.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND A.deleted_at IS NULL
            AND EDU.alumno_id IS NULL");
            $query->execute();
            return $query->fetchAll();
        }else if($validacion == " "){
            $query = $this->db->prepare("SELECT 
            A.id,
            A.nombres,
            A.apellidos,
            A.dni,
            A.tipo_documento,
            A.genero,
            A.nacionalidad,
            A.estado_civil,
            A.telefono,
            A.email,
            A.perfil_profesional,
            A.curso_talleres,
            A.referentes_carrera,
            A.fecha_nacimiento,
            P.nombre AS 'nombre_provincia',
            D.nombre AS 'nombre_distritos',
            AR.nombre AS 'nombre_area',
            A.ciclo,
            A.direccion,
            A.presentacion,
            A.aprobado,
            A.egresado,
            A.anio_egreso,
            A.semestre,
            A.salario,
            A.disponibilidad,
            A.created_at
            FROM alumnos A 
            INNER JOIN provincias P ON P.id=A.provincia_id 
            INNER JOIN distritos D ON D.id=A.distrito_id
            INNER JOIN areas AR ON AR.id=area_id
            WHERE A.egresado ".$tipoEstudiante." AND A.created_at BETWEEN '".$fecha_inicial." 00:00:00' AND '".$fecha_final." 23:59:59' AND A.deleted_at IS NULL");
            $query->execute();
            return $query->fetchAll();
        }
    }

    public function DataAlumnos($id)
    {
        $query = $this->db->prepare("SELECT * FROM alumnos WHERE id=$id AND deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    public function DataDistritos($idDistrito)
    {
        $query = $this->db->prepare("SELECT * FROM distritos WHERE id=$idDistrito AND deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    public function DataProvincia($idProvincia)
    {
        $query = $this->db->prepare("SELECT * FROM provincias WHERE id=$idProvincia AND deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    public function DataExperienciaLaborals($idAlumno)
    {
        $query = $this->db->prepare("SELECT * FROM experiencia_laborals Where alumno_id =$idAlumno AND deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    public function DataEducacion($idAlumno)
    {
        $query = $this->db->prepare("SELECT 
        E.alumno_id,
        E.area_id,
        E.institucion,
        E.carrera_curso,
        E.estado,
        E.estudio_inicio,
        E.estudio_fin,
        E.ciclo,
        E.estado_estudiante,
        E.anio,
        E.created_at,
        Ar.nombre as 'nombreArea'
        FROM educacions E
        inner join areas Ar on Ar.id=E.area_id
        where E.alumno_id =$idAlumno and E.deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function DataCursos($idAlumno)
    {
        $query = $this->db->prepare("SELECT * FROM referencia_laborals where alumno_id =$idAlumno and deleted_at is null");
        $query->execute();
        return $query->fetchAll();
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
        P.nombre AS 'nombre_provincia',
        D.nombre AS 'nombre_distritos'
        FROM empresas E 
        INNER JOIN provincias P ON P.id=E.provincia_id 
        INNER JOIN distritos D ON D.id=E.distrito_id
        WHERE E.id=$id");
        $query->execute();
        return $query->fetch();
    }

    public function EliminarDataEmpleadores($id)
    {
        $query = $this->db->prepare("DELETE FROM alumnos WHERE id = $id");  
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
