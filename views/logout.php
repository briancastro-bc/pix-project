<?php 

// session_start();

if(empty($_SESSION['user'])) {
  header('Location: /signin');
  exit();
}

session_destroy();

header('Location: /signin');