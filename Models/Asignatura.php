<?php

class Asignatura{
    private $id_asignatura;
    private $nombre;

    //Constructor
    public function __construct($id_asignatura = null, $nombre = null)
    {
        $this->id_asignatura = $id_asignatura;
        $this->nombre = $nombre;
    }

    // Métodos Getters y Setters
    public function getIdAsignatura()
    {
        return $this->id_asignatura;
    }

    public function setIdAsignatura($id_asignatura)
    {
        $this->id_asignatura = $id_asignatura;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /*Metodo para convertir el objeto a String*/
    public function __toString()
    {
        return "ID: {$this->id_asignatura}, Nombre: {$this->nombre}";
    }
}
