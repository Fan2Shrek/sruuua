<?php

namespace Sruuua\Database\Database;

class Table
{
    private string $name;

    /**
     * @var Column[]
     */
    private array $columns;

    public function __construct(string $name)
    {
        $this->name = strtolower($name);
        $this->columns = array();
    }

    public function hasColumn(string $name)
    {
        return in_array($name, $this->columns);
    }

    public function addColumn(Column $columns)
    {
        if (!$this->hasColumn($columns->getName())) {
            $this->columns[$columns->getName()] = $columns;
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
        $sql = "CREATE TABLE {$this->name} (";

        $columnDefinitions = array_map(function ($column) {
            return $column->generateSQL();
        }, $this->columns);

        $sql .= implode(',', $columnDefinitions);

        $sql .= ');';

        return $sql;
    }
}
