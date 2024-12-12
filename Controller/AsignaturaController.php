<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/Asignatura.php';

class AsignaturaController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }



    // Listar todas las asignaturas
    public function listar()
    {
        $query = "SELECT * FROM asignatura";
        $result = $this->db->query($query);

        $asignaturas = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $asignaturas[] = new Asignatura(
                    $row['id_asignatura'],
                    $row['nombre'],
                );
            }
        }

        return $asignaturas;
    }

    // Insertar una Asignatura
    public function insertar(Asignatura $asignatura)
    {
        $nombre = $this->db->escapeString($asignatura->getNombre());
        $query = "INSERT INTO asignatura (nombre) VALUES ('$nombre')";
        return $this->db->query($query);
    }

    // Actualizar una Asignatura
    public function actualizar(Asignatura $asignatura)
    {
        $id = $asignatura->getIdAsignatura();
        $nombre = $this->db->escapeString($asignatura->getNombre());
        $query = "UPDATE asignatura SET nombre = '$nombre' WHERE id_asignatura = $id";
        return $this->db->query($query);
    }

    // Eliminar una institución
    public function eliminar($id_asignatura)
    {
        $query = "DELETE FROM asignatura WHERE id_asignatura = $id_asignatura";
        return $this->db->query($query);
    }

    // Obtener una institución por ID
    public function obtenerPorId($id_asignatura)
    {
        $query = "SELECT * FROM institucion WHERE id_asignatura = $id_asignatura";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Institucion($row['id_asignatura'], $row['nombre']);
        }

        return null; // en caso de no encontrar la institución
    }
}
