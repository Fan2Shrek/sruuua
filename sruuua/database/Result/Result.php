<?php

namespace Sruuua\Database\Result;

use Sruuua\Database\Result\Interface\ResultInterface;
use \PDO;
use \PDOStatement;

final class Result implements ResultInterface
{
    private PDOStatement $statement;

    private function fetch(int $fetchMode)
    {
        return $this->statement->fetch($fetchMode);
    }

    private function fetchAll(int $fetchMode)
    {
        return $this->statement->fetchAll($fetchMode);
    }

    public function __construct(PDOStatement $state)
    {
        $this->statement = $state;
    }

    public function fetchAssociative()
    {
        return $this->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchNumeric()
    {
        return $this->fetch(PDO::FETCH_NUM);
    }

    public function fetchAllAssociative()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllNumeric()
    {
        return $this->fetchAll(PDO::FETCH_NUM);
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }
}
