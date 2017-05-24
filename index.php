<?php
require __DIR__.'/connection.php';
require __DIR__.'/vendor/Faker-master/src/autoload.php';
require __DIR__.'/vendor/autoload.php';

use JSantos\Map\Database;
use Faker\Factory;
use JSantos\Auto\Seed;

$database = new Database($pdo);

$faker = Factory::create();

$autoseed = new Seed($pdo,Factory::create());
$autoseed->setMapDatabase($database);

$loop = isset($_GET['n']) ? $_GET['n'] : 10 ;

$i = 1;
while ( $i <= $loop) {
    $autoseed->generator();
    $i++;
}