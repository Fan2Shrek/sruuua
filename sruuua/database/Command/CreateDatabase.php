<?php

namespace Sruuua\Database\Command;

use Sruuua\Database\Connection;
use Sruuua\Database\Database\Column;
use Sruuua\Database\Database\Database;
use Sruuua\Database\Database\Table;
use Sruuua\DependencyInjection\Container;

class CreateDatabase extends \Sruuua\Application\Command
{

    protected string $call = 'create-dtb';

    protected string $description = 'Create the database from config files';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke()
    {
        $data = $this->parseTableFile();

        $database = new Database();

        foreach ($data as $tableName => $columns) {
            $currentTable = new Table($tableName);
            foreach ($columns as $columnName => $column) {
                $nullable = str_contains($column, '?');
                $column = str_replace('?', '', $column);
                $primary = str_contains($column, 'primary');
                $column = str_replace('primary', '', $column);

                $currentColumn = new Column($columnName, trim($column), $nullable, $primary);

                $currentTable->addColumn($currentColumn);
            }

            $database->addTable($currentTable);
        }

        // exit($database->generateSQL());
        $req = $this->connection->prepare($database->generateSQL());
        $req->execute();
    }

    public function parseTableFile(): array
    {
        $content = file_get_contents(getcwd() . '/config/table.sr');
        $lines = explode("\n", $content);
        $data = [];
        $currentKey = '';

        foreach ($lines as $line) {
            $trim = ltrim($line);
            $isIdent = (strlen($trim) < strlen($line));

            if ($trim === "") continue;

            # Name
            if (!$isIdent) {
                $currentKey = $trim;
                $data[$currentKey] = [];
            } else {
                # is column
                $infos = explode('->', $trim);

                $data[$currentKey][trim($infos[0])] = ltrim($infos[1]);
            }
        }

        return $data;
    }
}
