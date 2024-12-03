<?php
class Estudiante
{
    private $id_estudiante;
    private $cedula;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $id_grupo;
    private $nombre_grupo; 

    public function __construct($id_estudiante = null, $cedula = null, $nombre = null, $apellido1 = null, $apellido2 = null, $id_grupo = null, $nombre_grupo = null)
    {
        $this->id_estudiante = $id_estudiante;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->id_grupo = $id_grupo;
        $this->nombre_grupo = $nombre_grupo;
    }

    // Métodos Getters y Setters
    public function getIdEstudiante()
    {
        return $this->id_estudiante;
    }

    public function setIdEstudiante($id_estudiante)
    {
        $this->id_estudiante = $id_estudiante;
    }

    public function getCedula()
    {
        return $this->cedula;
    }

    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido1()
    {
        return $this->apellido1;
    }

    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }

    public function getApellido2()
    {
        return $this->apellido2;
    }

    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }

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

    /**
     * Retorna el nombre completo del estudiante
     * @return string
     */
    public function getNombreCompleto()
    {
        return trim("{$this->nombre} {$this->apellido1} {$this->apellido2}");
    }

    /**
     * Verifica si el estudiante pertenece a un grupo
     * @return bool
     */
    public function tieneGrupo()
    {
        return !is_null($this->id_grupo) && $this->id_grupo > 0;
    }
}
