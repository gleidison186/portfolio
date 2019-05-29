<?php
  session_start();

  session_unset();

  session_destroy();
  if($_SERVER['REQUEST_METHOD'] == "GET"){
    if($_GET['acao'] == "login"){
      header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
    }
  }
  header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");

?>
