<?php

class BCLogs
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_log;
    
    /** ENUM('CREATE','READ','UPDATE','DELETE') NOT NULL */
    private string $operation;
    
    /** VARCHAR(80) NOT NULL */
    private string $table_name;
    
    /** JSON NOT NULL - can be string (JSON) or array (decoded) */
    private array $row_ids;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP */
    private string $performed_at;
    
    /** TEXT NULL */
    private ?string $details = null;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_log = (int)($data['id_log'] ?? 0);
            $this->operation = (string)($data['operation'] ?? '');
            $this->table_name = (string)($data['table_name'] ?? '');
            $this->row_ids = isset($data['row_ids']) ? (is_string($data['row_ids']) ? json_decode($data['row_ids'], true) : $data['row_ids']) : [];
            $this->performed_at = (string)($data['performed_at'] ?? date('Y-m-d H:i:s'));
            $this->details = isset($data['details']) ? (string)$data['details'] : null;
        }
    }

    public function getId()
    {
        return $this->id_log;
    }
    public function setId($id)
    {
        $this->id_log = $id;
        return $this;
    }

    public function getOperation()
    {
        return $this->operation;
    }
    public function setOperation($operation)
    {
        $this->operation = $operation;
        return $this;
    }

    public function getTableName()
    {
        return $this->table_name;
    }
    public function setTableName($table_name)
    {
        $this->table_name = $table_name;
        return $this;
    }

    public function getRowIds()
    {
        return $this->row_ids;
    }
    public function setRowIds($row_ids)
    {
        if (is_string($row_ids)) {
            $this->row_ids = json_decode($row_ids, true);
        } else {
            $this->row_ids = $row_ids;
        }
        return $this;
    }

    public function getPerformedAt()
    {
        return $this->performed_at;
    }
    public function setPerformedAt($performed_at)
    {
        $this->performed_at = $performed_at;
        return $this;
    }

    public function getDetails()
    {
        return $this->details;
    }
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }
}