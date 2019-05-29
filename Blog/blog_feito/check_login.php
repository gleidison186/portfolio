<?php
require "db_functions.php";
require "authenticate.php";


function verifica_campo($texto){
  $texto = trim($texto);
  $texto = stripslashes($texto);
  $texto = htmlspecialchars($texto);
  return $texto;
}
$email = "";
$senha = "";
$erro = false;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty($_POST["email"])){
    $erro_email = "Email é obrigatório.";
    $erro = true;
  }else if (!filter_var($_POST["email"], FILTER_SANITIZE_EMAIL)){
    $erro_email = "Email inválido.";
    $erro = true;
  }else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $erro_email = "Email inválido.";
    $erro = true;
  }
  else{
    $email = verifica_campo($_POST["email"]);
  }
  if(empty($_POST["senha"])){
    $erro_senha = "Senha é obrigatória.";
    $erro= true;
}
else{
  $senha = verifica_campo($_POST["senha"]);
}
if(!$erro){
  $conn = connect_db();
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }else{
      $email = mysqli_real_escape_string($conn,$email);
      $senha = mysqli_real_escape_string($conn,$senha);
      $senha = md5($senha);
      $email_sql = "SELECT id,name,email,password FROM $table_users WHERE email = '$email'";
      $result = mysqli_query($conn, $email_sql);
      if (mysqli_num_rows($result) <= 0){
        $erro = true;
      }else{
        $user = mysqli_fetch_assoc($result);
        if(strcmp($senha,$user["password"])!= 0){
          $erro = true;
        }else{
          $_SESSION["user_id"] = $user["id"];
          $_SESSION["user_name"] = $user["name"];
          $_SESSION["user_email"] = $user["email"];
          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
          exit();
        }
      }
    mysqli_close($conn);
    }
}
}
?>
