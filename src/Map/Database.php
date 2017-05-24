<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 23/05/2017
 * Time: 16:49
 */
namespace JSantos\Map;

class Database
{
    protected $connection;

    protected $tables = [];

    protected $columns = [];

    protected $all = [];

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
        $this->database = $this->getDataBase();
    }

    public function getDataBase()
    {
        return $this->connection->query('SELECT database()')->fetchColumn();
    }

    public function mapTables()
    {
        $prepare = $this->connection->prepare('SHOW TABLES');
        $prepare->execute();
        $this->tables = $prepare->fetchAll(\PDO::FETCH_ASSOC);
        return $this;
    }

    public function getTables()
    {
        return $this->tables;
    }

    public function mapColumns($tables = [])
    {
        if (!empty($tables)) {
            $this->tables = $tables;
        }
        foreach ($this->tables as $table) {
            $prepare = $this->connection->prepare('SHOW COLUMNS FROM '.$table['Tables_in_'.$this->database]);
            $prepare->execute();
            $this->columns[!empty($tables) ? $table : $table['Tables_in_'.$this->database]] = $prepare->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function mapAll()
    {
        $this->mapTables()->mapColumns();
        foreach ($this->tables as $table) {
            $nameTable = $table['Tables_in_'.$this->database];
            foreach ($this->columns[$nameTable] as $column) {
                $prepare = $this->connection->prepare('SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table AND COLUMN_NAME = :column');
                $prepare->bindValue(':table',$nameTable,\PDO::PARAM_STR);
                $prepare->bindValue(':column',$column['Field'],\PDO::PARAM_STR);
                $prepare->execute();
                $type = $prepare->fetch(\PDO::FETCH_ASSOC);
                $this->all[$nameTable][] = ['column' => $column['Field'], 'type' => $type['DATA_TYPE']];
            }
        }
        return $this->all;
    }
}