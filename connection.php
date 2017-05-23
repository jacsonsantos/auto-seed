<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 23/05/2017
 * Time: 17:40
 */
$config = json_decode(file_get_contents('config.json'));
$dsn = $config->driver.':host='.$config->host.';dbname='.$config->database.';port='.$config->port;
try {
    $pdo = new \PDO($dsn, $config->user, $config->password);
} catch (\PDOException $e) {
    echo $e->getMessage();die;
}