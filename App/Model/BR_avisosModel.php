<?php

namespace App\Model;

use Core\Model;

class BR_avisosModel extends Model
{

    public function BusquedaRapidaAviso($valor)
    {
        $query = $this->db->prepare("SELECT 
        A.id,
        A.titulo,
        TP.tipo as 'tipo_persona',
        COALESCE(A.periodo_vigencia,'-') as 'periodo_vigencia',
        A.descripcion,
        COALESCE(A.direccion,'-') as 'direccion',
        A.salario,
        A.created_at,
        COALESCE(GA.grado_estado,'-') as 'grado_academico',
        COALESCE(A.vacantes,'-') as 'vacantes',
        COALESCE(EM.ruc,'-') as 'rucEmpresa',
        COALESCE(EM.razon_social,'-') as 'razon_social',
        COALESCE(EM.nombre_comercial,'-') as 'nombre_comercial',
        COALESCE(D.nombre,'-') as 'nombre_distrito',
        COALESCE(AR.nombre,'-') as 'nombre_carrera'
        FROM avisos A
        left join empresas EM on EM.id=A.empresa_id
        left join distritos D on D.id= A.distrito_id
        left join areas AR on AR.id= A.solicita_carrera
        left join grado_academicos GA on GA.id= A.solicita_grado_a
        left join tipo_personas TP on TP.id=EM.tipo_persona
        WHERE (A.titulo like '%".$valor."%' or EM.ruc like '%".$valor."%') AND A.deleted_at IS NULL limit 20");
        $query->execute();
        return $query->fetchAll();
    }
    
    public function RegistrarPostulantemManual($datos)
    {
        $query = $this->db->prepare('INSERT INTO estudiante_avisos(aviso_id, nombres, dni, telefono, correo, grado_academico, estado) 
        VALUES ('.$datos["aviso_id"].', "'.$datos["nombre"].'", "'.$datos["dni"].'", "'.$datos["celular"].'", "'.$datos["correo"].'", "'.$datos["grado_academico"].'", "'.$datos["estado"].'" )');
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

    public function Distrito()
    {
        $query = $this->db->prepare("SELECT * FROM distritos WHERE deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function Carrera()
    {
        $query = $this->db->prepare("SELECT * FROM areas WHERE deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function EstadoPost()
    {
        $query = $this->db->prepare("SELECT * FROM estados WHERE deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function GradoAcademico()
    {
        $query = $this->db->prepare("SELECT * FROM grado_academicos WHERE deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function ListarTablaPostulantesManual($id)
    {
        $query = $this->db->prepare("SELECT * FROM estudiante_avisos WHERE aviso_id=$id and deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function ModificarAviso($datos)
    {
        $query = $this->db->prepare('UPDATE avisos SET titulo="'.$datos["mod_form_titulo"].'",distrito_id="'.$datos["mod_form_distrito"].'", descripcion="'.$datos["mod_form_descripcion"].'", salario="'.$datos["mod_form_salario"].'", vacantes="'.$datos["mod_form_vacantes"].'", solicita_carrera="'.$datos["mod_form_carrera"].'", solicita_grado_a="'.$datos["mod_form_estado"].'", ciclo_cursa="'.$datos["mod_form_grado"].'" WHERE id='.$datos["id_aviso"].'');                                                                                                             
        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    public function verDataAviso($id)
    {
        $query = $this->db->prepare('SELECT 
        AV.id,
        AV.distrito_id,
        AV.solicita_carrera,
        AV.vacantes,
        AV.ciclo_cursa,
        AV.periodo_vigencia,
        AV.salario,
        AV.solicita_grado_a,
        COALESCE(AV.titulo, "no hay dato") AS "titulo",
        COALESCE(D.nombre, "no hay dato") AS "distrito",
        COALESCE(AR.nombre, "no hay dato") AS "carrera",
        COALESCE(AV.descripcion, "no hay dato") AS "descripcion",
        COALESCE(AV.direccion, "no hay dato") AS "direccion",
        COALESCE(AV.salario, "no hay dato") AS "salario",
        COALESCE(EM.nombre_comercial, "no hay dato") AS "nombre_comercial",
        AV.created_at AS "publicado"
        FROM avisos AV 
        INNER JOIN empresas EM ON EM.id=AV.empresa_id
        INNER JOIN distritos D ON D.id=AV.distrito_id
        INNER JOIN areas AR ON AR.id=AV.solicita_carrera
        WHERE AV.id='.$id);
        $query->execute();
        return $query->fetchAll();
    }

    public function RegistrarCuadroSeguimiento($datos)
    {
        $query = $this->db->prepare('INSERT INTO intermediacion_seguimientos(aviso_id, fecha_envio_postulantes, fecha_seguimiento, comentarios) 
        VALUES ('.$datos["aviso_id_f"].', "'.$datos["fecha_envio_postulante"].'", "'.$datos["fecha_seguimiento"].'", "'.$datos["comentario"].'")');
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }

    public function ValidarAlumnoID($id, $idAviso)
    {
        $query = $this->db->prepare("SELECT 
        AL.id,
        AL.nombres,
        AL.apellidos,
        AL.dni,
        AL.telefono,
        AL.email
        FROM alumnos AL
        inner join alumno_avisos ALV on ALV.alumno_id = AL.id
        WHERE AL.id=$id AND ALV.aviso_id=$idAviso AND AL.deleted_at IS NULL;");
        $query->execute();
        return $query->fetchAll();
    }

    public function SelectAlumnoID($id)
    {
        $query = $this->db->prepare("SELECT * FROM alumnos WHERE id=$id AND deleted_at IS NULL");
        $query->execute();
        return $query->fetchAll();
    }

    public function AgregarAlumnoPostulante($idAlumnos, $idAviso)
    {
        $valor = "INSERT INTO alumno_avisos(alumno_id,aviso_id, estado_id) VALUES";
        for ($i=0; $i < count($idAlumnos); $i++) { 
            $valor .= '('.$idAlumnos[$i]. ','.$idAviso.',1), ';
        }
        $consulta = rtrim($valor, ', ');
        $query = $this->db->prepare($consulta);
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
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

    public function ConsultarAlumno($alumno, $idAviso)
    {
        $query = $this->db->prepare('SELECT 
        AL.nombres,
        AL.apellidos,
        AL.dni,
        AL.telefono,
        AL.email,
        AL.id
        FROM alumnos AL
        WHERE (AL.dni like "'.$alumno.'%" or AL.apellidos like "%'.$alumno.'%" ) AND AL.deleted_at is null limit 10');
        $query->execute();
        return $query->fetchAll();
    }

    public function DataCursos($idAlumno)
    {
        $query = $this->db->prepare("SELECT * FROM referencia_laborals where alumno_id =$idAlumno and deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }
   
    public function EditarEstadoPost($datos)
    {
        $query = $this->db->prepare('UPDATE alumno_avisos SET estado_id="'.$datos["idEstado"].'" WHERE alumno_id="'.$datos["idAlumno"].'" and aviso_id="'.$datos["idAviso"].'"');                                                                                                             
        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    public function VerAvisosAlumnos($id)
    {
        $query = $this->db->prepare("SELECT 
            AL.nombres,
            AL.apellidos,
            AL.dni,
            AL.telefono,
            AL.email,
            AV.estado_id,
            AV.alumno_id,
            AV.aviso_id,
            AL.perfil_profesional,
            AV.created_at,
            ES.nombre as 'estado'
        FROM alumno_avisos AV
        inner join alumnos AL on AL.id=AV.alumno_id
        inner join estados ES on ES.id=AV.estado_id
        WHERE aviso_id=$id");
        $query->execute();
        return $query->fetchAll();
    }

    public function EliminarDataEmpleadores($id)
    {
        $query = $this->db->prepare("DELETE FROM avisos WHERE id = $id");  
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        }
    }
}
