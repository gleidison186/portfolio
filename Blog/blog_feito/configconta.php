<?php
  require "force_authenticate.php";
  require "db_credentials.php";
  require "imagem.php";
  $conn = connect_db();
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
  </head>
  <body background="imagens/fundo.jpg">
    <img src="imagens/logo.png" class="logo">
    <div class="container">
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
        <h2>Configurações de Conta</h2>
        <hr>
        <div style="font-size: 30px;">
          <p> Nome: <?php echo $user_name; ?> </p>
          <p> Email: <?php echo $user_email; ?> </p>
          <img style="max-width: 40%; height: auto;" src="<?= $imagem ?>"/>
        </div>
        <hr>
        <ul id="listas">
          <li><a href="altemail.php">Alterar Email</a></li>
          <li><a href="altsenha.php">Alterar Senha</a></li>
          <br><a href="index.php">Voltar</a>
        </ul>
      </div>
  </div>
  </body>
</html>
