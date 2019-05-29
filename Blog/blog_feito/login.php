<?php
  require("check_login.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
  <?php if ($login):?>
    <h3>Você já está logado</h3>
    <a href="index.php">Página Inicial</a>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="page-header">Login</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
          <?php if (!$erro): ?>
            <div class="alert alert-success">
              Dados recebidos com sucesso:
              <ul>
                <li><strong>Email</strong>: <?php echo $email ?>;</li>
                <?php // limpa o formulário.
                  $email = "";
                  $senha = "";
                ?>
              </ul>
            </div>
          <?php else: ?>
            <div class="alert alert-danger">
              Email ou Senha Incorretos.
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <form enctype="multipart/form-data" id="form-test" class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4 form-group">
              <input required type="email" class="form-control" name="email" placeholder="exemplo@hotmail.com" value="<?php echo $email; ?>">
              <div id="erro-email">

              </div>
          </div>
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-12 form-group"></div>


          <label for="inputSenha" class="col-sm-2 control-label">Senha</label>
          <div class="col-sm-2 form-group">
            <input required type="password" maxlength="8" class="form-control" name="senha" placeholder="Senha">
            <div id="erro-senha">

            </div>
            </div><br>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <p>Não tem uma conta? <a href="register.php">Clique aqui</a> para se registrar</p>
  </body>
  </html>
