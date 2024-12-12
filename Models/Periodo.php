<?php

class Periodo {
    private $id_periodo;
    private $nombre_periodo;
    private $fecha_inicio;
    private $fecha_fin;

    // Constructor
    public function __construct($id_periodo = null, $nombre_periodo = null, $fecha_inicio = null, $fecha_fin = null) {
        $this->id_periodo = $id_periodo;
        $this->nombre_periodo = $nombre_periodo;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    // Getter para id_periodo
    public function getIdPeriodo() {
        return $this->id_periodo;
    }

    // Setter para id_periodo
    public function setIdPeriodo($id_periodo) {
        $this->id_periodo = $id_periodo;
    }

    // Getter para nombre_periodo
    public function getNombrePeriodo() {
        return $this->nombre_periodo;
    }

    // Setter para nombre_periodo
    public function setNombrePeriodo($nombre_periodo) {
        $this->nombre_periodo = $nombre_periodo;
    }

    // Getter para fecha_inicio
    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    // Setter para fecha_inicio
    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    // Getter para fecha_fin
    public function getFechaFin() {
        return $this->fecha_fin;
    }

    // Setter para fecha_fin
    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    // Método para convertir el objeto a string
    public function __toString() {
        return "ID: {$this->id_periodo}, Nombre: {$this->nombre_periodo}, Fecha Inicio: {$this->fecha_inicio}, Fecha Fin: {$this->fecha_fin}";
    }
}
?>
