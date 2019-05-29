<?php
require "db_functions.php";
require "db_credentials.php";
define('MB', 1048576);

function verifica_campo($texto){
  $texto = trim($texto);
  $texto = stripslashes($texto);
  $texto = htmlspecialchars($texto);
  return $texto;
}
$email = "";
$nome = "";
$senha = "";
$img = "";
$erro = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["nome"])){
    $erro_nome = "Nome é obrigatório.";
    $erro = true;
  }else if (!preg_match("/^[a-zA-Z ]*$/",$_POST["nome"])){
    $erro_nome = "Somente letras são permitidas.";
    $erro = true;
  }
  else{
    $nome = verifica_campo($_POST["nome"]);
  }
  //==================================================================
  if(empty($_POST["email"])){
    $erro_email = "Email é obrigatório.";
    $erro = true;
  }else if (!filter_var($_POST["email"], FILTER_SANITIZE_EMAIL)){
    $erro_email = "Carácteres inválidos no email.";
    $erro = true;
  }else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $erro_email = "Email inválido.";
    $erro = true;
  }
  else{
    $email = verifica_campo($_POST["email"]);
  }
  //==================================================================
  if(empty($_POST["senha"])){
    $erro_senha = "Senha é obrigatória.";
    $erro= true;
  }else if(strlen($_POST["senha"])>8){
    $erro_senha = "A senha deve conter de 8 carácteres.";
    $erro = true;
  }
  else if (!preg_match("/^[a-z0-9]*$/",$_POST["senha"])){
    $erro_senha = "Senha deve ser composta somente por letras e números.";
    $erro = true;
  }
  else{
    $senha = verifica_campo($_POST["senha"]);
  }
  //=================================================================
  if(strcmp($_POST["consenha"],$senha)!=0){
    $erro_consenha = "Senhas não se correspondem.";
    $erro = true;
  }
  //=================================================================
  $uploaddir = '/var/www/html/trab_web/feito/blog_feito/imagens/';
  if(!preg_match("/^image\/(pjpeg|jpeg|png|)$/", $_FILES["imagem"]["type"])){
    $erro_img = "Extensão Inválida";
    $erro = true;
  }else
  if($_FILES['imagem']['size'] == 0){
    $erro_img = "Imagem Inválida";
    $erro = true;
  }else
  if($_FILES['imagem']['size'] >= 3 * MB ){
    $erro_img = "Imagem muito grande";
    $erro = true;
  }else{
    preg_match("/\.(png|jpg|jpeg){1}$/i", $_FILES["imagem"]["name"], $ext);
    $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
    $uploadfile = $uploaddir . $nome_imagem;
    $uploadbd = 'imagens/' . $nome_imagem;
    if(!move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile)){
      $erro_img = "Imagem inválida";
      $erro = true;
    }
  }
  //================================================================
  if(!$erro){
    $conn = connect_db();
    // Create connection
    //$conn = mysqli_connect($servername, $username, $password, $dbname);
    $nome = mysqli_real_escape_string($conn,$nome);
    $email = mysqli_real_escape_string($conn,$email);
    $senha = mysqli_real_escape_string($conn,$senha);
    $senha = md5($senha);

    $email_sql = "SELECT email FROM $table_users WHERE email = '$email'";
    $result = mysqli_query($conn,$email_sql);
    if (mysqli_num_rows($result) > 0){
      $erro_email = "Email já cadastrado";
      $erro = true;
    }else{
      $sql = "INSERT INTO $table_users (name, email, password, img)
      VALUES ('$nome', '$email', '$senha', '$uploadbd')";
      if(!mysqli_query($conn,$sql)){
        $erro = true;
      }
    }
    mysqli_close($conn);
  }
}
?>
