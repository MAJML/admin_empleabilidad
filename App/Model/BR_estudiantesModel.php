<?php

namespace App\Model;

use Core\Model;

class BR_estudiantesModel extends Model
{

    public function BusquedaRapidaEstudiantes($valor)
    {
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
        WHERE (A.dni LIKE '".$valor."%' or A.apellidos like '%".$valor."%' ) and A.deleted_at IS NULL limit 20");
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

    public function programaEstudios()
    {
        $query = $this->db->prepare("SELECT * FROM areas where deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function GradoAcademico()
    {
        $query = $this->db->prepare("SELECT * FROM grado_academicos where deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function RegistrarCuentaAlumno($datos)
    {
        $query = $this->db->prepare('INSERT INTO alumnos(nombres, apellidos, dni, tipo_documento, telefono, email, fecha_nacimiento, provincia_id, distrito_id, area_id, usuario_alumno, password, aprobado, egresado) 
        VALUES ("'.$datos["nombres"].'", 
                "'.$datos["apellidos"].'", 
                "'.$datos["dni"].'", 
                1, 
                "'.$datos["telefono"].'",
                "'.$datos['email'].'",
                "'.$datos['nacimiento'].'",
                "'.$datos['provincia'].'",
                "'.$datos['distrito'].'",
                "'.$datos['programa_estudio'].'",
                "'.$datos['dni'].'",
                "'.$datos['password'].'",
                1,
                "'.$datos['grado_academico'].'")');
        if($query->execute()){
            return "ok";
        }else{
            return "error";          
        } 
    }

    public function VerificarAlumnoRepetidos($dni)
    {
        $query = $this->db->prepare("SELECT * FROM alumnos where dni=$dni and deleted_at is null");
        $query->execute();
        return $query->fetchAll();
    }

    public function ConsultarCuentasCreadas()
    {
        $query = $this->db->prepare("SELECT 
        AL.apellidos,
        AL.dni,
        AL.telefono,
        AL.email,
        AR.nombre as 'areas',
        D.nombre as 'distritos',
        GA.grado_estado as 'grado',
        AL.created_at
        from alumnos AL
        inner join areas AR on AR.id=AL.area_id
        inner join distritos D on D.id=AL.distrito_id 
        inner join grado_academicos GA on GA.id=AL.egresado
        where date(AL.created_at) = date(NOW()) and AL.deleted_at is null 
        order by AL.created_at desc");
        $query->execute();
        return $query->fetchAll();
    }

}
