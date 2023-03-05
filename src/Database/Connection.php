<?php

namespace App\Database;

use App\Kernel;
use PDO;
use PDOException;

class Connection
{
    private string $dbHost;
    private string $dbName;
    private string $dbUsername;
    private string $dbUserpassword;
    private int $port;
    private ?PDO $connection = null;

    public function __construct(Kernel $kernel)
    {
        $ctx = $kernel->getEnv();
        $this->dbHost = $ctx['DB_HOST'];
        $this->dbName = $ctx['DB_NAME'];
        $this->dbUsername = $ctx['DB_USER'];
        $this->dbUserpassword = $ctx['DB_PASSWORD'];
        $this->port = $ctx['DB_PORT'];
    }

    public function connect()
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    dsn: "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName . ";port=" . $this->port,
                    username: $this->dbUsername,
                    password: $this->dbUserpassword
                );
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return $this->connection;
    }

    public function disconnect()
    {
        $this->connection = null;
    }
}
