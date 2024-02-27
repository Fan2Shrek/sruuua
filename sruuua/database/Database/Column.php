<?php

namespace Sruuua\Database\Database;

use Sruuua\Database\Database\Exception\TypeNotSupported;

class Column
{
    private const TYPES = [
        'string' => 'VARCHAR(255)',
        'int' => 'INT',
        'bool' => 'boolean',
    ];

    private string $name;

    private string $type;

    private bool $canBeNull;

    private bool $isPrimary;

    public function __construct(string $name, string $type, bool $canBeNull = false, bool $isPrimary = false)
    {
        $this->name = $name;
        if (!in_array(strtolower($type), array_keys(self::TYPES))) throw new TypeNotSupported(sprintf('%s not supported (yet) sorry', $type));
        $this->type = $type;
        $this->canBeNull = $canBeNull;
        $this->isPrimary = $isPrimary;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function canBeNull(): bool
    {
        return $this->canBeNull;
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->isPrimary;
    }

    public function generateSql(): string
    {
        $type = self::TYPES[$this->getType()];
        $primary = !$this->isPrimary() ? '' : 'PRIMARY KEY';
        $nullable = !$this->canBeNull() ? '' : 'NOT NULL';

        return "{$this->name} {$type} {$primary} {$nullable}";
    }
}
