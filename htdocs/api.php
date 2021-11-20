<?php
//init and define and setup
$output = ['status' => "Balozhi ir skudras"];

require_once('../config.php');

try {
  $conn = new PDO("mysql:host=$servername;dbname=dbmaster", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $output['db'] = "Connected successfully"; 
} catch(PDOException $e) {
  $output['db'] = "Connection failed: " . $e->getMessage();
}

//processing



//output
die(json_encode($output));