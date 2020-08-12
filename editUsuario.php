<?php
session_start();

include 'sql.php';

$id = $_GET['id'];
$msg='';
$salvo;

$query = $db->prepare ("SELECT *
                        FROM usuarios
                        WHERE id=:id;");
$query->execute([':id' => $id]);

$usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

var_dump($usuarios);

if ($_POST) {
 // if ($_POST['senha']){//verifica se outra senha foi postada
 //   if (strlen($_POST['senha']) < 6) {//verifica se é menor do que 6
 //     $msg="Senha deve ter mais de 6 caracteres<br>";//imprime msg se for
 //   } elseif ($_POST['senha'] !== $_POST['confirmacao']) {//se for maior que 6, verifica se confirma
 //        $msg="Senha não confere!<br>";}//se não confirma, imprime msg
 //       else {
        $query = $db-> prepare("UPDATE usuarios SET nome = :nome,
                                                    email = :email,
                                                    senha = :senha,
                                                WHERE id = :id;");
        $salvo=$query->execute([':id'=>$id,
                                ':nome'=>$_POST['nomeUsuario'],
                                ':email'=>$_POST['email'],
                                ':senha'=>password_hash($_POST['senha'], PASSWORD_DEFAULT)]);}
var_dump($_POST);

// if(isset($salvo)){
//   header ('Location: http://localhost/projetos/DesafioPHPSQL/createUsuario.php'); }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Editar Usuario</title>
  </head>
  <body>
    <?php foreach ($usuarios as $usuario): ?>
      <form class="" method="post">
        <label for="nomeUsuario">Nome do Usuário</label><br>
         <input type="text" name="nomeUsuario" value="<?= $usuario['NOME']?>"><br>
         <label for="email">E-mail</label><br>
         <input type="email" name="email" value="<?= $usuario['EMAIL']?>"><br>
        <label for="senha">Senha</label><br>
         <input type="password" name="senha"><br>
        <label for="confirmacao">Confirmação de Senha</label><br>
         <input type="password" name="confirmacao"><br>
         <?php echo $msg;?>
         <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit" name="button">Enviar</button>
      </form>
    <?php endforeach; ?>
  </body>
</html>
