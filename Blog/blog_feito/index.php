<?php
require "authenticate.php";
//require "force_authenticate.php";
require "db_functions.php";
define('MB', 1048576);
$conn = connect_db();
$id = $_SESSION["user_id"];
  if(!$login){
    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
  }
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['comentario']) && $_POST['comentario'] != ""){
      $idpost = $_GET['id'];
      $comentario = mysqli_real_escape_string($conn, $_POST['comentario']);
      $sql = "INSERT INTO comentarios (idUserCom, idPost, texto) VALUES ('$id', '$idpost', '$comentario')";
      if(!mysqli_query($conn, $sql)){
        die("erro ao inserir dados<br>" . mysqli_error($conn));
      }
      header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php?id=" . $idpost . "&" . "acao=view");

    }else
    if(isset($_POST["post"]) && $_POST["post"] != "" && $_POST['title'] !=""){
      $postsql = mysqli_real_escape_string($conn, $_POST['post']);
      $titulo = mysqli_real_escape_string($conn, $_POST['title']);
      $uploadbd = "";
      if(isset($_FILES['imagem']['tmp_name'])){
        $uploaddir = '/var/www/html/trab_web/feito/blog_feito/imagens/';
        if(!preg_match("/^image\/(pjpeg|jpeg|png|)$/", $_FILES["imagem"]["type"])){
          $erro_vazio = "Imagem Inválida";
        }else
        if($_FILES['imagem']['size'] >= 3 * MB ){
          $erro_vazio = "Imagem muito grande";
        }else{
          preg_match("/\.(png|jpg|jpeg){1}$/i", $_FILES["imagem"]["name"], $ext);
          $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
          $uploadfile = $uploaddir . $nome_imagem;
          $uploadbd = 'imagens/' . $nome_imagem;
          if(!move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadfile)){
            $erro_vazio = "Imagem inválida";
          }
        }
      }
      $sql ="INSERT INTO posts (idUser,titulo,texto,imagem) VALUES ('$id','$titulo','$postsql','$uploadbd')";
      if(!mysqli_query($conn, $sql)){
        die("Erro ao inserir dados<br>" . mysqli_error($conn));
      }else{
        header("Refresh: 0");
      }
    }else{
      $erro_vazio = "Preencha todos os campos<br>";
    }
  }else
  if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['acao']) && isset($_GET['id'])){
      $sql = "";
      $idget = $_GET['id'];
      if($_GET['acao'] == "deletar"){
        $sql = "DELETE FROM comentarios WHERE idPost=" . $idget;
        if(!mysqli_query($conn, $sql)){
          die("Erro ao deletar<br>" . mysqli_error($conn));
        }
        $sql = "DELETE FROM posts WHERE id=" . $idget;
      }else if(isset($_GET['idcom']) && isset($_GET['acao2'])){
        $idcom = $_GET['idcom'];
        if($_GET['acao2'] == 'deletecom'){
          $sql = "DELETE FROM comentarios WHERE id=" . $idcom;
          if(!mysqli_query($conn, $sql)){
            die('erro no bd<br>' . mysqli_error($conn));
          }
        }
      }
      if(!empty($sql)){
        if(!mysqli_query($conn, $sql)){
          die("Erro ao deletar<br>" . mysqli_error($conn));
        }
      }
    }
  }

