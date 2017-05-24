<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 23/05/17
 * Time: 23:32
 */
namespace JSantos\Auto;

use Faker\Generator;
use JSantos\Lib\LibTrait;
use JSantos\Map\Database;

class Seed
{
    protected $connection;

    protected $faker;

    protected $database;

    protected $table = '';

    protected $data = [];

    use LibTrait;

    public function __construct(\PDO $connection, Generator $faker)
    {
        $this->connection = $connection;
        $this->faker = $faker;
    }

    public function insert(array $data = array())
    {
        foreach($data as $key => $value) {
            $fields[] = $key;
            $bind[]   = ':' . $key;
        }
        $fields = implode(', ', $fields);
        $bind   = implode(', ', $bind);
        $sql = "INSERT INTO " . $this->table . "(" . $fields . ")VALUES(" . $bind . ")";

        try{
            $this->connection->beginTransaction();

            $insert = $this->connection->prepare($sql);
            foreach($data as $key => $value) {

                $insert->bindValue(":" . $key, $value, !is_int($value)? \PDO::PARAM_STR : \PDO::PARAM_INT);
            }
            if($insert->execute()) {
                echo "inserido com sucesso!\n";
                $this->connection->commit();
            }
            return false;
        } catch(\PDOexception $e) {
            echo "Error to insert data in database\n";
            $this->connection->rollBack();
        }
    }

    public function setMapDatabase(Database $database)
    {
        $this->database = $database;
        return $this;
    }

    public function generator()
    {
        $value = '';
        $mapBase = $this->database->mapAll();
        foreach ($mapBase as $table => $val) {
            foreach ($mapBase[$table] as $column) {
                $nameColumn = $column['column'];
                $type = strtolower($column['type']);
                if ($type == 'int') {
                    $value = $value = (int)rand(1, 50);
                    if ($this->verify($this->id, $nameColumn)) {
                        $value = (int) $this->faker->randomNumber(2);
                    }
                    if ($this->verify($this->numero, $nameColumn)) {
                        $value = (int) $this->faker->randomNumber(4);
                    }
                    if ($this->verify($this->idades, $nameColumn)) {
                        $value = (int)rand(1, 50);
                    }
                    if ($this->verify($this->ano, $nameColumn)) {
                        $value = $this->faker->date('Y');
                    }
                }
                if ($type == 'float' || $type == 'real') {
                    $value = 0.00;
                    if ($this->verify($this->dinheiro, $nameColumn)) {
                        $value = (float)number_format($this->faker->randomNumber(2), 2, ',', '.');
                    }
                }
                if ($type == 'varchar') {
                    $value = 'Sem Informacao';
                    if ($this->verify($this->nomes, $nameColumn)) {
                        $value = $this->faker->name;
                    }
                    if ($this->verify($this->endereço, $nameColumn)) {
                        $value = $this->faker->address;
                    }
                    if ($this->verify($this->estado, $nameColumn)) {
                        $value = $this->faker->city;
                    }
                    if ($this->verify($this->username, $nameColumn)) {
                        $value = $this->faker->userName;
                    }
                    if ($nameColumn == 'email') {
                        $value = $this->faker->freeEmail;
                    }
                    if ($this->verify($this->email, $nameColumn)) {
                        $value = $this->faker->freeEmail;
                    }
                    if ($this->verify($this->cidade, $nameColumn)) {
                        $value = $this->faker->city;
                    }
                    if ($this->verify($this->imagem, $nameColumn)) {
                        $value = $this->faker->imageUrl();
                    }
                    if ($this->verify($this->senha, $nameColumn)) {
                        $value = $this->faker->password();
                    }
                }
                if ($type == 'text') {
                    $value = 'Sem Descricao de Texto';
                    if ($this->verify($this->descricao, $nameColumn)) {
                        $value = $this->faker->text;
                    }
                }
                if ($type == 'date') {
                    $value = $this->faker->date();
                }
                if ($type == 'datetime' || $type == 'timestamp') {
                    $value = $this->faker->date('Y-m-d h:m:i');
                }

                $this->data[$nameColumn] = $value;
                $value = '';
            }
            $this->insert($this->data);
            $this->data = [];
        }
    }

    private function verify($array, $key) {
        $string = implode($array);
        return strpos($string,$key);
    }
}