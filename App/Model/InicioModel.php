<?php

namespace App\Model;

use Core\Model;
use Core\Orm;

class InicioModel extends Model
{
    public function alumnosOnline()
    {
        $query = $this->db->prepare("SELECT count(*) FROM alumnos where online=1 and deleted_at is null");
        $query->execute();
        /* return $query->fetch(PDO::FETCH_ASSOC); */
        return json_encode($query->fetch());
    }

    public function WhereUsuario($correo)
    {
        $query = $this->db->prepare("SELECT nombre, apellido, correo, perfil, password FROM usuarios WHERE correo = '".$correo."'");
        $query->execute();
        return $query->fetch();
    }

    public function TodosUsuarios()
    {
        $query = $this->db->prepare("SELECT * FROM usuarios");
        $query->execute();
        return $query->fetchAll();
    }

    public function ReporteEmpleadorModel()
    {
        $query = $this->db->prepare("call cantidad_empleador_por_anio_mes()");
        $query->execute();
        return $query->fetchAll();
    }

    public function ReporteEstudianteModel()
    {
        $query = $this->db->prepare("call cantidad_estudiante_por_mes_2023()");
        $query->execute();
        return $query->fetchAll();
    }

    public function ContadorEmpleadores($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio." 00:00:00' AND '".$fecha_final." 23:59:59'");
            $query->execute();
            return $query->fetch();             
        }
    }

    public function ContadorEstudiantes($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio." 00:00:00' AND '".$fecha_final." 23:59:59'");
            $query->execute();
            return $query->fetch();             
        }
    }

    public function ContadorAvisos($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();             
        }
    }

    // CONSULTAS TABLA EMPRESAS

    public function ContadorEmpleadorPersonaJuridica($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE tipo_persona=1 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE tipo_persona=1 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorEmpleadorPersonaNatural($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE tipo_persona=2 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE tipo_persona=2 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorEmpleadorPersonaNconNegocio($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE tipo_persona=3 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM empresas WHERE tipo_persona=3 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }

    // CONSULTAS TABLA ESTUDIANTES

    public function ContadorAlumnoEnfermeria($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=1 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=1 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAlumnoFarmacia($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=2 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=2 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAlumnoFisioterapia($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=3 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=3 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAlumnoLaboratorio($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=4 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=4 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAlumnoProtesis($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=5 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM alumnos WHERE area_id=5 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }

    // CONSULTA TABLA AVISOS

    public function ContadorAvisosEnfermeria($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=1 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=1 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAvisosFarmacia($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=2 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=2 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAvisosFisioterapia($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=3 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=3 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAvisosLaboratorio($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=4 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=4 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }
    public function ContadorAvisosProtesis($fecha_inicio, $fecha_final)
    {
        if($fecha_inicio == "1970-01-01"){
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=5 AND deleted_at IS NULL AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at)  = MONTH(CURRENT_DATE())");
            $query->execute();
            return $query->fetch();  
        }else{
            $query = $this->db->prepare("SELECT COUNT(*) FROM avisos WHERE solicita_carrera=5 AND deleted_at IS NULL AND `created_at`BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'");
            $query->execute();
            return $query->fetch();  
        }
    }

}