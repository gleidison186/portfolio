<?php
  require "force_authenticate.php";
  require "db_functions.php";
  require "db_credentials.php";
  $erro = false;
  $sucess = false;
  $conn = connect_db();



  if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['senha']) && isset($_POST['nosenha']) && isset($_POST['consenha'])){
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);
        $nosenha = mysqli_real_escape_string($conn, $_POST['nosenha']);
        $consenha = mysqli_real_escape_string($conn, $_POST['consenha']);
        $id = $_SESSION["user_id"];
        $senha = md5($senha);
        $sql = "SELECT password FROM $table_users WHERE id=". $id;
        if(!mysqli_query($conn,$sql)){
          die("erro no banco de dados" . mysqli_error($conn));
        }
        $result = mysqli_query($conn,$sql);
        $user = mysqli_fetch_assoc($result);
        if($senha == $user['password']){
          if($nosenha == $consenha){
            $nosenha = md5($nosenha);
            $sql = "UPDATE $table_users SET password = '$nosenha' WHERE id =" . $id;
            if(!mysqli_query($conn,$sql)){
              die("erro ao inserir dados" . mysqli_error($conn));
            }
            $sucess = true;
          /*  echo "<script type='text/javascript'>alert('Email Alterado');</script>";
            echo "<script type='javascript'>alert('Email enviado com Sucesso!');";
            echo "javascript:window.location='index.php';</script>";*/
            echo '<!DOCTYPE html>';
            echo '<html xmlns="http://www.w3.org/1999/xhtml">';
            echo '<head>';
            echo '   <meta http-equiv="refresh" content="0; url=logout.php">';
            echo '</head>';
            echo '<body>';
            echo '<a href="logout.php"></a>';
            echo "<script type='text/javascript'>alert('Senha Alterada!')</script>";
            echo "<script type='text/javascript'>alert('Por Favor Entre Novamente!')</script>";
            echo '</body>';
            echo '</html>';
          }else{
            $erro_senha = "senhas não se correspondem";
            $erro = true;
            $sucess = false;
          }
        }else{
          $erro_senha = "senha atual incorreta";
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
      <h2>Alterar Senha</h2>
      <hr>
        <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <?php if($erro){
            echo $erro_senha . "<br><br>";
          }
          ?>
          <strong>Digite sua Senha Atual</strong>
          <input name="senha" type="password"><br><br>
          <strong>Nova Senha</strong>
          <input name="nosenha" type="password"><br><br>
          <strong>Confirme a Senha</strong>
          <input name="consenha" type="password"><br><br>
          <input type="submit" value="Confirmar"><br>
        </form>
        <br><button type="button"><a href="configconta.php">Voltar</a></button>
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
