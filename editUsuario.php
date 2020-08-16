<?php
session_start();
if (!$_SESSION['acesso']){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
}

include 'sql.php';
include 'header.php';

$id = $_GET['id'];
$salvo;
$msg="";

$query = $db->prepare ("SELECT * FROM usuarios
                                 WHERE id=:id;");
$query->execute([':id' => $id]);

$usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

  if ($_POST) {
    // if (strlen($_POST['senha']) < 6) {
    //  $msg="Senha deve ter mais de 6 caracteres<br>";
    //  } elseif ($_POST['senha'] !== $_POST['confirmacao']) {
    //      $msg="Senha não confere!<br>";
    //    } else {
    $query = $db-> prepare("UPDATE usuarios SET nome = :nome,
                                                email = :email
                                             -- senha = :senha
                                            WHERE id = :id;");
    $salvo=$query->execute([':id' =>$id,
                            ':nome'=>$_POST['nomeUsuario'],
                            ':email'=>$_POST['email'],
                         // ':senha'=>password_hash($_POST['senha'], PASSWORD_DEFAULT)]);
                       ]);
        }
  //}

if(isset($salvo)){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/createUsuario.php');
}

$query = $db->prepare ("SELECT * FROM usuarios
                                   WHERE id=:id;");
$query->execute([':id' => $id]);

$usuarios=$query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Editar Usuário</title>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-3"></div>
      <div class="col-6 border border-success rounded">
        <?php foreach ($usuarios as $usuario): ?>
          <form method="post">
            <div class="form-group">
              <br>
              <h5><label class="font-weight-bold" for="nomeUsuario">Nome do Usuário</label></h5>
              <input class="form-control" type="text" name="nomeUsuario" value="<?= $usuario['NOME'];?>">
            </div>

            <div class="form-group">
              <h5><label class="font-weight-bold" for="email">E-mail</label></h5>
              <input class="form-control" type="email" name="email" value="<?= $usuario['EMAIL'];?>">
            </div>
            <!-- <label for="senha">Senha</label><br>
            <input type="password" name="senha"><br>
            <label for="confirmacao">Confirmação de Senha</label><br>
            <input type="password" name="confirmacao"><br>
            <?php echo $msg;?> -->
            <br>
            <input class="btn btn-outline-success float-right mb-2" type="submit" name="button" value="Atualizar Usuário">
          </form>
        <?php endforeach; ?>
      </div>
      <div class="col-3"></div>
    </div>
  </div>
</body>
</html>
