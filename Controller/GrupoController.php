<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/Grupo.php';

class GrupoController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Insertar un grupo
    public function insertar(Grupo $grupo)
    {
        $nombre_grupo = $this->db->escapeString($grupo->getNombreGrupo());
        $id_institucion = $this->db->escapeString($grupo->getIdInstitucion());

        $query = "INSERT INTO grupo (nombre_grupo, id_institucion) 
                  VALUES ('$nombre_grupo', $id_institucion)";
        return $this->db->query($query);
    }

    // Actualizar un grupo
    public function actualizar(Grupo $grupo)
    {
        $id_grupo = $grupo->getIdGrupo();
        $nombre_grupo = $this->db->escapeString($grupo->getNombreGrupo());
        $id_institucion = $this->db->escapeString($grupo->getIdInstitucion());

        $query = "UPDATE grupo 
                  SET nombre_grupo = '$nombre_grupo', id_institucion = $id_institucion 
                  WHERE id_grupo = $id_grupo";
        return $this->db->query($query);
    }

    // Eliminar un grupo
    public function eliminar($id_grupo)
    {
        $query = "DELETE FROM grupo WHERE id_grupo = $id_grupo";
        return $this->db->query($query);
    }

    // Listar todos los grupos
    public function listar()
    {
        $query = "SELECT * FROM grupo";
        $result = $this->db->query($query);

        $grupos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $grupos[] = new Grupo(
                    $row['id_grupo'],
                    $row['nombre_grupo'],
                    $row['id_institucion']
                );
            }
        }

        return $grupos;
    }

    // Obtener un grupo por ID
    public function obtenerPorId($id_grupo)
    {
        $query = "SELECT * FROM grupo WHERE id_grupo = $id_grupo";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Grupo(
                $row['id_grupo'],
                $row['nombre_grupo'],
                $row['id_institucion']
            );
        }

        return null;
    }
}
