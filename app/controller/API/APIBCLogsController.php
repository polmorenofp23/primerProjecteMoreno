<?php

require_once DAO_PATH . 'BCLogsDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';

class APIBCLogsController
{
    /**
     * Get all logs from the database (can filter by table_name)
     */
    // GET /?controller=api&resource=BCLogs
    public function index()
    {
        $logsDao = new BCLogsDAO();
        $logs = [];

        if (isset($_GET['table_name']) && $_GET['table_name'] !== '') {
            $tableName = trim($_GET['table_name']);
            $logs = $logsDao->getAllLogsByTableName($tableName);
        } else {
            $logs = $logsDao->getAllLogs();
        }

        JsonUtils::jsonResponse(JsonUtils::serializeArray($logs, 'serializeBCLogs', $this));
    }

    /**
     * Get a single log by ID
     */
    // GET /?controller=api&resource=BCLogs&id=123
    public function show($id)
    {
        $logsDao = new BCLogsDAO();
        $log = $logsDao->getLogById((int)$id);

        if (!$log) {
            return JsonUtils::jsonError('Log not found', ['data' => null], 404);
        }

        JsonUtils::jsonResponse(JsonUtils::serializeItem($log, 'serializeBCLogs', $this));
    }

    /**
     * Serialize a BCLogs object to an array
     */
    public function serializeBCLogs($log)
    {
        return [
            'id' => $log->getId(),
            'operation' => $log->getOperation(),
            'table_name' => $log->getTableName(),
            'row_ids' => $log->getRowIds(),
            'performed_at' => $log->getPerformedAt(),
            'details' => $log->getDetails()
        ];
    }
}
