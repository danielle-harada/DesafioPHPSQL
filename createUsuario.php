<?php
session_start();
if (!$_SESSION['acesso']){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/login.php');
}

include 'sql.php';
include 'header.php';

$msg='';

if ($_POST) {
 if (strlen($_POST['senha']) < 6) {
  $msg="Senha deve ter mais de 6 caracteres<br>";
  } elseif ($_POST['senha'] !== $_POST['confirmacao']) {
      $msg="Senha não confere!<br>";
    } else {
        $query = $db->prepare("INSERT INTO usuarios (nome,
                                                     email,
                                                     senha)
                                VALUES (:nome,
                                        :email,
                                        :senha);");
        $salvo=$query->execute([':nome'=>$_POST['nomeUsuario'],
                   ':email'=>$_POST['email'],
                   ':senha'=>password_hash($_POST['senha'], PASSWORD_DEFAULT)]);
        // $idInserido = $db->lastInsertId();
}}

if(isset($salvo)){
  header ('Location: http://localhost/projetos/DesafioPHPSQL/createUsuario.php'); }

  $query = $db->prepare("SELECT * FROM usuarios;");
  $query -> execute();
  $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

// unset($_SESSION['acesso']);
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Criar Novo Usuário</title>
   </head>
   <body>
     <form class="" method="post">
       <label for="nomeUsuario">Nome do Usuário</label><br>
        <input type="text" name="nomeUsuario" value="" required><br>
        <label for="email">E-mail</label><br>
        <input type="email" name="email" value="" required><br>
       <label for="senha">Senha</label><br>
        <input type="password" name="senha" required><br>
       <label for="confirmacao">Confirmação de Senha</label><br>
        <input type="password" name="confirmacao" required><br>
        <?php echo $msg;?>
       <button type="submit" name="button">Enviar</button>
     </form>
<br>
<br>
     <table border="1">
       <tr>
         <td>NOME DO USUÁRIO</td>
         <td>E-MAIL</td>
         <td>EDITAR</td>
         <td>REMOVER</td>
       </tr>
       <?php foreach ($usuarios as $usuario) : ?>
       <tr>
         <td><?= $usuario['NOME']?> </td>
         <td><?= $usuario['EMAIL']?> </td>
         <td><a href="editUsuario.php?id=<?= $usuario['ID']?>">Editar</td>
         <td><a href="removeUsuario.php?id=<?= $usuario['ID']?>">Remover</td>
       </tr>
     <?php endforeach; ?>
   </table>
   </body>
 </html>
