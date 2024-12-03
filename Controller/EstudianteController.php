<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/Estudiante.php';

class EstudianteController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Insertar un estudiante
    public function insertar(Estudiante $estudiante)
    {
        $cedula = $this->db->escapeString($estudiante->getCedula());
        $nombre = $this->db->escapeString($estudiante->getNombre());
        $apellido1 = $this->db->escapeString($estudiante->getApellido1());
        $apellido2 = $this->db->escapeString($estudiante->getApellido2());
        $id_grupo = $this->db->escapeString($estudiante->getIdGrupo());

        $query = "INSERT INTO estudiante (cedula, nombre, apellido1, apellido2, id_grupo) 
                  VALUES ('$cedula', '$nombre', '$apellido1', '$apellido2', $id_grupo)";
        return $this->db->query($query);
    }

    // Actualizar un estudiante
    public function actualizar(Estudiante $estudiante)
    {
        $id = $estudiante->getIdEstudiante();
        $cedula = $this->db->escapeString($estudiante->getCedula());
        $nombre = $this->db->escapeString($estudiante->getNombre());
        $apellido1 = $this->db->escapeString($estudiante->getApellido1());
        $apellido2 = $this->db->escapeString($estudiante->getApellido2());
        $id_grupo = $this->db->escapeString($estudiante->getIdGrupo());

        $query = "UPDATE estudiante 
                  SET cedula = '$cedula', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', id_grupo = $id_grupo 
                  WHERE id_estudiante = $id";
        return $this->db->query($query);
    }

    // Eliminar un estudiante
    public function eliminar($id_estudiante)
    {
        $query = "DELETE FROM estudiante WHERE id_estudiante = $id_estudiante";
        return $this->db->query($query);
    }

    // Listar todos los estudiantes
    public function listar()
    {
        $query = "SELECT * FROM estudiante";
        $result = $this->db->query($query);

        $estudiantes = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $estudiantes[] = new Estudiante(
                    $row['id_estudiante'],
                    $row['cedula'],
                    $row['nombre'],
                    $row['apellido1'],
                    $row['apellido2'],
                    $row['id_grupo']
                );
            }
        }

        return $estudiantes;
    }

    // Obtener un estudiante por ID
    public function obtenerPorId($id_estudiante)
    {
        $query = "SELECT * FROM estudiante WHERE id_estudiante = $id_estudiante";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Estudiante(
                $row['id_estudiante'],
                $row['cedula'],
                $row['nombre'],
                $row['apellido1'],
                $row['apellido2'],
                $row['id_grupo']
            );
        }

        return null;
    }
}
