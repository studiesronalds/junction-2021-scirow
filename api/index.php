<?php

header('Access-Control-Allow-Origin: *'); 

//init and define and setup
$output = ['status' => "Balozhi ir skudras"];

// in bitami this is located at `/opt/bitnami/apache2/config.php`
require_once('../config.php');

spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . '.php';
});

use Helpers\DatabaseHelper;

try {
  $conn = new PDO("mysql:host=$servername;dbname=dbmaster", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  DatabaseHelper::init($conn);

  $output['db'] = "Connected successfully"; 
} catch(PDOException $e) {
  $output['db'] = "Connection failed: " . $e->getMessage();
}

//processing
use Helpers\RouterHelper;

$output = array_merge($output, RouterHelper::balodis($_REQUEST, $_SERVER['REQUEST_METHOD']));

//output
die(json_encode($output));