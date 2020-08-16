<?php
session_start();
if (!$_SESSION['acesso']){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
}

include 'sql.php';
include 'header.php';

$msg=null;

if ($_POST) {
  if (strlen($_POST['senha']) < 6) {
    $msg="Senha deve ter mais de 6 caracteres<br>";
  }
  elseif ($_POST['senha'] !== $_POST['confirmacao']) {
    $msg="Senha não confere!<br>";
  }
  else {
    $query = $db->prepare("INSERT INTO usuarios (nome, email, senha)
                                  VALUES (:nome, :email, :senha);");
    $salvo=$query->execute([':nome'=>$_POST['nomeUsuario'],
                            ':email'=>$_POST['email'],
                            ':senha'=>password_hash($_POST['senha'], PASSWORD_DEFAULT)]);
      }
    }

if(isset($salvo)){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/createUsuario.php');
}

$query = $db->prepare("SELECT * FROM usuarios;");
$query -> execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Criar Novo Usuário</title>
</head>
<body>
  <div class="container"><br>
    <div class="row">
      <div class="col-4 border border-success rounded">
        <form method="post">
          <div class="form-group">
            <h5><label class="font-weight-bold" for="nomeUsuario">Nome do Usuário</label></h5>
            <input class="form-control" type="text" name="nomeUsuario" value="" required>
          </div>

          <div class="form-group">
            <h5><label class="font-weight-bold" for="email">E-mail</label></h5>
            <input class="form-control" type="email" name="email" value="" required>
          </div>

          <div class="form-group">
            <h5><label class="font-weight-bold" for="senha">Senha</label></h5>
            <input class="form-control" type="password" name="senha" required>
          </div>

          <div class="form-group">
            <h5><label class="font-weight-bold" for="confirmacao">Confirmação de Senha</label></h5>
            <input class="form-control" type="password" name="confirmacao" required>
          </div>
          <?php if(isset($msg)): ?>
            <div class="alert alert-danger text-center" role="alert">
              <h5><?= $msg;?></h5>
            </div><?php endif; ?>

            <button class="btn btn-outline-success btn-lg float-right mb-2" type="submit" name="button">Enviar</button>
          </form>
        </div>
        <div class="col-1"></div>
        <div class="col-7">
          <table class="table table-hover text-center">
            <tr class="table-success text-success">
              <td class="font-weight-bold">NOME DO USUÁRIO</td>
              <td class="font-weight-bold">E-MAIL</td>
              <td></td>
              <td></td>
            </tr>
            <?php foreach ($usuarios as $usuario) : ?>
              <tr>
                <td><?= $usuario['NOME']?> </td>
                <td><?= $usuario['EMAIL']?> </td>
                <td><a class="btn btn-outline-info" role="button" href="editUsuario.php?id=<?= $usuario['ID']?>">Editar</td>
                  <td><a class="btn btn-outline-danger" role="button" href="removeUsuario.php?id=<?= $usuario['ID']?>">Remover</td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      </body>
      </html>
