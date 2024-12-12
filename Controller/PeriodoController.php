<?php
require_once __DIR__ . '/../DB/Database.php';
require_once __DIR__ . '/../Models/Periodo.php';

class PeriodoController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Listar todos los Periodos
    public function listar()
    {
        $query = "SELECT * FROM periodo";
        $result = $this->db->query($query);

        $periodos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $periodos[] = new Periodo(
                    $row['id_periodo'],
                    $row['nombre_periodo'],
                    $row['fecha_inicio'],
                    $row['fecha_fin'],
                );
            }
        }

        return $periodos;
    }

    // Insertar un nuevo Periodo
    public function insertar(Periodo $periodo)
    {
        $nombre_periodo = $this->db->escapeString($periodo->getNombrePeriodo());
        $fecha_inicio = $this->db->escapeString($periodo->getFechaInicio());
        $fecha_fin = $this->db->escapeString($periodo->getFechaFin());

        $query = "INSERT INTO periodo (nombre_periodo, fecha_inicio, fecha_fin) 
              VALUES ('$nombre_periodo', '$fecha_inicio', '$fecha_fin')";

        return $this->db->query($query);
    }

    // Actualizar un periodo
    public function actualizar(Periodo $periodo)
    {
        $id = $periodo->getIdPeriodo();
        $nombre_periodo = $this->db->escapeString($periodo->getNombrePeriodo());
        $fecha_inicio = $this->db->escapeString($periodo->getFechaInicio());
        $fecha_fin = $this->db->escapeString($periodo->getFechaFin());

        $query = "UPDATE periodo
              SET nombre_periodo = '$nombre_periodo', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin'
              WHERE id_periodo = $id";
        return $this->db->query($query);
    }

    // Eliminar un periodo
    public function eliminar($id_periodo)
    {
        $query = "DELETE FROM periodo WHERE id_periodo = $id_periodo";
        return $this->db->query($query);
    }
}
