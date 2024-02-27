<?php

namespace Sruuua\Database\Statement\Interface;

use Sruuua\Database\Result\Result;

interface StatementInterface
{
    public function bindValue(string|int $param, mixed $value, int $type = \PDO::PARAM_STR): bool;

    public function bindParam(string|int $param, mixed &$var, int $type = \PDO::PARAM_STR, int $maxLength = null, mixed $driverOptions = null): bool;

    public function execute(array $param = null): Result;
}
