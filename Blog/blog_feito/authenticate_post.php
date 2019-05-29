<?php
  require_once "db_functions.php";
  $conn = connect_db();

  if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["titulo"]) && (isset($_GET["acao"]))){
      $titulo = $_GET["titulo"];
      $sql = "SELECT * FROM posts WHERE titulo = '$titulo';";
      $result = mysqli_query($conn, $sql);
      if($result){
        if(mysqli_num_rows($result)){
          $titulo_post = mysqli_fetch_assoc($result);
          $caracteres = strlen($titulo_post['texto']);
          $success = true;
        }
      }else{
        $success = false;
      }
    }else{
      $success = false;
    }
  }
?>