function view(){
    global $conn, $post;
    $conn = connect_db();
    $sql = "SELECT l.name, p.id, p.idUser, p.titulo, p.texto FROM posts p, Login l
    WHERE p.idUser=l.id";
    if(!($post = mysqli_query($conn, $sql))){
      die("erro ao conectar ao db" . mysqli_error($conn));
    }
    mysqli_close($conn);
  }


  function comentar($idpost){
    global $conn, $coment;
    $conn = connect_db();
    $sqlcom = "SELECT c.id, c.idUserCom, c.idPost, c.texto AS coment, l.name FROM comentarios c, Login l, posts p
    WHERE c.idUserCom = l.id AND c.idPost = p.id";
    if(!($coment = mysqli_query($conn, $sqlcom))){
      die("erro ao conectar ao db" . mysqli_error($conn));
    }
    mysqli_close($conn);
  }

  function viewpost($id){
    global $conn, $post_show, $post;
    $conn = connect_db();
    $sql = "SELECT p.id, p.texto, p.titulo, l.name, p.idUser, p.imagem
    FROM posts p, Login l
    WHERE p.idUser=l.id AND p.id =" . $id;
    if(!($post = mysqli_query($conn, $sql))){
      die("erro ao conectar ao db" . mysqli_error($conn));
    }
    mysqli_close($conn);
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
    <img src="imagens/logo.png" class="logo">
    <div class="container">
      <?php if($login): ?>
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
      <div class="content rounded" id="posts">
        <?php
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            if(isset($_GET['acao']) && isset($_GET['id'])){
              $sql = "";
              $idget = $_GET['id'];
              if($_GET['acao'] == "view"):
                viewpost($idget);
                $post_show = mysqli_fetch_assoc($post);?>
                <br><br><strong class="palavra"><?=$post_show['titulo'];?></strong>
                <br>
                <?php if($_SESSION['user_id'] == $post_show['idUser']): ?>
                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $post_show["id"] . "&" . "acao=deletar";?>">
                    <button class="btn btn-danger" id="botao"> Deletar Publicação</button></a><br><br>
                 <?php endif; ?>
                Publicado Por:
                <?php if($_SESSION['user_id'] == $post_show['idUser']): ?>
                  Você<br><br>
                <?php else: ?>
                  <?= $post_show["name"] . "<br><br>";?>
                <?php endif; ?>
                <div class="post">
                    <img class="imagem" style="max-width: 50%; height: auto;" src="<?= $post_show['imagem']; ?>"><br>
                    Texto: <?php echo "<p>".nl2br($post_show['texto'])."</p>"; ?>
                    <?php comentar($post_show['id']); ?>
                    <br>====================================================
                </div>
                <br><br>Comentários:<br>
                <?php if(mysqli_num_rows($coment) == 0):?>
                  <br><br>Nenhum Comentário<br><br>
                <?php else: ?>
                  <?php while ($post_coment = mysqli_fetch_assoc($coment)): ?>
                    <?php if($post_coment['idPost'] == $idget): ?>
                      <strong><?= $post_coment["name"]; ?>: </strong>
                      <?= $post_coment["coment"]; ?>
                      <?php if($_SESSION['user_id'] == $post_coment['idUserCom']): ?>
                         <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $post_show["id"] . "&" . "acao=view" . "&" .
                        "idcom=" . $post_coment['id'] . "&" . "acao2=deletecom";?>">
                          <button class="btn btn-danger" id="botao">Deletar</button></a><br>
                       <?php endif; ?>
                       <br>
                    <?php endif; ?>
                  <?php endwhile; ?>
                <?php endif; ?>
                <form enctype="multipart/form-data" name="form" method="post" action="<?=
                htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $post_show["id"] . "&" . "acao=view";?>">
                  <input type='text' name='comentario' autocomplete='off' placeholder='Digite um Comentário...'>
                </form>
                <br><br><button><a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Voltar</a></button>
                </body></html>
                <?php exit(); ?>
              <?php endif;
          }
        }
        ?>
        <div id="configura">
          <h4 class="palavra">Postar</h4>
          <hr>
          <form name="form-post" enctype="multipart/form-data" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Título
            <input type="text" name="title" autocomplete="off"><br><br>Texto<br>
            <textarea name="post" rows="4" cols="50" maxlength="500"></textarea><br>
            <input style="margin-left: auto; margin-right: auto;" type="file" name="imagem" class="btn btn-info" accept="image/png,image/jpeg"><br>
            <?php if(!empty($erro_vazio)){
              echo $erro_vazio;
            }
            ?>
            <input type="submit" class="btn btn-success" value="Postar">
          </form>
          <hr>
          <h1>Aqui estão os Posts</h1>
          <?php view();
           if(mysqli_num_rows($post) == 0): ?>
            Nenhum Post.
          <?php else: ?>
            <?php while ($post_show = mysqli_fetch_assoc($post)): ?>
             Título: <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $post_show["id"] . "&" . "acao=view"; ?>">
              <?="<strong>" . $post_show['titulo'] . "</strong>"; ?></a>
            <br><br> Publicado por <?php if($_SESSION['user_id'] == $post_show['idUser']){
              echo "Você";
            }else{
              echo $post_show['name'];}?><br><br>
            <br>====================================================================<br><br>
          <?php endwhile; ?>
          <?php endif; ?>
          <a href="index.php"><p>Voltar</p></a>
        </div>
      </div>
  <?php endif; ?>
  </div>
</body>
</html>
