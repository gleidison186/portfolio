<?php
  require "force_authenticate.php";
  require "db_functions.php";
  require "db_credentials.php";
  $altemail = false;
  $erro = false;
  $sucess = false;
  $conn = connect_db();


  $id = $_SESSION["user_id"];
  $emailsql = "SELECT email FROM $table_users WHERE id=" . $id;
  if(!mysqli_query($conn,$emailsql)){
    die("erro no banco de dados" . mysqli_error($conn));
  }
  $emailres = (mysqli_fetch_assoc($result = mysqli_query($conn,$emailsql)));


  if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['email']) && isset($_POST['conemail']) && isset($_POST['senha'])){
      if(!filter_var($_POST["email"], FILTER_SANITIZE_EMAIL)){
        $erro_email = "Email invalido";
        $erro = true;
        $sucess = false;
      }else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $erro_email = "Email invalido";
        $erro = true;
        $sucess = false;
      }else if($_POST['email'] == $_POST['conemail']){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $conemail = mysqli_real_escape_string($conn, $_POST['conemail']);
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);
        $senha = md5($senha);
        $sql = "SELECT email FROM $table_users WHERE email = '$email'";
        $result = mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) > 0){
          $erro_email = "Email já cadastrado";
          $erro = true;
          $sucess = false;
        }else{
          $id = $_SESSION["user_id"];
          $sql = "SELECT password FROM $table_users WHERE id=" . $id;
          if(!mysqli_query($conn,$sql)){
            die("erro no banco de dados" . mysqli_error($conn));
          }
          $result = mysqli_query($conn,$sql);
          $user = mysqli_fetch_assoc($result);
          $senhasql = $user['password'];
          if($senha == $senhasql){
            $sql = "UPDATE $table_users SET email = '$email' WHERE id =" . $id;
            if(!mysqli_query($conn,$sql)){
              die("erro ao inserir dados" . mysqli_error($conn));
            }
            $sucess = true;
            echo '<!DOCTYPE html>';
            echo '<html xmlns="http://www.w3.org/1999/xhtml">';
            echo '<head>';
            echo '   <meta http-equiv="refresh" content="0; url=logout.php">';
            echo '</head>';
            echo '<body>';
            echo '<a href="logout.php"></a>';
            echo "<script type='text/javascript'>alert('Email Alterado!')</script>";
            echo "<script type='text/javascript'>alert('Por Favor Entre Novamente!!')</script>";
            echo '</body>';
            echo '</html>';
          }else{
            $erro_email = "senha incorreta";
            $erro = true;
            $sucess = false;
          }
        }
      }else{
        $erro_email = "Endereços de email não se correspondem";
        $erro = true;
        $sucess = false;
      }
    }
  }
  mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Pagina</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body background="imagens/fundo.jpg">
    <div class="container">
      <?php if ($login): ?>
      <img src="imagens/logo.png" class="logo">
      <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse bg-dark">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
              </ul>
              <form class="form-inline my-2 my-md-0">
                <div class="navbar-collapse collapse">
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="configconta.php">Configurações de Conta</a></li>
                    <li><a href="logout.php">Sair</a></li>
                  </ul>
                </div>
              </form>
            </div>
        </div>
      </nav>
      <div class="content rounded" id="configura">
        <h2>Alterar Email</h2>
        <p>Este é seu Email Atual: <?php echo $emailres['email']; ?></p>
          <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php if($erro){
              echo $erro_email . "<br><br>";
            }
            ?>
            <strong>Novo Email</strong>
            <input name="email" type="email"><br><br>
            <strong>Confirmar Email</strong>
            <input name="conemail" autocomplete="off" type="text"><br><br>
            <strong>Digite sua Senha</strong>
            <input name="senha" type="password"><br><br>
            <input type="submit" value="Confirmar"><br>
          </form>
          <br><button><a href="configconta.php">Voltar</a></button>
      </div>
      <?php else: ?>
        <div class="container">
          <div class="box">
            <ul>
              <li><a href="login.php">Entrar</a></li>
              <li><a href="register.php">Registrar</a></li>
            </ul>
          </div>
        </div>
      <?php endif; ?>
    </ul>
  </div>
</body>
</html>
