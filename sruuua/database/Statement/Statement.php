<?php

namespace Sruuua\Database\Statement;

use Sruuua\Database\Result\Result;
use Sruuua\Database\Statement\Interface\StatementInterface;
use \PDO;
use \PDOStatement;

class Statement implements StatementInterface
{
    private PDOStatement $statement;

    public function __construct(PDOStatement $state)
    {
        $this->statement = $state;
    }

    public function bindValue(int|string $param, mixed $value, int $type = PDO::PARAM_STR): bool
    {
        return $this->statement->bindValue($param, $value, $type);
    }

    public function bindParam(int|string $param, mixed &$var, int $type = PDO::PARAM_STR, int $maxLength = null, mixed $driverOptions = null): bool
    {
        return $this->statement->bindParam($param, $var, $type, $maxLength, $driverOptions);
    }

    public function execute(array|null $params = null): Result
    {
        $this->statement->execute($params);

        return new Result($this->statement);
    }
}
