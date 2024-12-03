<?php

class Institucion {
    private $id_institucion;
    private $nombre;

    // Constructor
    public function __construct($id_institucion = null, $nombre = null) {
        $this->id_institucion = $id_institucion;
        $this->nombre = $nombre;
    }

    // Getter para id_institucion
    public function getIdInstitucion() {
        return $this->id_institucion;
    }

    // Setter para id_institucion
    public function setIdInstitucion($id_institucion) {
        $this->id_institucion = $id_institucion;
    }

    // Getter para nombre
    public function getNombre() {
        return $this->nombre;
    }

    // Setter para nombre
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Método para convertir el objeto a string
    public function __toString() {
        return "ID: {$this->id_institucion}, Nombre: {$this->nombre}";
    }
}
?>
