<?php
class Calificacion
{
    private $id_calificacion;
    private $id_estudiante;
    private $id_acta;
    private $trabajo_cotidiano;
    private $tareas;
    private $proyecto;
    private $asistencia;
    private $calificacion_final;

    public function __construct($id_calificacion = null, $id_estudiante = null, $id_acta = null, $trabajo_cotidiano = null, $tareas = null, $proyecto = null, $asistencia = null, $calificacion_final = null)
    {
        $this->id_calificacion = $id_calificacion;
        $this->id_estudiante = $id_estudiante;
        $this->id_acta = $id_acta;
        $this->trabajo_cotidiano = $trabajo_cotidiano;
        $this->tareas = $tareas;
        $this->proyecto = $proyecto;
        $this->asistencia = $asistencia;
        $this->calificacion_final = $calificacion_final;
    }

    // Métodos Getters y Setters
    public function getIdCalificacion()
    {
        return $this->id_calificacion;
    }

    public function setIdCalificacion($id_calificacion)
    {
        $this->id_calificacion = $id_calificacion;
    }

    public function getIdEstudiante()
    {
        return $this->id_estudiante;
    }

    public function setIdEstudiante($id_estudiante)
    {
        $this->id_estudiante = $id_estudiante;
    }

    public function getIdActa()
    {
        return $this->id_acta;
    }

    public function setIdActa($id_acta)
    {
        $this->id_acta = $id_acta;
    }

    public function getTrabajoCotidiano()
    {
        return $this->trabajo_cotidiano;
    }

    public function setTrabajoCotidiano($trabajo_cotidiano)
    {
        $this->trabajo_cotidiano = $trabajo_cotidiano;
    }

    public function getTareas()
    {
        return $this->tareas;
    }

    public function setTareas($tareas)
    {
        $this->tareas = $tareas;
    }

    public function getProyecto()
    {
        return $this->proyecto;
    }

    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;
    }

    public function getAsistencia()
    {
        return $this->asistencia;
    }

    public function setAsistencia($asistencia)
    {
        $this->asistencia = $asistencia;
    }

    public function getCalificacionFinal()
    {
        return $this->calificacion_final;
    }

    public function setCalificacionFinal($calificacion_final)
    {
        $this->calificacion_final = $calificacion_final;
    }

    /**
     * Calcula la calificación final basada en los componentes individuales con pesos específicos.
     * Trabajo cotidiano: 30%, Tareas: 15%, Proyecto: 45%, Asistencia: 10%.
     * @return float
     */
    public function calcularCalificacionFinal()
    {
        return (
            ($this->trabajo_cotidiano * 0.30) +
            ($this->tareas * 0.15) +
            ($this->proyecto * 0.45) +
            ($this->asistencia * 0.10)
        );
    }

    /**
     * Verifica si la calificación final es aprobatoria.
     * @return bool
     */
    public function esAprobatoria()
    {
        return $this->calificacion_final >= 70;
    }
}
