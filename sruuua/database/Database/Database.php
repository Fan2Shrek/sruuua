<?php

namespace Sruuua\Database\Database;

class Database
{
    private string $name;

    /**
     * @var Table[]
     */
    private array $tables;

    public function __construct()
    {
        $this->tables = array();
        $this->name = $_ENV['DB_NAME'];
    }

    public function hasTable(string $name)
    {
        return in_array($name, $this->tables);
    }

    public function addTable(Table $tables)
    {
        if (!$this->hasTable($tables->getName())) {
            $this->tables[$tables->getName()] = $tables;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function generateSQL(): string
    {
        $sql = '';
        foreach ($this->tables as $table) {
            $sql .= $table->generateSQL();
        }

        return $sql;
    }
}
