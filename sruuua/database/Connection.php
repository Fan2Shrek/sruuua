<?php

namespace Sruuua\Database;

use \PDO;
use \PDOException;
use Sruuua\Database\Statement\Statement;

final class Connection
{
    private ?PDO $connection = null;

    private array $env = [];

    public function __construct()
    {
        $this->connect($_ENV);
    }

    public function connect(array $ctx)
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . $ctx['DB_HOST'] . ";dbname=" . $ctx['DB_NAME'] . ";port=" . $ctx['DB_PORT'],
                $ctx['DB_USER'],
                $ctx['DB_PASSWORD'],
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function prepare(string $req): Statement
    {
        return new Statement($this->connection->prepare($req));
    }

    /**
     * Return the PDO of connection
     */
    public function getConnection(): ?PDO
    {
        return $this->connection;
    }

    /**
     * Close the connection to database
     */
    public function disconnect(): self
    {
        $this->connection = null;

        return $this;
    }

    public function __serialize(): array
    {
        return ['env' => $_ENV];
    }

    public function __wakeup()
    {
        $this->connect($this->env);
    }
}
