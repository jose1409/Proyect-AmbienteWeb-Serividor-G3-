<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/Profesor.php';

class ProfesorController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Insertar un profesor
    public function insertar(Profesor $profesor)
    {
        $cedula = $this->db->escapeString($profesor->getCedula());
        $nombre = $this->db->escapeString($profesor->getNombre());
        $apellido1 = $this->db->escapeString($profesor->getApellido1());
        $apellido2 = $this->db->escapeString($profesor->getApellido2());
        $id_institucion = $this->db->escapeString($profesor->getIdInstitucion());

        $query = "INSERT INTO profesor (cedula, nombre, apellido1, apellido2, id_institucion) 
                  VALUES ('$cedula', '$nombre', '$apellido1', '$apellido2', $id_institucion)";
        return $this->db->query($query);
    }

    // Actualizar un profesor
    public function actualizar(Profesor $profesor)
    {
        $id = $profesor->getIdProfesor();
        $cedula = $this->db->escapeString($profesor->getCedula());
        $nombre = $this->db->escapeString($profesor->getNombre());
        $apellido1 = $this->db->escapeString($profesor->getApellido1());
        $apellido2 = $this->db->escapeString($profesor->getApellido2());
        $id_institucion = $this->db->escapeString($profesor->getIdInstitucion());

        $query = "UPDATE profesor 
                  SET cedula = '$cedula', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', id_institucion = $id_institucion 
                  WHERE id_profesor = $id";
        return $this->db->query($query);
    }

    // Eliminar un profesor
    public function eliminar($id_profesor)
    {
        $query = "DELETE FROM profesor WHERE id_profesor = $id_profesor";
        return $this->db->query($query);
    }

    // Listar todos los profesores
    public function listar()
    {
        $query = "SELECT * FROM profesor";
        $result = $this->db->query($query);

        $profesores = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $profesores[] = new Profesor(
                    $row['id_profesor'],
                    $row['cedula'],
                    $row['nombre'],
                    $row['apellido1'],
                    $row['apellido2'],
                    $row['id_institucion']
                );
            }
        }

        return $profesores;
    }

    // Obtener un profesor por ID
    public function obtenerPorId($id_profesor)
    {
        $query = "SELECT * FROM profesor WHERE id_profesor = $id_profesor";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Profesor(
                $row['id_profesor'],
                $row['cedula'],
                $row['nombre'],
                $row['apellido1'],
                $row['apellido2'],
                $row['id_institucion']
            );
        }

        return null;
    }
}
