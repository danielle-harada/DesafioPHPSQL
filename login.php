<?php
session_start();
unset($_SESSION['acesso']);

include 'sql.php';

$query = $db-> prepare ("SELECT *
  FROM usuarios;");
  $query -> execute();
  $acessos = $query->fetchAll(PDO::FETCH_ASSOC);

  if ($_POST) {
    foreach ($acessos as $acesso) {
      if ($_POST['emailLogin'] == $acesso['EMAIL']){
        if (password_verify($_POST['senhaLogin'], $acesso['SENHA'])){
          $_SESSION['acesso']=$acesso['NOME'];
          header('Location: http://localhost/projetos/DesafioPHPSQL/indexProdutos.php');
          // unset($_SESSION['acesso']);
        }
      }
    }
    $erro = 'E-mail e/ou senha não encontrados';
  }
  // var_dump($acesso);
  ?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Login - Desafio PHP</title>
  </head>
  <body class="text-center">
    <div class="row justify-content-center mt-5">
      <div class="col-4 border border-dark">
        <h2>Desafio PHP</h2>
        <h3>LOGIN</h3>
        <br>
        <form class="form-signin" method="post">
          <label for="emailLogin" class="sr-only">E-mail do Usuário</label>
          <input type="email" class="form-control" name="emailLogin" placeholder="E-mail do Usuário" required>
          <label for="senhaLogin" class="sr-only">Senha</label>
          <input type="password" class="form-control" name="senhaLogin" placeholder="Senha" required>
          <?php if(isset($erro)): ?>
            <div class="alert alert-info" role="alert">
              <p><?= $erro ?></p>
            </div> <?php endif; ?>
            <br>
            <button type="submit" class="btn btn-lg btn-dark btn-block" name="button">Entrar</button>
            <br>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
