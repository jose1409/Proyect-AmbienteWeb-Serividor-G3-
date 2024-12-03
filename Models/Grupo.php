<?php

class Grupo
{
    private $id_grupo;
    private $nombre_grupo;
    private $id_institucion;

    // Constructor
    public function __construct($id_grupo = null, $nombre_grupo = null, $id_institucion = null)
    {
        $this->id_grupo = $id_grupo;
        $this->nombre_grupo = $nombre_grupo;
        $this->id_institucion = $id_institucion;
    }

    // Getters y Setters
    public function getIdGrupo()
    {
        return $this->id_grupo;
    }

    public function setIdGrupo($id_grupo)
    {
        $this->id_grupo = $id_grupo;
    }

    public function getNombreGrupo()
    {
        return $this->nombre_grupo;
    }

    public function setNombreGrupo($nombre_grupo)
    {
        $this->nombre_grupo = $nombre_grupo;
    }

    public function getIdInstitucion()
    {
        return $this->id_institucion;
    }

    public function setIdInstitucion($id_institucion)
    {
        $this->id_institucion = $id_institucion;
    }
}
