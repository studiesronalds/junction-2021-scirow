<?php
//init and define and setup
$output = ['status' => "Balozhi ir skudras"];

// in bitami this is located at `/opt/bitnami/apache2/config.php`
require_once('../config.php');

try {
  $conn = new PDO("mysql:host=$servername;dbname=dbmaster", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $output['db'] = "Connected successfully"; 
} catch(PDOException $e) {
  $output['db'] = "Connection failed: " . $e->getMessage();
}

spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . '.php';
});

//processing
use Helpers\RouterHelper;

$output = array_merge($output, RouterHelper::balodis($_REQUEST));

//output
die(json_encode($output));