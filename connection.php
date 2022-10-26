<?php

$config = [
  "host" => "localhost",
  "username" => "root",
  "password" => "2004",
  "database" => "pix_project_db",
];

try {
  $mysqli = new mysqli($config["host"], $config["username"], $config["password"], $config["database"]);
} catch(Exception $e) {
  die('Something went wrong: '. $e->getMessage());
  echo $e->getMessage();
}

if(mysqli_connect_errno()) {
  printf("Connection error: %s\n", mysqli_connect_error());
  exit();
}

?>