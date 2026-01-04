<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'BCLogs.php';

class BCLogsDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get a log by its ID
     */
    public function getLogById($id_log)
    {
        $this->conn = $this->db->connect();

        $sql = "SELECT id_log, operation, table_name, row_ids, performed_at, details 
                FROM bc_logs 
                WHERE id_log = :id_log";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_log', (int)$id_log, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        return $result ? new BCLogs($result) : null;
    }

    /**
     * Get all logs from the database
     */
    public function getAllLogs($limit = null, $offset = 0)
    {
        $this->conn = $this->db->connect();

        $sql = "SELECT id_log, operation, table_name, row_ids, performed_at, details 
                FROM bc_logs 
                ORDER BY performed_at DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->conn->prepare($sql);

        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $logs = [];
        foreach ($results as $row) {
            $logs[] = new BCLogs($row);
        }
        return $logs;
    }

    /**
     * Get all logs from a specific table
     */
    public function getAllLogsByTableName($table_name, $limit = null, $offset = 0)
    {
        $this->conn = $this->db->connect();

        $sql = "SELECT id_log, operation, table_name, row_ids, performed_at, details 
                FROM bc_logs 
                WHERE table_name = :table_name 
                ORDER BY performed_at DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':table_name', $table_name, PDO::PARAM_STR);

        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $logs = [];
        foreach ($results as $row) {
            $logs[] = new BCLogs($row);
        }
        return $logs;
    }
}
