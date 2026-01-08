<?php

// Class of the database PHP Data Object, that allow us to connetct and close connection with DB that will use the DAO models to obtain the data.
class DatabasePDO{
    // Variables that contain the connection data 
    private $host;                  // 'localhost'
    private $dbname;                // 'bees_cavern_db'
    private $user;                  // 'polmq'
    private $password;              // 'Asdqwe!23'

    private $conn = null;

    public function __construct()
    {
        // IMPORTANT: same variables values that contains the docker-compose.yml
        $this->host     = getenv('DB_HOST')     ?: 'db';              // service name in docker-compose 
        $this->dbname   = getenv('DB_NAME')     ?: 'bees_cavern_db';
        $this->user     = getenv('DB_USER')     ?: 'polmq';
        $this->password = getenv('DB_PASSWORD') ?: 'Asdqwe!23';

        $this->initializeConnection();
    }

    /**
     * Internal helper to create the PDO connection and set attributes.
     * Throws exception on failure; never returns null when connect() expects PDO.
     */
    private function initializeConnection(): void
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4";
        if ($this->conn == null) {
            try {
                $pdo = new PDO($dsn, $this->user, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->conn = $pdo;
            } catch (PDOException $e) {
                error_log('DB connection failed: ' . $e->getMessage());
                if (!headers_sent()) {
                    $msg = urlencode('Error connecting with the DB: ' . $e->getMessage());
                    header('Location: ?controller=Error&action=show&code=500&message=' . $msg);
                    exit;
                }
                throw $e;
            }
        }
    }

    /**
     * realise the connection to the database
     */
    public function connect() : PDO {
        if (!($this->conn instanceof PDO)) {    // Lazy (re)connect: if previously disconnected, recreate the PDO instance
            $this->initializeConnection();
        }
        return $this->conn;
    }

    /**
     * close the connection to the database
     */
    public function disconnect() : void {
        if ($this->conn != null) {
            $this->conn = null;
        }
    }
}