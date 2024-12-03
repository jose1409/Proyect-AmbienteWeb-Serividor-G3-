<?php

class Profesor {
    private $id_profesor;
    private $cedula;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $id_institucion;

    // Constructor
    public function __construct($id_profesor = null, $cedula = null, $nombre = null, $apellido1 = null, $apellido2 = null, $id_institucion = null) {
        $this->id_profesor = $id_profesor;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->id_institucion = $id_institucion;
    }

    // Getters y Setters
    public function getIdProfesor() {
        return $this->id_profesor;
    }

    public function setIdProfesor($id_profesor) {
        $this->id_profesor = $id_profesor;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido1() {
        return $this->apellido1;
    }

    public function setApellido1($apellido1) {
        $this->apellido1 = $apellido1;
    }

    public function getApellido2() {
        return $this->apellido2;
    }

    public function setApellido2($apellido2) {
        $this->apellido2 = $apellido2;
    }

    public function getIdInstitucion() {
        return $this->id_institucion;
    }

    public function setIdInstitucion($id_institucion) {
        $this->id_institucion = $id_institucion;
    }
}
?>
