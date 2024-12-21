<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/Calificaciones.php';

class CalificacionController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Insertar una calificación
    public function insertar(calificacion $calificacion)
    {
        $id_estudiante = $this->db->escapeString($calificacion->getIdEstudiante());      
        $trabajo_cotidiano = $this->db->escapeString($calificacion->getTrabajoCotidiano());
        $tareas = $this->db->escapeString($calificacion->getTareas());
        $proyecto = $this->db->escapeString($calificacion->getProyecto());
        $asistencia = $this->db->escapeString($calificacion->getAsistencia());
        $calificacion_final = $this->db->escapeString($calificacion->getCalificacionFinal());

        $query = "INSERT INTO CALIFICACIONES (id_estudiante, trabajo_cotidiano, tareas, proyecto, asistencia, calificacion_final) 
                  VALUES ($id_estudiante, $trabajo_cotidiano, $tareas, $proyecto, $asistencia, $calificacion_final)";
        return $this->db->query($query);
    }

    // Actualizar una calificación
    public function actualizar(calificacion $calificacion)
    {
        $id = $calificacion->getIdCalificacion();
        $id_estudiante = $this->db->escapeString($calificacion->getIdEstudiante());
        $trabajo_cotidiano = $this->db->escapeString($calificacion->getTrabajoCotidiano());
        $tareas = $this->db->escapeString($calificacion->getTareas());
        $proyecto = $this->db->escapeString($calificacion->getProyecto());
        $asistencia = $this->db->escapeString($calificacion->getAsistencia());
        $calificacion_final = $this->db->escapeString($calificacion->getCalificacionFinal());

        $query = "UPDATE CALIFICACIONES 
                  SET id_estudiante = $id_estudiante, trabajo_cotidiano = $trabajo_cotidiano, 
                      tareas = $tareas, proyecto = $proyecto, asistencia = $asistencia, calificacion_final = $calificacion_final 
                  WHERE id_calificacion = $id";
        return $this->db->query($query);
    }

    // Eliminar una calificación
    public function eliminar($id_calificacion)
    {
        $query = "DELETE FROM CALIFICACIONES WHERE id_calificacion = $id_calificacion";
        return $this->db->query($query);
    }

    // Listar todas las calificaciones
    public function listar()
    {
        $query = "SELECT * FROM CALIFICACIONES";
        $result = $this->db->query($query);

        $calificaciones = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $calificaciones[] = new calificacion(
                    $row['id_calificacion'],
                    $row['id_estudiante'],
                    $row['trabajo_cotidiano'],
                    $row['tareas'],
                    $row['proyecto'],
                    $row['asistencia'],
                    $row['calificacion_final']
                );
            }
        }

        return $calificaciones;
    }

    // Obtener una calificación por ID
    public function obtenerPorId($id_calificacion)
    {
        $query = "SELECT * FROM CALIFICACIONES WHERE id_calificacion = $id_calificacion";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Calificacion(
                $row['id_calificacion'],
                $row['id_estudiante'],
                $row['trabajo_cotidiano'],
                $row['tareas'],
                $row['proyecto'],
                $row['asistencia'],
                $row['calificacion_final']
            );
        }

        return null;
    }
}
