<?php
  require "check_form.php";
  require "authenticate.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cadastro</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="check_register.js"></script>
</head>
<body>
  <?php if ($login):?>
    <h3>Você precisa sair da sua conta para registrar</h3>
    <a href="logout.php">Sair</a><br>
    <a href="index.php">Página Inicial</a>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header">Cadastrar-se</h1>

      <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <?php if (!$erro): ?>
          <div class="alert alert-success">
            Dados recebidos com sucesso:
            <ul>
              <li><strong>Nome</strong>: <?php echo $nome ?>;</li>
              <li><strong>Email</strong>: <?php echo $email ?>;</li>
              <?php // limpa o formulário.
                $nome = "";
                $email = "";
                $senha = "";
              ?>
            </ul>
          </div>
        <?php else: ?>
          <div class="alert alert-danger">
            Erros no formulário.
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <form enctype="multipart/form-data" id="form-test" class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="form-group">
          <label for="inputNome" class="col-sm-2 control-label">Nome</label>
          <div class="col-sm-10 form-group <?php if(!empty($erro_nome)){echo "has-error";}?>">
            <input required type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $nome; ?>">
            <div id="erro-nome">

            </div>
            <?php if (!empty($erro_nome)): ?>
              <span class="help-block"><?php echo $erro_nome ?></span>
            <?php endIf; ?>
          </div><br>


          <label for="inputEmail" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10 form-group <?php if (!empty($erro_email)) {echo "has-error";}?>">
            <input required type="email" class="form-control" name="email" placeholder="exemplo@hotmail.com" value="<?php echo $email; ?>">
            <div id="erro-email">

            </div>
            <?php if (!empty($erro_email)): ?>
              <span class="help-block"><?php echo $erro_email ?></span>
            <?php endIf; ?>
        </div><br>


        <label for="inputSenha" class="col-sm-2 control-label">Senha</label>
        <div class="col-sm-10 form-group <?php if (!empty($erro_senha)){echo "has-error";}?>">
          <input required type="password" maxlength="8" class="form-control" name="senha" placeholder="Senha">
          <div id="erro-senha">

          </div>
          <?php if (!empty($erro_senha)): ?>
            <span class="help-block"><?php echo $erro_senha ?></span>
            <?php endIf; ?>
          </div><br>


          <label for="inputConSenha" class="col-sm-2 control-label">Confirme a Senha</label>
          <div class="col-sm-10 form-group <?php if (!empty($erro_consenha)){echo "has-error";}?>">
            <input required type="password" maxlength="8" class="form-control" name="consenha" placeholder="Confirmar Senha" >
            <div id="erro-consenha">
            </div>
            <?php if (!empty($erro_consenha)): ?>
              <span class="help-block"><?php echo $erro_consenha ?></span>
              <?php endIf; ?>
            </div><br>

            <label for="inputImg" class="col-sm-2 control-label">Selecione a Imagem</label>
            <div class="col-sm-10 form-group <?php if (!empty($erro_img)){echo "has-error";}?>">

              <input type="file" class="form-control" name="imagem" accept="image/png,image/jpeg">
              <div id="erro-img">
              </div>
              <?php if (!empty($erro_img)): ?>
                <span class="help-block"><?php echo $erro_img ?></span>
                <?php endIf; ?>

            </div><br>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Enviar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<p>Já tem uma conta? <a href="login.php">Clique aqui</a> para entrar</p>
</body>
</html>
