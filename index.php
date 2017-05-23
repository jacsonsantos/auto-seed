<?php
function debug($valor) {
    var_dump($valor);die;
}
function verify($array, $key) {
    $string = implode($array);
    return strpos($string,$key);
}

require __DIR__.'/connection.php';
require __DIR__.'/entity/biblioteca.php';
require __DIR__.'/vendor/Faker-master/src/autoload.php';
require __DIR__.'/vendor/autoload.php';

use JSantos\Map\Database;
use Faker\Factory;

$database = new Database($pdo);
$mapBase = $database->mapAll();

$faker = Factory::create();

$data = [];
$value = '';

function insert(array $data = array(),$table, $pdo)
{
    foreach($data as $key => $value) {
        $fields[] = $key;
        $bind[]   = ':' . $key;
    }
    $fields = implode(', ', $fields);
    $bind   = implode(', ', $bind);
    $sql = "INSERT INTO " . $table . "(" . $fields . ") 
	              	    VALUES(" . $bind . ")";
    echo $sql."<br>";

    try{
        $pdo->beginTransaction();

        $insert = $pdo->prepare($sql);
        foreach($data as $key => $value) {

            $insert->bindValue(":" . $key, $value, !is_int($value)? \PDO::PARAM_STR : \PDO::PARAM_INT);
        }
        if($insert->execute()) {
            echo "inserido com sucesso!<br>";
            $pdo->commit();
        }
        return false;
    } catch(\PDOexception $e) {
        echo 'Error to insert data in database'."<br>";
        $pdo->rollBack();
    }
}
$i = 1;

    foreach ($mapBase as $table => $val) {
        while ( $i < $_GET['n']) {
            foreach ($mapBase[$table] as $column) {
            $nameColumn = $column['column'];
            $type = strtolower($column['type']);
            if ($type == 'int') {
                if (verify($numero, $nameColumn)) {
                    $value = (int)$faker->randomNumber(4);
                }
                if (verify($idades, $nameColumn)) {
                    $value = (int)rand(1, 50);
                }
                if (verify($ano, $nameColumn)) {
                    $value = $faker->date('Y');
                }
            }
            if ($type == 'float' || $type == 'real') {
                if (verify($dinheiro, $nameColumn)) {
                    $value = (float)number_format($faker->randomNumber(2), 2, ',', '.');
                }
            }
            if ($type == 'varchar') {
                if (verify($nomes, $nameColumn)) {
                    $value = $faker->name;
                }
                if (verify($endereço, $nameColumn)) {
                    $value = $faker->address;
                }
                if (verify($estado, $nameColumn)) {
                    $value = $faker->city;
                }
                if (verify($username, $nameColumn)) {
                    $value = $faker->userName;
                }
                if ($nameColumn == 'email') {
                    $value = $faker->freeEmail;
                }
                if (verify($email, $nameColumn)) {
                    $value = $faker->name . '@gmail.com';
                }
                if (verify($cidade, $nameColumn)) {
                    $value = $faker->city;
                }
            }
            if ($type == 'text') {
                if (verify($descricao, $nameColumn)) {
                    $value = $faker->text;
                }
            }
            if ($type == 'date' || $type == 'datetime' || $type == 'timezone') {
                $value = $faker->date();
            }

            $data[$nameColumn] = $value;
            $value = '';
            sleep(1);
        }
            insert($data, $table, $pdo);
            $data = [];
            $i++;
        }
    }