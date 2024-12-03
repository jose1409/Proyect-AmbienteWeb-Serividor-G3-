<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/institucion.php';

class InstitucionController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Insertar una institución
    public function insertar(Institucion $institucion)
    {
        $nombre = $this->db->escapeString($institucion->getNombre());
        $query = "INSERT INTO institucion (nombre) VALUES ('$nombre')";
        return $this->db->query($query);
    }

    // Actualizar una institución
    public function actualizar(Institucion $institucion)
    {
        $id = $institucion->getIdInstitucion();
        $nombre = $this->db->escapeString($institucion->getNombre());
        $query = "UPDATE institucion SET nombre = '$nombre' WHERE id_institucion = $id";
        return $this->db->query($query);
    }

    // Eliminar una institución
    public function eliminar($id_institucion)
    {
        $query = "DELETE FROM institucion WHERE id_institucion = $id_institucion";
        return $this->db->query($query);
    }

    // Listar todas las instituciones
    public function listar()
    {
        $query = "SELECT * FROM institucion";
        $result = $this->db->query($query);

        $instituciones = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $instituciones[] = new Institucion($row['id_institucion'], $row['nombre']);
            }
        }

        return $instituciones;
    }

    // Obtener una institución por ID
    public function obtenerPorId($id_institucion)
    {
        $query = "SELECT * FROM institucion WHERE id_institucion = $id_institucion";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Institucion($row['id_institucion'], $row['nombre']);
        }

        return null; // en caso de no encontrar la institución
    }
}
