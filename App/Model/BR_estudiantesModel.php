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
    
}
