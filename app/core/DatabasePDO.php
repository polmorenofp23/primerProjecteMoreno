<?php

// Class of the database PHP Data Object, that allow us to connetct and close connection with DB that will use the DAO models to obtain the data.
class DatabasePDO{
    // Variables that contain the connection data
    private $host = 'localhost';
    private $dbname = 'bees_cavern_db';
    private $user = 'root';
    private $password = 'Asdqwe!23';

    private $conn = null;

    public function __construct()
    {
        $dsn = "mysql:host".$this->host . ";dbname=".$this->dbname . ";charset=utf8mb4";

        try {
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            var_dump('Connection with database ' . $this->dbname . ' has been succesfully!');
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * realise the connection to the database
     */
    public function connect() : PDO {
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