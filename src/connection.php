<?php

$config = array(
  "host" => "localhost",
  "username" => "root",
  "password" => "2004",
  "database" => "pix_project_db",
  "port" => 3306
);

$mysqli = new mysqli($config["host"], $config["username"], $config["password"], $config["database"], $config["port"]);

if(mysqli_connect_errno()) {
  printf("Connection error: %s\n", mysqli_connect_error());
  exit();
}